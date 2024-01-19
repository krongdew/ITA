<?php
// Include your database connection here
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];

    // Check if the username exists in the database
    // Perform your database query here, for example:
    $sql = "SELECT * FROM sa_users WHERE Username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    // For the purpose of this example, simulate a result
    $exists = true;

    if ($exists) {
        // echo 'exists';
        echo json_encode(['status' => 'exists']);
    } else {
        // echo 'not exists';
        echo json_encode(['status' => 'not exists']);
    }
}
?>
