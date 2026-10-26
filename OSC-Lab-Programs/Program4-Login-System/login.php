<?php
session_start();
include('db.php');
if(isset($_POST['submit'])) {
$username = $_POST['username'];
$password = $_POST['password'];
$sql = "SELECT * FROM user
WHERE username='$username'
AND password='$password'";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) == 1) {
$_SESSION["username"] = $username;
header("Location: dashboard.php");
exit();
} else {
$error = "Invalid username or password";
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Login</title>
<style>
* { box-sizing:border-box; font-family:Arial,sans-serif; }
body { margin:0; background:#f5f3e8; min-height:100vh; display:flex; justify-content:center; align-items:center; }
.login-box { width:380px; background:white; padding:35px; border-radius:10px; box-shadow:0 5px 20px rgba(0,0,0,0.12); }
h2 { text-align:center; color:#315c45; margin-bottom:25px; }
label { display:block; margin-bottom:7px; color:#444; }
input[type="text"], input[type="password"] { width:100%; padding:11px; margin-bottom:18px; border:1px solid #ccc; border-radius:5px; }
input:focus { outline:none; border-color:#315c45; }
.login-btn { width:100%; padding:12px; background:#315c45; color:white; border:none; border-radius:5px; cursor:pointer; font-size:15px; }
.login-btn:hover { background:#264936; }
.error { background:#f8dddd; color:#a33a3a; padding:10px; margin-bottom:18px; border-radius:5px; text-align:center; }
</style>
</head>
<body>
<div class="login-box">
<h2>User Login</h2>
<?php if(isset($error)) { ?>
<div class="error"><?php echo $error; ?></div>
<?php } ?>
<form method="post">
<label>Username</label>
<input type="text" name="username" placeholder="Enter username" required>
<label>Password</label>
<input type="password" name="password" placeholder="Enter password" required>
<input type="submit" name="submit" value="Login" class="login-btn">
</form>
</div>
</body>
</html>
