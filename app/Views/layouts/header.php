<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= \PresenceEngine\Core\View::e($title ?? 'PresenceEngine') ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root {
  --bg: #08090d;
  --surface: rgba(255,255,255,.03);
  --surface-2: rgba(255,255,255,.05);
  --surface-3: rgba(255,255,255,.08);
  --border: rgba(255,255,255,.08);
  --border-2: rgba(255,255,255,.14);
  --text: #eef0f6;
  --text-2: #8b90a8;
  --text-3: #555a70;
  --accent: #6366f1;
  --accent-2: #8b5cf6;
  --accent-glow: rgba(99,102,241,.5);
  --green: #10b981;
  --green-glow: rgba(16,185,129,.5);
  --red: #ef4444;
  --red-glow: rgba(239,68,68,.4);
  --amber: #f59e0b;
  --cyan: #06b6d4;
  --pink: #ec4899;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

html { scroll-behavior: smooth; }

body {
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  background: var(--bg);
  color: var(--text);
  font-size: 14px;
  line-height: 1.6;
  -webkit-font-smoothing: antialiased;
  min-height: 100vh;
  overflow-x: hidden;
  position: relative;
}

body::before {
  content: '';
  position: fixed;
  inset: 0;
  background:
    radial-gradient(ellipse 80% 60% at 15% 0%, rgba(99,102,241,.18), transparent 55%),
    radial-gradient(ellipse 60% 50% at 85% 100%, rgba(139,92,246,.15), transparent 55%),
    radial-gradient(ellipse 50% 40% at 50% 50%, rgba(6,182,212,.06), transparent 60%);
  pointer-events: none;
  z-index: 0;
}

body::after {
  content: '';
  position: fixed;
  inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,.015) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,.015) 1px, transparent 1px);
  background-size: 50px 50px;
  pointer-events: none;
  z-index: 0;
  mask-image: radial-gradient(ellipse at center, black 30%, transparent 80%);
  -webkit-mask-image: radial-gradient(ellipse at center, black 30%, transparent 80%);
}

.container {
  position: relative;
  z-index: 1;
  max-width: 1200px;
  margin: 0 auto;
  padding: 32px 24px;
}

.mono { font-family: 'JetBrains Mono', monospace; }

.card {
  background: var(--surface);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid var(--border);
  border-radius: 20px;
  padding: 28px;
  position: relative;
  overflow: hidden;
}

.card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,.15), transparent);
}

.topbar {
  position: sticky;
  top: 0;
  z-index: 100;
  background: rgba(8,9,13,.75);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-bottom: 1px solid var(--border);
  padding: 16px 32px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.brand {
  display: flex;
  align-items: center;
  gap: 12px;
  font-weight: 700;
  font-size: 16px;
  letter-spacing: -.02em;
}

.brand-logo {
  width: 34px; height: 34px;
  border-radius: 10px;
  background: linear-gradient(135deg, var(--accent), var(--accent-2));
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 0 24px var(--accent-glow);
  position: relative;
}

.brand-logo::after {
  content: '';
  width: 10px; height: 10px;
  background: #fff;
  border-radius: 50%;
  box-shadow: 0 0 14px #fff;
}

.brand-name {
  background: linear-gradient(135deg, #fff, #b0b4c8);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.brand-tag {
  font-size: 10px;
  font-weight: 600;
  letter-spacing: .12em;
  text-transform: uppercase;
  color: var(--text-3);
  padding: 3px 8px;
  border: 1px solid var(--border);
  border-radius: 6px;
  margin-left: 8px;
}

.topbar-right {
  display: flex;
  align-items: center;
  gap: 6px;
}

.nav-link {
  color: var(--text-2);
  text-decoration: none;
  font-size: 13px;
  font-weight: 500;
  padding: 8px 14px;
  border-radius: 10px;
  transition: all .2s;
  border: 1px solid transparent;
}

.nav-link:hover {
  color: var(--text);
  background: var(--surface-2);
  border-color: var(--border);
}

.nav-link.active {
  color: var(--text);
  background: var(--surface-2);
  border-color: var(--border);
}

.user-chip {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 6px 12px 6px 6px;
  background: var(--surface-2);
  border: 1px solid var(--border);
  border-radius: 100px;
  font-size: 13px;
  font-weight: 500;
}

.user-avatar {
  width: 24px; height: 24px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--accent), var(--accent-2));
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  font-weight: 700;
  color: #fff;
  text-transform: uppercase;
}

.btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 9px 16px;
  border-radius: 10px;
  border: 1px solid transparent;
  cursor: pointer;
  font-size: 13px;
  font-weight: 600;
  text-decoration: none;
  transition: all .2s;
  font-family: inherit;
  white-space: nowrap;
}

.btn-primary {
  background: linear-gradient(135deg, var(--accent), var(--accent-2));
  color: #fff;
  box-shadow: 0 4px 16px var(--accent-glow);
}

.btn-primary:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 24px var(--accent-glow);
}

.btn-ghost {
  background: var(--surface-2);
  color: var(--text);
  border-color: var(--border);
}

.btn-ghost:hover {
  background: var(--surface-3);
  border-color: var(--border-2);
}

.btn-danger {
  background: rgba(239,68,68,.1);
  color: var(--red);
  border-color: rgba(239,68,68,.25);
}

.btn-danger:hover {
  background: rgba(239,68,68,.2);
  border-color: rgba(239,68,68,.4);
}

.btn-success {
  background: rgba(16,185,129,.1);
  color: var(--green);
  border-color: rgba(16,185,129,.25);
}

.btn-success:hover {
  background: rgba(16,185,129,.2);
  border-color: rgba(16,185,129,.4);
}

.btn-sm {
  padding: 6px 12px;
  font-size: 12px;
}

.form-group { margin-bottom: 18px; }

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: .03em;
  text-transform: uppercase;
  color: var(--text-2);
}

.form-group input,
.form-group select {
  width: 100%;
  padding: 12px 14px;
  background: var(--surface-2);
  border: 1px solid var(--border);
  border-radius: 10px;
  color: var(--text);
  font-size: 14px;
  font-family: inherit;
  transition: all .2s;
}

.form-group input:focus,
.form-group select:focus {
  outline: none;
  border-color: var(--accent);
  background: var(--surface-3);
  box-shadow: 0 0 0 3px rgba(99,102,241,.15);
}

.form-group input::placeholder {
  color: var(--text-3);
}

.form-group select option {
  background: #11131a;
  color: var(--text);
}

.alert {
  padding: 14px 16px;
  border-radius: 12px;
  margin-bottom: 20px;
  font-size: 13px;
  border: 1px solid;
}

.alert-error {
  background: rgba(239,68,68,.08);
  color: #fca5a5;
  border-color: rgba(239,68,68,.25);
}

.alert-success {
  background: rgba(16,185,129,.08);
  color: #6ee7b7;
  border-color: rgba(16,185,129,.25);
}

.dot {
  display: inline-block;
  width: 8px; height: 8px;
  border-radius: 50%;
  margin-right: 6px;
  vertical-align: middle;
}

.dot-on {
  background: var(--green);
  box-shadow: 0 0 8px var(--green-glow);
  animation: pulse 2s infinite;
}

.dot-off {
  background: var(--red);
  box-shadow: 0 0 8px var(--red-glow);
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: .5; }
}

.table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}

.table th {
  text-align: left;
  padding: 14px 16px;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: var(--text-3);
  border-bottom: 1px solid var(--border);
}

.table td {
  padding: 16px;
  border-bottom: 1px solid var(--border);
  color: var(--text);
  vertical-align: middle;
}

.table tr:last-child td {
  border-bottom: none;
}

.table tr {
  transition: background .15s;
}

.table tbody tr:hover {
  background: var(--surface-2);
}

.badge {
  display: inline-flex;
  align-items: center;
  padding: 4px 10px;
  border-radius: 100px;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: .03em;
  border: 1px solid;
}

.badge-admin {
  background: rgba(139,92,246,.1);
  color: #c4b5fd;
  border-color: rgba(139,92,246,.3);
}

.badge-user {
  background: rgba(6,182,212,.1);
  color: #67e8f9;
  border-color: rgba(6,182,212,.3);
}

.badge-active {
  background: rgba(16,185,129,.1);
  color: #6ee7b7;
  border-color: rgba(16,185,129,.3);
}

