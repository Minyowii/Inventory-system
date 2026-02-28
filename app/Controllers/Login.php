<?php namespace App\Controllers;

use App\Models\UsersModel;

class Login extends BaseController {
    public function index() {
        return view('users/login', ['title' => 'Login']);
    }

    public function auth() {
        $session = session();
        $model = new UsersModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $model->where('username', $username)->first();

        if ($user && $user['password'] === $password) {
            $session->set([
                'user_id'   => $user['user_id'],
                'username'  => $user['username'],
                'full_name' => $user['full_name'],
                'role'      => $user['role'],
                'logged_in' => TRUE
            ]);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('msg', 'Username/Password Salah');
        }
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }
}