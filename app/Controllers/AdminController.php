<?php
namespace PresenceEngine\Controllers;

use PresenceEngine\Core\Controller;
use PresenceEngine\Core\Session;
use PresenceEngine\Core\View;
use PresenceEngine\Models\User;
use PresenceEngine\Models\PresenceLog;

class AdminController extends Controller
{
    public function dashboard(): void
    {
        $userModel = new User();
        $logModel = new PresenceLog();

        $stats = [
            'total_users'  => $userModel->count(),
            'total_admins' => $userModel->countByRole('admin'),
            'online_now'   => $logModel->countOnline(),
            'online_s1'    => $logModel->countOnlineBySection('section1'),
            'online_s2'    => $logModel->countOnlineBySection('section2'),
            'online_s3'    => $logModel->countOnlineBySection('section3'),
        ];

        $this->view('admin.dashboard', [
            'username' => Session::get('username'),
            'stats'    => $stats,
        ]);
    }

    public function apiPresence(): void
    {
        $logs = (new PresenceLog())->getOnline();
        $this->json([
            'type'  => 'online_list',
            'users' => $logs,
        ]);
    }

    public function apiStats(): void
    {
        $userModel = new User();
        $logModel = new PresenceLog();

        $this->json([
            'total_users'  => $userModel->count(),
            'total_admins' => $userModel->countByRole('admin'),
            'online_now'   => $logModel->countOnline(),
            'online_s1'    => $logModel->countOnlineBySection('section1'),
            'online_s2'    => $logModel->countOnlineBySection('section2'),
            'online_s3'    => $logModel->countOnlineBySection('section3'),
        ]);
    }

    public function history(): void
    {
        $logs = (new PresenceLog())->getHistory(200);
        $this->view('admin.history', [
            'username' => Session::get('username'),
            'logs'     => $logs,
        ]);
    }

    public function listUsers(): void
    {
        $users = (new User())->all();
        $this->view('admin.users.index', [
            'username' => Session::get('username'),
            'users'    => $users,
            'flash'    => Session::get('flash'),
        ]);
        Session::remove('flash');
    }

    public function showCreateUser(): void
    {
        $this->view('admin.users.create', [
            'username' => Session::get('username'),
            'errors'   => [],
            'old'      => [],
        ]);
    }

    public function storeUser(): void
    {
        if (!View::verifyCsrf($_POST['csrf_token'] ?? null)) {
            $this->view('admin.users.create', [
                'username' => Session::get('username'),
                'errors'   => ['csrf' => 'Invalid CSRF token'],
                'old'      => [],
            ]);
            return;
        }

        $usernameInput = trim($_POST['username'] ?? '');
        $email         = trim($_POST['email'] ?? '');
        $password      = $_POST['password'] ?? '';
        $section       = trim($_POST['section'] ?? '');
        $role          = $_POST['role'] ?? 'user';

        $errors = [];

        if (!preg_match('/^[a-zA-Z0-9_]{3,50}$/', $usernameInput)) {
            $errors['username'] = 'Username must be 3-50 chars (a-z, 0-9, _)';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email address';
        }
        if (strlen($password) < 6) {
            $errors['password'] = 'Password must be at least 6 characters';
        }
        if ($role === 'user' && !in_array($section, ['section1', 'section2', 'section3'], true)) {
            $errors['section'] = 'Please select a valid section';
        }
        if (!in_array($role, ['admin', 'user'], true)) {
            $errors['role'] = 'Invalid role';
        }

        $userModel = new User();
        if (!$errors && $userModel->usernameExists($usernameInput)) {
            $errors['username'] = 'Username already taken';
        }
        if (!$errors && $userModel->emailExists($email)) {
            $errors['email'] = 'Email already taken';
        }

        if ($errors) {
            $this->view('admin.users.create', [
                'username' => Session::get('username'),
                'errors'   => $errors,
                'old'      => compact('usernameInput', 'email', 'section', 'role'),
            ]);
            return;
        }

        $userModel->create([
            'username' => $usernameInput,
            'email'    => $email,
            'password' => $password,
            'section'  => $role === 'user' ? $section : null,
            'role'     => $role,
        ]);

        Session::set('flash', 'User created successfully');
        $this->redirect('/PresenceEngine/public/admin/users');
    }

    public function toggleUser(string $id): void
    {
        if (!View::verifyCsrf($_POST['csrf_token'] ?? null)) {
            $this->redirect('/PresenceEngine/public/admin/users');
            return;
        }

        if ((int) $id === Session::get('user_id')) {
            Session::set('flash', 'You cannot disable your own account');
            $this->redirect('/PresenceEngine/public/admin/users');
            return;
        }

        $userModel = new User();
        $user = $userModel->findById((int) $id);

        if (!$user) {
            $this->redirect('/PresenceEngine/public/admin/users');
            return;
        }

        $userModel->toggleActive((int) $id);
        Session::set('flash', 'User status updated');
        $this->redirect('/PresenceEngine/public/admin/users');
    }
}