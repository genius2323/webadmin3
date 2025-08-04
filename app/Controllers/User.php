<?php
namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $search = $this->request->getGet('search');
        $perPage = (int)($this->request->getGet('perPage') ?? 10);
        if ($perPage < 1) $perPage = 10;
        $builder = $userModel->where('deleted_at', null);
        if ($search) {
            $builder = $builder->groupStart()
                ->like('nama', $search)
                ->orLike('username', $search)
                ->orLike('alamat', $search)
                ->orLike('noktp', $search)
                ->groupEnd();
        }
        $data['users'] = $builder->paginate($perPage);
        $data['pager'] = $userModel->pager;
        $data['perPage'] = $perPage;
        $data['search'] = $search;
        $data['title'] = 'Manajemen User';
        return view('user/index', $data);
    }

    public function create()
    {
        // Ambil daftar departemen dari database utama
        $db = \Config\Database::connect();
        $departments = $db->table('departments')->where('deleted_at', null)->get()->getResultArray();
        return view('user/create', ['departments' => $departments]);
    }

    public function store()
    {
        $userModel = new UserModel();
        $userDepartmentModel = new \App\Models\UserDepartmentModel();
        $db2 = \Config\Database::connect('db2');

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'alamat' => $this->request->getPost('alamat'),
            'noktp' => $this->request->getPost('noktp'),
            'otoritas' => null,
        ];
        // Simpan user di database utama
        $userModel->insert($data);
        $userId = $userModel->getInsertID();

        // Simpan user di database kedua dengan id yang sama
        $dataDb2 = $data;
        $dataDb2['id'] = $userId;
        $db2->table('users')->insert($dataDb2);

        // Simpan relasi user-departemen di kedua database
        $departments = $this->request->getPost('departments');
        foreach ($departments as $deptId) {
            $userDepartmentModel->insert([
                'user_id' => $userId,
                'department_id' => $deptId
            ]);
            $db2->table('user_departments')->insert([
                'user_id' => $userId,
                'department_id' => $deptId
            ]);
        }

        return redirect()->to('user')->with('success', 'User berhasil ditambahkan di dua database');
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $userDepartmentModel = new \App\Models\UserDepartmentModel();
        $db = \Config\Database::connect();

        // Ambil data user
        $user = $userModel->find($id);
        if (!$user || $user['deleted_at']) {
            return redirect()->to('user')->with('error', 'User tidak ditemukan.');
        }

        // Ambil semua departemen
        $departments = $db->table('departments')->where('deleted_at', null)->get()->getResultArray();

        // Ambil relasi user-department
        $userDepartments = $userDepartmentModel->where('user_id', $id)->where('deleted_at', null)->findAll();
        $userDepartmentsIds = array_column($userDepartments, 'department_id');

        return view('user/edit', [
            'user' => $user,
            'departments' => $departments,
            'userDepartments' => $userDepartmentsIds
        ]);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $userDepartmentModel = new \App\Models\UserDepartmentModel();
        $db2 = \Config\Database::connect('db2');

        $user = $userModel->find($id);
        if (!$user || $user['deleted_at']) {
            return redirect()->to('user')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'alamat' => $this->request->getPost('alamat'),
            'noktp' => $this->request->getPost('noktp'),
        ];
        $password = $this->request->getPost('password');
        if ($password) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Update user di database utama
        $userModel->update($id, $data);

        // Pastikan update di db2 menggunakan id yang sama
        $dataDb2 = $data;
        $dataDb2['id'] = $id;
        $db2->table('users')->where('id', $id)->update($dataDb2);

        // Update relasi departemen
        $departments = $this->request->getPost('departments') ?? [];
        // Ambil semua relasi lama
        $oldRelations = $userDepartmentModel->where('user_id', $id)->findAll();
        $oldDeptIds = array_column($oldRelations, 'department_id');

        // 1. Soft delete relasi yang di-off-kan
        $toSoftDelete = array_diff($oldDeptIds, $departments);
        foreach ($toSoftDelete as $deptId) {
            $userDepartmentModel->where('user_id', $id)->where('department_id', $deptId)->set(['deleted_at' => date('Y-m-d H:i:s')])->update();
            $db2->table('user_departments')->where('user_id', $id)->where('department_id', $deptId)->update(['deleted_at' => date('Y-m-d H:i:s')]);
        }

        // 2. Aktifkan relasi yang di-on-kan (deleted_at=null jika sebelumnya softdelete)
        foreach ($departments as $deptId) {
            // Cek apakah relasi sudah ada di database utama
            $relation = $userDepartmentModel->where('user_id', $id)->where('department_id', $deptId)->first();
            if ($relation) {
                // Jika relasi ada dan softdelete, aktifkan
                if ($relation['deleted_at']) {
                    $userDepartmentModel->where('id', $relation['id'])->set(['deleted_at' => null])->update();
                }
            } else {
                // Jika belum ada, insert baru
                $userDepartmentModel->insert([
                    'user_id' => $id,
                    'department_id' => $deptId,
                    'deleted_at' => null
                ]);
            }
            // Database kedua
            $relation2 = $db2->table('user_departments')->where('user_id', $id)->where('department_id', $deptId)->get()->getRowArray();
            if ($relation2) {
                if ($relation2['deleted_at']) {
                    $db2->table('user_departments')->where('id', $relation2['id'])->update(['deleted_at' => null]);
                }
            } else {
                $db2->table('user_departments')->insert([
                    'user_id' => $id,
                    'department_id' => $deptId,
                    'deleted_at' => null
                ]);
            }
        }

        return redirect()->to('user')->with('success', 'User berhasil diupdate di dua database');
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $userDepartmentModel = new \App\Models\UserDepartmentModel();

        $now = date('Y-m-d H:i:s');
        // Soft delete user di database utama
        $userModel->update($id, ['deleted_at' => $now]);
        // Soft delete relasi user_departments di database utama
        $userDepartmentModel->where('user_id', $id)->set(['deleted_at' => $now])->update();

        // Soft delete di database kedua (misal: db2)
        $db2 = \Config\Database::connect('db2');
        $db2->table('users')->where('id', $id)->update(['deleted_at' => $now]);
        $db2->table('user_departments')->where('user_id', $id)->update(['deleted_at' => $now]);

        return redirect()->to('user')->with('success', 'User berhasil dihapus (soft delete di dua database)');
    }
}
