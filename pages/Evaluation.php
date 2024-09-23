<?php
session_start();
include '../action/connect.php';


if (!isset($_SESSION['user'])) {
    // ถ้าไม่มี session user แสดงว่ายังไม่ได้ Login
    header("Location:/index.php");
}

// ดึงข้อมูลผู้ใช้จาก session
$user = $_SESSION['user'];



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">

    <title>แบบประเมินความพึงพอใจบริการของกองกิจการนักศึกษา</title>
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

</head>


<body class="g-sidenav-show bg-gray-100">

    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <main class="main-content position-relative border-radius-lg ps">
        <div class="container-fluid py-8 p-10">
            <div class="row">
                <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">

                    <div class="card">
                        <div class="card-body p-5">

                            <center>
                                <h2>แบบประเมินความพึงพอใจบริการของกองกิจการนักศึกษา</h2>
                            </center>

                            <?php

                            // Check if AssessmentID is set and not empty
                            if (isset($_POST['AssessmentID']) && !empty($_POST['AssessmentID'])) {
                                // Store the AssessmentID from POST into a variable
                                $AssessmentID = $_POST['AssessmentID'];

                                // Query to fetch questions from sa_question table with specific AssessmentID
                                $sql = "SELECT * FROM sa_question WHERE AssessmentID = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(1, $AssessmentID, PDO::PARAM_INT); // Bind AssessmentID parameter
                                $stmt->execute(); // Execute the prepared statement
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Check if there are any questions available
                                if (count($result) > 0) {
                                    echo '<form action="../action/process_approval.php" method="post" class="col-xl-6 col-sm-12 mb-xl-0 mb-4 pt-4">'; // Opening form tag here
                                    // Output data of each row

                                    foreach ($result as $question) {
                                        // Check the QuestionType to determine the input field type
                                        switch ($question["QuestionType"]) {
                                            case "Choice":
                                                // Fetch choice items for Number type questions
                                                $choiceItems = [];
                                                $choiceSql = "SELECT * FROM sa_choice_item WHERE choice_id = ?";
                                                $choiceStmt = $conn->prepare($choiceSql);
                                                $choiceStmt->bindParam(1, $question["chioce_id"], PDO::PARAM_STR); // Bind QuestionType parameter
                                                $choiceStmt->execute();
                                                $choiceResult = $choiceStmt->fetchAll(PDO::FETCH_ASSOC);
                                                if ($choiceResult) {
                            ?>
                                                    <label class="form-label" for="<?= $question["QuestionText"] ?>"><?= $question["QuestionText"] ?></label>
                                                    <select class="form-select" name="<?= $question["QuestionText"] ?>" id="<?= $question["QuestionText"] ?>">
                                                        <?php foreach ($choiceResult as $choiceRow) : ?>
                                                            <option value="<?= $choiceRow["choice_item"] ?>"><?= $choiceRow["choice_item"] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <br><br>
                                                <?php
                                                    break;
                                                } else {
                                                    // If no choice items found, exit switch statement and start next iteration of foreach loop
                                                    break;
                                                }
                                                ?>
                                            <?php
                                                break;
                                            case "Date":
                                            ?>
                                                <label class="form-label" for="<?= $question["QuestionText"] ?>"><?= $question["QuestionText"] ?></label>
                                                <input class="form-control" type="date" name="<?= $question["QuestionText"] ?>" id="<?= $question["QuestionText"] ?>">
                                                <br><br>
                                            <?php
                                                break;
                                            case "Ans":
                                            ?>
                                                <label class="form-label" for="<?= $question["QuestionText"] ?>"><?= $question["QuestionText"] ?></label>
                                                <input class="form-control" type="text" name="<?= $question["QuestionText"] ?>" id="<?= $question["QuestionText"] ?>">
                                                <br><br>
                                            <?php
                                                break;
                                            case "Rate":
                                            ?>
                                                <label class="form-label" for="<?= $question["QuestionText"] ?>"><?= $question["QuestionText"] ?></label>
                                                <select class="form-select" name="<?= $question["QuestionText"] ?>" id="<?= $question["QuestionText"] ?>">
                                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                        <option value="<?= $i ?>"><?= $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                                <br><br>
                                                <?php
                                                break;
                                            case "Subservice":

                                                // Fetch choice items for Number type questions
                                                $choiceItems = [];
                                                $choiceSql = " SELECT ss.subservice_name,ss.ID
                                                                FROM sa_subservices ss
                                                                INNER JOIN sa_assessment sa ON ss.service_id = sa.service_id
                                                                WHERE sa.AssessmentID = ?";
                                                $choiceStmt = $conn->prepare($choiceSql);
                                                $choiceStmt->bindParam(1, $AssessmentID, PDO::PARAM_INT); // Bind QuestionType parameter
                                                $choiceStmt->execute();
                                                $choiceResult = $choiceStmt->fetchAll(PDO::FETCH_ASSOC);
                                                if ($choiceResult) {
                                                ?>
                                                    <label class="form-label" for="<?= $question["QuestionText"] ?>"><?= $question["QuestionText"] ?></label>
                                                    <select class="form-select" name="<?= $question["QuestionText"] ?>" id="<?= $question["QuestionText"] ?>">
                                                        <?php foreach ($choiceResult as $choiceRow) : ?>
                                                            <option value="<?= $choiceRow["ID"] ?>"><?= $choiceRow["subservice_name"] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <br><br>
                                                <?php
                                                } else {
                                                    // กรณีไม่พบข้อมูล AssessmentName ในฐานข้อมูล
                                                    echo "ไม่พบข้อมูล บริการย่อย<br><br>";
                                                }


                                                break;
                                            case "Service":

                                                // Query ข้อมูล AssessmentName จากตาราง sa_assessment โดยใช้ AssessmentID ที่ได้จากฟอร์ม
                                                $sql = "SELECT AssessmentName FROM sa_assessment WHERE AssessmentID = ?";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->bindParam(1, $AssessmentID, PDO::PARAM_INT);
                                                $stmt->execute();
                                                $assessment_result = $stmt->fetch(PDO::FETCH_ASSOC);

                                                // ตรวจสอบว่าได้ข้อมูล AssessmentName จากฐานข้อมูลหรือไม่
                                                if ($assessment_result) {
                                                    // แสดงชื่อ AssessmentName ใน input
                                                ?>
                                                    <label class="form-label" for="<?= $question["QuestionText"] ?>"><?= $question["QuestionText"] ?></label>
                                                    <input class="form-control" type="text" name="<?= $question["QuestionText"] ?>" id="<?= $question["QuestionText"] ?>" value="<?= $assessment_result['AssessmentName']; ?>">
                                                    <br><br>
                                                <?php
                                                } else {
                                                    // กรณีไม่พบข้อมูล AssessmentName ในฐานข้อมูล
                                                    echo "ไม่พบข้อมูล AssessmentName";
                                                }

                                                break;
                                            default:
                                                ?>
                                                <label class="form-label" for="<?= $question["QuestionText"] ?>"><?= $question["QuestionText"] ?></label>
                                                <input class="form-control" type="text" name="<?= $question["QuestionText"] ?>" id="<?= $question["QuestionText"] ?>">
                                                <br><br>
                            <?php
                                                break;
                                        }
                                    }

                                    echo '<input type="hidden" name="AssessmentID" value="' . $AssessmentID . '">';
                                    echo '<input type="hidden" name="ApproverUserID" value="' . $user['ID'] . '">'; // Hidden input field to send AssessmentID with the form
                                    if ($user['position_c'] === "Leader") {


                                        echo '<button class="btn btn-primary btn-sm ms-auto" type="submit" name="approve" value="approve">อนุมัติ</button>'; // Submit button
                                        echo '  <button class="btn btn-primary btn-sm ms-auto" type="submit" name="reject" value="reject">ไม่อนุมัติ</button>'; // Submit button
                                        echo '</form>'; // Closing form tag
                                    } else {
                                        // Query ข้อมูล AssessmentName จากตาราง sa_assessment โดยใช้ AssessmentID ที่ได้จากฟอร์ม
                                        $sql = "SELECT AssessmentURL FROM sa_assessment WHERE AssessmentID = ?";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bindParam(1, $AssessmentID, PDO::PARAM_INT);
                                        $stmt->execute();
                                        $assessment_URL = $stmt->fetch(PDO::FETCH_ASSOC);

                                        // ตรวจสอบว่าได้ข้อมูล AssessmentName จากฐานข้อมูลหรือไม่
                                        if ($assessment_URL) {
                                            echo "หากแบบประเมินอนุมัติแล้ว จะมี link ปรากฏที่นี่ => <a href='" . $assessment_URL['AssessmentURL'] . "'>" . $assessment_URL['AssessmentURL'] . "</a> ";
                                        }
                                    }
                                } else {
                                    echo "No questions available";
                                }
                            } else {
                                // If AssessmentID is not set or empty, display an error message
                                echo "Error: No AssessmentID provided";
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>