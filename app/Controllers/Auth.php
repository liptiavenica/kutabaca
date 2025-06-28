<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        helper(['form']);
        if ($this->request->getMethod() === 'post') {
            $userModel = new UserModel();
            $user = $userModel->where('username', $this->request->getPost('username'))->first();
            if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
                session()->set('user', $user);
                return redirect()->to('/books');
            }
            return redirect()->back()->with('error', 'Login gagal.');
        }
        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
