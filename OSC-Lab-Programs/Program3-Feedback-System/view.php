<?php
include("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Feedback</title>
<style>
* { box-sizing:border-box; margin:0; padding:0; font-family:Arial,sans-serif; }
body { background:#f4f6f9; padding:40px 20px; }
.container { max-width:1000px; margin:auto; background:white; padding:30px; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.1); }
h1 { text-align:center; color:#333; margin-bottom:25px; }
table { width:100%; border-collapse:collapse; margin-bottom:25px; }
th { background:#333; color:white; padding:14px; text-align:left; }
td { padding:12px 14px; border-bottom:1px solid #ddd; color:#444; }
tr:hover { background:#f5f5f5; }
.back-btn { display:inline-block; text-decoration:none; background:#333; color:white; padding:10px 18px; border-radius:6px; }
.back-btn:hover { background:#555; }
@media (max-width:700px) { .container { padding:15px; overflow-x:auto; } table { min-width:600px; } }
</style>
</head>
<body>
<div class="container">
<h1>Feedback Details</h1>
<table>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th></tr>
<?php
$sql = "SELECT * FROM feedback";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)) {
?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['message']; ?></td>
</tr>
<?php } ?>
</table>
<a href="./index.php" class="back-btn">&larr; Back to Form</a>
</div>
</body>
</html>
