<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkPermitModel extends Model
{
    protected $table            = 'work_permit';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'no_wp',
        'tipe_pengaju',
        'nama_pengaju',
        'alamat_vendor',
        'notelp_vendor',
        'nama_pekerja_vendor',
        'jabatan_pekerja_vendor',
        'no_ktp_pic_vendor',
        'departemen',
        'lokasi_kerja',
        'tanggal',
        'pekerjaan_id',
        'jam_mulai',
        'jam_selesai',
        'tipe_approval',
        'izin_lembur_id',
        'approved_k3',
        'approved_p2k3',
        'updated_by',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
