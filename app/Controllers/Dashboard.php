<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data['title'] = 'Dashboard';

        return view('header', $data)
            . view('menu')
            . view('dashboard')
            . view('footer');
    }
}

