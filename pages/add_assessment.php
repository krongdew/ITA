<?php
session_start();
include '../action/connect.php';

if (!isset($_SESSION['user'])) {
    // ถ้าไม่มี session user แสดงว่ายังไม่ได้ Login
    header("Location: /index.php");
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
include '../action/connect.php';
// ตรวจสอบว่ามีการส่งค่า ID มาหรือไม่
if (isset($_GET['ID'])) {
    $serviceID = $_GET['ID'];



    // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
    try {
        // เตรียมคำสั่ง SQL
        $stmt = $conn->prepare("SELECT * FROM sa_services WHERE ID = :serviceID");
        $stmt->bindParam(':serviceID', $serviceID);
        $stmt->execute();

        // ดึงข้อมูลผู้ใช้
        $service = $stmt->fetch(PDO::FETCH_ASSOC);

        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if ($service) {
?>

            <body class="g-sidenav-show   bg-gray-100">
                <?php // เรียกใช้ Sidebar ตาม UserType
                if ($user['UserType'] === "admin") {

                    include '../components/sidebar_admin.php';
                } else {
                    include '../components/sidebar.php';
                } ?>
                <?php include '../components/navbar.php' ?>
                <?php include '../action/connect.php';

                ?>

                <div class="container-fluid py-4">
                    <div class="row">
                        <div class="col-12">

                            <div class="card mb-4">
                                <div class="card-header pb-0">
                                    <h6>สร้างแบบประเมินความพึงพอใจ</h6>
                                    <br>
                                </div>

                                <div class="card-body px-0 pt-0 pb-2">
                                    <div id="add-form">
                                        <form method="post" action="../action/add_assessment_base.php">
                                            <div class="container-fluid py-4">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="card">
                                                            <div class="card-header pb-0">
                                                                <div class="d-flex align-items-center">
                                                                    <p class="mb-0">สร้างแบบประเมินความพึงพอใจของบริการ <?php echo $service['service_name']; ?></p>

                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <p class="text-uppercase text-sm"><b>ตรวจสอบข้อมูลของบริการก่อนสร้างแบบประเมิน</b></p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="example-text-input" class="form-control-label">ชื่อบริการ : </label>
                                                                            <input class="form-control" type="hidden" id="id" name="service_id" value="<?php echo $service['ID']; ?>">
                                                                            <input class="form-control" type="text" name="service_name" placeholder="ชื่อบริการ" value="<?php echo $service['service_name']; ?>" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-text-input" class="form-control-label">รายละเอียดของบริการ : </label>
                                                                            <input class="form-control" type="text" name="service_detail" placeholder="รายละเอียดของบริการ" value="<?php echo $service['service_detail']; ?>" disabled>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-text-input" class="form-control-label">สังกัดงาน : </label>
                                                                            <?php
                                                                            try {
                                                                                // คำสั่ง SQL สำหรับดึงข้อมูล department
                                                                                $sql = "SELECT ID, department_name FROM sa_department";

                                                                                // ใช้ Prepared Statement
                                                                                $stmt = $conn->prepare($sql);

                                                                                // ประมวลผลคำสั่ง SQL
                                                                                $stmt->execute();

                                                                                // ดึงผลลัพธ์
                                                                                $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                                                // ตรวจสอบว่ามีข้อมูลหรือไม่
                                                                                if (count($departments) > 0) {
                                                                                    echo '<select name="service_Access"  id="department_id"  class="form-select" required disabled>';
                                                                                    foreach ($departments as $department) {
                                                                                        $selected = ($service['service_Access'] == $department['ID']) ? 'selected' : '';
                                                                                        echo '<option value="' . $department['ID'] . '" ' . $selected . '>' . $department['department_name'] . '</option>';
                                                                                    }
                                                                                    echo '</select>';
                                                                                } else {
                                                                                    echo '<p>No departments found</p>';
                                                                                }
                                                                            } catch (PDOException $e) {
                                                                                echo "Connection failed: " . $e->getMessage();
                                                                            }
                                                                            ?>


                                                                        </div>

                                                                    </div>


                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="example-text-input" class="form-control-label">สถานะของบริการ :</label><br>
                                                                            <label>ปิด</label>
                                                                            <?php
                                                                            echo "<label class='switch'>";
                                                                            echo "<input type='checkbox' name='service_status[]'";

                                                                            // ตรวจสอบค่า $subservice['subservice_status'] เพื่อกำหนด checked attribute
                                                                            if ($service['service_status'] == 1) {
                                                                                echo " checked";
                                                                            }

                                                                            echo ">";
                                                                            echo "<span class='slider round'></span>";
                                                                            echo "</label>";
                                                                            ?>
                                                                            <label>เปิด</label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <!-- Toggle Button -->
                                                                        <button type="button" id="toggleSubserviceButton" class="btn btn-secondary btn-sm ms-auto">สร้างแบบประเมินแยกตามบริการย่อย</button>
                                                                        <div class="form-group">
                                                                            <span for="example-text-input" class="form-control-label"><b>ส่วนของบริการย่อย :</b></span><br>
                                                                            <!-- สร้าง input สำหรับรับค่าบริการย่อย -->
                                                                            <div class="form-group">
                                                                                <div id="subserviceTable">
                                                                                    <table id="subservices">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th style="font-size: smaller; padding:10px">ชื่อบริการย่อย</th>
                                                                                                <th style="font-size: smaller; padding:10px">รายละเอียดของบริการย่อย</th>
                                                                                                <th style="font-size: smaller; padding:10px">หน่วยงานที่ดูแล</th>
                                                                                                <th style="font-size: smaller; padding:10px">สถานะของบริการย่อย</th>

                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody id="mytable">

                                                                                            <?php


                                                                                            try {
                                                                                                // คำสั่ง SQL สำหรับดึงข้อมูลบริการย่อย
                                                                                                $sql = "SELECT * FROM sa_subservices WHERE service_id = :serviceID";

                                                                                                // ใช้ Prepared Statement
                                                                                                $stmt = $conn->prepare($sql);
                                                                                                // Bind parameter
                                                                                                $stmt->bindParam(':serviceID', $serviceID, PDO::PARAM_INT);

                                                                                                // ประมวลผลคำสั่ง SQL
                                                                                                $stmt->execute();

                                                                                                // ดึงผลลัพธ์
                                                                                                $subservices = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                                                                // ตรวจสอบว่ามีข้อมูลหรือไม่
                                                                                                if (count($subservices) > 0) {
                                                                                                    // สร้างตัวเลือกของ unit
                                                                                                    // $options = '<option value="">ชื่อหน่วย</option>';
                                                                                                    foreach ($subservices as $subservice) {
                                                                                                        echo "<tr>";
                                                                                                        echo "<td style='font-size: smaller;'> <input class='form-control' type='hidden' name='subservice_ID[]' placeholder='ชื่อบริการย่อย' value='" . $subservice['ID'] . "'><input class='form-control' type='text' name='subservice_name[]' placeholder='ชื่อบริการย่อย' value='" . $subservice['subservice_name'] . "' disabled></td>";
                                                                                                        echo "<td style='font-size: smaller;'> <input class='form-control' type='text' name='subservice_detail[]' placeholder='รายละเอียดบริการย่อย' value='" . $subservice['subservice_detail'] . "' disabled></td>";
                                                                                                        // ทำการตรวจสอบว่ามีข้อมูลหน่วยหรือไม่
                                                                                                        echo "<td style='font-size: smaller;'>";
                                                                                                        $departmentId = $service['service_Access'];
                                                                                                        try {
                                                                                                            // คำสั่ง SQL สำหรับดึงข้อมูล department
                                                                                                            $sql = "SELECT ID, unit_name FROM sa_unit WHERE department_id = :departmentId";

                                                                                                            // ใช้ Prepared Statement
                                                                                                            $stmt = $conn->prepare($sql);
                                                                                                            // Bind parameter
                                                                                                            $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);

                                                                                                            // ประมวลผลคำสั่ง SQL
                                                                                                            $stmt->execute();


                                                                                                            // ดึงผลลัพธ์
                                                                                                            $units = $stmt->fetchAll(PDO::FETCH_ASSOC);


                                                                                                            if (count($units) > 0) {
                                                                                                                echo '<select name="subservice_Access[]"  id="subservice_Access"  class="form-select" required disabled>';
                                                                                                                foreach ($units as $unit) {
                                                                                                                    $selected = ($subservice['subservice_Access'] == $unit['ID']) ? 'selected' : '';
                                                                                                                    echo '<option value="' . $unit['ID'] . '" ' . $selected . '>' . $unit['unit_name'] . '</option>';
                                                                                                                }
                                                                                                            } else {
                                                                                                                echo '<option value="" disabled selected>No unit found</option>';
                                                                                                            }
                                                                                                        } catch (PDOException $e) {
                                                                                                            echo "Connection failed: " . $e->getMessage();
                                                                                                        }

                                                                                                        echo "</select>";
                                                                                                        echo "</td>";

                                                                                                        echo "<td style='font-size: smaller;'>";
                                                                                                        echo "<select name='subservice_status[]' id='subservice_status' class='form-select' required disabled>";

                                                                                                        // เตรียมคำสั่งเพื่อกำหนด option ที่เลือกตาม $subservice['subservice_status']
                                                                                                        $selectedOpen = ($subservice['subservice_status'] == 1) ? 'selected' : '';
                                                                                                        $selectedClose = ($subservice['subservice_status'] == 0) ? 'selected' : '';

                                                                                                        // แสดง option ที่เลือก
                                                                                                        echo "<option value='1' $selectedOpen>เปิด</option>";
                                                                                                        echo "<option value='0' $selectedClose>ปิด</option>";

                                                                                                       
                                                                                                        echo "</select></td>";


                                                                                                        // หากต้องการแสดงข้อมูลหน่วยงานที่ดูแลและสถานะบริการย่อยต่อไปนี้
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
                                                                                </div>

                                                                                <!-- New Select Dropdown (Initially Hidden) -->
                                                                                <div id="subserviceSelect" style="display:none;">
                                                                                    <select class="form-select" name="selected_subservice">
                                                                                        <option value="">เลือกบริการย่อย</option>
                                                                                        <?php
                                                                                        // Loop through subservices to create options
                                                                                        foreach ($subservices as $subservice) {
                                                                                            echo "<option value='" . $subservice['ID'] . "'>" . $subservice['subservice_name'] . "</option>";
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>

                                                                                <br>
                                                                                <div class="form-group">
                                                                                    <span for="example-text-input" class="form-control-label"><b>ชื่อแบบประเมิน :</b> </span>
                                                                                    <input class="form-control" type="text" name="AssessmentName" placeholder="ชื่อแบบประเมิน" required>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <span for="example-text-input" class="form-control-label"><b>ชื่อผู้สร้างแบบประเมิน :</b> </span>
                                                                                    <input class="form-control" type="text" name="name_surname " value="<?php echo $user['name_surname']  ?> " disabled>
                                                                                    <input class="form-control" type="hidden" name="CreatorUserID" value="<?php echo $user['ID'] ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <button type="submit" class="btn btn-primary btn-sm ms-auto">สร้างข้อคำถาม</button>



                                        </form>
                                        <a href="../pages/services.php"><button type="button" class="btn btn-primary btn-sm ms-auto">ยกเลิกและกลับไปหน้าบริการ</button></a>
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
                    $(document).ready(function() {
                        // Fetch product options based on selected company and plant
                        $('#department_id').on('change', function() {
                            var selectedDepartment = $(this).val();
                            $.ajax({
                                url: '../action/get_unit2.php',
                                type: 'POST',
                                data: {
                                    department_id: selectedDepartment
                                },
                                success: function(data) {
                                    // $('#subservice_Access').html(data);
                                    var Departmentselected = document.querySelectorAll("select[name='subservice_Access[]'");
                                    for (var i = 0; i < Departmentselected.length; i++) {
                                        Departmentselected[i].innerHTML = data;
                                    }

                                }
                            });
                        });
                    })


                    // ฟังก์ชันเพิ่มแถวในตาราง
                    function addRow() {
                        // ดึงตารางมา
                        var table = document.getElementById("subservices");

                        // สร้างแถวใหม่
                        var newRow = table.insertRow(table.rows.length);

                        // สร้างเซลล์ในแถว
                        var cell1 = newRow.insertCell(0);
                        var cell2 = newRow.insertCell(1);
                        var cell3 = newRow.insertCell(2);
                        var cell4 = newRow.insertCell(3);
                        var cell5 = newRow.insertCell(4);

                        // เพิ่ม HTML ลงในเซลล์
                        cell1.innerHTML = '<input class="form-control" type="text" name="subservice_name[]" placeholder="ชื่อบริการย่อย" required>';
                        cell2.innerHTML = '<input class="form-control" type="text" name="subservice_detail[]" placeholder="รายละเอียดของบริการย่อย">';

                        // สร้าง select ใน cell3 และให้มี id เฉพาะ
                        // cell3.innerHTML = '<select class="form-select" name="subservice_Access[]" onchange="getUnits2(this)""></select>';
                        // Create a new select element for the product
                        var departmentSelect = document.createElement("select");
                        departmentSelect.className = "form-select";
                        departmentSelect.name = "subservice_Access[]";
                        // departmentSelect.onchange = function() {
                        //   getUnits2(this)
                        // };
                        cell3.appendChild(departmentSelect);

                        // Fetch product options based on selected company and plant
                        var selecteddepartment = $('#department_id').val();
                        $.ajax({
                            url: '../action/get_unit2.php',
                            type: 'POST',
                            data: {
                                department_id: selecteddepartment

                            },
                            success: function(data) {
                                departmentSelect.innerHTML = data;
                                // Fetch price for the selected product
                                // getUnits2(departmentSelect);
                            }
                        });

                        // สร้าง select ใน cell4
                        cell4.innerHTML = '<select class="form-select" name="subservice_status[]"><option value="1">เปิด</option><option value="0">ปิด</option></select>';

                        // สร้างปุ่มลบใน cell5
                        cell5.innerHTML = '<button type="button" class="delBtn" onclick="deleteRow(this)" style="font-size: small;" >ลบแถว</button>';

                    }

                    // ฟังก์ชันลบแถว
                    function deleteRow(row) {
                        var index = row.parentNode.parentNode.rowIndex;
                        document.getElementById("subservices").deleteRow(index);
                    }



                    // ฟังก์ชันสำหรับลบข้อมูลบริการย่อย
                    function deleteSubservices(button) {
                        // ดึงข้อมูลที่ต้องการลบ (subservicesID) จากปุ่มที่ถูกคลิก
                        var subservicesID = $(button).closest('tr').find('input[name="subservice_ID[]"]').val();

                        // แสดง SweetAlert 2 สำหรับยืนยันการลบ
                        Swal.fire({
                            title: 'คุณต้องการลบข้อมูลหรือไม่?',
                            text: "ลบบริการย่อย",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'ใช่, ลบ!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // ทำการลบในฐานข้อมูลด้วย Ajax
                                $.ajax({
                                    url: '../action/delete_subservices.php',
                                    type: 'POST',
                                    data: {
                                        subservicesID: subservicesID
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
                <script>
                    document.getElementById('toggleSubserviceButton').addEventListener('click', function() {
                        var table = document.getElementById('subserviceTable');
                        var select = document.getElementById('subserviceSelect');

                        if (table.style.display === 'none') {
                            table.style.display = 'block';
                            select.style.display = 'none';
                        } else {
                            table.style.display = 'none';
                            select.style.display = 'block';
                        }
                    });
                </script>
            </body>

</html>