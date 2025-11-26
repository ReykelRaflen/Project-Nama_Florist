<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;

class Pengguna extends BaseController
{
    protected $penggunaModel;

    public function __construct()
    {
        $this->penggunaModel = new PenggunaModel();
        helper(['form', 'url', 'date']);
    }

    // [READ] Menampilkan semua pengguna dengan filter & paginasi
    public function index()
    {
        $query = $this->penggunaModel->orderBy('dibuat_pada', 'DESC');

        // Filter: Pencarian
        $search = $this->request->getGet('search');
        if ($search) {
            $query->groupStart()
                ->like('nama', $search)
                ->orLike('email', $search)
                ->orLike('telepon', $search)
                ->groupEnd();
        }

        // Filter: Peran/Role
        $role = $this->request->getGet('role');
        if ($role) {
            $query->where('peran', $role);
        }

        $data = [
            'users' => $query->paginate(10, 'users'), // 10 pengguna per halaman
            'pager' => $this->penggunaModel->pager,
            'search' => $search,
            'role' => $role,
        ];
        return view('admin/pengguna/index', $data);
    }

    public function new()
    {
        return view('admin/pengguna/new');
    }

    // Menampilkan form edit pengguna
    public function edit($id = null)
    {
        $user = $this->penggunaModel->find($id);
        if (empty($user)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna tidak ditemukan');
        }

        return view('admin/pengguna/edit', [
            'user' => $user
        ]);
    }

    // [CREATE] Memproses pembuatan pengguna baru
    public function create()
    {
        $rules = [
            'nama' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[pengguna.email]',
            'telepon' => 'permit_empty|numeric|min_length[10]',
            'peran' => 'required|in_list[admin,penyewa]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->penggunaModel->save([
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'telepon' => $this->request->getPost('telepon'),
            'peran' => $this->request->getPost('peran'),
            'kata_sandi' => $this->request->getPost('password'), // Akan di-hash oleh model
        ]);

        return redirect()->to('/admin/pengguna')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    // [UPDATE] Memproses pembaruan data pengguna
    public function update($id = null)
    {
        $rules = [
            'nama' => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[pengguna.email,id,{$id}]", // is_unique dengan pengecualian
            'telepon' => 'permit_empty|numeric|min_length[10]',
            'peran' => 'required|in_list[admin,penyewa]',
        ];

        // Jika password diisi, validasi juga passwordnya
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'telepon' => $this->request->getPost('telepon'),
            'peran' => $this->request->getPost('peran'),
        ];

        // Jika password diisi, tambahkan ke data untuk di-update (dan di-hash)
        if ($this->request->getPost('password')) {
            $data['kata_sandi'] = $this->request->getPost('password');
        }

        $this->penggunaModel->update($id, $data);

        return redirect()->to('/admin/pengguna')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // [DELETE] Menghapus pengguna
    public function delete($id = null)
    {
        // Pencegahan agar tidak bisa menghapus diri sendiri
        if ($id == session()->get('user_id')) {
            return redirect()->to('/admin/pengguna')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $this->penggunaModel->delete($id);
        return redirect()->to('/admin/pengguna')->with('success', 'Pengguna berhasil dihapus.');
    }
}