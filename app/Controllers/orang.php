<?php

namespace App\Controllers;

use  App\Models\OrangModel;
use CodeIgniter\Validation\Rules;

class orang extends BaseController
{
    protected $komikModel;

    public function __construct()
    {
        $this->OrangModel = new OrangModel();
    }

    public function index()
    {
        //ambil halaman url utuk hitungan halaman
        $currentPage = $this->request->getVar('page_orang') ? $this->request->getVar('page_orang') : 1;
        //$komik = $this->komikModel->findAll();
        // sercing data
        $cari = $this->request->getVar('cari');
        if ($cari) {
            $Orang_cari =  $this->OrangModel->search($cari);
        } else {
            //cari tidak ada
            $Orang_cari = $this->OrangModel;
        }
        $data = [
            'title' => 'Daftar Orang | Belajar Ci4',
            //'komik' => $this->komikModel->getKomik()
            //membuat pagination
            'orang' => $Orang_cari->paginate(10, 'orang'),
            'pager' => $this->OrangModel->pager,
            'currentPage' => $currentPage
        ];


        return view('Orang/index', $data);
    }
}
