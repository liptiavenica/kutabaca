<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        helper(['form']);

        if (session()->get('user')) {
            return redirect()->to('/admin');
        }

        if ($this->request->getMethod(true) === 'POST') {
            $userModel = new UserModel();

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = $userModel->where('username', $username)->first();

            if ($user) {
                if ($user['password'] === $password && $user['role'] === 'admin') {
                    session()->set('user', [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'role' => $user['role']
                    ]);
                    return redirect()->to('/admin');
                } else {
                    return redirect()->back()->with('error', 'Password atau role salah.');
                }
            } else {
                return redirect()->back()->with('error', 'Username tidak ditemukan.');
            }
        }

        return view('auth/login', [
            'title' => 'Login Admin'
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Berhasil logout.');
    }
}
