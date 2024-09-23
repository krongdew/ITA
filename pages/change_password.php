<?php
session_start();
include '../action/connect.php';

if (!isset($_SESSION['user'])) {
    // ถ้าไม่มี session user แสดงว่ายังไม่ได้ Login
    header("Location: /index.php");
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

    .buttonform {
        padding: 0;
        margin: 0;
        display: inline;
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
    if (isset($_POST['ID'])) {
        $userID = $_POST['ID'];
     


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


    ?>
                <div class="container-fluid py-4">
                    <div class="row">
                        <div class="col-12">

                            <div class="card mb-4">
                                <div class="card-header pb-0">
                                    <h6>แก้ไข password</h6>
                                    <br>
                                </div>

                                <div class="card-body px-0 pt-0 pb-2">
                                    <div id="add-form">
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="container-fluid py-4">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="card">
                                                            <div class="card-header pb-0">

                                                            </div>
                                                            <div class="card-body">
                                                                <p class="text-uppercase text-sm"><b>User Information</b></p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="example-text-input" class="form-control-label">Username*: </label>
                                                                            <input class="form-control" type="hidden" id="id" name="id" value="<?php echo $row['ID']; ?>">
                                                                            <input class="form-control" type="text" id="username" name="username" value="<?php echo $row['Username']; ?>" disabled>

                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-text-input" class="form-control-label">Old Password*: </label>
                                                                            <input id="oldpassword" class="form-control" type="password" name="Password" placeholder="Password เดิม" required>
                                                                            <!-- An element to toggle between password visibility -->
                                                                            <input type="checkbox" onclick="showpassoldword()">
                                                                            <span style="font-size: xx-small;">Show Password</span>
                                                                            <br>

                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-text-input" class="form-control-label">New Password*: </label>
                                                                            <input id="ipassword" class="form-control" type="password" name="Password" placeholder="Password" required>
                                                                            <!-- An element to toggle between password visibility -->
                                                                            <input type="checkbox" onclick="showpassword()">
                                                                            <span style="font-size: xx-small;">Show Password</span>
                                                                            <br>
                                                                            <span class="noticeerror" id="passwordComplexityError"></span>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="example-text-input" class="form-control-label">Confirm New Password*: </label>
                                                                            <input class="form-control" type="password" id="ConfirmPassword" name="confirmPassword" placeholder="Password" required>
                                                                            <span class="noticeerror" id="passwordMatchError"></span>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary btn-sm ms-auto">Change Password</button>
                                                                        <a href="../pages/user.php"><button type="button" class="btn btn-primary btn-sm ms-auto">Cancel</button></a>
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
                </script>
                <script>
                    function showpassoldword() {
                        var x = document.getElementById("oldpassword");
                        if (x.type === "password") {
                            x.type = "text";
                        } else {
                            x.type = "password";
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


                        // Event listeners for password input
                        $("#ConfirmPassword").keyup(checkPasswordMatch);
                        $("#ipassword").keyup(checkPasswordComplexity);


                    });

                    $(document).ready(function() {
                        $('form').submit(function(e) {
                            e.preventDefault();

                            var id = $('#id').val();
                            var oldPassword = $('#oldpassword').val();
                            var newPassword = $('#ipassword').val();
                            var confirmPassword = $('#ConfirmPassword').val();
                            
                           

                            // เช็คว่ารหัสผ่านใหม่ตรงกันหรือไม่
                            if (newPassword !== confirmPassword) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'รหัสผ่านใหม่ไม่ตรงกัน!',
                                });
                                return;
                            }

                            // เช็ครหัสผ่านเก่าและรหัสผ่านใหม่ตรงกันหรือไม่
                            $.ajax({
                                url: '../action/check_password.php',
                                type: 'post',
                                data: {
                                    id: id,
                                    oldPassword: oldPassword,
                                    newPassword: newPassword,
                                    confirmPassword : confirmPassword
                                },
                                success: function(response) {
                                    if (response === "success") {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว',
                                        }).then((result) => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'รหัสผ่านเก่าไม่ถูกต้อง!',
                                        });
                                    }
                                }
                            });
                        });
                    });
                </script>






</body>

</html>