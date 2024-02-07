<?php
include 'connect.php';

// ในไฟล์ connect.php หรือไฟล์ที่เกี่ยวข้อง
function getServiceName($serviceId)
{
    global $conn; // ตัวแปรเชื่อมต่อฐานข้อมูล

    // คำสั่ง SQL เพื่อดึงข้อมูล service_name จาก ID ของบริการ
    $sql = "SELECT service_name FROM sa_services WHERE ID = :service_id";

    // ใช้ Prepared Statement เพื่อป้องกัน SQL Injection
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':service_id', $serviceId);
    $stmt->execute();

    // ดึงข้อมูลจากฐานข้อมูล
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

// ที่เพิ่มเข้าไป
$selectedYear = isset($_POST['selectedYear']) ? intval($_POST['selectedYear']) : date('Y'); // ในกรณีที่ไม่ได้รับค่าให้ใช้ปีปัจจุบัน
$userdepartment = isset($_POST['userdepartment']) ? $_POST['userdepartment'] : 0;

// Additional condition based on userdepartment
$userDepartmentCondition = ($userdepartment == 0) ? '' : " AND service_Access = $userdepartment";


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
    // ที่เพิ่มเข้าไป
    $query = "SELECT sa_services.service_Access, sa_services.ID,
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
INNER JOIN sa_services ON sa_number_of_people.service_id = sa_services.ID
WHERE YEAR(Date) = :selectedYear $userDepartmentCondition
GROUP BY sa_services.service_Access, sa_services.ID
ORDER BY sa_services.service_Access, sa_services.ID";



    $stmt = $conn->prepare($query);
    // ที่เพิ่มเข้าไป
    $stmt->bindParam(':selectedYear', $selectedYear);
    $stmt->execute();

    $data = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // เรียกใช้ฟังก์ชันเพื่อดึงชื่อบริการ
        $serviceName = getServiceName($row['ID']);

        $data[] = array(
            "service_id" => $serviceName['service_name'],
            "service_Access" => $row['service_Access'],
            "Jan" => $row['Jan'],
            "Feb" => $row['Feb'],
            "Mar" => $row['Mar'],
            "Apr" => $row['Apr'],
            "May" => $row['May'],
            "Jun" => $row['Jun'],
            "Jul" => $row['Jul'],
            "Aug" => $row['Aug'],
            "Sep" => $row['Sep'],
            "Oct" => $row['Oct'],
            "Nov" => $row['Nov'],
            "Dec" => $row['Dec']
        );
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
