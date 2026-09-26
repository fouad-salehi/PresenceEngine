<?php $uri = $_SERVER['REQUEST_URI']; ?>
<div class="topbar">
  <div class="brand">
    <div class="brand-logo"></div>
    <span class="brand-name">PresenceEngine</span>
    <span class="brand-tag">Admin</span>
  </div>
  <div class="topbar-right">
    <a href="/PresenceEngine/public/admin" class="nav-link<?= (strpos($uri, '/admin/users') === false && strpos($uri, '/admin/history') === false && strpos($uri, '/admin') !== false) ? ' active' : '' ?>">Dashboard</a>
    <a href="/PresenceEngine/public/admin/history" class="nav-link<?= (strpos($uri, '/admin/history') !== false) ? ' active' : '' ?>">History</a>
    <a href="/PresenceEngine/public/admin/users" class="nav-link<?= (strpos($uri, '/admin/users') !== false) ? ' active' : '' ?>">Users</a>
    <div class="user-chip">
      <div class="user-avatar"><?= \PresenceEngine\Core\View::e(substr($username ?? 'A', 0, 1)) ?></div>
      <span><?= \PresenceEngine\Core\View::e($username ?? '') ?></span>
    </div>
    <form method="post" action="/PresenceEngine/public/logout" style="display:inline">
      <input type="hidden" name="csrf_token" value="<?= \PresenceEngine\Core\View::csrfToken() ?>">
      <button class="btn btn-ghost btn-sm">Logout</button>
    </form>
  </div>
</div>