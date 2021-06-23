<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Home</title>
</head>

<body>
    <h1> Page 1 [Home] </h1>

    <?php
    define("filepath", "Transaction_database.txt");

    $category = $phone = $amount = "";
    $categoryErr = $amountErr = $phoneErr = "";
    $successfulMessage = $errorMessage = "";
    $time = date("Y-m-d H:i:s");

    $flag = false;

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $category = $_POST['category'];
        $phone = $_POST['phone'];
        $amount = $_POST['amount'];

        if (empty($category)) {
            $categoryErr = "Please select an option";
            $flag = true;
        }
        if (empty($phone)) {
            $phoneErr = "Enter a number";
            $flag = true;
        } /*elseif (substr($phone, 0, 4) != "+880" && strlen($phone) != 13 or substr($phone, 0, 1) == "01" && strlen($phone) != 11) {
            $phoneErr = "Enter a valid number";
            $flag = true;
        } else {
            $phoneErr = "Enter a valid number";
            $flag = true;
        }*/

        if (empty($amount)) {
            $amountErr = "Enter a valid amount!";
            $flag = true;
        } elseif ($amount <= 0) {
            $amountErr = "Enter Valid Amount!";
            $flag = true;
        }

        if (!$flag) {
            $category = test_input($category);
            $phone = test_input($phone);
            $amount = test_input($amount);

            $fileData = read();

            if (empty($fileData)) {
                $data[] = array("category" => $category, "phone" => $phone, "amount" => $amount, "time" => $time);
            } else {
                $data = json_decode($fileData);
                array_push($data, array("category" => $category, "phone" => $phone, "amount" => $amount, "time" => $time));
            }
            $data_encode = json_encode($data, JSON_PRETTY_PRINT);
            write("");
            $result1 = write($data_encode);
            if ($result1) {
                $successfulMessage = $category .     "Your Transaction is Successful";
            } else {
                $errorMessage = "Error while saving.";
            }
        }
    }

    function write($content)
    {
        $resource = fopen(filepath, "w");
        $fw = fwrite($resource, $content . "\n");
        fclose($resource);
        return $fw;
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    ?>
    <h2>Digital Wallet</h2>
    <ol>
        <li><a href="/home.php">Home</a></li>
        <li><a href="/DigitalWallet/transaction.php">Transaction History</a></li>
    </ol>

    <h2>Fund Trasnfer</h2>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <label for="category">Select Category:</label>
        <select name="category" id="category" value="<?php echo isset($_POST['category']) ? $_POST['category'] : '' ?>">
            <option value="">Select a category</option>
            <option value="mobile_reacharge">Mobile Reacharge</option>
            <option value="send_money">Send Money</option>
            <option value="merchant_pay">Merchant Pay</option>
        </select>
        <span style="color: red;"><?php echo $categoryErr; ?></span><br><br>

        <label for="phone">Phone:</label>
        <input type="tel" name="phone" id="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : '' ?>"><br><br>
        <label for=" amount">Amount:</label>
        <input type="int" name="amount" id="amount" value="<?php echo isset($_POST['amount']) ? $_POST['amount'] : '' ?>">
        <span style="color: red;"><?php echo $amountErr; ?></span><br><br>

        <input type="submit" value="submit">
    </form>

    <span style="color: green;"><?php echo $successfulMessage; ?></span>
    <span style="color: red;"><?php echo $errorMessage; ?></span>

    <?php

    function read()
    {
        $resource = fopen(filepath, "r");
        $fz = filesize(filepath);
        $fr = "";
        if ($fz > 0) {
            $fr = fread($resource, $fz);
        }
        fclose($resource);
        return $fr;
    }
    ?>

</body>

</html>