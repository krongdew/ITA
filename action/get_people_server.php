<?php
include 'connect.php';

// Columns
$columns = array('subservice_id', 'number_people', 'Date');

// ตรวจสอบและกำหนดค่า start และ length
$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;

// Order by
$orderColumnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 2; // เปลี่ยนตำแหน่งของคอลัมน์ "timestamp"

if (array_key_exists($orderColumnIndex, $columns)) {
    $orderColumn = $columns[$orderColumnIndex];
} else {
    // กำหนดค่าเริ่มต้นหากไม่พบคีย์
    $orderColumn = 'Date';
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
// เพิ่มตัวแปร $service_id ที่ได้จาก URL parameter
$service_id = isset($_POST['service_id']) ? $_POST['service_id'] : null;

// SQL query
$sql = "SELECT * FROM sa_number_of_people WHERE service_id = :service_id $searchQuery ORDER BY $orderColumn $orderDirection LIMIT $start, $length";


// ใช้ Prepared Statement
$stmt = $conn->prepare($sql);

// เพิ่ม binding parameter สำหรับ service_id
$stmt->bindParam(':service_id', $service_id);

// Execute the query
$stmt->execute();

// Fetch the data and store it in an array
$data = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}


// Total records
$totalRecords = $conn->query("SELECT COUNT(*) FROM sa_number_of_people")->fetchColumn();

// Total filtered records (for pagination)
$totalFiltered = $conn->query("SELECT COUNT(*) FROM sa_number_of_people WHERE 1 $searchQuery")->fetchColumn();

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


