<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {

        $data = [
            'title' => 'Home | Belajar Ci4',
            'tes' => ['satu', 'dua', 'tiga']
        ];
        return view('Pages/Home', $data);
    }
    public function about()
    {
        $data = [
            'title' => 'About | Belajar Ci4'
        ];
        return view('Pages/about', $data);
    }
    public function contact()
    {
        $data = [
            'title' => 'Contact | Belajar Ci4',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'Jl. abc No. 123',
                    'kota' => 'Bandung'
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'Jl. Setia Budi No. 193',
                    'kota' => 'Bandung'
                ]
            ]
        ];
        return view('Pages/contact', $data);
    }
    //--------------------------------------------------------------------

}
