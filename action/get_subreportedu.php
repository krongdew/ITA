
<?php
include 'connect.php';

// ในไฟล์ connect.php หรือไฟล์ที่เกี่ยวข้อง
function getServiceName($subservice_id)
{
    global $conn; // ตัวแปรเชื่อมต่อฐานข้อมูล

    // คำสั่ง SQL เพื่อดึงข้อมูล service_name จาก ID ของบริการ
    $sql = "SELECT subservice_name FROM sa_subservices WHERE ID = :subservice_id";

    // ใช้ Prepared Statement เพื่อป้องกัน SQL Injection
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':subservice_id', $subservice_id);
    $stmt->execute();

    // ดึงข้อมูลจากฐานข้อมูล
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

// ที่เพิ่มเข้าไป
$selectedYear = isset($_POST['selectedYear']) ? intval($_POST['selectedYear']) : date('Y'); // ในกรณีที่ไม่ได้รับค่าให้ใช้ปีปัจจุบัน
$selectedYearNext = $selectedYear + 1;

// หากปีที่เลือกเป็นปีการศึกษา ให้ใช้เงื่อนไขของปีการศึกษา
if ($selectedYear != date('Y')) {
    // หากปีที่เลือกไม่ใช่ปีปัจจุบัน ให้ใช้เงื่อนไขของปีการศึกษา
    $whereConditionPeople = "WHERE ((YEAR(Date) = :selectedYear AND MONTH(Date) >= 8) OR (YEAR(Date) = :selectedYearNext AND MONTH(Date) <= 7))";
    $whereConditionRespondent = "WHERE ((YEAR(SubmissionDate) = :selectedYear AND MONTH(SubmissionDate) >= 8) OR (YEAR(SubmissionDate) = :selectedYearNext AND MONTH(SubmissionDate) <= 7))";
    $whereConditionResponse = "WHERE ((YEAR(date_data.assessment_date) = $selectedYear AND MONTH(date_data.assessment_date) >= 8) OR (YEAR(date_data.assessment_date) = $selectedYearNext AND MONTH(date_data.assessment_date) <= 7))";
} else {
    // หากปีที่เลือกเป็นปีปัจจุบัน ให้ใช้เงื่อนไขของปีปัจจุบัน
    $whereConditionPeople = "WHERE ((MONTH(Date) >= 8 AND YEAR(Date) = :selectedYear) OR (MONTH(Date) <= 7 AND YEAR(Date) = :selectedYearNext))";
    $whereConditionRespondent = "WHERE ((MONTH(SubmissionDate) >= 8 AND YEAR(SubmissionDate) = :selectedYear) OR (MONTH(SubmissionDate) <= 7 AND YEAR(SubmissionDate) = :selectedYearNext))";
    $whereConditionResponse = "WHERE ((MONTH(date_data.assessment_date) >= 8 AND YEAR(date_data.assessment_date) = $selectedYear) OR (MONTH(date_data.assessment_date) <= 7 AND YEAR(date_data.assessment_date) = $selectedYearNext))";
}

$userdepartment = isset($_POST['userdepartment']) ? $_POST['userdepartment'] : 0;

// Additional condition based on userdepartment
$userDepartmentCondition = ($userdepartment == 0) ? '' : " AND sa_subservices.service_Access = $userdepartment";

