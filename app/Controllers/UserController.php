<?php
namespace PresenceEngine\Controllers;

use PresenceEngine\Core\Controller;
use PresenceEngine\Core\Session;
use PresenceEngine\Models\PresenceLog;

class UserController extends Controller
{
    public function dashboard(): void
    {
        $logId = Session::get('presence_log_id');

        $log = null;
        if ($logId) {
            $log = (new PresenceLog())->getById((int) $logId);
        }

        $this->view('user.dashboard', [
            'username' => Session::get('username'),
            'section'  => Session::get('section'),
            'log'      => $log,
        ]);
    }
}