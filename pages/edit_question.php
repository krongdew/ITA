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
</head>
<style>
    body {
        font-family: 'Mitr', sans-serif;
    }

    .editBtn {
        background-color: #fca400;
        color: white;
        border-radius: 10px;
        border: 0px;
        padding: 4px;
    }

    .delBtn {
        background-color: #ff3a24;
        color: white;
        border-radius: 10px;
        border: 0px;
        padding: 4px;
    }

    .saveBtn {
        background-color: #009103;
        color: white;
        border-radius: 10px;
        border: 0px;
        padding: 4px;
    }

    .buttons-html5 {
        font-size: 12px;
        /* ปรับขนาดตามที่คุณต้องการ */
        padding: 6px 10px;
        /* ปรับขนาดตามที่คุณต้องการ */
    }

    label {
        margin-right: 20px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
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

    // ตรวจสอบว่ามีการส่งค่า ID มาหรือไม่
    if (isset($_GET['ID'])) {
        $AssessmentID = $_GET['ID'];


        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        try {
            // เตรียมคำสั่ง SQL
            $stmt = $conn->prepare("SELECT * FROM sa_assessment WHERE AssessmentID = :AssessmentID");
            $stmt->bindParam(':AssessmentID', $AssessmentID);
            $stmt->execute();

            // ดึงข้อมูลผู้ใช้
            $Assessment = $stmt->fetch(PDO::FETCH_ASSOC);

            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if ($Assessment) {
    ?>

                <div class="container-fluid py-4">
                    <div class="row">
                        <div class="col-12">

                            <div class="card mb-4">
                                <div class="card-header pb-0">
                                    <h6>แก้ไขแบบประเมิน</h6>

                                </div>

                                <div class="card-body px-0 pt-0 pb-2">
                                    <div id="add-form">

                                        <form method="post" action="../action/edit_question_base.php">
                                            <div class="container-fluid py-4">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="card">
                                                            <div class="card-header pb-0">
                                                                <div class="d-flex align-items-center">
                                                                    <p class="mb-0">แก้ไขแบบประเมิน</p>

                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <p class="text-uppercase text-sm"><b>ข้อมูลของแบบประเมิน</b></p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="example-text-input" class="form-control-label">ชื่อเรียกแบบประเมิน : </label>
                                                                            <input class="form-control" type="text" name="AssessmentName" placeholder="ชื่อเรียกแบบประเมิน" value="<?php echo $Assessment['AssessmentName']; ?>" required>
                                                                            <input type="hidden" name="AssessmentID[]" value="<?php echo $Assessment['AssessmentID']; ?>">
                                                                            <label for="example-text-input" class="form-control-label">ผู้สร้างแบบประเมิน : </label>
                                                                            <?php
                                                                            $CreatorUserID = $Assessment['CreatorUserID'];

                                                                            // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
                                                                            try {
                                                                                // เตรียมคำสั่ง SQL
                                                                                $stmt = $conn->prepare("SELECT * FROM sa_users WHERE ID = :CreatorUserID");
                                                                                $stmt->bindParam(':CreatorUserID', $CreatorUserID);
                                                                                $stmt->execute();

                                                                                // ดึงข้อมูลผู้ใช้
                                                                                $CreatorUser = $stmt->fetch(PDO::FETCH_ASSOC);

                                                                                // ตรวจสอบว่ามีข้อมูลหรือไม่
                                                                                if ($CreatorUser) {
                                                                            ?>
                                                                                    <input class="form-control" type="text" value="<?php echo $CreatorUser['Username']; ?>" disabled>
                                                                                <?php
                                                                                } else {
                                                                                ?>
                                                                                    <div>ไม่มีผู้ใช้รายนี้</div>
                                                                            <?php
                                                                                }
                                                                            } catch (Exception $e) {
                                                                                echo "เกิดข้อผิดพลาด: " . $e->getMessage();
                                                                            }
                                                                            ?>

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <span for="example-text-input" class="form-control-label">รายละเอียดของข้อคำถาม :</span><br>
                                                                            <!-- สร้าง input สำหรับรับค่าบริการย่อย -->
                                                                            <div class="form-group">
                                                                                <table id="question">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-9">ข้อที่</th>
                                                                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-9">คำถาม</th>
                                                                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-9">ประเภทคำถามปัจจุบัน</th>
                                                                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-9"> แก้ไขประเภทคำถาม </th>
                                                                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-9"></th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php


                                                                                        try {
                                                                                            // คำสั่ง SQL สำหรับดึงข้อมูลบริการย่อย
                                                                                            $sql = "SELECT * FROM sa_question WHERE AssessmentID = :AssessmentID";

                                                                                            // ใช้ Prepared Statement
                                                                                            $stmt = $conn->prepare($sql);
                                                                                            // Bind parameter
                                                                                            $stmt->bindParam(':AssessmentID', $AssessmentID, PDO::PARAM_INT);

                                                                                            // ประมวลผลคำสั่ง SQL
                                                                                            $stmt->execute();

                                                                                            // ดึงผลลัพธ์
                                                                                            $Assessmentitems = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                                                            // ตรวจสอบว่ามีข้อมูลหรือไม่
                                                                                            if (count($Assessmentitems) > 0) {
                                                                                                // สร้างตัวเลือกของ unit
                                                                                                // $options = '<option value="">ชื่อหน่วย</option>';
                                                                                                foreach ($Assessmentitems as $Assessmentitem) {
                                                                                                    echo "<tr>";
                                                                                                    echo "<td style='font-size: smaller;'> 
                                                                                                    <input class='form-control' type='hidden' name='QuestionID[]' value='" . $Assessmentitem['QuestionID'] . "'>
                                                                                                    <input class='form-control' type='text' name='QuestionOrder[]' placeholder='ข้อที่' value='" . $Assessmentitem['QuestionOrder'] . "'>";
                                                                                                    echo "</td>";
                                                                                                    echo "<td style='font-size: smaller;'> 
                                                                                                    <input class='form-control' type='text' name='QuestionText[]' placeholder='คำถาม' value='" . $Assessmentitem['QuestionText'] . "'>";
                                                                                                    echo "</td>";
                                                                                                    // echo "<td style='font-size: smaller;'> 
                                                                                                    // <input class='form-control' type='text' name='QuestionText[]' placeholder='ประเภท' value='" . $Assessmentitem['QuestionType'] . "'>";
                                                                                                    // echo "</td>";
                                                                                                    echo "<td style='font-size: smaller;'>";

                                                                                                    $chioceID = $Assessmentitem['QuestionType'];


                                                                                                    try {
                                                                                                        // คำสั่ง SQL สำหรับดึงข้อมูล department
                                                                                                        $sql = "SELECT ID, choice_name FROM sa_choice_name WHERE ID = :chioceID";

                                                                                                        // ใช้ Prepared Statement
                                                                                                        $stmt = $conn->prepare($sql);
                                                                                                        // Bind parameter
                                                                                                        $stmt->bindParam(':chioceID', $chioceID, PDO::PARAM_INT);

                                                                                                        // ประมวลผลคำสั่ง SQL
                                                                                                        $stmt->execute();


                                                                                                        // ดึงผลลัพธ์
                                                                                                        $chioces = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                                                                                        if (count($chioces) > 0) {
                                                                                                            echo '<select name="QuestionType[]"  id="QuestionType"  class="form-select" required>';
                                                                                                            foreach ($chioces as $chioce) {
                                                                                                                $selected = ($Assessmentitem['QuestionType'] == $chioce['ID']) ? 'selected' : '';
                                                                                                                echo '<option value="' . $chioce['ID'] . '" ' . $selected . '> Choice : ' . $chioce['choice_name'] . '</option>';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo '<option value="' . $Assessmentitem['QuestionType'] . '">' . $Assessmentitem['QuestionType'] . '</option>';
                                                                                                        }
                                                                                                    } catch (PDOException $e) {
                                                                                                        echo "Connection failed: " . $e->getMessage();
                                                                                                    }
                                                                                                    
                                                                                                    echo "</select>";
                                                                                                    // echo "<input type='text' name='chioce_id[]' value='".$Assessmentitem['chioce_id']."'>";
                                                                                                    echo "</td>";
                                                                                        ?>
                                                                                                    <td style='font-size: smaller;'>
                                                                                                        <select class="form-select" name="QuestionType[]">
                                                                                                            <option value="Service" <?php echo ($Assessmentitem['QuestionType'] == 'Service') ? 'selected' : ''; ?>>Service</option>
                                                                                                            <option value="Date" <?php echo ($Assessmentitem['QuestionType'] == 'Date') ? 'selected' : ''; ?>>วันที่ (Date)</option>
                                                                                                            <option value="Ans" <?php echo ($Assessmentitem['QuestionType'] == 'Ans') ? 'selected' : ''; ?>>คำตอบสั้น (ANS)</option>
                                                                                                            <option value="Rate" <?php echo ($Assessmentitem['QuestionType'] == 'Rate') ? 'selected' : ''; ?>>ระดับความพึงพอใจ (Rate)</option>
                                                                                                            <option value="Subservice" <?php echo ($Assessmentitem['QuestionType'] == 'Subservice') ? 'selected' : ''; ?>>รายชื่อบริการย่อย</option>
                                                                                                            <option value="Choice" <?php echo ($Assessmentitem['QuestionType'] == 'Choice') ? 'selected' : ''; ?>>Choice</option>
                                                                                                        </select>
                                                                                                        <!-- ส่วนนี้คือ input field สำหรับ chioce_id[] และจะถูกแสดงหากเลือก 'Choice' -->
                                                                                                       
                                                                                                        <select class="form-select" name="chioce_id[]" style="display: none;"></select>
                                                                                                    </td>;
                                                                                                    <td> <input type='text' id="choiceinput" name='chioce_id[]' value="<?php echo $Assessmentitem['chioce_id']; ?>" ></td>
                                                                                                    
                                                                                        <?php
                                                                                        echo "<td><input class='form-control' type='text' id='id' name='assessmentID[]' value='".$Assessment['AssessmentID']."'</td>";
                                                                                        echo "<td><button type='button' class='delBtn' onclick='deleteqution(this)' style='font-size: small;'>ลบแถว</button></td>";
                                                                                                    echo "</tr>";
                                                                                                    
                                                                                                }
                                                                                            } else {
                                                                                                echo 'ไม่พบบริการย่อย';
                                                                                            }
                                                                                        } catch (PDOException $e) {
                                                                                            echo "Connection failed: " . $e->getMessage();
                                                                                        }
                                                                                        ?>
                                                                                    </tbody>
                                                                                </table>
                                                                                <br>
                                                                                <button type="button" id="addrow" class="saveBtn" style="font-size: small;" onclick="addRow()">+เพิ่มคำถาม</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>

                                                                <button type="submit" class="btn btn-primary btn-sm ms-auto">แก้ไขข้อคำถาม</button>
                                                                <!-- <a href="../pages/assessment.php"><button type="button" class="btn btn-primary btn-sm ms-auto">Cancel</button></a> -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                        </form>

                                        <?php
                                        include('../assets/phpqrcode/qrlib.php');

                                        $link = $Assessment['AssessmentURL'];
                                        $filename = '../assets/img/qrcodes/qrcodes' . md5($link) . '.png';
                                        // สร้าง QR code และบันทึกเป็นไฟล์ PNG
                                        QRcode::png($link, $filename, QR_ECLEVEL_L, 4);

                                        // แสดงผล QR code
                                        echo '<img src="' . $filename . '" /><br>';

                                        ?>

                                        <label for="example-text-input" class="form-control-label">QR-Code : </label>
                                        <div style="display: flex;">
                                            <input class="form-control" type="text" value="<?php echo $Assessment['AssessmentURL']; ?>" disabled>
                                        </div>

                            <?php
                        } else {
                            echo '<p>ไม่พบข้อมูล</p>';
                        }
                    } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
                } else {
                    echo '<p>ไม่พบรหัสผู้ใช้</p>';
                }
                            ?>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>

                    <?php include '../components/footer.php' ?>
                </div>
                </main>

                <?php include '../components/setting.php'; ?>
                <!--   Core JS Files   -->
                <?php include '../components/script.php'; ?>

                <script>
                    // ฟังก์ชันเพิ่มแถวในตาราง
                    var questionCounter = 1;

                    function addRow() {
                        // ดึงตารางมา
                        var table = document.getElementById("question");

                        // หาจำนวนแถวที่มีอยู่
                        var rowCount = table.rows.length;

                        // สร้างแถวใหม่
                        var newRow = table.insertRow(rowCount);

                        // สร้างเซลล์ในแถว
                        var cell1 = newRow.insertCell(0);
                        var cell2 = newRow.insertCell(1);
                        var cell3 = newRow.insertCell(2);
                        var cell4 = newRow.insertCell(3);
                        var cell5 = newRow.insertCell(4);
                        var cell6 = newRow.insertCell(5);
                        var cell7 = newRow.insertCell(6);

                        // เพิ่ม HTML ลงในเซลล์
                        cell1.innerHTML = '<input class="form-control" type="text" id="QuestionOrder" name="QuestionOrder[]" value="' + rowCount + '" style="width: 50px;">';
                        cell2.innerHTML = '<input class="form-control" type="text" id="QuestionText" name="QuestionText[]" value="">';
                        cell3.innerHTML = '';

                        // สร้าง select ใน cell3 และให้มี id เฉพาะ
                        var choiceSelect = document.createElement("select");
                        choiceSelect.className = "form-select";
                        choiceSelect.name = "QuestionType[]";
                        cell4.appendChild(choiceSelect);

                        // เพิ่มตัวเลือกใน dropdown
                        var options = [{
                                value: 'Date',
                                label: 'วันที่ (Date)'
                            },
                            {
                                value: 'Ans',
                                label: 'คำตอบสั้น (ANS)'
                            },
                            {
                                value: 'Rate',
                                label: 'ระดับความพึงพอใจ (Rate)'
                            },
                            {
                                value: 'Subservice',
                                label: 'รายชื่อบริการย่อย'
                            },
                            {
                                value: 'Choice',
                                label: 'Choice'
                            }
                        ];

                        options.forEach(function(option) {
                            var optionElem = document.createElement("option");
                            optionElem.value = option.value;
                            optionElem.text = option.label;
                            choiceSelect.appendChild(optionElem);
                        });

                        // เพิ่ม input field สำหรับ chioce_id[] และปรากฏทันที
                        cell5.innerHTML = '<input type="hidden" name="chioce_id[]" value="0">';

                        // เมื่อมีการเลือก Choice ให้ดึงข้อมูลจากไฟล์ get_choice.php โดยใช้ AJAX
                        choiceSelect.addEventListener('change', function() {
                            var secondSelect = cell5.querySelector('select[name="chioce_id[]"]');
                            var inputSelect = cell5.querySelector('input[name="chioce_id[]"]')
                            cell5.removeChild(inputSelect);

                            if (this.value === 'Choice') {
                                // ตรวจสอบว่ามี select อันสองอยู่แล้วหรือไม่
                                if (secondSelect) {
                                    // ถ้ามีให้ลบออก
                                    cell5.removeChild(secondSelect);

                                }
                                // สร้าง element select ใหม่
                                var newSelect = document.createElement("select");
                                newSelect.className = "form-select";
                                newSelect.name = "chioce_id[]";

                                // ส่งคำขอ AJAX เพื่อดึงข้อมูลจากไฟล์ get_choice.php
                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', '../action/get_choice.php', true);
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState == 4 && xhr.status == 200) {
                                        var choices = JSON.parse(xhr.responseText);
                                        createChoiceOptions(choices, newSelect);
                                    }
                                };
                                xhr.send();

                                // เพิ่ม dropdown select ใหม่ลงใน cell4
                                cell5.appendChild(newSelect);
                            } else {
                                // ถ้าไม่ได้เลือก 'Choice' ให้ตรวจสอบว่ามี select อันสองอยู่แล้วหรือไม่ แล้วลบออก
                                if (secondSelect) {
                                    cell5.removeChild(secondSelect);
                                }
                                cell5.innerHTML = '<input type="text" name="chioce_id[]" value="0">';
                            }
                        });

                        // สร้างปุ่มลบใน cell4
                        cell6.innerHTML = '<input class="form-control" type="text" id="id" name="assessmentID[]" value="<?php echo $Assessment['AssessmentID']; ?>"> ';
                        cell7.innerHTML = '<button type="button" class="delBtn" onclick="deleteRow(this)" style="font-size: small;" >ลบแถว</button>';
                        
                    }


                    // ฟังก์ชันลบแถว
                    function deleteRow(row) {
                        var index = row.parentNode.parentNode.rowIndex;
                        document.getElementById("question").deleteRow(index);
                    }



                    document.querySelectorAll('select[name="QuestionType[]"]').forEach(function(selectElement) {
                        selectElement.addEventListener('change', function() {
                            var cell = selectElement.parentNode;
                            var secondSelect = cell.querySelector('select[name="chioce_id[]"]');
                            var inputSelect = cell.querySelector('input[name="chioce_id[]"]');

                            if (secondSelect) {
                                cell.removeChild(secondSelect);
                            }

                            if (selectElement.value === 'Choice') {
                                // สร้าง element select ใหม่
                                var newSelect = document.createElement("select");
                                newSelect.className = "form-select";
                                newSelect.style.margin = "10px 0"; // Adds 10px spacing on top and bottom
                                newSelect.name = "chioce_id[]";

                                // ส่งคำขอ AJAX เพื่อดึงข้อมูลจากไฟล์ get_choice.php
                                var xhr = new XMLHttpRequest();
                                xhr.open('POST', '../action/get_choice.php', true);
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState == 4 && xhr.status == 200) {
                                        var choices = JSON.parse(xhr.responseText);
                                        createChoiceOptions(choices, newSelect);
                                    }
                                };
                                xhr.send();

                                // เพิ่ม dropdown select ใหม่ลงใน cell
                                cell.appendChild(newSelect);
                            } else {
                                // ถ้าไม่ได้เลือก 'Choice' ให้แสดง input hidden
                                cell.appendChild(inputSelect);
                            }
                        });
                    });
                    
                

                    // ฟังก์ชันสำหรับสร้างตัวเลือก Choice จากข้อมูลที่ได้จาก AJAX
                    function createChoiceOptions(choices, selectElement) {
                        selectElement.innerHTML = "";
                        var defaultOption = document.createElement("option");
                        defaultOption.value = '0';
                        defaultOption.text = 'กรุณาเลือก Choice ที่ต้องการ';
                        selectElement.appendChild(defaultOption);

                        choices.forEach(function(choice) {
                            var optionElem = document.createElement("option");
                            optionElem.value = choice.ID;
                            optionElem.text = "Choice " + choice.choice_name;
                            optionElem.name = "chioce_id[]";
                            selectElement.appendChild(optionElem);
                        });
                        
                       
                    }
                    
                        // ฟังก์ชันลบแถว
                        function deleteRow(row) {
                        var index = row.parentNode.parentNode.rowIndex;
                        document.getElementById("question").deleteRow(index);
                    }
                    
                    
                    
                    // ฟังก์ชันสำหรับลบข้อมูลบริการย่อย
                    function deleteqution(button) {
                        // ดึงข้อมูลที่ต้องการลบ (subservicesID) จากปุ่มที่ถูกคลิก
                        var QuestionID = $(button).closest('tr').find('input[name="QuestionID[]"]').val();

                        // แสดง SweetAlert 2 สำหรับยืนยันการลบ
                        Swal.fire({
                            title: 'คุณต้องการลบข้อคำถามหรือไม่?',
                            text: "ลบข้อคำถาม",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'ใช่, ลบ!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // ทำการลบในฐานข้อมูลด้วย Ajax
                                $.ajax({
                                    url: '../action/deleteqution.php',
                                    type: 'POST',
                                    data: {
                                        QuestionID: QuestionID
                                    },
                                    dataType: 'json', // รับข้อมูลเป็น JSON
                                    success: function(response) {
                                        if (response.status === 'success') {
                                            // ลบแถวที่ต้องการในตาราง
                                            $(button).closest('tr').remove();

                                            Swal.fire(
                                                'ลบข้อมูลเรียบร้อย!',
                                                'ข้อมูลถูกลบออกจากระบบแล้ว.',
                                                'success'
                                            );
                                        } else {
                                            Swal.fire(
                                                'เกิดข้อผิดพลาด!',
                                                'เกิดข้อผิดพลาดในการลบข้อมูล.',
                                                'error'
                                            );
                                        }
                                    }
                                });
                            }
                        });
                    }
                    
                </script>


                <!-- ส่วนที่เพิ่มเข้าไป
