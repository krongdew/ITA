<?php
session_start();
include '../action/connect.php';

if (!isset($_SESSION['user'])) {
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
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
    .commentbox {
        height: 30vh;
        overflow-y: scroll;
        margin-bottom: 3rem;
    }

    #exportto {
        padding-left: 100px;
        padding-top: 50px;
        padding-right: 100px;
    }

    @media screen and (max-width: 800px) {

        #exportto {
            padding-left: 20px;
            padding-right: 20px;

        }

        .questionhead,
        h5 {
            font-size: 1rem;
        }

        .card-header>button {
            font-size: 0.9rem;
        }

        #dateFilterForm>button {
            font-size: 0.8rem;
        }

        .chart {
            height: fit-content;
            padding: 0;
        }
    }

    @media print {
        body> :not(#exportto) {
            visibility: hidden;
            /* ซ่อนทุกอย่างนอกเหนือจาก #exportto */
        }

        #exportto {
            margin-left: 0;
            margin-top: 0;
            margin-right: 0;

        }

        @page :first {
            size: auto;
            /* ปรับขนาดหน้ากระดาษให้พอดีกับเนื้อหา */
            margin: 0;
            /* ตั้งค่าระยะขอบหน้ากระดาษเป็น 0 */
        }

        #exportto,
        #exportto * {
            visibility: visible;
            /* แสดงเฉพาะส่วนที่ต้องการพิมพ์ */
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

        .commentbox {
            height: 100vh;
            overflow-y: hidden;

        }

        .tablechoice {
            page-break-after: always;
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

    <div>
        <?php include '../action/as_result.php'; ?>
    </div>




    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>รายงานความพึงพอใจของผู้เข้าใช้บริการ</h6>

                        <form id="FilterForm" method="GET" action="">
                            <input type="hidden" name="AssessmentID" value="<?php echo $_GET['AssessmentID']; ?>">
                            <label for="start_date">วันที่เริ่มต้น:</label>
                            <input type="date" id="start_date" name="start_date" value="<?php echo $_GET['start_date'] ?? ''; ?>">
                            <label for="end_date">วันที่สิ้นสุด:</label>
                            <input type="date" id="end_date" name="end_date" value="<?php echo $_GET['end_date'] ?? ''; ?>">
                            <button type="submit" style="border: 0px; background-color: #4CAF50; color: white; border-radius: 20px;">กรองข้อมูล</button>
                        </form>

                        <div id="dateError" style="color: red; display: none;">กรุณาเลือกวันที่เริ่มต้นให้เป็นวันที่ก่อนวันที่สิ้นสุด</div>

                        <div style="float: right;">
                            <form id="dateFilterForm" method="POST" action="../action/delete_respone.php" onsubmit="return handleFormSubmit(event)">
                                <input type="hidden" name="AssessmentID" value="<?php echo $_GET['AssessmentID']; ?>">
                                <label for="deleteDate">เลือกวันที่ที่จะลบข้อมูล:</label>
                                <input type="date" id="deleteDate" name="deleteDate">
                                <button style="border: 0px; background-color:brown; color:white; border-radius:20px;">ลบข้อมูลผลการประเมิน</button>
                            </form>

                        </div>
                        <button style="border: 0px; background-color:green; color:white; 
                        border-radius:20px; float:right; margin-right:10px;" onclick="printDiv()">&nbsp;&nbsp;Print&nbsp;&nbsp;</button>
                    </div>



                    <div id="exportto">
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
                            $startDate = $_GET['start_date'] ?? null;
                            $endDate = $_GET['end_date'] ?? null;

                            // Fetch assessment results based on AssessmentID and date range
                            $assessmentResults = getAssessmentResults($assessmentID, $startDate, $endDate);



                            if (is_array($assessmentResults) && !isset($assessmentResults['error'])) {
                                // Display assessment results based on question type
                                foreach ($assessmentResults as $result) {
                                    echo "<div class='question-container'>";
                                    echo "<h4 class='questionhead'>Question : {$result['QuestionText']}</h4>";
                                    // (เนื้อหาภายในแต่ละ question เช่น ตารางหรือกราฟ)
                                    echo "</div>";
                                    // echo "<p>QuestionID: {$result['QuestionID']}</p>";
                                    // echo "<p>Question Order: {$result['QuestionOrder']}</p>";
                                    // echo "<p>Question Type: {$result['QuestionType']}</p>";
                                    // Count ratings


                                    if ($result['QuestionType'] === 'Choice') {



                                        $sql = "SELECT COUNT(*) AS totalRespondents FROM sa_respondent WHERE AssessmentID = :assessmentID";

                                        // เตรียมคำสั่ง SQL สำหรับการ execute
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bindParam(':assessmentID', $assessmentID, PDO::PARAM_INT);

                                        // execute คำสั่ง SQL
                                        $stmt->execute();

                                        // ดึงข้อมูลผลลัพธ์
                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $totalRespondents = $row["totalRespondents"];




                                        // Output the canvas for the chart
                                        echo "<div class='chart'><canvas id='chart{$result['QuestionID']}'></canvas></div><br>";

                                        echo "<script>";
                                        echo "var ctx = document.getElementById('chart{$result['QuestionID']}').getContext('2d');";
                                        echo "var chartData = {";
                                        echo "    labels: " . json_encode(array_keys($result['Choices'])) . ",";
                                        echo "    datasets: [{";
                                        echo "        label: 'จำนวนผู้ตอบ',";
                                        echo "        data: " . json_encode(array_column($result['Choices'], 'count')) . ",";
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

                                        echo "<table class='tablechoice'>";
                                        echo "<tr><th>ตัวเลือก</th><th>จำนวน</th><th>เปอร์เซ็นต์</th></tr>";
                                        foreach ($result['Choices'] as $choice => $data) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($choice) . "</td>";
                                            echo "<td>" . $data['count'] . "</td>";
                                            echo "<td>" . number_format($data['percentage'], 2) . "%</td>";
                                            echo "</tr>";
                                        }
                                        echo "</table><br><br>";
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

                                        // ส่วนของการสร้างกราฟ
                                    } elseif ($result['QuestionType'] === 'Subservice') {

                                        echo "<div class='chart' style='height: 350px;'><canvas id='chart{$result['QuestionID']}'></canvas></div>";

                                        // Prepare data for the bar chart
                                        $subserviceNames = array_keys($result['Subservice']);
                                        $subserviceCounts = array_values($result['Subservice']);
                                        
                                      
                                        // คำนวณค่าเฉลี่ยและเปอร์เซ็นต์
                                        $totalResponses = $result['TotalResponses'];
                                        $averageSubservices = [];
                                        $percentageSubservices = [];

                                        foreach ($subserviceCounts as $count) {
                                            $average = $count / $totalResponses;
                                            $percentage = ($count / $totalResponses) * 100;
                                            $averageSubservices[] = $average;
                                            $percentageSubservices[] = $percentage;
                                        }

                                        // สร้าง labels ที่มีชื่อบริการย่อย พร้อมค่าเฉลี่ยและเปอร์เซ็นต์
                                        $labelsWithAvg = [];
                                        foreach ($subserviceNames as $index => $name) {
                                            $label = $name . " (Avg: " . number_format($averageSubservices[$index], 2) . " / " . number_format($percentageSubservices[$index], 2) . "%)";
                                            $labelsWithAvg[] = $label;
                                        }

                                        // JavaScript for creating the bar chart
                                        echo "<script>";
                                        echo "var ctx = document.getElementById('chart{$result['QuestionID']}').getContext('2d');";
                                        echo "var chart = new Chart(ctx, {";
                                        echo "    type: 'bar',";
                                        echo "    data: {";
                                        echo "        labels: " . json_encode($labelsWithAvg) . ","; // ใช้ labels ที่รวมชื่อบริการย่อยและค่าเฉลี่ย
                                        echo "        datasets: [{";
                                        echo "            label: 'Subservice',"; // เปลี่ยน label เป็นชื่อบริการย่อย
                                        echo "            data: [" . implode(', ', $subserviceCounts) . "],"; // ใช้ counts เป็นข้อมูลในกราฟ
                                        echo "            backgroundColor: [";
                                        echo "                'rgba(255, 99, 132, 0.7)',";
                                        echo "                'rgba(54, 162, 235, 0.7)',";
                                        echo "                'rgba(255, 206, 86, 0.7)',";
                                        echo "                'rgba(75, 192, 192, 0.7)',";
                                        echo "                'rgba(153, 102, 255, 0.7)'";
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
                                        echo "                    text: 'บริการย่อย'"; // Update title to match the x-axis
                                        echo "                }";
                                        echo "            }";
                                        echo "        }";
                                        echo "    }";
                                        echo "});";
                                        echo "</script><br>";
                                        
                                    } elseif ($result['QuestionType'] === 'Ans') {

                                        echo "<div class='commentbox'>";
                                        echo "<h5>Comments:</h5>";
                                        echo "<ul>";
                                        foreach ($result['Comments'] as $comment) {
                                            echo "<li>{$comment}</li>";
                                        }
                                        echo "</ul></div>";
                                    } elseif ($result['QuestionType'] === 'Date') {

                                        // echo "<h5>วันที่:</h5>";
                                        // echo "<ul>";
                                        // foreach ($result['Date'] as $comment) {
                                        //     echo "<li>{$comment}</li>";
                                        // }
                                        // echo "</ul>";


                                        echo "<div class='chart' style='height: 350px;'><canvas id='chart{$result['QuestionID']}'></canvas></div>";

                                        // JavaScript สำหรับสร้าง Line Chart
                                        echo "<script>";
                                        echo "var ctx = document.getElementById('chart{$result['QuestionID']}').getContext('2d');";
                                        echo "var chartData = {";
                                        echo "    labels: " . json_encode(array_keys($result['Date'])) . ",";
                                        echo "    datasets: [{";
                                        echo "        label: 'Total',";
                                        echo "        data: " . json_encode(array_values($result['Date'])) . ",";
                                        echo "        backgroundColor: 'rgba(255, 99, 132, 0.7)',";
                                        echo "        borderColor: 'rgba(255, 99, 132, 1)',";
                                        echo "        borderWidth: 4,";
                                        echo "    }]";
                                        echo "};";
                                        echo "var chartOptions = {
                                                responsive: true,
                                                plugins: {
                                                    datalabels: {
                                                        anchor: 'end',
                                                        align: 'top',
                                                        formatter: Math.round,
                                                        font: {
                                                            weight: 'bold'
                                                        }
                                                    }
                                                }
                                            };";

                                        echo "var chart = new Chart(ctx, {";
                                        echo "    type: 'line',";
                                        echo "    data: chartData,";
                                        echo "    options: chartOptions,";
                                        echo "    plugins: [ChartDataLabels]";
                                        echo "});";
                                        echo "</script><br>";
                                    } elseif ($result['QuestionType'] === 'Service') {



                                        foreach ($result['Service'] as $comment) {
                                            echo "<h5>บริการ : {$comment}</h5><br>";
                                            break;
                                        }
                                    }
                                }
                            } elseif (isset($assessmentResults['error'])) {
                                // ถ้ามี error ให้แสดงข้อความผิดพลาด
                                echo "<p>เกิดข้อผิดพลาดในการดึงข้อมูล: " . htmlspecialchars($assessmentResults['error']) . "</p>";
                            } else {
                                echo "<p>ไม่พบข้อมูลสำหรับ AssessmentID ที่ระบุ</p>";
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
    <!-- <button id="saveButton">Save as PDF</button> -->


    <script>
        function printDiv() {
            window.print(); // เปิดหน้าต่างการพิมพ์
        }
    </script>
    <script>
        function handleFormSubmit(event) {
            event.preventDefault(); // Prevent immediate form submission

            const deleteDate = document.getElementById('deleteDate').value;
            let confirmText = 'คุณต้องการลบข้อมูลผลการประเมินทั้งหมด? การกระทำนี้ไม่สามารถย้อนกลับได้';

            if (deleteDate) {
                confirmText = `คุณต้องการลบข้อมูลผลการประเมินสำหรับวันที่ ${deleteDate} ใช่หรือไม่? การกระทำนี้ไม่สามารถย้อนกลับได้`;
            }

            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: confirmText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if the user clicks 'ใช่, ลบเลย!'
                    document.getElementById('dateFilterForm').submit();
                }
            });
        }
    </script>
    <script>
        window.addEventListener('load', () => {
            const questionheads = document.querySelectorAll('.questionhead');
            const pageHeight = 1122; // ความสูงของหน้า A4 ในหน่วย pixel (สำหรับการพิมพ์)
            let currentPageHeight = 0;
            let questionCount = 0;

            questionheads.forEach((questionhead, index) => {
                const container = questionhead.parentElement;
                const containerHeight = container.offsetHeight;

                // ตรวจสอบว่าความสูงของ container พอดีกับหน้าหรือไม่
                if (currentPageHeight + containerHeight > pageHeight || questionCount >= 2) {
                    container.style.pageBreakBefore = 'always';
                    currentPageHeight = containerHeight;
                    questionCount = 1;
                } else {
                    currentPageHeight += containerHeight;
                    questionCount++;
                }
            });
        });
    </script>

    <script>
        document.getElementById('FilterForm').addEventListener('submit', function(e) {
            var startDate = new Date(document.getElementById('start_date').value);
            var endDate = new Date(document.getElementById('end_date').value);
            var errorDiv = document.getElementById('dateError');

            if (startDate > endDate) {
                e.preventDefault(); // ป้องกันการส่งฟอร์ม
                errorDiv.style.display = 'block'; // แสดงข้อความผิดพลาด

                // ซ่อนข้อความผิดพลาดหลังจาก 3 วินาที
                setTimeout(function() {
                    errorDiv.style.display = 'none';
                }, 3000);
            } else {
                errorDiv.style.display = 'none'; // ซ่อนข้อความผิดพลาด (ถ้ามี)
            }
        });

        // เพิ่มการตรวจสอบทุกครั้งที่มีการเปลี่ยนแปลงวันที่
        document.getElementById('start_date').addEventListener('change', validateDates);
        document.getElementById('end_date').addEventListener('change', validateDates);

        function validateDates() {
            var startDate = new Date(document.getElementById('start_date').value);
            var endDate = new Date(document.getElementById('end_date').value);
            var errorDiv = document.getElementById('dateError');

            if (startDate > endDate) {
                errorDiv.style.display = 'block';
            } else {
                errorDiv.style.display = 'none';
            }
        }
    </script>
    <?php include '../components/footer.php'; ?>
    <?php include '../components/setting.php'; ?>
    <!-- Core JS Files -->
    <?php include '../components/script.php'; ?>


</body>

</html>