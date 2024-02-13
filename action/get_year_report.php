<?php
// // get_years.php
// include 'connect.php';

// $selectedYear = isset($_POST['selectedYear']) ? intval($_POST['selectedYear']) : date('Y');

//  // หากปีที่เลือกเป็นปีงบประมาณ ให้ใช้เงื่อนไขของปีงบประมาณ
//  if ($selectedYear < date('Y')) {
//     // หากปีที่เลือกไม่ใช่ปีปัจจุบัน ให้ใช้เงื่อนไขของปีงบประมาณ
   
//     $whereCondition = "WHERE (YEAR(Date) = $selectedYear AND MONTH(Date) >= 10) OR (YEAR(Date) = $selectedYear+1  AND MONTH(Date) <= 9)";
// } else if ($selectedYear > date('Y')) {
    
//     $whereCondition = "WHERE (YEAR(Date) = $selectedYear-1 AND MONTH(Date) >= 10) OR (YEAR(Date) = $selectedYear  AND MONTH(Date) <= 9)";
// }

// else {
//     // หากปีที่เลือกเป็นปีปัจจุบัน ให้ใช้เงื่อนไขของปีปัจจุบัน
//     $whereCondition = "WHERE (MONTH(Date) >= 10 AND YEAR(Date) = $selectedYear-1) OR (MONTH(Date) <= 9 AND YEAR(Date) = $selectedYear )";
// }




// $sql = "SELECT DISTINCT YEAR(Date) as year FROM sa_number_of_people $whereCondition ORDER BY YEAR(Date) DESC";
// $stmt = $conn->prepare($sql);

// $stmt->execute();

// $years = $stmt->fetchAll(PDO::FETCH_COLUMN);
// echo json_encode($years);
?>

<?php
// get_years.php
include 'connect.php';

$sql = "SELECT DISTINCT YEAR(Date) as year FROM sa_number_of_people ORDER BY YEAR(Date) DESC";
$stmt = $conn->query($sql);

$years = $stmt->fetchAll(PDO::FETCH_COLUMN);
echo json_encode($years);
?>


