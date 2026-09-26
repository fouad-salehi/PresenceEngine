<?php $title = 'Forbidden · PresenceEngine'; require __DIR__ . '/../layouts/header.php'; ?>

<div class="login-wrap">
  <div class="card" style="max-width:420px; text-align:center;">
    <div style="font-size:56px; font-weight:800; font-family:'JetBrains Mono',monospace; background:linear-gradient(135deg, var(--red), #f87171); -webkit-background-clip:text; background-clip:text; -webkit-text-fill-color:transparent; margin-bottom:8px;">403</div>
    <div style="font-size:18px; font-weight:600; margin-bottom:8px;">Access denied</div>
    <div style="color:var(--text-2); font-size:13px; margin-bottom:24px;">You don't have permission to access this page.</div>
    <a href="/login" class="btn btn-primary">Go to login</a>
  </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>