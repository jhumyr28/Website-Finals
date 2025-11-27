<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function profile()
    {
        // Check if user is logged in
        if (!session()->get('user')) {
            return redirect()->to('login');
        }

        $userId = session()->get('user')['id'];
        $data['user'] = $this->userModel->find($userId);

        if (!$data['user']) {
            return redirect()->to('login');
        }

        echo view('templates/header');
        echo view('user/profile', $data);
        echo view('templates/footer');
    }

    public function updateProfile()
    {
        // Check if user is logged in
        if (!session()->get('user')) {
            return redirect()->to('login');
        }

        $userId = session()->get('user')['id'];

        // Validate input
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        if ($this->userModel->update($userId, $data)) {
            // Update session data
            $updatedUser = $this->userModel->find($userId);
            session()->set('user', [
                'id' => $updatedUser['id'],
                'name' => $updatedUser['name'],
                'email' => $updatedUser['email'],
                'is_admin' => $updatedUser['is_admin'],
            ]);

            return redirect()->to('profile')->with('success', 'Profile updated successfully!');
        }

        return redirect()->back()->with('error', 'Failed to update profile');
    }

    public function changePassword()
    {
        // Check if user is logged in
        if (!session()->get('user')) {
            return redirect()->to('login');
        }

        $userId = session()->get('user')['id'];
        $user = $this->userModel->find($userId);

        // Validate input
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');

        // Verify current password
        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Current password is incorrect');
        }

        // Update password
        $data = [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
        ];

        if ($this->userModel->update($userId, $data)) {
            return redirect()->to('profile')->with('success', 'Password changed successfully!');
        }

        return redirect()->back()->with('error', 'Failed to change password');
    }
}
