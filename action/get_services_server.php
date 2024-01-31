<?php
include 'connect.php';

// Columns
$columns = array('service_name', 'service_detail', 'service_status','service_Access','updated_at');

// ตรวจสอบและกำหนดค่า start และ length
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;

// Order by
$orderColumnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 6; // เปลี่ยนตำแหน่งของคอลัมน์ "timestamp"

if (array_key_exists($orderColumnIndex, $columns)) {
    $orderColumn = $columns[$orderColumnIndex];
} else {
    // กำหนดค่าเริ่มต้นหากไม่พบคีย์
    $orderColumn = 'updated_at';
}

$orderDirection = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';

// Search
$searchValue = $_POST['search']['value'];
$searchQuery = '';
if (!empty($searchValue)) {
    $searchQuery = " AND (";
    foreach ($columns as $column) {
        $searchQuery .= "$column LIKE '%$searchValue%' OR ";
    }
    $searchQuery = rtrim($searchQuery, " OR ");
    $searchQuery .= ")";
}

// SQL query
// SQL query
$sql = "SELECT * FROM sa_services WHERE 1 $searchQuery ORDER BY $orderColumn $orderDirection LIMIT $start, $length";


// Execute the query
$result = $conn->query($sql);

// Fetch the data and store it in an array
$data = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}

// Total records
$totalRecords = $conn->query("SELECT COUNT(*) FROM sa_services")->fetchColumn();

// Total filtered records (for pagination)
$totalFiltered = $conn->query("SELECT COUNT(*) FROM sa_services WHERE 1 $searchQuery")->fetchColumn();

// Convert the array to JSON
$jsonData = array(
    "draw"            => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
    "recordsTotal"    => $totalRecords,
    "recordsFiltered" => $totalFiltered,
    "data"            => $data
);

// Send the response
echo json_encode($jsonData);
?>


