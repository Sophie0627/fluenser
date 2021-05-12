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

    $sql = "SELECT * FROM ipdomainlist WHERE ip='". $_GET['ip']. "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row['domain'];
    }
    } else {
    echo "0 results";
    }
    $conn->close();
?>