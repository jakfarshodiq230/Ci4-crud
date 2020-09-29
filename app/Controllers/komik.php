<?php

namespace App\Controllers;

use  App\Models\KomikModel;
use CodeIgniter\Validation\Rules;

class komik extends BaseController
{
    protected $komikModel;

    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }

    public function index()
    {
        //ambil halaman url utuk hitungan halaman
        $currentPage = $this->request->getVar('page_komik') ? $this->request->getVar('page_komik') : 1;
        //$komik = $this->komikModel->findAll();
        // sercing data
        $cari = $this->request->getVar('cari');
        if ($cari) {
            $komik_cari =  $this->komikModel->search($cari);
        } else {
            //cari tidak ada
            $komik_cari = $this->komikModel;
        }
        $data = [
            'title' => 'Daftar Komik | Belajar Ci4',
            //'komik' => $this->komikModel->getKomik()
            //membuat pagination
            'komik' => $komik_cari->paginate(6, 'komik'),
            'pager' => $this->komikModel->pager,
            'currentPage' => $currentPage
        ];


        return view('Komik/index', $data);
    }

    public function detail($slug)
    {
        $komik = $this->komikModel->getKomik($slug);
        $data = [
            'title' => 'Detail Komik | Belajar Ci4',
            'komik' => $komik
        ];
        //jika komik tidak ada di lebel
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Komik' . $slug . 'tidak ditemukan');
        };
        return view('komik/detail', $data);
    }
    public function create()
    {

        $data = [
            'title' => 'Tambah Data Komik | Belajar Ci4',
            'validation' => \Config\Services::validation() //membuat validasi
        ];
        return view('komik/create', $data);
    }
    public function save()
    {
        //validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus diisi',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    //'uploaded' => 'Pilih Gambar sampul terlebih dahulu',
                    'max_size' => 'Ukuan gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            //$validation = \Config\Services::validation();
            //dd($validation);
            //$data['validation'] = $validation;
            //return redirect()->to('/Komik/create')->withInput()->with('validation', $validation);
            return redirect()->to('/Komik/create')->withInput();
        }

        //ambil gambar
        $fileSampul = $this->request->getFile('sampul');
        //cek upload file
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.jpg';
        } else {
            // membuat nama random
            $namaSampul = $fileSampul->getRandomName();
            //pindahkan file ke folder img
            $fileSampul->move('img', $namaSampul);

            //ambil nama file
            //$namaSampul = $fileSampul->getName();
        }


        //membuat sepasi menjadi tanda '-'
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('judul'),
            'sampul' => $namaSampul
        ]);
        //dd($this->request->getVar());
        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan');
        return redirect()->to('/komik');
    }

    public function delete($id)
    {
        //menampilkan nama file sesuai id
        $komik = $this->komikModel->find($id);
        //cek file gambar defauld.jpg
        if ($komik['sampul'] != 'default.jpg') {
            //hapus gambar di folder
            unlink('img/' . $komik['sampul']);
        }

        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus');
        return redirect()->to('/komik');
    }
    public function edit($slug)
    {
        //$komik = $this->komikModel->findAll();
        $data = [
            'title' => 'Edit Komik | Belajar Ci4',
            'validation' => \Config\Services::validation(),
            'komik' =>  $this->komikModel->getKomik($slug)
        ];


        return view('Komik/edit', $data);
    }
    public function update($id)
    {
        //validasi input
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($komikLama['judul'] == $this->request->getVar('slug')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} komik harus diisi',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    //'uploaded' => 'Pilih Gambar sampul terlebih dahulu',
                    'max_size' => 'Ukuan gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            //$validation = \Config\Services::validation();
            //dd($validation);
            //$data['validation'] = $validation;
            // return redirect()->to('/Komik/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
            return redirect()->to('/Komik/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');
        //cek gambar update
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('file_nama_lama');
        } else {
            //generate nama random
            $namaSampul = $fileSampul->getRandomName();
            //pindahkan gambar
            $fileSampul->move('img', $namaSampul);
            //hapus file lama
            unlink('img/' . $this->request->getVar('file_nama_lama'));
        }

        //membuat sepasi menjadi tanda '-'
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('judul'),
            'sampul' => $namaSampul
        ]);
        //dd($this->request->getVar());
        session()->setFlashdata('pesan', 'Data Berhasil Diubah');
        return redirect()->to('/komik');
    }
}
