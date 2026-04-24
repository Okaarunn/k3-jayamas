<?php

namespace App\Models;

use CodeIgniter\Model;

class IzinLemburModel extends Model
{
    protected $table            = 'izin_lembur';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'no_lembur',
        'tanggal_lembur',
        'hari',
        'jam_mulai_lembur',
        'jam_selesai_lembur',
        'uraian_pekerjaan',
        'alasan_lembur',
        'peralatan_digunakan',
        'potensi_bahaya',
        'apd_digunakan',
        'nama_penanggung_jawab_vendor',
        'jabatan_penanggung_jawab_vendor',
        'nama_penanggung_jawab_perusahaan',
        'jabatan_penanggung_jawab_perusahaan',
        'dibuat_oleh',
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
