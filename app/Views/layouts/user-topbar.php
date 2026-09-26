<div class="topbar">
  <div class="brand">
    <div class="brand-logo"></div>
    <span class="brand-name">PresenceEngine</span>
  </div>
  <div class="topbar-right">
    <div class="user-chip">
      <div class="user-avatar"><?= \PresenceEngine\Core\View::e(substr($username ?? 'U', 0, 1)) ?></div>
      <span><?= \PresenceEngine\Core\View::e($username ?? '') ?></span>
    </div>
    <form method="post" action="/PresenceEngine/public/logout" style="display:inline">
      <input type="hidden" name="csrf_token" value="<?= \PresenceEngine\Core\View::csrfToken() ?>">
      <button class="btn btn-ghost btn-sm">Logout</button>
    </form>
  </div>
</div>