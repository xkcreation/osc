<?php
session_start();
if(!isset($_SESSION['username'])) {
header("Location: login.php");
exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<style>
* { box-sizing:border-box; font-family:Arial,sans-serif; }
body { margin:0; background:#f5f3e8; min-height:100vh; display:flex; justify-content:center; align-items:center; }
.dashboard { width:420px; background:white; padding:40px; text-align:center; border-radius:10px; box-shadow:0 5px 20px rgba(0,0,0,0.12); }
.dashboard h1 { color:#315c45; margin-bottom:10px; }
.dashboard p { color:#666; margin-bottom:30px; }
.logout { display:inline-block; padding:11px 30px; background:#315c45; color:white; text-decoration:none; border-radius:5px; }
.logout:hover { background:#264936; }
</style>
</head>
<body>
<div class="dashboard">
<h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
<p>You have successfully logged in.</p>
<a href="logout.php" class="logout">Logout</a>
</div>
</body>
</html>
