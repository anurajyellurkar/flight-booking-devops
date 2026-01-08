
<?php require __DIR__.'/../config.php'; ?>
<!doctype html><html><head>
<meta name=viewport content='width=device-width,initial-scale=1'>
<title>Airline</title>
<style>
body{background:#070d1c;color:#e9f0ff;font-family:Inter,Arial;margin:0}
header,footer{background:#0b1737;padding:16px 22px}
.container{max-width:1100px;margin:auto;padding:18px}
.card{background:#111f45;border:1px solid #1f2f63;border-radius:18px;padding:18px;margin:14px 0;box-shadow:0 10px 28px rgba(0,0,0,.35)}
a{color:#9fd3ff;text-decoration:none}
.btn{padding:9px 15px;border-radius:9px;border:0;background:#2d6aff;color:#fff;cursor:pointer}
.table{width:100%;border-collapse:collapse}
.table th,.table td{padding:10px;border-bottom:1px solid #243a6f}
.seat{width:30px;height:30px;border-radius:6px;display:inline-flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;margin:4px;cursor:pointer;color:white}
.free{background:#1b8b4b}
.taken{background:#b53b3b;cursor:not-allowed}
.selected{background:#cc3a3a!important}
.wizard{display:flex;gap:10px;margin-bottom:14px}
.wizard div{padding:6px 10px;border-radius:8px;background:#0f2151;color:#9abaff;font-size:12px}
</style></head><body>
<header>
<b>✈ Airline System</b>
<span style=float:right>
<?php if(isset($_SESSION['user'])): ?>
Hello, <?=$_SESSION['user']['name']?> |
<a href="dashboard.php">My bookings</a> |
<a href='logout.php'>Logout</a>
<?php else: ?>
<a href="login.php">Login</a> |
<a href="register.php">Register</a>
<?php endif; ?>
</span>
</header>
<div class=container>
