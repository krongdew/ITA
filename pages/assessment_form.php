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
<style>
.star-rating{
  font-size:0;
  white-space:nowrap;
  display:inline-block;
  width:250px;
  height:50px;
  overflow:hidden;
  position:relative;
  background:
      url('../assets/img/star_grey.png');
  background-size: contain;
  i{
    opacity: 0;
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 20%;
    z-index: 1;
    background: 
        url('../assets/img/star_blink.png');  
    background-size: contain;
  }
  input{ 
    -moz-appearance:none;
    -webkit-appearance:none;
    opacity: 0;
    display:inline-block;
    width: 20%;
    height: 100%; 
    margin:0;
    padding:0;
    z-index: 2;
    position: relative;
    &:hover + i,
    &:checked + i{
      opacity:1;    
    }
  }
  i ~ i{
    width: 40%;
  }
  i ~ i ~ i{
    width: 60%;
  }
  i ~ i ~ i ~ i{
    width: 80%;
  }
  i ~ i ~ i ~ i ~ i{
    width: 100%;
  }
}

.choice{
  position: relative;
  top: 0;
  left:0;
  right:0;
  text-align: left;
  padding: 20px;
  display:block;
}
.container-fluid{
    padding-left: 2.0rem!important;
    margin: 0 auto !important; 
    
}
.row{
    width: 100% !important;
}
@media screen and (max-width: 800px) {
    .container-fluid {
    padding-left: 2.0rem!important;
  }
  .row{
    width: 105% !important;
    }
}
</style>
<?php

include '../action/connect.php';

?>