<script>
  function updatedata() {
    $('#myTable').DataTable().ajax.reload();
  }


  $(document).ready(function() {
    // ให้ฟังก์ชันทำงานเมื่อมีการกด submit ฟอร์ม
    $('form').submit(function(e) {
      e.preventDefault(); // ป้องกันให้ฟอร์ม submit ตามปกติ

      // ทำการส่งข้อมูลไปยังไฟล์ PHP ตาม URL ที่ระบุใน action
      $.ajax({
        type: 'POST',
        url: '../action/add_Choice.php',
        data: $(this).serialize(), // เพิ่ม CSRF Token ในข้อมูลที่ส่ง
        success: function(response) {
          // เมื่อเพิ่มข้อมูลเสร็จสิ้น, แสดง popup box
          Swal.fire({
            icon: 'success',
            title: 'บันทึกข้อมูลสำเร็จ',
            showConfirmButton: false,
            timer: 1500,

          }).then(function() {

            // ล้างข้อมูลในฟอร์ม (ตรวจสอบว่าเขียนไว้ถูกหรือไม่)
            $('form')[0].reset();

            // เรียกใช้ฟังก์ชัน updatedata() เพื่อรีเฟรชตาราง
            updatedata();
          });
        },
        error: function(error) {
          // กรณีเกิดข้อผิดพลาด
          Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: 'ไม่สามารถบันทึกข้อมูลได้'
          });
        }
      });
    });
  });
</script> --->



</body>

</html>