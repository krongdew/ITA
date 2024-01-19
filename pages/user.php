<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">

    <title>
        ระบบ ITA
    </title>
    <!--     Fonts and icons     -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" /> -->
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
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
    <!-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script> -->

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
    <!-- <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
    <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script> -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.css"> -->
    <!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.js"></script> -->
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

    .cancelBtn {
        background-color: #ff3a24;
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

    .noticeerror {
        font-size: small;
        color: #ff3a24;
    }
</style>

<body class="g-sidenav-show   bg-gray-100">
    <?php include '../components/sidebar.php' ?>
    <?php include '../components/navbar.php' ?>
    <? include '../action/connect.php';

    // ใช้ PDO เพื่อดึงข้อมูลจากฐานข้อมูล
    // $sql = "SELECT * FROM sa_department";
    // $stmt = $conn->prepare($sql);
    // $stmt->execute();
    ?>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">

                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>เพิ่ม / ลบ / แก้ไข Unit</h6>
                        <br>
                        <button class="badge badge-sm bg-gradient-success" style="border: 0px;" onMouseOver="this.style.color='red'" onMouseOut="this.style.color='white'" id="button-service" onclick="toggleAddForm()">เพิ่ม User</button>

                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div id="add-form" style="display: none;">
                            <form method="post" enctype="multipart/form-data">
                                <div class="container-fluid py-4">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="card">
                                                <div class="card-header pb-0">
                                                    <div class="d-flex align-items-center">
                                                        <p class="mb-0">เพิ่มผู้ใช้ (User) ของกองกิจการนักศึกษา</p>

                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <p class="text-uppercase text-sm"><b>User Information</b></p>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">Username*: </label>
                                                                <input class="form-control" type="text" id="Username" name="Username" placeholder="Username" required>
                                                                <div class="noticeerror" id="#usernameExistsError"></div>
                                                            </div>
                                                            <div class="form-group" style="padding-top: 25px;">
                                                                <label for="example-text-input" class="form-control-label">Confirm Password*: </label>
                                                                <input class="form-control" type="password" id="ConfirmPassword" name="ConfirmPassword" placeholder="Password" required>
                                                                <span class="noticeerror" id="passwordMatchError"></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">งาน*: </label>
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

                                                                        echo '<select name="department_id" class="form-select" required onchange="getUnits(this.value)">';
                                                                        echo '<option value="" disabled selected>กรุณาเลือกงาน</option>';
                                                                        foreach ($departments as $department) {

                                                                            echo '<option value="' . $department['ID'] . '">' . $department['department_name'] . '</option>';
                                                                        }
                                                                        echo '</select>';
                                                                    } else {
                                                                        echo '<p>No departments found</p>';
                                                                    }
                                                                } catch (PDOException $e) {
                                                                    echo "Connection failed: " . $e->getMessage();
                                                                }
                                                                ?>

                                                                <!-- <input class="form-control" type="text" name="department_id" placeholder="ชื่องานที่สังกัด" required> -->

                                                            </div>
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">ตำแหน่ง*: </label>
                                                                <input class="form-control" type="text" name="position" placeholder="ตำแหน่ง" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">email มหาวิทยาลัย*: </label>
                                                                <input class="form-control" type="email" name="email" placeholder="email มหาวิทยาลัย" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">เบอร์โต๊ะทำงาน*: </label>
                                                                <input class="form-control" type="text" name="phone" placeholder="เบอร์โต๊ะทำงาน" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">รูปถ่าย*: </label>
                                                                <input class="form-control" type="file" name="image" id="imageInput" accept="image/*" required>
                                                                <div id="fileSizeError" style="color: red; font-size: small;"></div>
                                                                <div id="fileTypeError" style="color: red; font-size: small;"></div>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">Password*: </label>
                                                                <input id="ipassword" class="form-control" type="password" name="Password" placeholder="Password" required>
                                                                <!-- An element to toggle between password visibility -->
                                                                <input type="checkbox" onclick="showpassword()">
                                                                <span style="font-size: xx-small;">Show Password</span>
                                                                <br>
                                                                <span class="noticeerror" id="passwordComplexityError"></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">ชื่อ-นามสกุล*: </label>
                                                                <input class="form-control" type="text" name="name_surname" placeholder="ชื่อ-นามสกุล" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">หน่วย*: </label>
                                                                <div id="unitSelect"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">ตำแหน่งบริหาร (ถ้ามี): </label>
                                                                <input class="form-control" type="text" name="position_c" placeholder="ตำแหน่งบริหาร">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">email อื่น ๆ: </label>
                                                                <input class="form-control" type="email" name="email_other" placeholder="email อื่น ๆ">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="example-text-input" class="form-control-label">เบอร์โทรศัพท์: </label>
                                                                <input class="form-control" type="text" name="tell" placeholder="เบอร์โทรศัพท์">
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm ms-auto">Add</button>
                                                    <button type="reset" class="btn btn-primary btn-sm ms-auto" onclick="toggleAddForm()">Cancel</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div style="padding: 20px;">
                    <table id="myTable" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">image</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ชื่อ-นามสกุล</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">งาน</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">หน่วย</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">เบอร์โทรโต๊ะ</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">อีเมลมหาลัย</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ตำแหน่ง</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ตำแหน่งบริหาร</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">อีเมลอื่น ๆ </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">เบอร์โทรส่วนตัว</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">created_at</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">updated_at</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
        function showpassword() {
            var x = document.getElementById("ipassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }


        function toggleAddForm() {
            var addFormDiv = document.getElementById('add-form');

            // Check if the form is already visible
            if (addFormDiv.style.display === 'none' || addFormDiv.style.display === '') {
                // Show the form
                addFormDiv.style.display = 'block';
            } else {
                // Hide the form
                addFormDiv.style.display = 'none';
            }

            // Return false to prevent the default behavior of the button
            return false;
        }
    </script>
    <script>
        function getUnits(departmentId) {
            // ตรวจสอบว่า departmentId ไม่ใช่ค่าว่าง
            if (departmentId !== "") {
                // ใช้ XMLHttpRequest หรือ Fetch API สำหรับสร้าง request ไปยัง get_unit.php
                var xhr = new XMLHttpRequest();

                // กำหนด method และ URL ที่จะส่ง request
                xhr.open("GET", "../action/get_unit.php?department_id=" + departmentId, true);

                // กำหนด callback function ที่จะทำงานเมื่อ request เสร็จสิ้น
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // นำข้อมูลที่ได้มาแสดงผลใน element ที่มี id เท่ากับ "unitSelect"
                        document.getElementById("unitSelect").innerHTML = xhr.responseText;
                    }
                };

                // ส่ง request
                xhr.send();
            }
        }
    </script>


    <script>
        $(document).ready(function() {
            // Function to check if passwords match

            function checkPasswordMatch() {
                var password = $("#ipassword").val();
                var confirmPassword = $("#ConfirmPassword").val();

                if (password != confirmPassword) {
                    $("#passwordMatchError").html("Password ไม่ตรงกัน");
                } else {
                    $("#passwordMatchError").html("");
                }
            }

            // Function to check password complexity
            function checkPasswordComplexity() {
                var password = $("#ipassword").val();
                var regex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{6,}$/;

                if (!regex.test(password)) {
                    $("#passwordComplexityError").html("Password ไม่ปลอดภัย กรุณาใส่อักขระพิเศษอย่างน้อย 1 ตัว, ตัวเลข และตัวอักษร และมีความยาวอย่างน้อย 6 ตัว");
                } else {
                    $("#passwordComplexityError").html("");
                }
            }

            // Function to check if username already exists
            function checkUsernameExists() {
                var username = $("#Username").val();

                $.ajax({
                    type: "POST",
                    url: "../action/check_username.php", // ต้องสร้างไฟล์ check_username.php เพื่อตรวจสอบ username ในฐานข้อมูล
                    data: {
                        username: username
                    },
                    dataType: 'json',
                    success: function(response) {
                        var usernameExistsError = $("#usernameExistsError");

                        if (response.status === 'exists') {
                            usernameExistsError.html("<span style='color: red;'>มี username นี้แล้ว</span>");
                        } else if (response.status === 'not exists') {
                            usernameExistsError.html("<span style='color: green;'>username นี้สามารถใช้งานได้</span>");
                        }
                    }
                });
            }

            // Event listeners for password input
            $("#ConfirmPassword").keyup(checkPasswordMatch);
            $("#ipassword").keyup(checkPasswordComplexity);

            // Event listener for username input
            $("#Username").keyup(checkUsernameExists);
        });

        document.getElementById('imageInput').addEventListener('change', handleFileSelect);

        function handleFileSelect(event) {
            const fileInput = event.target;
            const fileSize = fileInput.files[0].size; // ขนาดไฟล์ใน bytes
            const maxSizeInBytes = 5 * 1024 * 1024; // 5 MB
            const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i; // นามสกุลไฟล์ที่อนุญาต

            // ตรวจสอบนามสกุลของไฟล์ที่ผู้ใช้เลือก
            if (!allowedExtensions.exec(fileInput.value)) {
                document.getElementById('fileTypeError').innerHTML = 'อนุญาตเฉพาะไฟล์ภาพเท่านั้น (jpg, jpeg, png, gif)';
                fileInput.value = ''; // ล้างค่า input file
            } else {
                document.getElementById('fileTypeError').innerHTML = '';
            }

            // ตรวจสอบขนาดของไฟล์
            if (fileSize > maxSizeInBytes) {
                document.getElementById('fileSizeError').innerHTML = 'ไฟล์มีขนาดเกิน 5 MB';
                fileInput.value = ''; // ล้างค่า input file
            } else {
                document.getElementById('fileSizeError').innerHTML = '';
            }
        }
    </script>



    <!-- ส่วนที่เพิ่มเข้าไป -->
    <script>
        function updatedata() {
            $('#myTable').DataTable().ajax.reload();
        }


        $(document).ready(function() {
            // ให้ฟังก์ชันทำงานเมื่อมีการกด submit ฟอร์ม
            $('form').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                // ทำการส่งข้อมูลไปยังไฟล์ PHP ตาม URL ที่ระบุใน action
                $.ajax({
                    type: 'POST',
                    url: '../action/add_user.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json', // รับข้อมูลเป็น JSON
                    success: function(response) {
                        if (response.status === 'success') {
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
                        } else {
                            // กรณีที่มีข้อผิดพลาด
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: response // แสดงข้อความ error ที่ได้รับจากไฟล์ PHP
                            });
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // กรณีที่มีข้อผิดพลาดใน Ajax request
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถบันทึกข้อมูลได้: ' + errorThrown
                        });
                    }
                });
            });
        });
    </script>

    <script>
        pdfMake.fonts = {
            thaiFont: {
                normal: 'THSarabun.ttf',
                bold: 'THSarabun-Bold.ttf',
                italics: 'THSarabun-Italic.ttf',
                bolditalics: 'THSarabun-BoldItalic.ttf'
            }
        };



        $(document).ready(function() {
            var table;
            var globalDepartmentData;
            var globalUnitData; // Add a global variable for unit data

            // Fetch department data
            $.ajax({
                url: "../action/get_department_data.php",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    globalDepartmentData = response;

                    // Fetch unit data
                    $.ajax({
                        url: "../action/get_unit_data.php", // Adjust the URL accordingly
                        type: "GET",
                        dataType: "json",
                        success: function(unitResponse) {
                            globalUnitData = unitResponse;

                            // Initialize DataTable after fetching both department and unit data
                            initializeDataTable();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Error fetching unit data:', errorThrown);
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching department data:', errorThrown);
                }
            });

            function initializeDataTable() {

                table = $('#myTable').DataTable({
                    responsive: true,
                    dom: 'lBfrtip',
                    columns: [{
                            data: "column1",
                            title: "Column 1"
                        },
                        {
                            data: "column2",
                            title: "Column 2"
                        },
                        {
                            data: "column3",
                            title: "Column 3"
                        },
                        {
                            data: "column4",
                            title: "Column 4"
                        },
                        {
                            data: "column5",
                            title: "Column 5"
                        },
                        {
                            data: "column6",
                            title: "Column 6"
                        },
                        {
                            data: "column7",
                            title: "Column 7"
                        },
                        {
                            data: "column8",
                            title: "Column 8"
                        },
                        {
                            data: "column9",
                            title: "Column 9"
                        },
                        {
                            data: "column10",
                            title: "Column 10"
                        },
                        {
                            data: "column11",
                            title: "Column 11"
                        },
                        {
                            data: "column12",
                            title: "Column 12"
                        },
                        {
                            data: "column13",
                            title: "Column 13"
                        },
                        {
                            data: "column14",
                            title: "Column 14"
                        },

                        // เพิ่มคอลัมน์ตามต้องการ
                    ],
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        {
                            extend: 'pdfHtml5',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13] // ระบุคอลัมน์ที่จะ export (index 0, 1, 2)
                            },
                            customize: function(doc) {
                                doc.defaultStyle.font = 'thaiFont'; // หรือใช้ชื่อ font ที่คุณต้องการ
                                doc.defaultStyle.fontSize = 10; // ตั้งค่าขนาดตัวอักษรที่นี่ (เป็นตัวเลข)

                                // ... รายละเอียดอื่น ๆ
                                // ตั้งค่ากระดาษ A4 แนวนอน
                                doc.pageSize = 'A4';
                                doc.pageOrientation = 'landscape';

                            }
                        }
                    ],
                    autoWidth: false,
                    lengthMenu: [10, 25, 50, 75, 100],
                    pageLength: 10,
                    serverSide: true,
                    ajax: {
                        url: "../action/get_user_server.php",
                        type: "POST",
                        dataType: "json",
                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row) {
                                return '<a href="../pages/edit_user.php?ID='+ data.ID +'"><button class="editBtn">Edit</button></a> <button class="saveBtn" style="display:none;">Save</button> <button class="delBtn">Delete</button>';
                            },
                            orderable: false,
                        },
                        {
                            data: "image",
                            render: function(data, type, row) {
                                // ตรวจสอบประเภทของข้อมูลที่ DataTables กำลังร้องขอ
                                if (type === 'display' && data) {
                                    // สร้าง HTML สำหรับแสดงภาพ
                                    return '<img src="' + data + '" alt="Image" style="width: 30px; height: 30px;">';
                                } else {
                                    // สำหรับประเภทข้อมูลอื่น ๆ หรือถ้าข้อมูลไม่มี
                                    return data;
                                }
                            },
                        },
                        {
                            data: "Username",
                        },
                        {
                            data: "name_surname",
                        },
                        {
                            data: "department",
                            className: "editable",
                            render: function(data) {
                                // ให้หาข้อมูล department_name จาก globalDepartmentData แล้วแสดง
                                var department = globalDepartmentData.find(function(dep) {
                                    return dep.ID === data;
                                });
                                return department ? department.department_name : '';
                            },
                        },
                        {
                            data: "unit",
                            className: "editable",
                            render: function(data) {
                                // Find unit_name from globalUnitData based on the ID
                                var unit = globalUnitData.find(function(unit) {
                                    return unit.ID === data;
                                });
                                return unit ? unit.unit_name : '';
                            },
                        },
                        {
                            data: "phone",
                        },
                        {
                            data: "email",
                        },
                        {
                            data: "position",
                        },
                        {
                            data: "position_c",
                        },
                        {
                            data: "email_other",
                        },
                        {
                            data: "tell",
                        },
                        {
                            data: "created_at",
                        },
                        {
                            data: "updated_at",
                        },

                    ],
                    order: [
                        [0, 'asc'],
                    ],
                });
            }




            // // ฟังก์ชัน Edit
            // $('#myTable tbody').on('click', 'button.editBtn', function() {
            //     var data = table.row($(this).parents('tr')).data();
            //     var tr = $(this).closest('tr');
            //     var departmentSelect = '<select class="editDepartment" style="width:100%"></select>';

            //     // แสดงชื่อหน่วยและ department_id เพื่อให้แก้ไข
            //     tr.find('td:eq(1)').html('<input class="editUnitName" value="' + data.unit_name + '">');
            //     tr.find('td:eq(2)').html(departmentSelect);

            //     // เตรียมค่าใน select box
            //     if (Array.isArray(globalDepartmentData)) {
            //         globalDepartmentData.forEach(function(dep) {
            //             var option = '<option value="' + dep.ID + '">' + dep.department_name + '</option>';
            //             tr.find('.editDepartment').append(option);
            //         });
            //     } else {
            //         console.error('Department data is not an array or is undefined.');
            //     }

            //     tr.find('.editDepartment').val(data.department_id);
            //     tr.find('td:eq(4)').html('<button class="saveBtn">Save</button> <button class="cancelBtn">Cancel</button>');
            // });
            // // ฟังก์ชัน Save
            // $('#myTable tbody').on('click', 'button.saveBtn', function() {
            //     var tr = $(this).closest('tr');
            //     var data = table.row(tr).data();
            //     var unitName = tr.find('.editUnitName').val();
            //     var departmentId = tr.find('.editDepartment').val();

            //     // ทำการบันทึกข้อมูลลงฐานข้อมูล
            //     $.ajax({
            //         url: '../action/update_unit.php', // สร้างไฟล์ update_unit.php สำหรับการบันทึกข้อมูล
            //         type: 'POST',
            //         data: {
            //             unit_id: data.ID, // แนบ ID ของหน่วยที่ต้องการแก้ไข
            //             unit_name: unitName,
            //             department_id: departmentId
            //         },
            //         dataType: 'json',
            //         success: function(response) {
            //             if (response.status === 'success') {
            //                 // Reload DataTable to display updated data
            //                 table.ajax.reload();
            //             } else {
            //                 Swal.fire(
            //                     'เกิดข้อผิดพลาด!',
            //                     'เกิดข้อผิดพลาดในการแก้ไขข้อมูล.',
            //                     'error'
            //                 );
            //             }
            //         }
            //     });
            // });

            // // ฟังก์ชัน Cancel
            // $('#myTable tbody').on('click', 'button.cancelBtn', function() {
            //     table.draw();
            // });

            //   // Edit button click event
            //   $('#myTable').on('click', '.editBtn', function() {
            //     var row = $(this).closest('tr');
            //     row.find('td.editable').prop('contenteditable', true);
            //     row.find('.editBtn').hide();
            //     row.find('.saveBtn').show();

            //     // Set focus to the first editable field (unit_name)
            //     row.find('.editable:eq(0)').focus();

            //     // Add border styling to the editable fields
            //     row.find('.editable').css({
            //       'border': '2px solid #337ab7', // Change the color as needed
            //       'border-radius': '5px', // Optional: Add border-radius for rounded corners
            //     });
            //   });

            //   // Save button click event
            //   $('#myTable').on('click', '.saveBtn', function() {
            //     var row = $(this).closest('tr');
            //     var data = $('#myTable').DataTable().row($(this).parents('tr')).data();
            //     row.find('td.editable').prop('contenteditable', false);
            //     row.find('.editBtn').show();
            //     row.find('.saveBtn').hide();

            //     // Save data to your server using Ajax if needed
            //     // Get the edited data
            //     var editedData = {
            //       unit_name: row.find('.editable:eq(0)').text(),
            //       department_id: row.find('.editable:eq(1)').text(),
            //       // Add other fields as needed
            //     };

            //     // Get the unit ID
            //     var unitID = data.ID


            //     // Save data to your server using Ajax
            //     $.ajax({
            //       url: '../action/update_unit.php',
            //       type: 'POST',
            //       data: {
            //         unitID: unitID,
            //         editedData: editedData
            //       },
            //       dataType: 'json',
            //       success: function(response) {

            //         if (response.status === 'success') {
            //           // Reload DataTable to display updated data
            //           table.ajax.reload();
            //         } else {
            //           Swal.fire(
            //             'เกิดข้อผิดพลาด!',
            //             'เกิดข้อผิดพลาดในการแก้ไขข้อมูล.',
            //             'error'
            //           );
            //         }
            //       }
            //     });



            // Event listener สำหรับปุ่ม Delete
            $('#myTable').on('click', '.delBtn', function() {
                var data = $('#myTable').DataTable().row($(this).parents('tr')).data();
                var userID = data.ID;

                // แสดง SweetAlert 2 สำหรับยืนยันการลบ
                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: "คุณต้องการลบข้อมูลหรือไม่?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ลบ!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // ทำการลบในฐานข้อมูลด้วย Ajax
                        $.ajax({
                            url: '../action/delete_user.php',
                            type: 'POST',
                            data: {
                                userID: userID
                            },
                            dataType: 'json', // รับข้อมูลเป็น JSON
                            success: function(response) {
                                if (response.status === 'success') {

                                    Swal.fire(
                                        'ลบข้อมูลเรียบร้อย!',
                                        'ข้อมูลถูกลบออกจากระบบแล้ว.',
                                        'success'
                                    ).then((result) => {
                                        if (result.isConfirmed) {
                                            // ทำการ reload ข้อมูล
                                            $('#myTable').DataTable().ajax.reload();
                                        }
                                    });
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
            });
        });
    </script>


</body>

</html>