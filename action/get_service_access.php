<?php
include 'connect.php';

try {
    $query = "SELECT ID, department_name FROM sa_department";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $data = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }

    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(array('error' => 'Error: ' . $e->getMessage()));
}

$conn = null;
?>
