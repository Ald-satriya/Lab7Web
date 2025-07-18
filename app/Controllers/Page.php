<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        return view('view/about', [
            'title' => 'Halaman About',
            'content' => 'Ini adalah halaman abaut yang menjelaskan tentang isi
            halaman ini.'
        ]);
    }
    public function contact()
    {
        return view('view/contact', [
            'title' => 'Halaman Contaact',
            'content' => 'Ini adalah halaman contact yang menjelaskan tentang isi
            halaman ini.'
        ]);
    }
    public function faqs()
    {
        echo "Ini halaman FAQ";
    }
    public function tos()
    {
        echo "ini halaman Term of Services";
    }
}