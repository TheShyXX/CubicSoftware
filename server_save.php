<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cubicsoftware";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['data'])) {
    $data = $_POST['data'];
    $sql = "INSERT INTO collected_data (transaction_number) VALUES ('$data')";

    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
        exit;
    }

    echo "Data stored successfully";
}else{
    echo "No data receive";
}

$conn->close();

