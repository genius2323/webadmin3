<?php
// app/Controllers/Profile.php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    public function index()
    {
        $user = session()->get('user');
        if (!$user) return redirect()->to('login');
        return view('profile/index', ['user' => $user]);
    }

    public function update()
    {
        $user = session()->get('user');
        if (!$user) return redirect()->to('login');
        $userModel = new UserModel();
        $data = $this->request->getPost();
        // Konversi birthday dari dd/mm/yyyy ke yyyy-mm-dd jika ada
        if (!empty($data['birthday'])) {
            $parts = explode('/', $data['birthday']);
            if (count($parts) === 3) {
                $data['birthday'] = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
            }
        }
        // Handle image upload
        $img = $this->request->getFile('profile_image');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $imgName = $img->getRandomName();
            $img->move('assets/img/profiles', $imgName);
            $data['profile_image'] = 'assets/img/profiles/' . $imgName;
        }
        if (!empty($data)) {
            $userModel->update($user['id'], $data);
            // Update juga di database kedua, hanya field yang valid
            $db2 = \Config\Database::connect('db2');
            $allowed = [
                'username',
                'password',
                'nama',
                'alamat',
                'noktp',
                'otoritas',
                'profile_image',
                'birthday',
                'deleted_at',
                'recovered_at',
                'created_at',
                'updated_at'
            ];
            $dataDb2 = array_intersect_key($data, array_flip($allowed));
            $dataDb2['id'] = $user['id'];
            $db2->table('users')->where('id', $user['id'])->update($dataDb2);
            // Update session
            $user = $userModel->find($user['id']);
            session()->set('user', $user);
            return redirect()->back()->with('success', 'Profile updated!');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang diubah.');
        }
    }

    public function security()
    {
        $user = session()->get('user');
        if (!$user) return redirect()->to('login');
        return view('profile/security', ['user' => $user]);
    }

    public function updateSecurity()
    {
        $user = session()->get('user');
        if (!$user) return redirect()->to('login');
        $userModel = new UserModel();
        $oldPassword = $this->request->getPost('old_password');
        $newPassword = $this->request->getPost('password');
        $userData = $userModel->find($user['id']);
        if (!$oldPassword || !$newPassword) {
            return redirect()->back()->with('error', 'Semua field harus diisi.');
        }
        if (!password_verify($oldPassword, $userData['password'])) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $userModel->update($user['id'], ['password' => $hash]);
        // Update juga di database kedua
        $db2 = \Config\Database::connect('db2');
        $db2->table('users')->where('id', $user['id'])->update(['password' => $hash]);
        return redirect()->back()->with('success', 'Password updated!');
    }
}
