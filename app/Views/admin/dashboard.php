<?php $title = 'Dashboard · PresenceEngine'; require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/admin-topbar.php'; ?>

<div class="container">

  <div class="page-header">
    <div>
      <div class="page-title">Dashboard</div>
      <div class="page-subtitle">Live overview of your team's presence</div>
    </div>
    <div class="live-status">
      <span class="dot dot-off" id="ws-status"></span>
      <span id="ws-status-text">Connecting...</span>
    </div>
  </div>

  <div class="stats-grid">
    <div class="stat">
      <div class="stat-label">Online Now</div>
      <div class="stat-value green" id="stat-online"><?= (int) $stats['online_now'] ?></div>
    </div>
    <div class="stat">
      <div class="stat-label">Total Users</div>
      <div class="stat-value"><?= (int) $stats['total_users'] ?></div>
    </div>
    <div class="stat">
      <div class="stat-label">Section 1</div>
      <div class="stat-value accent" id="stat-s1"><?= (int) $stats['online_s1'] ?></div>
    </div>
    <div class="stat">
      <div class="stat-label">Section 2</div>
      <div class="stat-value accent" id="stat-s2"><?= (int) $stats['online_s2'] ?></div>
    </div>
    <div class="stat">
      <div class="stat-label">Section 3</div>
      <div class="stat-value accent" id="stat-s3"><?= (int) $stats['online_s3'] ?></div>
    </div>
  </div>

  <div class="card">
    <div class="section-header">
      <div class="section-title">Live Presence</div>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>Status</th>
          <th>User</th>
          <th>Section</th>
          <th>Login Time</th>
          <th>IP</th>
        </tr>
      </thead>
      <tbody id="presence-table">
        <tr>
          <td colspan="5" class="empty">
            <div class="empty-icon">⏳</div>
            Loading...
          </td>
        </tr>
      </tbody>
    </table>
  </div>

</div>

<script>
const wsStatusDot  = document.getElementById('ws-status');
const wsStatusText = document.getElementById('ws-status-text');
const tableBody    = document.getElementById('presence-table');

function escapeHtml(s) {
  return String(s ?? '').replace(/[&<>"']/g, c => ({
    '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'
  }[c]));
}

function renderRows(users) {
  if (!users.length) {
    tableBody.innerHTML = '<tr><td colspan="5" class="empty"><div class="empty-icon">🌙</div>No one is online right now</td></tr>';
    return;
  }
  tableBody.innerHTML = users.map(u => `
    <tr>
      <td><span class="dot dot-on"></span>Online</td>
      <td>${escapeHtml(u.username)}</td>
      <td>${escapeHtml(u.section ?? '—')}</td>
      <td class="mono">${escapeHtml(u.login_time)}</td>
      <td class="mono">${escapeHtml(u.ip_address ?? '—')}</td>
    </tr>
  `).join('');
}

async function refreshStats() {
  try {
    const r = await fetch('/PresenceEngine/public/admin/api/stats');
    const s = await r.json();
    document.getElementById('stat-online').textContent = s.online_now;
    document.getElementById('stat-s1').textContent = s.online_s1;
    document.getElementById('stat-s2').textContent = s.online_s2;
    document.getElementById('stat-s3').textContent = s.online_s3;
  } catch (e) {}
}

async function refreshPresence() {
  try {
    const r = await fetch('/PresenceEngine/public/admin/api/presence');
    const d = await r.json();
    renderRows(d.users);
  } catch (e) {}
}

refreshPresence();
refreshStats();

setInterval(refreshPresence, 3000);
setInterval(refreshStats, 3000);

const ws = new WebSocket(`ws://${location.hostname}:8080`);

ws.onopen = () => {
  wsStatusDot.className = 'dot dot-on';
  wsStatusText.textContent = 'Live';
};

ws.onclose = () => {
  wsStatusDot.className = 'dot dot-off';
  wsStatusText.textContent = 'Reconnecting...';
  setTimeout(() => location.reload(), 3000);
};

ws.onmessage = (e) => {
  const msg = JSON.parse(e.data);
  if (msg.type === 'online_list') {
    renderRows(msg.users);
    refreshStats();
  }
};
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>