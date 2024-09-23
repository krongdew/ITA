<?php
include 'connect.php';

$userdepartment = isset($_GET['userdepartment']) ? $_GET['userdepartment'] : 0;

// เช็คว่ามี userDepartmentCondition หรือไม่ ถ้ามีให้ใส่เงื่อนไขที่สร้างขึ้น ไม่งั้นให้ให้เป็นค่าว่าง
$userDepartmentCondition = ($userdepartment == 0) ? '' : " AND s.service_Access = $userdepartment";

// คำสั่ง SQL สำหรับหาผลรวมของบริการที่มี service_id เดียวกันในเดือนปัจจุบันจาก sa_number_of_people
$sqlNumberPeople = "SELECT s.ID, s.service_name, s.service_Access, 
                           SUM(np.number_people) AS total_users
                    FROM sa_services s
                    LEFT JOIN sa_number_of_people np ON np.service_id = s.ID 
                    WHERE (MONTH(np.date) = MONTH(CURRENT_DATE()) AND YEAR(np.date) = YEAR(CURRENT_DATE())) $userDepartmentCondition
                    GROUP BY s.ID, s.service_name, s.service_Access";

// คำสั่ง SQL สำหรับหาผลรวมของบริการที่มี service_id เดียวกันในเดือนปัจจุบันจาก sa_respondent
$sqlRespondent = "SELECT s.ID, s.service_name, s.service_Access, 
                         COUNT(sr.service_id) AS total_person
                  FROM sa_services s
                  LEFT JOIN sa_respondent sr ON sr.service_id = s.ID 
                       AND MONTH(sr.SubmissionDate) = MONTH(CURDATE()) 
                       AND YEAR(sr.SubmissionDate) = YEAR(CURDATE())
                  WHERE 1=1 $userDepartmentCondition
                  GROUP BY s.ID, s.service_name, s.service_Access";

// ดึงข้อมูลจากฐานข้อมูลโดยใช้ PDO
$stmtNumberPeople = $conn->query($sqlNumberPeople);
$stmtRespondent = $conn->query($sqlRespondent);

// เตรียมข้อมูลให้เป็นรูปแบบ JSON
$data = [];
$serviceData = [];

// จัดเก็บข้อมูลจาก sa_number_of_people
while ($row = $stmtNumberPeople->fetch(PDO::FETCH_ASSOC)) {
    $serviceData[$row['ID']] = [
        'service_name' => $row['service_name'],
        'service_Access' => $row['service_Access'],
        'total_users' => $row['total_users'],
        'total_person' => 0, // ค่าเริ่มต้นสำหรับ total_person
        'total_combined' => $row['total_users'], // ค่าเริ่มต้นสำหรับ total_combined
    ];
}

// จัดเก็บข้อมูลจาก sa_respondent และรวมกับข้อมูลจาก sa_number_of_people ถ้ามี
while ($row = $stmtRespondent->fetch(PDO::FETCH_ASSOC)) {
    if (isset($serviceData[$row['ID']])) {
        $serviceData[$row['ID']]['total_person'] = $row['total_person'];
        $serviceData[$row['ID']]['total_combined'] += $row['total_person'];
    } else {
        $serviceData[$row['ID']] = [
            'service_name' => $row['service_name'],
            'service_Access' => $row['service_Access'],
            'total_users' => 0, // ค่าเริ่มต้นสำหรับ total_users
            'total_person' => $row['total_person'],
            'total_combined' => $row['total_person'],
        ];
    }
}

// จัดเรียงข้อมูลตาม total_combined ในลำดับจากมากไปน้อย
usort($serviceData, function($a, $b) {
    return $b['total_combined'] - $a['total_combined'];
});

// จำกัดข้อมูลเพียง 5 อันดับ
$data = array_slice($serviceData, 0, 5);

// ส่งข้อมูลในรูปแบบ JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
