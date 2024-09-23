<?php
include 'connect.php';
include 'as_result.php';

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
                                    echo "<h4 id='questionhead'>Question : {$result['QuestionText']}</h4>";
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

                                        echo "<table>";
                                        echo "<tr><th>ตัวเลือก</th><th>จำนวน</th><th>เปอร์เซ็นต์</th></tr>";
                                        foreach ($result['Choices'] as $choice => $data) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($choice) . "</td>";
                                            echo "<td>" . $data['count'] . "</td>";
                                            echo "<td>" . number_format($data['percentage'], 2) . "%</td>";
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