<?php $title = 'New User · PresenceEngine'; require __DIR__ . '/../../layouts/header.php'; ?>
<?php require __DIR__ . '/../../layouts/admin-topbar.php'; ?>

<div class="container">

  <div class="page-header">
    <div>
      <div class="page-title">New User</div>
      <div class="page-subtitle">Create a new account for PresenceEngine</div>
    </div>
    <a href="/PresenceEngine/public/admin/users" class="btn btn-ghost">← Back</a>
  </div>

  <div class="card" style="max-width:560px;">

    <?php if (!empty($errors['csrf'])): ?>
      <div class="alert alert-error"><?= \PresenceEngine\Core\View::e($errors['csrf']) ?></div>
    <?php endif; ?>

    <form method="post" action="/PresenceEngine/public/admin/users">
      <input type="hidden" name="csrf_token" value="<?= \PresenceEngine\Core\View::csrfToken() ?>">

      <div class="form-group">
        <label>Username</label>
        <input name="username" required value="<?= \PresenceEngine\Core\View::e($old['usernameInput'] ?? '') ?>" placeholder="e.g. john_doe">
        <?php if (!empty($errors['username'])): ?>
          <div class="alert alert-error" style="margin-top:8px; margin-bottom:0;"><?= \PresenceEngine\Core\View::e($errors['username']) ?></div>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input name="email" type="email" required value="<?= \PresenceEngine\Core\View::e($old['email'] ?? '') ?>" placeholder="name@company.com">
        <?php if (!empty($errors['email'])): ?>
          <div class="alert alert-error" style="margin-top:8px; margin-bottom:0;"><?= \PresenceEngine\Core\View::e($errors['email']) ?></div>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input name="password" type="password" required placeholder="At least 6 characters">
        <?php if (!empty($errors['password'])): ?>
          <div class="alert alert-error" style="margin-top:8px; margin-bottom:0;"><?= \PresenceEngine\Core\View::e($errors['password']) ?></div>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label>Role</label>
        <select name="role" id="role-select">
          <option value="user"  <?= (($old['role'] ?? 'user') === 'user')  ? 'selected' : '' ?>>User</option>
          <option value="admin" <?= (($old['role'] ?? '')      === 'admin') ? 'selected' : '' ?>>Admin</option>
        </select>
        <?php if (!empty($errors['role'])): ?>
          <div class="alert alert-error" style="margin-top:8px; margin-bottom:0;"><?= \PresenceEngine\Core\View::e($errors['role']) ?></div>
        <?php endif; ?>
      </div>

      <div class="form-group" id="section-group">
        <label>Section</label>
        <select name="section">
          <option value="">— Select section —</option>
          <option value="section1" <?= (($old['section'] ?? '') === 'section1') ? 'selected' : '' ?>>Section 1</option>
          <option value="section2" <?= (($old['section'] ?? '') === 'section2') ? 'selected' : '' ?>>Section 2</option>
          <option value="section3" <?= (($old['section'] ?? '') === 'section3') ? 'selected' : '' ?>>Section 3</option>
        </select>
        <?php if (!empty($errors['section'])): ?>
          <div class="alert alert-error" style="margin-top:8px; margin-bottom:0;"><?= \PresenceEngine\Core\View::e($errors['section']) ?></div>
        <?php endif; ?>
      </div>

      <div style="display:flex; gap:10px; margin-top:24px;">
        <button class="btn btn-primary" style="flex:1; justify-content:center;">Create User</button>
        <a href="/PresenceEngine/public/admin/users" class="btn btn-ghost">Cancel</a>
      </div>
    </form>
  </div>

</div>

<script>
const roleSelect  = document.getElementById('role-select');
const sectionGroup = document.getElementById('section-group');

function toggleSection() {
  sectionGroup.style.display = roleSelect.value === 'admin' ? 'none' : 'block';
}

roleSelect.addEventListener('change', toggleSection);
toggleSection();
</script>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>