.badge-inactive {
  background: rgba(239,68,68,.1);
  color: #fca5a5;
  border-color: rgba(239,68,68,.3);
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
  margin-bottom: 24px;
}

.stat {
  background: var(--surface);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 22px;
  position: relative;
  overflow: hidden;
}

.stat::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,.12), transparent);
}

.stat-label {
  font-size: 11px;
  font-weight: 600;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: var(--text-3);
  margin-bottom: 10px;
}

.stat-value {
  font-size: 28px;
  font-weight: 700;
  letter-spacing: -.03em;
  background: linear-gradient(135deg, #fff, #b0b4c8);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  font-family: 'JetBrains Mono', monospace;
}

.stat-value.accent {
  background: linear-gradient(135deg, var(--accent), var(--accent-2));
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.stat-value.green {
  background: linear-gradient(135deg, var(--green), #34d399);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.page-header {
  margin-bottom: 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
}

.page-title {
  font-size: 24px;
  font-weight: 700;
  letter-spacing: -.03em;
  margin-bottom: 4px;
}

.page-subtitle {
  font-size: 13px;
  color: var(--text-2);
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  gap: 16px;
}

.section-title {
  font-size: 16px;
  font-weight: 600;
  letter-spacing: -.02em;
}

.live-status {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 12px;
  color: var(--text-2);
  padding: 6px 12px;
  background: var(--surface-2);
  border: 1px solid var(--border);
  border-radius: 100px;
  font-family: 'JetBrains Mono', monospace;
}

.empty {
  text-align: center;
  padding: 48px 24px;
  color: var(--text-3);
}

.empty-icon {
  font-size: 32px;
  margin-bottom: 12px;
  opacity: .5;
}

.login-wrap {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 24px;
  position: relative;
  z-index: 1;
}

.login-card {
  width: 100%;
  max-width: 400px;
}

.login-brand {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 32px;
  gap: 16px;
}

.login-brand-logo {
  width: 56px; height: 56px;
  border-radius: 16px;
  background: linear-gradient(135deg, var(--accent), var(--accent-2));
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 0 40px var(--accent-glow);
}

.login-brand-logo::after {
  content: '';
  width: 16px; height: 16px;
  background: #fff;
  border-radius: 50%;
  box-shadow: 0 0 20px #fff;
}

.login-brand-name {
  font-size: 22px;
  font-weight: 700;
  letter-spacing: -.03em;
  background: linear-gradient(135deg, #fff, #b0b4c8);
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.login-brand-tag {
  font-size: 12px;
  color: var(--text-3);
  letter-spacing: .05em;
}

.user-status-card {
  text-align: center;
  padding: 48px 32px;
}

.user-status-icon {
  width: 80px; height: 80px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--green), #34d399);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 24px;
  box-shadow: 0 0 60px var(--green-glow);
  position: relative;
}

.user-status-icon::after {
  content: '';
  width: 24px; height: 24px;
  background: #fff;
  border-radius: 50%;
  box-shadow: 0 0 20px #fff;
}

.user-status-title {
  font-size: 26px;
  font-weight: 700;
  letter-spacing: -.03em;
  margin-bottom: 8px;
}

.user-status-sub {
  color: var(--text-2);
  font-size: 14px;
  margin-bottom: 32px;
}

.user-status-meta {
  display: inline-flex;
  flex-direction: column;
  gap: 12px;
  padding: 20px 32px;
  background: var(--surface-2);
  border: 1px solid var(--border);
  border-radius: 16px;
  text-align: left;
}

.user-status-meta-item {
  display: flex;
  justify-content: space-between;
  gap: 24px;
  font-size: 13px;
}

.user-status-meta-label {
  color: var(--text-3);
}

.user-status-meta-value {
  font-family: 'JetBrains Mono', monospace;
  color: var(--text);
  font-weight: 500;
}

@media (max-width: 640px) {
  .topbar { padding: 12px 16px; }
  .container { padding: 20px 16px; }
  .card { padding: 20px; border-radius: 16px; }
  .brand-tag { display: none; }
  .nav-link { padding: 6px 10px; font-size: 12px; }
  .user-chip span:not(.user-avatar) { display: none; }
  .page-title { font-size: 20px; }
  .stat-value { font-size: 22px; }
  .table th, .table td { padding: 12px; }
}
</style>
</head>
<body>