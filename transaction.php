<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Home</title>
</head>

<body>
    <h1> Page 2 [Transaction History] </h1>

    <h2>Digital Wallet</h2>
    <ol>
        <li><a href="/DigitalWallet/home.php">Home</a></li>
        <li><a href="/transaction.php">Transaction History</a></li>
    </ol>
    <?php
    define("filepath", "Transaction_database.txt");

    $category = $phone = $amount = "";
    $flag = $found = false;

    $fileData = read();

    $data = json_decode($fileData, true);
    $count = 0;
    foreach ($data as  $id => $userdata) {
        $count++;
    }

    ?>

    <h2>Total Records: <?php echo $count ?></h2>

    <?php

    echo "<table>";
    echo "<tr><th>Transaction Category </th>";
    echo "<th>To </th>";
    echo "<th>Amount </th>";
    echo "<th> Transferred On</th></tr>";
    foreach ($data as  $id => $userdata) {
        echo "<tr>";
        echo "<td>" . $data[$id]['category'] . "</td>";
        echo "<td>" . $data[$id]['phone'] . "</td>";
        echo "<td>" . $data[$id]['amount'] . "</td>";
        echo "<td>" . $data[$id]['time'] . "</td>";
        echo "</tr>";
        $count++;
    }
    echo "</table>";

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    ?>
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