$startMonth = isset($_POST['startMonth']) ? $_POST['startMonth'] : null;
$endMonth = isset($_POST['endMonth']) ? $_POST['endMonth'] : null;

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
    $query = "SELECT 
        sa_subservices.service_id, 
        sa_subservices.ID AS subservice_id, 
        sa_subservices.sub_ea,
        COALESCE(SUM(num_people.Jan), 0) + COALESCE(SUM(respondents.Jan), 0) + COALESCE(SUM(responses.Jan), 0) as Jan,
        COALESCE(SUM(num_people.Feb), 0) + COALESCE(SUM(respondents.Feb), 0) + COALESCE(SUM(responses.Feb), 0) as Feb,
        COALESCE(SUM(num_people.Mar), 0) + COALESCE(SUM(respondents.Mar), 0) + COALESCE(SUM(responses.Mar), 0) as Mar,
        COALESCE(SUM(num_people.Apr), 0) + COALESCE(SUM(respondents.Apr), 0) + COALESCE(SUM(responses.Apr), 0) as Apr,
        COALESCE(SUM(num_people.May), 0) + COALESCE(SUM(respondents.May), 0) + COALESCE(SUM(responses.May), 0) as May,
        COALESCE(SUM(num_people.Jun), 0) + COALESCE(SUM(respondents.Jun), 0) + COALESCE(SUM(responses.Jun), 0) as Jun,
        COALESCE(SUM(num_people.Jul), 0) + COALESCE(SUM(respondents.Jul), 0) + COALESCE(SUM(responses.Jul), 0) as Jul,
        COALESCE(SUM(num_people.Aug), 0) + COALESCE(SUM(respondents.Aug), 0) + COALESCE(SUM(responses.Aug), 0) as Aug,
        COALESCE(SUM(num_people.Sep), 0) + COALESCE(SUM(respondents.Sep), 0) + COALESCE(SUM(responses.Sep), 0) as Sep,
        COALESCE(SUM(num_people.Oct), 0) + COALESCE(SUM(respondents.Oct), 0) + COALESCE(SUM(responses.Oct), 0) as Oct,
        COALESCE(SUM(num_people.Nov), 0) + COALESCE(SUM(respondents.Nov), 0) + COALESCE(SUM(responses.Nov), 0) as Nov,
        COALESCE(SUM(num_people.Dec), 0) + COALESCE(SUM(respondents.Dec), 0) + COALESCE(SUM(responses.Dec), 0) as `Dec`
    FROM 
        sa_subservices
    LEFT JOIN (
        SELECT 
            subservice_id,
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
        FROM 
            sa_number_of_people 
        $whereConditionPeople
        GROUP BY 
            subservice_id
    ) num_people ON sa_subservices.ID = num_people.subservice_id
    LEFT JOIN (
        SELECT 
            subservice_id,
            SUM(CASE WHEN MONTH(SubmissionDate) = 1 THEN 1 ELSE 0 END) as Jan,
            SUM(CASE WHEN MONTH(SubmissionDate) = 2 THEN 1 ELSE 0 END) as Feb,
            SUM(CASE WHEN MONTH(SubmissionDate) = 3 THEN 1 ELSE 0 END) as Mar,
            SUM(CASE WHEN MONTH(SubmissionDate) = 4 THEN 1 ELSE 0 END) as Apr,
            SUM(CASE WHEN MONTH(SubmissionDate) = 5 THEN 1 ELSE 0 END) as May,
            SUM(CASE WHEN MONTH(SubmissionDate) = 6 THEN 1 ELSE 0 END) as Jun,
            SUM(CASE WHEN MONTH(SubmissionDate) = 7 THEN 1 ELSE 0 END) as Jul,
            SUM(CASE WHEN MONTH(SubmissionDate) = 8 THEN 1 ELSE 0 END) as Aug,
            SUM(CASE WHEN MONTH(SubmissionDate) = 9 THEN 1 ELSE 0 END) as Sep,
            SUM(CASE WHEN MONTH(SubmissionDate) = 10 THEN 1 ELSE 0 END) as Oct,
            SUM(CASE WHEN MONTH(SubmissionDate) = 11 THEN 1 ELSE 0 END) as Nov,
            SUM(CASE WHEN MONTH(SubmissionDate) = 12 THEN 1 ELSE 0 END) as `Dec`
        FROM 
            sa_respondent
        $whereConditionRespondent
        GROUP BY 
            subservice_id
    ) respondents ON sa_subservices.ID = respondents.subservice_id
    LEFT JOIN (
   SELECT 
    subservice_data.subservice_id,
    date_data.assessment_date,
    SUM(CASE WHEN MONTH(assessment_date) = 1 THEN 1 ELSE 0 END) as Jan,
    SUM(CASE WHEN MONTH(assessment_date) = 2 THEN 1 ELSE 0 END) as Feb,
    SUM(CASE WHEN MONTH(assessment_date) = 3 THEN 1 ELSE 0 END) as Mar,
    SUM(CASE WHEN MONTH(assessment_date) = 4 THEN 1 ELSE 0 END) as Apr,
    SUM(CASE WHEN MONTH(assessment_date) = 5 THEN 1 ELSE 0 END) as May,
    SUM(CASE WHEN MONTH(assessment_date) = 6 THEN 1 ELSE 0 END) as Jun,
            SUM(CASE WHEN MONTH(assessment_date) = 7 THEN 1 ELSE 0 END) as Jul,
            SUM(CASE WHEN MONTH(assessment_date) = 8 THEN 1 ELSE 0 END) as Aug,
            SUM(CASE WHEN MONTH(assessment_date) = 9 THEN 1 ELSE 0 END) as Sep,
            SUM(CASE WHEN MONTH(assessment_date) = 10 THEN 1 ELSE 0 END) as Oct,
            SUM(CASE WHEN MONTH(assessment_date) = 11 THEN 1 ELSE 0 END) as Nov,
            SUM(CASE WHEN MONTH(assessment_date) = 12 THEN 1 ELSE 0 END) as `Dec`
    FROM 
        sa_response2
        
        CROSS JOIN JSON_TABLE(
            sa_response2.Responses,
            '$[*]' COLUMNS (
                subservice_id VARCHAR(50) PATH '$.Answer',
                question_type VARCHAR(50) PATH '$.QuestionType'
            )
        ) AS subservice_data
    
        CROSS JOIN JSON_TABLE(
            sa_response2.Responses,
            '$[*]' COLUMNS (
                assessment_date VARCHAR(50) PATH '$.Answer',
                question_type VARCHAR(50) PATH '$.QuestionType'
            )
        ) AS date_data
        
    $whereConditionResponse
         
    GROUP BY 
        subservice_data.subservice_id,
        date_data.assessment_date

    ) responses ON sa_subservices.ID = responses.subservice_id

    WHERE 
        1 $userDepartmentCondition
    GROUP BY 
        sa_subservices.service_id, sa_subservices.ID, sa_subservices.sub_ea
    ORDER BY 
        sa_subservices.service_id, sa_subservices.ID
";


    // รันคำสั่ง SQL และดึงข้อมูล
    $stmt = $conn->prepare($query);


    
    $stmt->bindParam(':selectedYear', $selectedYear);
    $stmt->bindParam(':selectedYearNext', $selectedYearNext);
    
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // เรียกใช้ฟังก์ชันเพื่อดึงชื่อบริการ
        $serviceName = getServiceName($row['subservice_id']);

        $data[] = array(
            "subservice_id" => $serviceName['subservice_name'],
            "service_id" => $row['service_id'],
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
            "Dec" => $row['Dec'],
         "sub_ea" => $row['sub_ea']
        );
    }

    $totalRecords = $conn->query("SELECT COUNT(*) FROM sa_subservices")->fetchColumn();
    $totalFiltered = $conn->query("SELECT COUNT(*) FROM sa_subservices WHERE 1 $searchQuery")->fetchColumn();

    $jsonData = array(
        "draw"            => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
        "recordsTotal"    => $totalRecords,
        "recordsFiltered" => $totalFiltered,
        "data"            => $data,
        "startMonth"      => $startMonth,
        "endMonth"        => $endMonth
    );

    echo json_encode($jsonData);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>