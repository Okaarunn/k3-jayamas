<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProgressPengerjaanModel;
use App\Models\WorkPermitModel;
use CodeIgniter\HTTP\ResponseInterface;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Libraries\WorkPermitExcel;


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
            $excel = new WorkPermitExcel();
            $excelData = $excel->generate($id);

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
                'Work_Permit_' . $id . '.xlsx'
            );

            $mail->isHTML(true);
            $mail->Subject = 'Work Permit Disetujui';
            $mail->Body    = "Work Permit ID {$id} sudah disetujui.";

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
            ->where('work_permit.approved_k3_by IS NOT NULL');

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

        $lembur = $this->db->table('izin_lembur')
            ->select('id')
            ->where('work_permit_id', $id)
            ->get()
            ->getRow();

        $this->db->transStart();

        $workPermitModel->update($id, [
            'approved_p2k3_by' => user_id(),
            'status_approval'  => 'approve_by_p2k3',
            'verified_p2k3_at' => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ]);

        $progressPengerjaanModel->insert([
            'work_permit_id'    => $id,
            'izin_lembur_id'    => $lembur ? $lembur->id : null,
            'status_pengerjaan' => 'ongoing',
            'plant_id'          => $workPermit['plant_id'],
            'updated_by'        => user_id(),
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses data.');
        }

        // kirim email
        $emailResult = $this->sendApprovalEmail($id, $workPermit);

        if ($emailResult !== true) {
            return redirect()->to('/approval-p2k3')
                ->with('warning', 'Approve berhasil, tapi email gagal dikirim: ' . $emailResult);
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

        $workPermitModel->update($id, [
            'rejected_p2k3_by'   => user_id(),
            'status_approval'    => 'reject_by_p2k3',
            'keterangan_ditolak' => $alasan,
            'verified_k3_at'  => date('Y-m-d H:i:s'),
            'updated_at'         => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/approval-p2k3')->with('success', 'Work Permit berhasil ditolak.');
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
}
