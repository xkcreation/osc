<!DOCTYPE html>
<html>
<head>
    <title>Electricity Bill Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 30px;
            text-align: center;
        }

        .form-box {
            margin: 20px auto 35px;
        }

        input {
            padding: 8px;
            margin: 8px;
        }

        button {
            padding: 8px 15px;
            cursor: pointer;
        }

        .bill {
            width: 350px;
            max-width: 85%;
            margin: auto;
            border: 1px solid black;
            padding: 20px;
            text-align: left;
            background: white;
        }

        .bill h2 {
            text-align: center;
            border-bottom: 1px solid #aaa;
            padding-bottom: 15px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin: 18px 0;
        }

        .total {
            color: darkred;
            font-weight: bold;
            font-size: 18px;
            border-top: 1px solid #aaa;
            border-bottom: 1px solid #aaa;
            padding: 15px 0;
        }

        .thanks {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<h2>Electricity Bill Generator</h2>

<div class="form-box">
    <form method="POST">
        Consumer Name:
        <input type="text" name="customer_name"
               value="<?php echo isset($_POST['customer_name']) ? htmlspecialchars($_POST['customer_name']) : ''; ?>"
               required>
        <br>

        Units Consumed:
        <input type="number" name="units" min="0"
               step="0.01" required>
        <br>

        <button type="submit" name="submit">Generate Bill</button>
    </form>
</div>

<?php
if (isset($_POST['submit'])) {
    $name = htmlspecialchars(trim($_POST['customer_name']));
    $units = (float)$_POST['units'];

    // Sample energy charge rates
    if ($units <= 100) {
        $energy = $units * 2;
    } elseif ($units <= 200) {
        $energy = (100 * 2) + (($units - 100) * 3);
    } elseif ($units <= 300) {
        $energy = (100 * 2) + (100 * 3)
                + (($units - 200) * 3);
    } else {
        $energy = (100 * 2) + (100 * 3)
                + (100 * 3) + (($units - 300) * 5);
    }

    $fixed = 50;
    $total = $energy + $fixed;
?>

<div class="bill">
    <h2>TNEB ELECTRICITY BILL</h2>

    <div class="row">
        <strong>Consumer Name</strong>
        <span><?php echo $name; ?></span>
    </div>

    <div class="row">
        <strong>Units Consumed</strong>
        <span><?php echo $units; ?> Units</span>
    </div>

    <div class="row">
        <strong>Energy Charges</strong>
        <span>₹ <?php echo number_format($energy, 2); ?></span>
    </div>

    <div class="row">
        <strong>Fixed Charges</strong>
        <span>₹ <?php echo number_format($fixed, 2); ?></span>
    </div>

    <div class="row total">
        <span>Total Bill Amount</span>
        <span>₹ <?php echo number_format($total, 2); ?></span>
    </div>

    <div class="thanks">
        Thank You - Pay Before Due Date
    </div>
</div>

<?php } ?>

</body>
</html>