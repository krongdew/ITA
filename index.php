<?php
session_start();
header_remove("X-Powered-By");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header_remove("Server");
?>

<?php
$current_time = time();
$next_login_time = isset($_SESSION['next_login_time']) ? $_SESSION['next_login_time'] : array();
if (isset($_SESSION['next_login_time'][$_SERVER['REMOTE_ADDR']])) {
  $next_login_time = $_SESSION['next_login_time'][$_SERVER['REMOTE_ADDR']];
  date_default_timezone_set('Asia/Bangkok'); // เลือกโซนเวลาของประเทศไทย
  // echo "Next login time for IP address 172.25.0.1: " . date("Y-m-d H:i:s", $next_login_time);
} else {
  // echo "Next login time is not set for IP address 172.25.0.1";
}

include './action/csrf_token.php';
// สร้าง CSRF token
$csrf_token = generateCsrfToken();
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/Mahidol_U.png">
  <link rel="icon" type="image/png" href="./assets/img/Mahidol_U.png">

  <title>ระบบ ITA</title>
  <!--     Fonts and icons     -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" /> -->
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <!-- <script src="./assets/js/42d5adcbca.js" crossorigin="anonymous"></script> -->
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="./assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <!-- เพิ่ม link ไปยัง SweetAlert2 CSS ตรงนี้ -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <!-- เพิ่ม link ไปยัง SweetAlert2 JavaScript ตรงนี้ -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>


<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
          <div class="container-fluid">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 ">
              SA Service System <br>
              Mahidol Division of Student Affairs
            </a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
          </div>
      </div>
      </nav>
      <!-- End Navbar -->
    </div>
  </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  <p class="mb-0">Enter your Username and password to sign in</p>
                </div>
                <div class="card-body">
                  <form role="form" method="POST" action="action/login.php">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    <div class="mb-3">
                      <input type="text" name="Username" class="form-control form-control-lg" placeholder="Username" aria-label="Username" required>
                    </div>
                    <div class="mb-3">
                      <input type="password" name="Password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" required>
                    </div>
                    <div id="error" style="color: red;"><?php echo isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
                                                        unset($_SESSION['error_message']); ?></div>

                    <div id="countdown" style="color: red;"></div>

                    <div class="text-center">
                    
                    <button id="signInButton" type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>

                    </div>
                  </form>
                  
                  <!-- <button class="btn btn-link text-dark px-3 mb-0" id="forgotPassword">ลืมรหัสผ่าน?</button> -->
                  
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7  border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('assets/img/005-128.jpg');
          background-size: cover;">
                <span class="mask bg-gradient-primary opacity-6"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <div id="forgotPasswordModal" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ลืมรหัสผ่าน</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>กรุณากรอก Username และ email ที่ได้บันทึกข้อมูลไว้กับระบบ</p>
        <form id="forgotPasswordForm">
          <div class="mb-3">
            <label for="Username" class="form-label">Username</label>
            <input type="text" class="form-control" id="Username" name="Username">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">อีเมล์ (mahidol.ac.th) </label>
            <input type="email" class="form-control" id="email" name="email">
          </div>
          <button type="submit" class="btn btn-primary">ส่ง</button>
        </form>
      </div>
    </div>
  </div>
</div>

  <!--   Core JS Files   -->

  <?php include './components/script.php'; ?>
  <script>
    // ฟังก์ชันสำหรับการนับถอยหลัง
    var nextLoginTime = <?php echo $next_login_time; ?>;

    var intervalId; // สร้างตัวแปรเก็บ id ของ setInterval

    // เรียกใช้ฟังก์ชัน countdown() ทุกๆ 1 วินาที
    intervalId = setInterval(countdown, 1000);

    // ฟังก์ชัน countdown
    function countdown() {
      // คำนวณเวลาที่เหลือ
      var now = Math.floor(Date.now() / 1000); // เวลาปัจจุบันในรูปแบบ timestamp (เวลาในมิลลิวินาทีที่ผ่านไปตั้งแต่ Epoch)
      var remainingTime = nextLoginTime - now;

      // ตรวจสอบว่าเวลาที่เหลือมีค่ามากกว่าศูนย์หรือไม่
      if (remainingTime > 0) {
        // แปลงเวลาที่เหลือให้เป็นรูปแบบนาที
        var minutes = Math.floor(remainingTime / 60); // หาจำนวนนาทีที่เหลือ
        var seconds = remainingTime % 60; // หาจำนวนวินาทีที่เหลือ

        // แสดงผลลัพธ์

        // แสดงผลลัพธ์ใน <div> ที่มี id="countdown"
        document.getElementById("countdown").innerHTML = "เหลืออีก " + minutes + ":" + Math.abs(seconds) + " นาที";
      } else {

        // เมื่อเวลาหมดลงแล้ว
        document.getElementById("countdown").innerHTML = "เวลาการเข้าสู่ระบบของคุณหมดลงแล้ว กรุณาเข้าสู่ระบบอีกครั้ง";
        clearInterval(intervalId); // หยุดการเรียกใช้ setInterval เมื่อเวลาหมดลงแล้ว
        return;
      }
    }

    // เรียกใช้ฟังก์ชันนับถอยหลังเมื่อหน้าเว็บโหลด
    window.onload = function() {
      countdown();
    };
  </script>
  
  <script>
  // เมื่อคลิกที่ "ลืมรหัสผ่าน"
  document.getElementById("forgotPassword").addEventListener("click", function() {
    // เปิด popup form
    var myModal = new bootstrap.Modal(document.getElementById('forgotPasswordModal'), {
      keyboard: false
    });
    myModal.show();
  });

  // ส่งข้อมูลผ่าน Ajax เมื่อกดปุ่มส่งใน popup form
  document.getElementById("forgotPasswordForm").addEventListener("submit", function(event) {
    event.preventDefault(); // ป้องกันการ submit form ธรรมดา
    var username = document.getElementById("Username").value;
    var email = document.getElementById("email").value;
    
    console.log(username)
    // ส่งข้อมูลผ่าน Ajax
    $.ajax({
      type: "POST",
      url: "./action/forgot_password.php",
      data: {
        Username: username,
        email: email
      },
      success: function(response) {
        // โค้ดการจัดการผลลัพธ์ที่ได้จากการส่งข้อมูล
        if (response == "success") {
          // ส่งข้อมูลสำเร็จ
          Swal.fire({
            icon: 'success',
            title: 'ส่งลิงก์เปลี่ยนรหัสผ่านแล้ว',
            text: 'กรุณาตรวจสอบอีเมล์ของคุณเพื่อเปลี่ยนรหัสผ่าน',
          });
        } else {
          // ส่งข้อมูลไม่สำเร็จ
          Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: response, // แสดงข้อความ error ที่ได้รับจากการส่งข้อมูล
          });
        }
      }
    });
  });
</script>

</body>

</html>