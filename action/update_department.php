<?php
include 'connect.php';

if(isset($_POST['departmentID']) && isset($_POST['editedData'])) {
    $departmentID = $_POST['departmentID'];
    $editedData = $_POST['editedData'];

    // Update data in the database
    $stmt = $conn->prepare("UPDATE sa_department SET department_name = :department_name, owner_name = :owner_name WHERE id = :departmentID");
    $stmt->bindParam(':department_name', $editedData['department_name'], PDO::PARAM_STR);
    $stmt->bindParam(':owner_name', $editedData['owner_name'], PDO::PARAM_STR);
    $stmt->bindParam(':departmentID', $departmentID, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
} else {
    echo json_encode(['status' => 'errorID']);
}
?>
