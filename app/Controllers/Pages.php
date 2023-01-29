<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home | UAS Pemgrograman Web'
        ];
        return view('pages/home', $data);
    }
    public function about()
    {
        $data = [
            'title' => 'About | UAS Pemgrograman Web'
        ];
        return view('pages/about', $data);
    }
}
