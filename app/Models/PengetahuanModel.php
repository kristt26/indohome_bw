<?php

namespace App\Models;

use CodeIgniter\Model;

class PengetahuanModel extends Model
{
    protected $table            = 'pengetahuan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kerusakan_id', 'gejala_id', 'ya', 'tidak'];
}
