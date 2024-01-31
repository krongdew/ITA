<?php
include 'connect.php';

$columns = array('service_id', 'subservice_id', 'number_people', 'Date');

$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;

$orderColumnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 6;
$columnsOrder = array('service_id', 'subservice_id', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

if (array_key_exists($orderColumnIndex, $columnsOrder)) {
    $orderColumn = $columnsOrder[$orderColumnIndex];
} else {
    $orderColumn = 'Date'; // ตั้งค่าเริ่มต้นเป็น 'Date' หรือคอลัมน์ที่ต้องการให้เรียง
}

$orderDirection = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';

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

try {
    $query = "SELECT service_id, subservice_id, 
                SUM(CASE WHEN MONTH(Date) = 1 THEN number_people ELSE 0 END) as Jan,
                SUM(CASE WHEN MONTH(Date) = 2 THEN number_people ELSE 0 END) as Feb,
                SUM(CASE WHEN MONTH(Date) = 3 THEN number_people ELSE 0 END) as Mar,
                SUM(CASE WHEN MONTH(Date) = 4 THEN number_people ELSE 0 END) as Apr,
                SUM(CASE WHEN MONTH(Date) = 5 THEN number_people ELSE 0 END) as May,
                SUM(CASE WHEN MONTH(Date) = 6 THEN number_people ELSE 0 END) as Jun,
                SUM(CASE WHEN MONTH(Date) = 7 THEN number_people ELSE 0 END) as Jul,
                SUM(CASE WHEN MONTH(Date) = 8 THEN number_people ELSE 0 END) as Aug,
                SUM(CASE WHEN MONTH(Date) = 9 THEN number_people ELSE 0 END) as Sep,
                SUM(CASE WHEN MONTH(Date) = 10 THEN number_people ELSE 0 END) as Oct,
                SUM(CASE WHEN MONTH(Date) = 11 THEN number_people ELSE 0 END) as Nov,
                SUM(CASE WHEN MONTH(Date) = 12 THEN number_people ELSE 0 END) as `Dec`
          FROM sa_number_of_people
          GROUP BY service_id, subservice_id";


    $stmt = $conn->prepare($query);
    $stmt->execute();

    $data = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }

    $totalRecords = $conn->query("SELECT COUNT(*) FROM sa_number_of_people")->fetchColumn();
    $totalFiltered = $conn->query("SELECT COUNT(*) FROM sa_number_of_people WHERE 1 $searchQuery")->fetchColumn();

    $jsonData = array(
        "draw"            => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
        "recordsTotal"    => $totalRecords,
        "recordsFiltered" => $totalFiltered,
        "data"            => $data
    );

    echo json_encode($jsonData);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
