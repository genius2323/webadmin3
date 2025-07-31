<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    /**
     * Menampilkan halaman login.
     */
    public function index()
    {
        // Jika user sudah login, arahkan ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    /**
     * Memproses percobaan login dari form.
     */
    public function process()
    {
        // 1. Validasi input
        $rules = [
            'username'     => 'required',
            'password'     => 'required',
            'department_id'=> 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Ambil data dari form
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $department_id = $this->request->getPost('department_id');

        // --- LOGIKA VALIDASI USER MULTI-DEPARTEMEN ---
        $userModel = new \App\Models\UserModel();
        $userDeptModel = new \App\Models\UserDepartmentModel();
        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Cek apakah user punya relasi ke departemen yang dipilih dan belum soft delete
            $userDept = $userDeptModel
                ->where('user_id', $user['id'])
                ->where('department_id', $department_id)
                ->where('deleted_at', null)
                ->first();
            // DEBUG: log hasil pencarian user dan userDept
            log_message('debug', 'LOGIN DEBUG: user=' . print_r($user, true));
            log_message('debug', 'LOGIN DEBUG: userDept=' . print_r($userDept, true));
            if (!$userDept) {
                log_message('error', 'LOGIN ERROR: User tidak punya akses ke departemen ini atau relasi tidak ditemukan.');
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke departemen ini.');
            }
            $sessionData = [
                'user_id'       => $user['id'],
                'user_username' => $user['username'],
                'user_nama'     => $user['nama'],
                'department_id' => $department_id,
                'isLoggedIn'    => true,
            ];
            session()->set($sessionData);
            log_message('debug', 'LOGIN DEBUG: sessionData=' . print_r($sessionData, true));
            return redirect()->to('/dashboard');
        } else {
            // DEBUG: log hasil pencarian user
            log_message('error', 'LOGIN ERROR: User tidak ditemukan atau password salah. user=' . print_r($user, true));
            return redirect()->back()->with('error', 'Username atau Password salah!');
        }
    }

    /**
     * Proses logout.
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