<body class="g-sidenav-show bg-gray-100">

    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    <main class="main-content position-relative border-radius-lg ps">
        <div class="container-fluid py-8">
            <div class="row">
                <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">

                    <div class="card">
                        <div class="card-body p-5">

                            <!-- <center>
                                <h2>แบบประเมินความพึงพอใจบริการของกองกิจการนักศึกษา</h2>
                            </center> -->

                            <?php
                            $key = getenv('ENCRYPTION_KEY');

                            // Function to decrypt data
                            function decryptData($data, $key)
                            {
                                $cipher = "aes-256-cbc";
                                list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
                                return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
                            }


                            // Check if AssessmentID is set and not empty
                            if (isset($_GET['Assessment']) && !empty($_GET['Assessment'])) {
                                // Store the AssessmentID from POST into a variable
                                $AssessmentID = decryptData($_GET['Assessment'], $key);

                                // Query ข้อมูล AssessmentStatus จากตาราง sa_assessment โดยใช้ AssessmentID ที่ได้จากฟอร์ม
                                $sql = "SELECT AssessmentStatus,service_id,subservice_id FROM sa_assessment WHERE AssessmentID = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(1, $AssessmentID, PDO::PARAM_INT);
                                $stmt->execute();
                                $AssessmentStatusRe = $stmt->fetch(PDO::FETCH_ASSOC);

                                // ตรวจสอบว่าได้ข้อมูล AssessmentStatus จากฐานข้อมูลหรือไม่
                                if ($AssessmentStatusRe && $AssessmentStatusRe['AssessmentStatus'] == 'online') {
                                    
                                    $service_id = $AssessmentStatusRe['service_id'];
                                    $subservice_id = $AssessmentStatusRe['subservice_id'];
                                    
                                   

                                    // Query to fetch questions from sa_question table with specific AssessmentID
                                    $sql = "SELECT * FROM sa_question WHERE AssessmentID = ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(1, $AssessmentID, PDO::PARAM_INT); // Bind AssessmentID parameter
                                    $stmt->execute(); // Execute the prepared statement
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Check if there are any questions available
                                    if (count($result) > 0) {
                                        echo '<form action="../action/process_as2.php" method="post" class="col-xl-6 col-sm-12 mb-xl-0 mb-4 pt-4">'; // Opening form tag here
                                        // Output data of each row
                                        
                                        if(isset($subservice_id)){
                                            echo "<input type='hidden' name='subservice_id' value='".$subservice_id."'>";
                                        }else {
                                            echo "<input type='hidden' name='subservice_id' value='0'>";
                                        }

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
                                                        <label  style="font-size: medium;" for="<?= $question["QuestionText"] ?>"><?= $question["QuestionText"] ?></label>
                                                        <input type="hidden" name="QuestionID" value="<?= $question["QuestionID"] ?>">
                                                        <input type="hidden" name="QuestionType<?= $question["QuestionID"] ?>" value="<?= $question["QuestionType"] ?>">
                                                        <select class="form-select" name="QuestionAns<?= $question["QuestionID"] ?>" id="<?= $question["QuestionText"] ?>">
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
                                                    <label  style="font-size: medium;" for="<?= $question["QuestionText"] ?>"><?= $question["QuestionText"] ?></label>
                                                    <input type="hidden" name="QuestionID" value="<?= $question["QuestionID"] ?>">
                                                    <input type="hidden" name="QuestionType<?= $question["QuestionID"] ?>" value="<?= $question["QuestionType"] ?>">

                                                    <input class="form-control" type="date" name="QuestionAns<?= $question["QuestionID"] ?>" id="<?= $question["QuestionText"] ?>">
                                                    <br><br>
                                                <?php
                                                    break;
                                                case "Ans":
                                                ?>

                                                    <label  style="font-size: medium;" for="<?= $question["QuestionText"] ?>"><?= $question["QuestionText"] ?></label>
                                                    <input type="hidden" name="QuestionID" value="<?= $question["QuestionID"] ?>">
                                                    <input type="hidden" name="QuestionType<?= $question["QuestionID"] ?>" value="<?= $question["QuestionType"] ?>">

                                                    <input class="form-control" type="text" name="QuestionAns<?= $question["QuestionID"] ?>" id="<?= $question["QuestionText"] ?>">
                                                    <br><br>
                                                <?php
                                                    break;
                                                case "Rate":
                                                ?>

                                                    <label style="font-size: medium;" for="<?= $question["QuestionText"] ?>"><?= $question["QuestionText"] ?></label>
                                                    <input type="hidden" name="QuestionID" value="<?= $question["QuestionID"] ?>">
                                                    <input type="hidden" name="QuestionType<?= $question["QuestionID"] ?>" value="<?= $question["QuestionType"] ?>">

                                                    <!-- <select class="form-select" name="QuestionAns<?= $question["QuestionID"] ?>" id="<?= $question["QuestionText"] ?>">
                                                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                            <option value="<?= $i ?>"><?= $i ?></option>
                                                        <?php endfor; ?>
                                                    </select> -->
                                                    
                                                    <br><br>
                                                    <span style="font-size: small;">กรุณาให้คะแนนตั้งแต่ 1-5 ดาว</span>
                                                    <br>
                                                    <span class="star-rating" >
                                                        <table>
                                                        <tr >
                                                        
                                                        <input type="radio" name="QuestionAns<?= $question["QuestionID"] ?>" id="<?= $question["QuestionText"] ?>" value="1"><i></i>
                                                        <input type="radio" name="QuestionAns<?= $question["QuestionID"] ?>" id="<?= $question["QuestionText"] ?>" value="2"><i></i>
                                                        <input type="radio" name="QuestionAns<?= $question["QuestionID"] ?>" id="<?= $question["QuestionText"] ?>" value="3"><i></i>
                                                        <input type="radio" name="QuestionAns<?= $question["QuestionID"] ?>" id="<?= $question["QuestionText"] ?>" value="4"><i></i>
                                                        <input type="radio" name="QuestionAns<?= $question["QuestionID"] ?>" id="<?= $question["QuestionText"] ?>" value="5"><i></i>
                                                        
                                                        </tr>
                                                        </table>
                                                    </span>
                                                    
                                                    <br><br>
                                                    <?php
                                                    break;
                                                    case "Subservice":

                                                        // Fetch choice items for Number type questions
                                                        $SubserviceItems = [];
                                                        $SubserviceSql = " SELECT ss.subservice_name,ss.ID
                                                                        FROM sa_subservices ss
                                                                        INNER JOIN sa_assessment sa ON ss.service_id = sa.service_id
                                                                        WHERE sa.AssessmentID = ?";
                                                        $SubserviceStmt = $conn->prepare($SubserviceSql);
                                                        $SubserviceStmt->bindParam(1, $AssessmentID, PDO::PARAM_INT); // Bind QuestionType parameter
                                                        $SubserviceStmt->execute();
                                                        $SubserviceResult = $SubserviceStmt->fetchAll(PDO::FETCH_ASSOC);
                                                        if ($SubserviceResult) {
                                                        ?>
                                                            <label class="form-label" for="<?= $question["QuestionText"] ?>"><?= $question["QuestionText"] ?></label>
                                                            <input type="hidden" name="QuestionID" value="<?= $question["QuestionID"] ?>">
                                                            <input type="hidden" name="QuestionType<?= $question["QuestionID"] ?>" value="<?= $question["QuestionType"] ?>">
                                                            <select class="form-select" name="QuestionAns<?= $question["QuestionID"] ?>" id="<?= $question["QuestionText"] ?>">
                                                                <?php foreach ($SubserviceResult as $SubserviceRow) : ?>
                                                                    <option value="<?= $SubserviceRow["ID"] ?>"><?= $SubserviceRow["subservice_name"] ?></option>
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
                                                        <center>
                                                            <h2><?= $assessment_result['AssessmentName']; ?></h2>
                                                        </center>
                                                        <br>
                                                        <label  style="font-size: medium;" for="<?= $question["QuestionText"] ?>"><?= $question["QuestionText"] ?></label>
                                                        <input type="hidden" name="QuestionID" value="<?= $question["QuestionID"] ?>">
                                                        <input type="hidden" name="QuestionType<?= $question["QuestionID"] ?>" value="<?= $question["QuestionType"] ?>">
                                                        <input class="form-control" type="text" name="QuestionAns<?= $question["QuestionID"] ?>" id="<?= $question["QuestionText"] ?>" value="<?= $assessment_result['AssessmentName']; ?>" readonly >
                                                        <br><br>
                                                    <?php
                                                    } else {
                                                        // กรณีไม่พบข้อมูล AssessmentName ในฐานข้อมูล
                                                        echo "ไม่พบข้อมูล AssessmentName";
                                                    }

                                                    break;
                                                default:
                                                    ?>
                                                    <label  style="font-size: medium;" for="<?= $question["QuestionText"] ?>"><?= $question["QuestionText"] ?></label>
                                                    <input type="hidden" name="QuestionID" value="<?= $question["QuestionID"] ?>">
                                                    <input type="hidden" name="QuestionType<?= $question["QuestionID"] ?>" value="<?= $question["QuestionType"] ?>">

                                                    <input class="form-control" type="text" name="QuestionAns<?= $question["QuestionID"] ?>" id="<?= $question["QuestionText"] ?>">
                                                    <br><br>
                            <?php
                                                    break;
                                            }
                                        }

                                        echo '<input type="hidden" name="AssessmentID" value="' . $AssessmentID . '"><input type="hidden" name="service_id" value="' . $service_id . '">'; // Hidden input field to send AssessmentID with the form
                                        echo '<button class="btn btn-primary btn-sm ms-auto" type="submit">บันทึก</button>'; // Submit button

                                        echo '</form>'; // Closing form tag
                                    } else {
                                        echo "No questions available";
                                    }
                                } else {
                                    // If AssessmentStatus is not 'online', display a message
                                    echo "ฟอร์มนี้ปิดให้บริการ";
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
    <script>
    // ฟังก์ชันสำหรับกำหนดวันที่ปัจจุบัน
    function setTodayDate() {
        var today = new Date().toISOString().split('T')[0]; // รับวันที่ในรูปแบบ YYYY-MM-DD
        document.querySelector('input[type="date"]').value = today;
    }

    // เรียกใช้งานฟังก์ชันเมื่อหน้าโหลดเสร็จ
    document.addEventListener('DOMContentLoaded', setTodayDate);
</script>
</body>

</html>