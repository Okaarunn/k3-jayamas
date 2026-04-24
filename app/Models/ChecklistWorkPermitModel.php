<?php

namespace App\Models;

use CodeIgniter\Model;

class ChecklistWorkPermitModel extends Model
{
    protected $table            = 'checklist_work_permit';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'work_permit_id',
        'pemeriksaan_bahaya',
        'penyediaan_apd',
        'alat_pernapasan',
        'pemeriksaan_kelayakan',
        'tanda_peringatan',
        'perlengkapan_k3',
        'penaikan_penurunan_peralatan',
        'peralatan_terhubung_dengan_badan',
        'pengecekan_alat',
        'peralatan_mengagetkan',
        'konfirmasi_pekerja',
        'monitoring_pekerjaan',
        'monitoring_kebersihan',
        'izin_bahan_kimia',
        'tersedia_apar',
        'penggunaan_apd',
        'pencegahan_tambahan',
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
