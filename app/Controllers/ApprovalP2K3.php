<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProgressPengerjaanModel;
use App\Models\WorkPermitModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Libraries\WorkPermitWorkbook;


class ApprovalP2K3 extends BaseController
{

    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    private function currentUserPlantId(): ?int
    {
        $user = $this->db->table('users')
            ->select('plant_id')
            ->where('id', user_id())
            ->get()->getRow();

        return $user ? (int)$user->plant_id : null;
    }

    private function canModify(object $row): bool
    {
        if (in_groups('administrator')) return true;

        $myPlantId = $this->currentUserPlantId();
        $dataPlantId = isset($row->plant_id) ? (int)$row->plant_id : null;

        return $myPlantId === $dataPlantId;
    }

    private function sendApprovalEmail($id, $workPermit)
    {
        $mail = new PHPMailer(true);

        try {
            // generate excel ke memory
            $excel = new WorkPermitWorkbook();
            $excelData = $excel->generate($id);
            $filename  = $excel->getFilename($id);

            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username = env('EMAIL_USER');
            $mail->Password = env('EMAIL_PASS');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('noreplyemailtojmi@gmail.com', 'K3 Jayamas Medica Industri');
            $mail->addAddress($workPermit['email_pengaju']);

            // kirim excel tanpa simpan file
            $mail->addStringAttachment(
                $excelData,
                $filename,
                'base64',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            );

            $namaPengaju = $workPermit['nama_pengaju'] ?? 'Pengaju';
            $keputusan = $excel->getKeputusanAkhir($workPermit);

            $mail->isHTML(true);
            $namaPengaju = $workPermit['nama_pengaju'] ?? 'Bapak/Ibu';
            $noWp        = $workPermit['no_wp'] ?? $id;
            $mail->Subject = "Pemberitahuan Status Work Permit No. {$noWp} - {$keputusan}";

            $mail->Body = "
      <p>Dear Departement/Vendor {$namaPengaju},</p>

    <p>Dengan ini menyampaikan hasil Work Permit (Izin kerja) untuk hari ini</p>
    <p>
        No. Work Permit : {$noWp}<br>
        Plant : {$workPermit['nama_plant']}<br>
        Status : <strong>{$keputusan}</strong>
    </p>
    <p>Terimakasih, salam sehat (Tim K3)</p>
";
            $mail->send();
            return true;
        } catch (Exception $e) {
            return $mail->ErrorInfo;
        }
    }

