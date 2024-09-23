<?php
session_start();
include '../action/connect.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['UserType'] !== "admin") {
    // ถ้าไม่มี session user แสดงว่ายังไม่ได้ Login
    header("Location:/index.php");
}

// ดึงข้อมูลผู้ใช้จาก session
$user = $_SESSION['user'];

// ดึงข้อมูลผู้ใช้จาก session


?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/Mahidol_U.png">
    <link rel="icon" type="image/png" href="../assets/img/Mahidol_U.png">

    <title>
        ระบบ ITA
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> -->
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@500&family=Kanit&family=Mitr:wght@300&display=swap" rel="stylesheet">
    <!-- เพิ่ม link ไปยัง SweetAlert2 CSS ตรงนี้ -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- เพิ่ม link ไปยัง SweetAlert2 JavaScript ตรงนี้ -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- datatables -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <link rel="stylesheet" href="../assets/DataTables/datatables.css" />
    <link rel="stylesheet" href="../assets/DataTables/Responsive-2.5.0/css/responsive.dataTables.css" />
    <link rel="stylesheet" href="../assets/DataTables/Buttons-2.4.2/css/buttons.dataTables.css" />

    <script src="../assets/DataTables/datatables.js"></script>
    <script src="../assets/DataTables/Responsive-2.5.0/js/dataTables.responsive.js"></script>

    <script src="../assets/DataTables/Buttons-2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="../assets/DataTables/Buttons-2.4.2/js/dataTables.buttons.js"></script>
    <script src="../assets/DataTables/Buttons-2.4.2/js/buttons.html5.min.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap">
    <script src="../pages/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   
    <script src=
 "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

</head>


<style>
    body {
        font-family: 'Mitr', sans-serif;
    }

    table,
    tr {
        border-width: 1px;
        padding: 10px;
        width: 100%;
    }

    th,
    td {
        border-width: 1px;
        padding: 10px;
    }

    .chart {

        display: flex;
        align-items: center;
        justify-content: center;
        height: 450px;
      
    }
</style>
<style>
    @media print {
        body > :not(#exportto) {
        visibility: hidden; /* ซ่อนทุกอย่างนอกเหนือจาก #exportto */
    }
       
    @page :first {
        size: auto;  /* ปรับขนาดหน้ากระดาษให้พอดีกับเนื้อหา */
        margin: 0; /* ตั้งค่าระยะขอบหน้ากระดาษเป็น 0 */
    }
        
        #exportto, #exportto * {
            visibility: visible; /* แสดงเฉพาะส่วนที่ต้องการพิมพ์ */
            position: static;
        }
        #exportto {
            position: relative;
            left: 0;
            top: 0;
            width: 100%;
            box-sizing: border-box;
            margin-top: 0;
            padding-top: 0;
            
        }
        #questionhead {
            page-break-before: always;
        }
    }
</style>


