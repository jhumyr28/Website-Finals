<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function register()
    {
        echo view('templates/header');
        echo view('auth/register');
        echo view('templates/footer');
    }

    public function registerPost()
    {
        $validation = $this->validate([
            'name' => 'required|min_length[2]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ]);

        if (! $validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        $userModel->insert(['name' => $name, 'email' => $email, 'password' => $password, 'is_admin' => 0]);
        return redirect()->to('/login')->with('success', 'Registration successful! Please log in.');
    }

    public function login()
    {
        echo view('templates/header');
        echo view('auth/login');
        echo view('templates/footer');
    }

    public function loginPost()
    {
        $validation = $this->validate([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ]);

        if (! $validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();
        if ($user && password_verify($password, $user['password'])) {
            session()->set('user', ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email'], 'is_admin' => $user['is_admin']]);
            return redirect()->to('/');
        }
        return redirect()->back()->with('error', 'Invalid email or password');
    }

    public function logout()
    {
        session()->remove('user');
        return redirect()->to('/login');
    }
}
