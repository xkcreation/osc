<?php
// Initialize variables
$show_bill = false;
$name = "";
$units = "";
$energy_charges = 0;
$fixed_charges = 50.00;
$total_amount = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$name = htmlspecialchars($_POST['consumer_name']);
$units = (int)$_POST['units'];
// Calculation Logic
// First 100 units @ Rs 2.50
// Remaining units @ Rs 3.50
if ($units <= 100) {
$energy_charges = $units * 2.50;
} else {
$energy_charges = (100 * 2.50) + (($units - 100) * 3.50);
}
$total_amount = $energy_charges + $fixed_charges;
$show_bill = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Electricity Bill Generator</title>
<style>
body { background-color:#eaf5fa; font-family:Arial,sans-serif; color:#00334e; display:flex; flex-direction:column; align-items:center; padding-top:40px; margin:0; }
h1 { color:#003b5c; margin-bottom:30px; }
.form-table { border-spacing:0 15px; }
.form-table td { padding:0 10px; }
.form-table label { font-weight:bold; color:#003b5c; }
.form-table input { padding:8px; border:1px solid #a8c6d9; border-radius:3px; width:170px; font-size:14px; }
.btn-container { text-align:center; margin-top:10px; }
.submit-btn { padding:6px 15px; background-color:#f7fbfc; border:1px solid #7094a8; color:#003b5c; border-radius:3px; cursor:pointer; font-size:14px; }
.submit-btn:hover { background-color:#dbeaf1; }
.bill-container { margin-top:40px; background-color:#fff; border:2px solid #1c4b66; padding:30px 40px; width:420px; box-sizing:border-box; box-shadow:2px 2px 5px rgba(0,0,0,0.05); }
.bill-title { text-align:center; font-size:20px; font-weight:bold; color:#003b5c; text-transform:uppercase; margin-bottom:20px; }
hr { border:0; border-top:1px solid #cbd6dd; margin:15px 0; }
.bill-details { width:100%; border-collapse:collapse; }
.bill-details td { padding:8px 0; font-size:15px; }
.bill-details td:first-child { font-weight:bold; color:#003b5c; width:60%; }
.bill-details td:last-child { color:#2c5973; }
.total-row { display:flex; justify-content:space-between; padding:5px 0; color:#922036; font-size:17px; font-weight:bold; }
.footer-msg { text-align:center; font-size:13px; font-weight:bold; color:#003b5c; margin-top:20px; }
</style>
</head>
<body>
<h1>Electricity Bill Generator</h1>
<form method="POST" action="">
<table class="form-table">
<tr>
<td align="right"><label for="consumer_name">Consumer Name</label></td>
<td><input type="text" id="consumer_name" name="consumer_name" value="<?php echo htmlspecialchars($name); ?>" required></td>
</tr>
<tr>
<td align="right"><label for="units">Units Consumed</label></td>
<td><input type="number" id="units" name="units" value="<?php echo htmlspecialchars($units); ?>" required min="0"></td>
</tr>
</table>
<div class="btn-container">
<button type="submit" class="submit-btn">Generate Bill</button>
</div>
</form>
<?php if ($show_bill): ?>
<div class="bill-container">
<div class="bill-title">TNEB ELECTRICITY BILL</div>
<hr>
<table class="bill-details">
<tr><td>Consumer Name</td><td><?php echo $name; ?></td></tr>
<tr><td>Units Consumed</td><td><?php echo $units; ?> Units</td></tr>
<tr><td>Energy Charges</td><td>&#8377; <?php echo number_format($energy_charges, 2); ?></td></tr>
<tr><td>Fixed Charges</td><td>&#8377; <?php echo number_format($fixed_charges, 2); ?></td></tr>
</table>
<hr>
<div class="total-row">
<span>Total Bill Amount</span>
<span>&#8377; <?php echo number_format($total_amount, 2); ?></span>
</div>
<hr>
<div class="footer-msg">Thank You - Pay Before Due Date</div>
</div>
<?php endif; ?>
</body>
</html>
