<?php $title = 'History · PresenceEngine'; require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/admin-topbar.php'; ?>

<div class="container">

  <div class="page-header">
    <div>
      <div class="page-title">History</div>
      <div class="page-subtitle">Recent login and logout activity</div>
    </div>
  </div>

  <div class="card">
    <?php if (empty($logs)): ?>
      <div class="empty">
        <div class="empty-icon">📋</div>
        No activity recorded yet
      </div>
    <?php else: ?>
      <table class="table">
        <thead>
          <tr>
            <th>User</th>
            <th>Section</th>
            <th>Login</th>
            <th>Logout</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($logs as $log): ?>
            <tr>
              <td><?= \PresenceEngine\Core\View::e($log['username']) ?></td>
              <td><?= \PresenceEngine\Core\View::e($log['section'] ?? '—') ?></td>
              <td class="mono"><?= \PresenceEngine\Core\View::e($log['login_time']) ?></td>
              <td class="mono"><?= \PresenceEngine\Core\View::e($log['logout_time'] ?? '—') ?></td>
              <td>
                <?php if ($log['is_online']): ?>
                  <span class="dot dot-on"></span>Online
                <?php else: ?>
                  <span class="dot dot-off"></span>Offline
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>