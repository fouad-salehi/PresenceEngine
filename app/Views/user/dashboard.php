<?php $title = 'My Status · PresenceEngine'; require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/user-topbar.php'; ?>

<div class="container">
  <div class="card user-status-card">
    <div class="user-status-icon"></div>
    <div class="user-status-title">You are online</div>
    <div class="user-status-sub">Your admin can see that you are currently active.</div>

    <div class="user-status-meta">
      <div class="user-status-meta-item">
        <span class="user-status-meta-label">Section</span>
        <span class="user-status-meta-value"><?= \PresenceEngine\Core\View::e($section ?? '—') ?></span>
      </div>
      <div class="user-status-meta-item">
        <span class="user-status-meta-label">Login time</span>
        <span class="user-status-meta-value"><?= \PresenceEngine\Core\View::e($log['login_time'] ?? '—') ?></span>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>