<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Login extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper('url');
    }

    public function index()
    {
        // Check if user is already logged in
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin/dashboard')->with('success', 'You are already logged in!');
        }

        return view('admin/login');
    }

    public function authenticate()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->verifyPassword($email, $password);

        if ($user) {
            // Set session data
            session()->set([
                'admin_id' => $user['id'],
                'admin_name' => $user['name'],
                'admin_email' => $user['email'],
                'admin_logged_in' => true
            ]);

            return redirect()->to('/admin/dashboard')->with('success', 'Welcome to Dashboard!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login')->with('success', 'You have been logged out successfully!');
    }
}