<?php
$servername = "localhost";
$username = "flueqdmm_fluenser";
$password = "o5BY9zL%V3ER";
$dbname = "flueqdmm_fluenser";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM ipdomainlist WHERE ip='". $_POST['ip'] ."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $updatesql = "UPDATE ipdomainlist SET domain='". $_POST['domain']. "' WHERE ip='". $_POST['ip']. "'";

    if ($conn->query($updatesql) === TRUE) {
    echo "Record updated successfully";
    } else {
    echo "Error updating record: " . $conn->error;
    }
} else {
    $createsql = "INSERT INTO ipdomainlist (ip, domain, created_at) VALUES ('" . $_POST['ip'] . "', '" .  $_POST['domain'] . "','" . date('Y-m-d h:i:sa') . "')";

    if ($conn->query($createsql) === TRUE) {
    echo "New record created successfully";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>