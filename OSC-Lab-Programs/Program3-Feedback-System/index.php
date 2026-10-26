<?php
include("db.php");
if(isset($_POST['submit'])){
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$sql = "INSERT INTO feedback(name, email, message)
VALUES('$name', '$email', '$message')";
if(mysqli_query($conn, $sql)){
echo "<script>alert('Feedback submitted Successfully');</script>";
}
else{
echo "Error: " . mysqli_error($conn);
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Feedback System</title>
<style>
body { font-family:Arial,sans-serif; background-color:#f2f2f2; margin:0; padding:0; }
form { width:400px; margin:80px auto 20px; padding:30px; background-color:white; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.2); }
h2 { text-align:center; margin-bottom:25px; }
label { display:block; margin-top:15px; margin-bottom:6px; font-weight:bold; }
input[type="text"], textarea { width:100%; padding:10px; border:1px solid #ccc; border-radius:5px; box-sizing:border-box; font-size:14px; }
textarea { resize:vertical; }
input[type="submit"] { width:100%; padding:12px; margin-top:20px; border:none; border-radius:5px; background-color:#333; color:white; font-size:16px; cursor:pointer; }
input[type="submit"]:hover { background-color:#555; }
a { display:block; width:400px; margin:10px auto; text-align:center; text-decoration:none; color:#333; font-weight:bold; }
a:hover { text-decoration:underline; }
</style>
</head>
<body>
<form action="" method="post">
<h2>Feedback Form</h2>
<label>Name</label>
<input type="text" name="name" required>
<label>Email</label>
<input type="text" name="email" required>
<label>Feedback</label>
<textarea name="message" rows="5" required></textarea>
<input type="submit" name="submit" value="Submit Feedback"/>
</form>
<a href="./view.php">View Data</a>
</body>
</html>
