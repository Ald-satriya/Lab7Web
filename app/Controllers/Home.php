<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function home()
    {
        return view('home', [
            'title' => 'Beranda',
            'content' => 'Ini adalah halaman beranda menggunakan layout.'
        ]);
    }
}