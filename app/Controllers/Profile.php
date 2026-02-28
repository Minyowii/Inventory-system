<?php namespace App\Controllers;

use App\Models\UsersModel;

class Profile extends BaseController {

    public function index() {
        $model = new UsersModel();
        $data = [
            'title' => 'Profil Saya',
            'user'  => $model->find(session()->get('user_id'))
        ];
        return view('profile/index', $data);
    }

   public function edit() {
        $model = new \App\Models\UsersModel();
        return view('profile/edit', [
            'title' => 'Ubah Profil',
            'user' => $model->find(session()->get('user_id'))
        ]);
    }

    public function update() {
        $model = new \App\Models\UsersModel();
        $id = session()->get('user_id');

        if (!$this->validate([
            'full_name' => 'required|min_length[3]',
            'email'     => 'required|valid_email'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Nama dan Email wajib diisi dengan benar!');
        }

        $model->update($id, [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
        ]);

        return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui!');
    }
}