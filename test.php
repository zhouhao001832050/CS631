<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve account and password from the form
    $account = $_POST["account"];
    $password = $_POST["password"];

    // Database connection details
    $server = "localhost";
    $username = "root";
    $db_password = "";
    $database = "CS631";

    // Establish database connection
    $connect = mysqli_connect($server, $username, $db_password, $database);

    if(mysqli_connect_error()) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // SQL query to select password based on account
    $sql = "SELECT PASSWORD FROM CUSTOMER WHERE ACCOUNT = '$account'";
    $result = mysqli_query($connect, $sql);

    if (!$result) {
        echo "Query error: " . mysqli_error($connect);
    } else {
        if (mysqli_num_rows($result) > 0) {
            // Account found, check password
            $row = mysqli_fetch_assoc($result);
            $storedPassword = $row["PASSWORD"];

            if ($password==$storedPassword) {
                // Password is correct, display all information
                echo "<h2>Customer Information</h2>";
                $infoSql = "SELECT * FROM CUSTOMER WHERE ACCOUNT = '$account'";
                $infoResult = mysqli_query($connect, $infoSql);

                if ($infoResult) {
                    $infoRow = mysqli_fetch_assoc($infoResult);

                    echo "CID: " . $infoRow["CID"] . "<br>";
                    echo "Email: " . $infoRow["EMAIL"] . "<br>";
                    echo "Address: " . $infoRow["ADDRESS"] . "<br>";
                    echo "Phone: " . $infoRow["PHONE"] . "<br>";
                    echo "First Name: " . $infoRow["FNAME"] . "<br>";
                    echo "Last Name: " . $infoRow["LNAME"] . "<br>";
                    echo "Status: " . $infoRow["STATUS"] . "<br>";
                } else {
                    echo "Error retrieving customer information.";
                }
            } else {
                echo "Incorrect password for Account $account";
            }
        } else {
            // Account not found, prompt user to create an account
            echo "Account not found. Please create an account.";
        }
    }

    mysqli_close($connect);
} else {
    // Redirect to the index.html if accessed directly
    header("Location: index.html");
    exit();
}
?>