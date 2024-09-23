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
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">

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
<?php

// ตรวจสอบว่ามีการส่งค่า ID มาหรือไม่
if (isset($_GET['ID'])) {
    $AssessmentID  = $_GET['ID'];


    // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
    try {
        // เตรียมคำสั่ง SQL
        $stmt = $conn->prepare("SELECT * FROM sa_assessment WHERE AssessmentID  = :AssessmentID ");
        $stmt->bindParam(':AssessmentID', $AssessmentID);
        $stmt->execute();

        // ดึงข้อมูลผู้ใช้
        $Assessment = $stmt->fetch(PDO::FETCH_ASSOC);

        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if ($Assessment) {
?>

            <body class="g-sidenav-show   bg-gray-100">
                <?php // เรียกใช้ Sidebar ตาม UserType
                if ($user['UserType'] === "admin") {

                    include '../components/sidebar_admin.php';
                } else {
                    include '../components/sidebar.php';
                } ?>
                <?php include '../components/navbar.php' ?>
               

                <div class="container-fluid py-4">
                    <div class="row">
                        <div class="col-12">

                            <div class="card mb-4">
                                <div class="card-header pb-0">
                                    <h6>สร้างข้อคำถามแบบประเมินความพึงพอใจ</h6>
                                    <br>
                                    <!-- <button class="badge badge-sm bg-gradient-success" style="border: 0px;" onMouseOver="this.style.color='red'" onMouseOut="this.style.color='white'" id="button-service" onclick="toggleAddForm()">เพิ่ม Services</button>
                        <button class="badge badge-sm bg-gradient-warning" style="border: 0px;" onMouseOver="this.style.color='red'" onMouseOut="this.style.color='white'" id="button-service" onclick="toggleAddForm()">สร้างแบบประเมินความพึงพอใจ</button> -->
                                </div>

                                <div class="card-body px-0 pt-0 pb-2">
                                    <div id="add-form">
                                        <form method="post" action="../action/add_question_base.php">
                                            <div class="container-fluid py-4">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="card">
                                                            <div class="card-header pb-0">
                                                                <div class="d-flex align-items-center">
                                                                    <p class="mb-0">สร้างข้อคำถามแบบประเมินความพึงพอใจของ <b><?php echo $Assessment['AssessmentName']; ?></b></p>

                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <table id="question" class="table align-items-center mb-0">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-9">ข้อที่</th>
                                                                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-9">คำถาม</th>
                                                                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-9">ประเภทคำถาม</th>
                                                                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-9">ตัวเลือก</th>
                                                                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-9"></th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><input class="form-control" type="hidden" id="id" name="AssessmentID[]" value="<?php echo $Assessment['AssessmentID']; ?>">
                                                                                        <input class="form-control" type="text" id="QuestionOrder" name="QuestionOrder[]" value="1" style="width: 50px;">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input class="form-control" type="text" id="QuestionText" name="QuestionText[]" value="บริการที่ท่านเข้าใช้งาน">
                                                                                    </td>
                                                                                    <td>
                                                                                        <!-- ใส่ชื่อบริการลงไปเลย -->
                                                                                        <!-- <input class="form-control" type="text" id="service" name="QuestionType" value="<?php echo $Assessment['AssessmentName']; ?>"> -->
                                                                                        <select class="form-select" name="QuestionType[]">
                                                                                            <option value="Service"><?php echo $Assessment['AssessmentName']; ?></option>
                                                                                        </select>
                                                                                        <input class="form-control" type="hidden" id="QuestionText" name="chioce_id[]" value="0">
                                                                                    </td>
                                                                                    <td></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <input class="form-control" type="hidden" id="id" name="AssessmentID[]" value="<?php echo $Assessment['AssessmentID']; ?>">
                                                                                        <input class="form-control" type="text" id="QuestionOrder" name="QuestionOrder[]" value="2" style="width: 50px;">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input class="form-control" type="text" id="QuestionText" name="QuestionText[]" value="เข้าใช้บริการวันที่">
                                                                                    </td>
                                                                                    <td>
                                                                                        <!-- เรียกช่องวันที่ -->
                                                                                        <!-- <input class="form-control" type="text" id="Dateofservice" name="QuestionType" value="Date"> -->
                                                                                        <select class="form-select" name="QuestionType[]">
                                                                                            <option value="Date">วันที่</option>
                                                                                        </select>
                                                                                        <input class="form-control" type="hidden" id="QuestionText" name="chioce_id[]" value="0">
                                                                                    </td>
                                                                                    <td></td>
                                                                                </tr>
                                                                            </tbody>

                                                                        </table>
                                                                        <br>
                                                                        <button type="button" id="addrow" class="saveBtn" style="font-size: small;" onclick="addRow()">+เพิ่มคำถาม</button>
                                                                    </div>


                                                                    <div class="col-md-2">




                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <button type="submit" class="btn btn-primary btn-sm ms-auto">สร้างข้อคำถาม</button>



                                        </form>
                                        <a href="../pages/assessment.php"><button type="button" class="btn btn-primary btn-sm ms-auto">ยกเลิกและกลับไปหน้าสร้างข้อคำถาม</button></a>
                                    </div>
                                </div>
                            </div>

                        </div>
            <?php
        } else {
            echo '<p>ไม่พบข้อมูล</p>';
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    echo '<p>ไม่พบรหัส</p>';
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

                        // เพิ่ม HTML ลงในเซลล์
                        cell1.innerHTML = '<input class="form-control" type="hidden" id="id" name="AssessmentID[]" value="<?php echo $Assessment['AssessmentID']; ?>"> <input class="form-control" type="text" id="QuestionOrder" name="QuestionOrder[]" value="' + rowCount + '" style="width: 50px;">';
                        cell2.innerHTML = '<input class="form-control" type="text" id="QuestionText" name="QuestionText[]" value="">';

                        // สร้าง select ใน cell3 และให้มี id เฉพาะ
                        var choiceSelect = document.createElement("select");
                        choiceSelect.className = "form-select";
                        choiceSelect.name = "QuestionType[]";
                        cell3.appendChild(choiceSelect);

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
                        cell4.innerHTML = '<input type="hidden" name="chioce_id[]" value="0">';

                        // เมื่อมีการเลือก Choice ให้ดึงข้อมูลจากไฟล์ get_choice.php โดยใช้ AJAX
                        choiceSelect.addEventListener('change', function() {
                            var secondSelect = cell4.querySelector('select[name="chioce_id[]"]');
                            var inputSelect = cell4.querySelector('input[name="chioce_id[]"]')
                            cell4.removeChild(inputSelect);
                            
                            if (this.value === 'Choice') {
                                // ตรวจสอบว่ามี select อันสองอยู่แล้วหรือไม่
                                if (secondSelect) {
                                    // ถ้ามีให้ลบออก
                                    cell4.removeChild(secondSelect);
                                    
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
                                cell4.appendChild(newSelect);
                            } else {
                                // ถ้าไม่ได้เลือก 'Choice' ให้ตรวจสอบว่ามี select อันสองอยู่แล้วหรือไม่ แล้วลบออก
                                if (secondSelect) {
                                    cell4.removeChild(secondSelect);
                                }
                                cell4.innerHTML = '<input type="hidden" name="chioce_id[]" value="0">';
                            }
                        });

                        // สร้างปุ่มลบใน cell4
                        cell5.innerHTML = '<button type="button" class="delBtn" onclick="deleteRow(this)" style="font-size: small;" >ลบแถว</button>';
                    }

                    // ฟังก์ชันลบแถว
                    function deleteRow(row) {
                        var index = row.parentNode.parentNode.rowIndex;
                        document.getElementById("question").deleteRow(index);
                    }

                    // ฟังก์ชันสำหรับสร้างตัวเลือก Choice จากข้อมูลที่ได้จาก AJAX
                    function createChoiceOptions(choices, selectElement) {
                        // เริ่มต้นด้วยการลบตัวเลือกทั้งหมดที่มีอยู่
                        selectElement.innerHTML = "";

                        // เพิ่มตัวเลือก Choice ไว้ที่ตัวแรก
                        var defaultOption = document.createElement("option");
                        defaultOption.value = '0'; // ตั้งค่าค่าเริ่มต้นเป็น 0
                        defaultOption.text = 'Choice';
                        selectElement.appendChild(defaultOption);

                        // เพิ่มตัวเลือกจากข้อมูลที่ได้จาก AJAX
                        choices.forEach(function(choice) {
                            var optionElem = document.createElement("option");
                            optionElem.value = choice.ID;
                            optionElem.text = "Choice " + choice.choice_name;
                            selectElement.appendChild(optionElem);
                        });
                    }

                    
                </script>
            </body>

</html>