<body class="g-sidenav-show   bg-gray-100">
    <?php  // เรียกใช้ Sidebar ตาม UserType
    if ($user['UserType'] === "admin") {

        include '../components/sidebar_admin.php';
    } else {
        include '../components/sidebar.php';
    }
    ?>
    <?php include '../components/navbar.php' ?>

    <?php
    include '../action/as_resultold.php'; // เรียกใช้ไฟล์ as_result.php ที่มีการจัดรูปแบบข้อมูล


    ?>

    <div  class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>รายงานความพึงพอใจของผู้เข้าใช้บริการ</h6>
                        
                    </div>
                   
                    
                    <div id="exportto" style="padding-left: 100px; padding-top: 50px; padding-right:100px;">
                        <?php
                        
                        // Check if AssessmentID is provided via GET
                        function getRespondentsCount($assessmentID)
                        {

                            try {
                                // Connect to database using PDO

                                // Prepare SQL statement to count respondents
                                $sql = "SELECT COUNT(*) AS count FROM sa_respondent WHERE AssessmentID = :assessmentID";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':assessmentID', $assessmentID, PDO::PARAM_INT);
                                $stmt->execute();

                                // Fetch the count of respondents
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                $count = $result['count'];

                                // Close connection
                                $conn = null;

                                return $count;
                            } catch (PDOException $e) {
                                echo "Connection failed: " . $e->getMessage();
                            }
                        }

                        if (isset($_GET['AssessmentID'])) {
                            $assessmentID = $_GET['AssessmentID'];

                            // Fetch assessment results based on AssessmentID
                            $assessmentResults = getAssessmentResults($assessmentID);




                            // Display assessment results based on question type
                            foreach ($assessmentResults as $result) {
                                echo "<h4 id='questionhead'>Question : {$result['QuestionText']}</h4>";
                                // echo "<p>QuestionID: {$result['QuestionID']}</p>";
                                // echo "<p>Question Order: {$result['QuestionOrder']}</p>";
                                // echo "<p>Question Type: {$result['QuestionType']}</p>";
                                // Count ratings


                                if ($result['QuestionType'] === 'Choice') {

                                    $ChoiceCount = []; // Initialize an array to count each choice


                                    // Count each choice
                                    foreach ($result['Choices'] as $Choice) {
                                        if (!isset($ChoiceCount[$Choice])) {
                                            $ChoiceCount[$Choice] = 0;
                                        }
                                        $ChoiceCount[$Choice]++;
                                    }

                                    $sql = "SELECT COUNT(*) AS totalRespondents FROM sa_respondent WHERE AssessmentID = :assessmentID";

                                    // เตรียมคำสั่ง SQL สำหรับการ execute
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':assessmentID', $assessmentID, PDO::PARAM_INT);

                                    // execute คำสั่ง SQL
                                    $stmt->execute();

                                    // ดึงข้อมูลผลลัพธ์
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $totalRespondents = $row["totalRespondents"];

                                    $averageRatings = [];
                                    $percentageRatings = [];

                                    foreach ($ChoiceCount as $choice => $count) {

                                        $averageRatings[$choice] = $count > 0 ? $choice * $count / $totalRespondents : 0;
                                        // echo "totalRespondents  " . $totalRespondents . "<br>";
                                        // echo "avgRate  " . $averageRatings[$choice] . "<br>";
                                        // echo "จำนวนผลรวมคนตอบchoice  " . $choice . "<br>";

                                        // echo "count  " . $count . "<br>";

                                        $percentageRatings[$choice] = $totalRespondents > 0 ? ($choice / $totalRespondents) * 100 : 0;
                                        // echo "percentageRatings  " . $percentageRatings[$choice] . "<br>";
                                    }



                                    // Output the canvas for the chart
                                    echo "<div class='chart'><canvas id='chart{$result['QuestionID']}'></canvas></div><br>";

                                    
                                    // JavaScript for creating the Pie Chart
                                    echo "<script>";
                                    echo "var ctx = document.getElementById('chart{$result['QuestionID']}').getContext('2d');";
                                    echo "var chartData = {";
                                    echo "    labels: " . json_encode(array_keys($result['Choices'])) . ",";
                                    echo "    datasets: [{";
                                    echo "        label: 'Total',";
                                    echo "        data: " . json_encode(array_values($result['Choices'])) . ",";
                                    echo "        backgroundColor: [";
                                    echo "            'rgba(255, 99, 132, 0.7)',";
                                    echo "            'rgba(54, 162, 235, 0.7)',";
                                    echo "            'rgba(255, 206, 86, 0.7)',";
                                    echo "            'rgba(75, 192, 192, 0.7)'";
                                    echo "        ],";
                                    echo "        borderWidth: 1";
                                    echo "    }]";
                                    echo "};";
                                    echo "var chartOptions = {";
                                    echo "    responsive: true,";
                                    echo "    plugins: {";
                                    echo "        legend: {";
                                    echo "            position: 'right'";
                                    echo "        }";
                                    echo "    }";
                                    echo "};";
                                    echo "var chart = new Chart(ctx, {";
                                    echo "    type: 'pie',";
                                    echo "    data: chartData,";
                                    echo "    options: chartOptions";
                                    echo "});";
                                    echo "</script>";


                                    // Output the table to display average and percentage
                                    echo "จำนวนผู้ตอบแบบสอบถามทั้งหมด : " . $totalRespondents . " คน <br>";
                                    echo "<table>";
                                    echo "<tr>";
                                    echo "<th>รายการ</th>";
                                    echo "<th>จำนวน</th>";
                                    echo "<th>ค่าเฉลี่ย</th>";
                                    echo "<th>เปอร์เซ็นต์</th>";
                                    echo "</tr>";


                                    $choices = $result['Choices']; // ดึงอาร์เรย์ของตัวเลือก
                                    // ดึงชื่อตัวเลือก (คีย์) จาก $result['Choices']
                                    $choiceNames = array_keys($result['Choices']);


                                    foreach ($choices as $choice => $label) {
                                        echo "<tr>";
                                        echo "<td>" . (in_array($choice, $choiceNames) ? $choice : "N/A") . "</td>";
                                        echo "<td>{$label}</td>";

                                        // เข้าถึงค่าใน $averageRatings และ $percentageRatings โดยใช้ key ของตัวเลือก (ชื่อตัวเลือก)
                                        echo "<td>" . (isset($averageRatings[$label]) ? number_format($averageRatings[$label], 2) : "N/A") . "</td>";
                                        echo "<td>" . (isset($percentageRatings[$label]) ? number_format($percentageRatings[$label], 2) : "N/A") . " % </td>";

                                        echo "</tr>";
                                    }



                                    echo "</table><br>";
                                } elseif ($result['QuestionType'] === 'Rate') {


                                    echo "<div class='chart' style='height: 350px;'><canvas id='chart{$result['QuestionID']}'></canvas></div>";

                                    // Prepare data for the bar chart
                                    $ratingsCount = [0, 0, 0, 0, 0]; // Array to count ratings from 1 to 5
                                    $totalRespondents = count($result['Ratings']);
                                    // Count ratings
                                    foreach ($result['Ratings'] as $rating) {
                                        // Increment count for corresponding rating (index starts from 0)
                                        $ratingsCount[$rating - 1]++;
                                    }

                                    // Calculate average rating and percentage for each rating
                                    $averageRatings = [];
                                    $percentageRatings = [];

                                    for ($i = 0; $i < 5; $i++) {
                                        $averageRatings[$i] = $ratingsCount[$i] > 0 ? ($i + 1) * $ratingsCount[$i] / $totalRespondents : 0;
                                        $percentageRatings[$i] = $totalRespondents > 0 ? ($ratingsCount[$i] / $totalRespondents) * 100 : 0;
                                    }

                                    // Store average and percentage ratings in the result array
                                    $result['AverageRatings'] = $averageRatings;
                                    $result['PercentageRatings'] = $percentageRatings;

                                    // JavaScript for creating the bar chart
                                    echo "<script>";
                                    echo "var ctx = document.getElementById('chart{$result['QuestionID']}').getContext('2d');";
                                    echo "var chart = new Chart(ctx, {";
                                    echo "    type: 'bar',";
                                    echo "    data: {";
                                    echo "        labels: [ '1( Avg : " . number_format($averageRatings[0], 2) . " / " . number_format($percentageRatings[0], 2) . "%)', 
                                                            '2 ( Avg : " . number_format($averageRatings[1], 2) . " / " . number_format($percentageRatings[1], 2) . "%)', 
                                                            '3 ( Avg : " . number_format($averageRatings[2], 2) . " / " . number_format($percentageRatings[2], 2) . "%)', 
                                                            '4 ( Avg : " . number_format($averageRatings[3], 2) . " / " . number_format($percentageRatings[3], 2) . "%)', 
                                                            '5 ( Avg : " . number_format($averageRatings[4], 2) . " / " . number_format($percentageRatings[4], 2) . "%)'],";
                                    echo "        datasets: [{";
                                    echo "            label: 'Number of Respondents',";
                                    echo "            data: [" . implode(', ', $ratingsCount) . "],";
                                    echo "            backgroundColor: [";
                                    echo "                'rgba(255, 99, 132, 0.7)',"; // Color for rating 1
                                    echo "                'rgba(54, 162, 235, 0.7)',"; // Color for rating 2
                                    echo "                'rgba(255, 206, 86, 0.7)',"; // Color for rating 3
                                    echo "                'rgba(75, 192, 192, 0.7)',"; // Color for rating 4
                                    echo "                'rgba(153, 102, 255, 0.7)'"; // Color for rating 5
                                    echo "            ],";
                                    echo "            borderWidth: 1";
                                    echo "        }]";
                                    echo "    },";
                                
                                    echo "    options: {";
                                    echo "        scales: {";
                                    echo "            y: {";
                                    echo "                beginAtZero: true,";
                                    echo "                title: {";
                                    echo "                    display: true,";
                                    echo "                    text: 'Number of Respondents'";
                                    echo "                }";
                                    echo "            },";
                                    echo "            x: {";
                                    echo "                title: {";
                                    echo "                    display: true,";
                                    echo "                    text: 'Rating (1-5)'";
                                    echo "                }";
                                    echo "            }";
                                    echo "        }";
                                    echo "    }";
                                    echo "});";
                                    echo "</script><br>";
                                  
                                } elseif ($result['QuestionType'] === 'Ans') {

                                    echo "<h5>Comments:</h5>";
                                    echo "<ul>";
                                    foreach ($result['Comments'] as $comment) {
                                        echo "<li>{$comment}</li>";
                                    }
                                    echo "</ul>";
                                } elseif ($result['QuestionType'] === 'Date') {

                                    // echo "<h5>วันที่:</h5>";
                                    // echo "<ul>";
                                    // foreach ($result['Date'] as $comment) {
                                    //     echo "<li>{$comment}</li>";
                                    // }
                                    // echo "</ul>";


                                    echo "<div class='chart' style='height: 350px;'><canvas id='chart{$result['QuestionID']}'></canvas></div>";

                                    // JavaScript สำหรับสร้าง Pie Chart
                                    echo "<script>";
                                    echo "var ctx = document.getElementById('chart{$result['QuestionID']}').getContext('2d');";
                                    echo "var chartData = {";
                                    echo "    labels: " . json_encode(array_keys($result['Date'])) . ","; // labels เป็นอาร์เรย์ของ key ของตัวเลือก
                                    echo "    datasets: [{";
                                    echo "        label: 'Total',";
                                    echo "        data: " . json_encode(array_values($result['Date'])) . ","; // data เป็นอาร์เรย์ของ value ของตัวเลือก
                                    echo "        backgroundColor: [";
                                    echo "            'rgba(255, 99, 132, 0.7)',";
                                    echo "            'rgba(54, 162, 235, 0.7)',";
                                    echo "            'rgba(255, 206, 86, 0.7)',";
                                    echo "            'rgba(75, 192, 192, 0.7)'";
                                    echo "        ],";
                                    echo "        borderColor: 'rgba(255, 99, 132, 1)',"; // เพิ่ม border color ที่นี่
                                    echo "        borderWidth: 4,";

                                    echo "    }]";
                                    echo "};";
                                    echo "var chartOptions = {
                                        responsive: true, 
                                                 
                                    };"; // ตั้งค่าอื่นๆ ของกราฟวงกลมตามต้องการ

                                    echo "var chart = new Chart(ctx, {";
                                    echo "    type: 'line',";
                                    echo "    data: chartData,";
                                    echo "    options: chartOptions";
                                    echo "});";
                                    echo "</script><br>";
                                } elseif ($result['QuestionType'] === 'Service') {



                                    foreach ($result['Service'] as $comment) {
                                        echo "<h5>บริการ : {$comment}</h5><br>";
                                        break;
                                    }
                                }
                            }
                        } else {
                            echo "<p>No AssessmentID specified.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ปุ่ม Save as PDF -->
<button id="saveButton">Save as PDF</button>
<button onclick="printDiv()">Print</button>

<script>
    function printDiv() {
        window.print(); // เปิดหน้าต่างการพิมพ์
    }
</script>

<!-- ส่วน JavaScript สำหรับเรียกใช้งาน saveAsPDF() -->
<!-- <script>
    function saveAsPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            orientation: 'portrait', // ตั้งค่าเอกสารให้เป็นแนวตั้ง (portrait)
            unit: 'mm', // ตั้งหน่วยของเอกสารเป็นมิลลิเมตร (mm)
            format: 'a4' // ตั้งค่าขนาดของเอกสารเป็น A4
        });

        const element = document.getElementById('exportto'); // เลือก div ที่ต้องการแปลงเป็น PDF

        // เปลี่ยน HTML ใน div เป็น PDF และจัดรูปแบบเนื้อหา
        doc.html(element, {
            x: 10, // ตำแหน่ง x เริ่มต้น
            y: 10, // ตำแหน่ง y เริ่มต้น
            callback: function (doc) {
                // บันทึกเอกสาร PDF เมื่อเสร็จสิ้น
                doc.save('assessment_results.pdf');
            }
        });

        // กำหนดขนาดเอกสาร PDF เป็น A4
        const pageSize = doc.internal.pageSize;
        const pageHeight = pageSize.height;
        const contentHeight = 10; // ความสูงของเนื้อหาที่เพิ่มใน PDF

        // หากเนื้อหามีมากกว่าความสูงของหน้ากระดาษ A4 จะสร้างหน้าใหม่
        if (contentHeight > pageHeight - 20) {
            doc.addPage(); // เพิ่มหน้าใหม่
        }
    }

    // เรียกใช้งาน saveAsPDF() เมื่อคลิกที่ปุ่ม Save as PDF
    document.addEventListener('DOMContentLoaded', function() {
        const saveButton = document.getElementById('saveButton');
        saveButton.addEventListener('click', saveAsPDF);
    });
</script> -->

    <?php include '../components/footer.php'; ?>
    <?php include '../components/setting.php'; ?>
    <!-- Core JS Files -->
    <?php include '../components/script.php'; ?>
    
    
</body>

</html>