    public function index()
    {
        $workPermitModel = new WorkPermitModel();
        $myPlantId = $this->currentUserPlantId();

        $builder = $workPermitModel
            ->select('
            work_permit.*,
            kategori_pekerjaan.nama_kategori_pekerjaan,
            plant.nama_plant,
            u1.username as approved_k3_nama,
            u2.username as approved_p2k3_nama,
            izin_lembur.id as lembur_id
        ')
            ->join('kategori_pekerjaan', 'kategori_pekerjaan.id = work_permit.kategori_pekerjaan_id', 'left')
            ->join('plant', 'plant.id = work_permit.plant_id', 'left')
            ->join('users as u1', 'u1.id = work_permit.approved_k3_by', 'left')
            ->join('users as u2', 'u2.id = work_permit.approved_p2k3_by', 'left')
            ->join('izin_lembur', 'izin_lembur.work_permit_id = work_permit.id', 'left')
            ->where('work_permit.approved_k3_by IS NOT NULL')
            ->orderBy('work_permit.created_at', 'DESC');

        if (!in_groups('administrator')) {
            $builder->where('work_permit.plant_id', $myPlantId);
        }

        $workPermits = $builder->findAll();

        return view('approvalp2k3/approvalp2k3', [
            'title'       => 'Work Permit Approval P2K3',
            'workPermits' => $workPermits,
        ]);
    }

    public function approvep2k3(int $id)
    {
        $workPermitModel = new WorkPermitModel();
        $progressPengerjaanModel = new ProgressPengerjaanModel();

        $workPermit = $workPermitModel->find($id);

        if (!$workPermit || !$this->canModify((object)$workPermit)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data plant ini.');
        }

        if ($workPermit['status_approval'] !== 'approve_by_k3') {
            return redirect()->back()->with('error', 'Work permit ini belum disetujui oleh K3.');
        }

        // ambil lembur
        $lembur = $this->db->table('izin_lembur')
            ->select('id')
            ->where('work_permit_id', $id)
            ->get()
            ->getRow();

        $this->db->transBegin();

        // update
        $updated = $workPermitModel
            ->where('id', $id)
            ->where('status_approval', 'approve_by_k3')
            ->set([
                'approved_p2k3_by' => user_id(),
                'status_approval'  => 'approve_by_p2k3',
                'verified_p2k3_at' => date('Y-m-d H:i:s'),
                'updated_at'       => date('Y-m-d H:i:s'),
            ])
            ->update();

        if (!$updated) {
            $this->db->transRollback();
            return redirect()->back()->with('error', 'Data sudah diproses oleh user lain.');
        }

        // cegah duplicate progress
        $exists = $progressPengerjaanModel
            ->where('work_permit_id', $id)
            ->first();

        if (!$exists) {
            $progressPengerjaanModel->insert([
                'work_permit_id'    => $id,
                'izin_lembur_id'    => $lembur ? $lembur->id : null,
                'status_pengerjaan' => 'ongoing',
                'plant_id'          => $workPermit['plant_id'],
                'updated_by'        => user_id(),
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ]);

            $progressId = $progressPengerjaanModel->insertID();

            // tambahkan ke document_center
            $dcExists = $this->db->table('document_center')
                ->where('work_permit_id', $id)
                ->get()->getRow();

            if (!$dcExists) {
                $this->db->table('document_center')->insert([
                    'work_permit_id'         => $id,
                    'izin_lembur_id'         => $lembur ? $lembur->id : null,
                    'progress_pengerjaan_id' => $progressId,
                ]);
            }
        }

        $this->db->transCommit();

        // ambil data terbaru untuk email
        $updatedWorkPermit = $workPermitModel
            ->select('work_permit.*, plant.nama_plant')
            ->join('plant', 'plant.id = work_permit.plant_id', 'left')
            ->where('work_permit.id', $id)
            ->first();

        // kirim email
        $emailResult = $this->sendApprovalEmail($id, $updatedWorkPermit);

        if ($emailResult !== true) {
            return redirect()->to('/approval-p2k3')
                ->with('warning', 'Approval berhasil, tapi email gagal dikirim: ' . $emailResult);
        }

        return redirect()->to('/approval-p2k3')
            ->with('success', 'Work Permit berhasil disetujui & email terkirim.');
    }

    public function rejectp2k3(int $id)
    {
        $workPermitModel = new WorkPermitModel();

        $workPermit = $workPermitModel->find($id);

        if (!$workPermit || !$this->canModify((object)$workPermit)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke data plant ini.');
        }

        if ($workPermit['status_approval'] !== 'approve_by_k3') {
            return redirect()->back()->with('error', 'Work permit ini tidak dalam posisi menunggu persetujuan P2K3.');
        }

        $alasan = $this->request->getPost('keterangan_ditolak');

        if (empty($alasan)) {
            return redirect()->back()->with('error', 'Alasan penolakan wajib diisi.');
        }

        $this->db->transBegin();

        // proteksi race condition
        $updated = $workPermitModel
            ->where('id', $id)
            ->where('status_approval', 'approve_by_k3')
            ->set([
                'rejected_p2k3_by'   => user_id(),
                'status_approval'    => 'reject_by_p2k3',
                'keterangan_ditolak' => $alasan,
                'verified_p2k3_at'   => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ])
            ->update();

        if (!$updated) {
            $this->db->transRollback();
            return redirect()->back()->with('error', 'Data sudah diproses oleh user lain.');
        }

        $this->db->transCommit();

        // ambil data terbaru
        $updatedWorkPermit = $workPermitModel
            ->select('work_permit.*, plant.nama_plant')
            ->join('plant', 'plant.id = work_permit.plant_id', 'left')
            ->where('work_permit.id', $id)
            ->first();

        // kirim email
        $emailResult = $this->sendApprovalEmail($id, $updatedWorkPermit);

        if ($emailResult !== true) {
            return redirect()->to('/approval-p2k3')
                ->with('warning', 'Penolakan berhasil, tapi email gagal dikirim: ' . $emailResult);
        }

        return redirect()->to('/approval-p2k3')
            ->with('success', 'Work Permit berhasil ditolak & email terkirim.');
    }

    public function delete(int $id)
    {
        $workPermitModel = new WorkPermitModel();
        $workPermit = $workPermitModel->find($id);

        if (!$workPermit || !$this->canModify((object)$workPermit)) {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau Anda tidak memiliki akses.');
        }

        if ($workPermitModel->delete($id)) {
            return redirect()->to('/approval-p2k3')->with('success', 'Work Permit dan data lembur terkait berhasil dihapus.');
        } else {
            return redirect()->to('/approval-p2k3')->with('error', 'Gagal menghapus data.');
        }
    }

    public function preview(int $id)
    {
        $excel = new WorkPermitWorkbook();
        return $excel->download($id);
    }
}
