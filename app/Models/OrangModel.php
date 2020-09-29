<?php

namespace App\Models;

use CodeIgniter\Model;

class OrangModel extends Model
{
    protected $table      = 'orang';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'alamat'];
    //searchi
    public function  search($cari)
    {
        // $builder = $this->table('komik');
        // $builder->like('judul', $cari);
        // return $builder;

        return $this->table('orang')->like('nama', $cari)->orLike('alamat', $cari);
    }
}
