<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != 'login') {
            redirect(base_url('auth'));
        }
    }
    public function index()
    {
        $data['title'] = 'Dashboard';

        $this->load->view('header', $data);
        $this->load->view('menu');
        $this->load->view('dashboard');
        $this->load->view('footer');
    }
}
