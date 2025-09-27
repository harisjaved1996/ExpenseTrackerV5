<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
    }

    public function updateProfile()
    {
        $userId = $this->session->get('admin_id');
        $user = $this->userModel->find($userId);
        
        if (!$user) {
            return redirect()->to('/admin/logout');
        }
        // if password fields are not empty
        $current_password = $this->request->getPost('current_password');
        $new_password = $this->request->getPost('new_password');
        $confirm_password = $this->request->getPost('confirm_password');
        $name = $this->request->getPost('name');
        $data['name'] = $name;


        /*
        $rules = [
            'name' => 'required|min_length[5]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        */


        If(!empty($current_password) && !empty($new_password) && !empty($confirm_password)){
            if (!password_verify($current_password, $user['password'])) {
                return redirect()->back()->with('error', 'Current password is incorrect');
            }
            if($new_password != $confirm_password){
                return redirect()->back()->with('error', 'New Password and Confirm Password are not matched');
            }
            $data['password'] = password_hash($confirm_password, PASSWORD_DEFAULT);
        }
        
        if ($this->userModel->update($userId, $data)) {
            // Update session data
            $this->session->set([
                'admin_name' => $data['name'],
            ]);

            return redirect()->back()->with('success', 'Profile updated successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
        }
    }

}