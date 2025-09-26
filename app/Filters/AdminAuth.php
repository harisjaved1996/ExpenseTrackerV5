<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Check if admin is logged in
        if (!$session->get('admin_logged_in')) {
            // Redirect to admin login page
            return redirect()->to('/admin/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}