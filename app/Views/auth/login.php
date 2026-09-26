<?php $title = 'Sign in · PresenceEngine'; require __DIR__ . '/../layouts/header.php'; ?>

<div class="login-wrap">
  <div class="login-card">
    <div class="login-brand">
      <div class="login-brand-logo"></div>
      <div style="text-align:center">
        <div class="login-brand-name">PresenceEngine</div>
        <div class="login-brand-tag">Real-time presence tracking</div>
      </div>
    </div>

    <div class="card">
      <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= \PresenceEngine\Core\View::e($error) ?></div>
      <?php endif; ?>

      <form method="post" action="/PresenceEngine/public/login">
        <input type="hidden" name="csrf_token" value="<?= \PresenceEngine\Core\View::csrfToken() ?>">

        <div class="form-group">
          <label>Username</label>
          <input name="username" required autofocus autocomplete="username" placeholder="Enter your username">
        </div>

        <div class="form-group">
          <label>Password</label>
          <input name="password" type="password" required autocomplete="current-password" placeholder="Enter your password">
        </div>

        <button class="btn btn-primary" style="width:100%; justify-content:center; padding:12px;">
          Sign in
        </button>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>