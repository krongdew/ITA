<?php
include 'connect.php';

// Columns
$columns = array('department_name', 'owner_name', 'timestamp');

// Total records
$totalRecords = $conn->query("SELECT COUNT(*) FROM sa_department")->fetchColumn();

// SQL query
$sql = "SELECT * FROM sa_department";

// Execute the query
$result = $conn->query($sql);

// Fetch the data and store it in an array
$data = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}

// Convert the array to JSON
$jsonData = array(
    "draw"            => 1, // For simplicity, set to 1. You can increment this for each request.
    "recordsTotal"    => $totalRecords,
    "recordsFiltered" => $totalRecords,
    "data"            => $data
);

// Send the response
echo json_encode($jsonData);
?>
