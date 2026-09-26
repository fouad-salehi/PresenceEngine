<?php $title = 'Users · PresenceEngine'; require __DIR__ . '/../../layouts/header.php'; ?>
<?php require __DIR__ . '/../../layouts/admin-topbar.php'; ?>

<div class="container">

  <div class="page-header">
    <div>
      <div class="page-title">Users</div>
      <div class="page-subtitle"><?= count($users) ?> total</div>
    </div>
    <a href="/PresenceEngine/public/admin/users/create" class="btn btn-primary">+ New User</a>
  </div>

  <?php if (!empty($flash)): ?>
    <div class="alert alert-success"><?= \PresenceEngine\Core\View::e($flash) ?></div>
  <?php endif; ?>

  <div class="card" style="padding:0; overflow:hidden;">
    <?php if (empty($users)): ?>
      <div class="empty">
        <div class="empty-icon">👤</div>
        No users yet
      </div>
    <?php else: ?>
      <table class="table">
        <thead>
          <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Section</th>
            <th>Role</th>
            <th>Status</th>
            <th style="text-align:right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $u): ?>
            <tr>
              <td><strong><?= \PresenceEngine\Core\View::e($u['username']) ?></strong></td>
              <td class="mono" style="color:var(--text-2)"><?= \PresenceEngine\Core\View::e($u['email']) ?></td>
              <td><?= \PresenceEngine\Core\View::e($u['section'] ?? '—') ?></td>
              <td>
                <span class="badge badge-<?= $u['role'] === 'admin' ? 'admin' : 'user' ?>">
                  <?= \PresenceEngine\Core\View::e($u['role']) ?>
                </span>
              </td>
              <td>
                <span class="badge badge-<?= $u['is_active'] ? 'active' : 'inactive' ?>">
                  <?= $u['is_active'] ? 'Active' : 'Inactive' ?>
                </span>
              </td>
              <td style="text-align:right">
                <form method="post" action="/PresenceEngine/public/admin/users/<?= (int) $u['id'] ?>/toggle" style="display:inline">
                  <input type="hidden" name="csrf_token" value="<?= \PresenceEngine\Core\View::csrfToken() ?>">
                  <button class="btn btn-sm <?= $u['is_active'] ? 'btn-danger' : 'btn-success' ?>">
                    <?= $u['is_active'] ? 'Disable' : 'Enable' ?>
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>