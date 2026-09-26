<?php
namespace PresenceEngine\Controllers;

use PresenceEngine\Core\Controller;
use PresenceEngine\Core\Session;
use PresenceEngine\Core\View;
use PresenceEngine\Models\User;
use PresenceEngine\Models\PresenceLog;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->view('auth.login', ['error' => null]);
    }

    public function login(): void
    {
        if (!View::verifyCsrf($_POST['csrf_token'] ?? null)) {
            $this->view('auth.login', ['error' => 'Invalid CSRF token']);
            return;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $this->view('auth.login', ['error' => 'Please fill all fields']);
            return;
        }

        $userModel = new User();
        $user = $userModel->findByUsername($username);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $this->view('auth.login', ['error' => 'Invalid credentials']);
            return;
        }

        Session::regenerate();
        Session::set('user_id', (int) $user['id']);
        Session::set('username', $user['username']);
        Session::set('section', $user['section']);
        Session::set('role', $user['role']);

        if ($user['role'] === 'user') {
            $logModel = new PresenceLog();
            $logId = $logModel->markOnline(
                (int) $user['id'],
                $user['section'],
                $_SERVER['REMOTE_ADDR'] ?? null
            );
            Session::set('presence_log_id', $logId);
        }

        $target = $user['role'] === 'admin'
            ? '/PresenceEngine/public/admin'
            : '/PresenceEngine/public/me';
        $this->redirect($target);
    }

    public function logout(): void
    {
        if (!View::verifyCsrf($_POST['csrf_token'] ?? null)) {
            $this->redirect('/PresenceEngine/public/login');
            return;
        }

        $userId = Session::get('user_id');
        if ($userId) {
            (new PresenceLog())->markOffline((int) $userId);
        }

        Session::destroy();
        $this->redirect('/PresenceEngine/public/login');
    }
}