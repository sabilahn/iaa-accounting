<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if ($session->get('status') !== 'login') {
            return redirect()->to(base_url('auth'));
        }

        if (! empty($arguments) && in_array('super_user', $arguments, true)) {
            if ($session->get('role') !== 'super_user') {
                return redirect()->to(base_url('dashboard'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}

