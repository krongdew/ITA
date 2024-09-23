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
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" /> -->
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
<?php
// ตรวจสอบว่ามีการส่งค่า ID มาหรือไม่
if (isset($_POST['ID'])) {
    $userID = $_POST['ID'];

    // Key for encryption
    $key = getenv('ENCRYPTION_KEY');

    // Function to decrypt data
    function decryptData($data, $key)
    {
        $cipher = "aes-256-cbc";
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);
    }

    // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
    try {
        // เตรียมคำสั่ง SQL

        $stmt = $conn->prepare("SELECT * FROM sa_users WHERE ID = :userID");
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();

        // ดึงข้อมูลผู้ใช้
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if ($row) {

            $row['name_surname'] = decryptData($row['name_surname'], $key);
            $row['email'] = decryptData($row['email'], $key);
            $row['email_other'] = decryptData($row['email_other'], $key);
            $row['tell'] = decryptData($row['tell'], $key);
?>

            <body class="g-sidenav-show   bg-gray-100">
                <?php if ($user['UserType'] === "admin") {

                    include '../components/sidebar_admin.php';
                } else {
                    include '../components/sidebar.php';
                }
                ?>

                <?php include '../components/navbar.php' ?>

                <?php include '../action/connect.php';

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
                                    <h6>แก้ไขผู้ใช้งานระบบ</h6>
                                    <br>
                                    <form action="./change_password.php" method="post">
                                        <input class="form-control" type="hidden" id="id" name="ID" value="<?php echo $row['ID']; ?>">
                                        <button type="submit" class="badge badge-sm bg-gradient-success" style="border: 0px;" onMouseOver="this.style.color='red'" onMouseOut="this.style.color='white'" id="button-service">เปลี่ยน password</button>
                                    </form>
                                    <form action="./reset_password_admin.php" method="post">
                                        <input class="form-control" type="hidden" id="id" name="ID" value="<?php echo $row['ID']; ?>">
                                        <button type="submit" class="badge badge-sm bg-gradient-success" style="border: 0px;" onMouseOver="this.style.color='red'" onMouseOut="this.style.color='white'" id="button-service">Reset password</button>
                                    </form>

                                </div>

                                <div class="card-body px-0 pt-0 pb-2">
                                    <form method="post" enctype="multipart/form-data" action="../action/edit_user_base.php">
                                        <div class="container-fluid py-4">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="card">
                                                        <div class="card-header pb-0">
                                                            <div class="d-flex align-items-center">
                                                                <p class="mb-0">แก้ไขผู้ใช้งาน (User) ของกองกิจการนักศึกษา</p>

                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <p class="text-uppercase text-sm"><b>User Information</b></p>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="example-text-input" class="form-control-label">Username*: </label>
                                                                        <input class="form-control" type="hidden" id="id" name="ID" value="<?php echo $row['ID']; ?>">
                                                                        <input class="form-control" type="text" id="username" name="username" value="<?php echo $row['Username']; ?>" disabled>
                                                                        <input class="form-control" type="hidden" id="username" name="username" value="<?php echo $row['Username']; ?>" disabled>
                                                                        <div class="noticeerror" id="#usernameExistsError"></div>
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
                                                                                echo '<select name="department_id"  id="department_id"  class="form-select" required onchange="getUnits(this.value)">';
                                                                                foreach ($departments as $department) {
                                                                                    $selected = ($row['department'] == $department['ID']) ? 'selected' : '';
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

                                                                        <!-- <input class="form-control" type="text" name="department_id" placeholder="ชื่องานที่สังกัด" required> -->

                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="example-text-input" class="form-control-label">ตำแหน่ง*: </label>
                                                                        <input class="form-control" type="text" name="position" value="<?php echo $row['position']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="example-text-input" class="form-control-label">email มหาวิทยาลัย*: </label>
                                                                        <input class="form-control" type="email" name="email" value="<?php echo $row['email']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="example-text-input" class="form-control-label">เบอร์โต๊ะทำงาน*: </label>
                                                                        <input class="form-control" type="text" name="phone" value="<?php echo $row['phone']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group">

                                                                        <label for="example-text-input" class="form-control-label">รูปถ่าย*: </label><br>
                                                                        <img src="../upload/<?php echo $row['image']; ?>" width="100px" height="100px"><br><br>
                                                                        <input class="form-control" type="text" name="image" id="imageInput" value="">
                                                                        <div id="fileSizeError" style="color: red; font-size: small;"></div>
                                                                        <div id="fileTypeError" style="color: red; font-size: small;"></div>
                                                                    </div>

                                                                </div>

                                                                <div class="col-md-6">

                                                                    <div class="form-group">
                                                                        <label for="example-text-input" class="form-control-label">ชื่อ-นามสกุล*: </label>
                                                                        <input class="form-control" type="text" name="name_surname" value="<?php echo $row['name_surname']; ?>" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="example-text-input" class="form-control-label">หน่วยปัจจุบันที่สังกัด:
                                                                            <?php
                                                                            $unit = $row['unit'];
                                                                            // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
                                                                            try {
                                                                                // เตรียมคำสั่ง SQL
                                                                                $stmt = $conn->prepare("SELECT * FROM sa_unit WHERE ID = :unitID");
                                                                                $stmt->bindParam(':unitID', $unit);
                                                                                $stmt->execute();

                                                                                // ดึงข้อมูลผู้ใช้
                                                                                $units = $stmt->fetch(PDO::FETCH_ASSOC);

                                                                                // ตรวจสอบว่ามีข้อมูลหรือไม่
                                                                                if ($units) {

                                                                                    echo '<input class="form-control" type="text" name="unit_old" value="' . $units['unit_name'] . '" disabled>';
                                                                                    echo '<input type="hidden" name="unit_old_id" value="' . $row['unit'] . '" >';
                                                                                } else {
                                                                                    echo '<p>ไม่พบข้อมูลหน่วยที่สังกัด</p>';
                                                                                }
                                                                            } catch (PDOException $e) {
                                                                                echo "Connection failed: " . $e->getMessage();
                                                                            }
                                                                            ?>
                                                                        </label>
                                                                        <label>หากต้องการเปลี่ยนแปลงหน่วย เลือกหน่วยใหม่ที่นี่</label>
                                                                        <select class="form-select" name="unit_id" id="unit_id">
                                                                            <option></option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="example-text-input" class="form-control-label">ตำแหน่งบริหาร (ถ้ามี): </label>
                                                                        <input class="form-control" type="text" name="position_c" value="<?php echo $row['position_c']; ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="example-text-input" class="form-control-label">email อื่น ๆ: </label>
                                                                        <input class="form-control" type="email" name="email_other" value="<?php echo $row['email_other']; ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="example-text-input" class="form-control-label">Role: </label>
                                                                        <input class="form-control" type="text" name="UserType" placeholder="user / admin" value="<?php echo $row['UserType']; ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="example-text-input" class="form-control-label">เบอร์โทรศัพท์: </label>
                                                                        <input class="form-control" type="text" name="tell" value="<?php echo $row['tell']; ?>">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <button type="submit" class="btn btn-primary btn-sm ms-auto">edit</button>
                                                            <a href="../pages/user.php"><button type="button" class="btn btn-primary btn-sm ms-auto">Cancel</button></a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                    </form>
                        <?php
                    } else {
                        echo '<p>ไม่พบข้อมูลผู้ใช้</p>';
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
                                    $('#unit_id').html(data);
                                }
                            });
                        });
                    })

                    // function getUnits(departmentId) {
                    //     // ตรวจสอบว่า departmentId ไม่ใช่ค่าว่าง
                    //     if (departmentId !== "") {
                    //         // ใช้ XMLHttpRequest หรือ Fetch API สำหรับสร้าง request ไปยัง get_unit.php
                    //         var xhr = new XMLHttpRequest();

                    //         // กำหนด method และ URL ที่จะส่ง request
                    //         xhr.open("GET", "../action/get_unit.php?department_id=" + departmentId, true);

                    //         // กำหนด callback function ที่จะทำงานเมื่อ request เสร็จสิ้น
                    //         xhr.onreadystatechange = function() {
                    //             if (xhr.readyState == 4 && xhr.status == 200) {
                    //                 // นำข้อมูลที่ได้มาแสดงผลใน element ที่มี id เท่ากับ "unitSelect"
                    //                 document.getElementById("unitSelect").innerHTML = xhr.responseText;
                    //             }
                    //         };

                    //         // ส่ง request
                    //         xhr.send();
                    //     }
                    // }
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





            </body>

</html>