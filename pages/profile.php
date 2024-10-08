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
<html lang="en">

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

    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;700&display=swap">
    
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

<body class="g-sidenav-show bg-gray-100">
    <?php  // เรียกใช้ Sidebar ตาม UserType
    if ($user['UserType'] === "admin") {

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


  
    <div class="card shadow-lg mx-4 card-profile-bottom">
      <div class="card-body p-3">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
              <img src="<?php echo $user['image']; ?>" alt="profile_image" class="w-100 h-100 border-radius-lg shadow-sm" style="object-fit: cover;">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
              <?php echo $user['name_surname']; ?>
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
              <?php echo $user['position_c']; ?> <?php echo $user['position']; ?>
              </p>
            </div>
          </div>
          <!-- <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
            <div class="nav-wrapper position-relative end-0">
              <ul class="nav nav-pills nav-fill p-1" role="tablist">
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center " data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="true">
                    <i class="ni ni-app"></i>
                    <span class="ms-2">App</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                    <i class="ni ni-email-83"></i>
                    <span class="ms-2">Messages</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center " data-bs-toggle="tab" href="javascript:;" role="tab" aria-selected="false">
                    <i class="ni ni-settings-gear-65"></i>
                    <span class="ms-2">Settings</span>
                  </a>
                </li>
              </ul>
            </div>
          </div> -->
        </div>
      </div>
    </div>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0">Profile</p>
                
                <form class="ms-auto" action="./change_password.php" method="post">
                <input class="form-control" type="hidden" id="id" name="ID" value="<?php echo $user['ID']; ?>">
                <button type="submit" class="btn btn-primary btn-sm ms-auto" style="border: 0px;" onMouseOver="this.style.color='red'" onMouseOut="this.style.color='white'" id="button-service">เปลี่ยน password</button>
              </div>
            </div>
            <div class="card-body">
              <p class="text-uppercase text-sm">User Information</p>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Username</label>
                    <input class="form-control" type="text" value="<?php echo $user['Username']; ?>" disabled>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">อีเมล</label>
                    <input class="form-control" type="email" value="<?php echo $user['email']; ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">ชื่อ-นามสกุล</label>
                    <input class="form-control" type="text" value="<?php echo $user['name_surname']; ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">ตำแหน่ง</label>
                    <input class="form-control" type="text" value="<?php echo $user['position']; ?>">
                  </div>
                </div>
              </div>
              <hr class="horizontal dark">
              <p class="text-uppercase text-sm">Contact Information</p>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">งานที่สังกัด</label>
                    <?php
                    $department = $user['department'];
                      if($department == 0){
                        echo '<p><input class="form-control" type="text" value="Admin"></p>';
                      }else{
                   
                      try {
                      // คำสั่ง SQL สำหรับดึงข้อมูล department
                      $sql = "SELECT ID, department_name FROM sa_department WHERE ID = :department";

                      // ใช้ Prepared Statement
                      $stmt = $conn->prepare($sql);
                      $stmt->bindParam(':department', $department);
                      // ประมวลผลคำสั่ง SQL
                      $stmt->execute();

                      // ดึงผลลัพธ์
                      $departments = $stmt->fetch(PDO::FETCH_ASSOC);

                      // ตรวจสอบว่ามีข้อมูลหรือไม่
                      if ($departments) {
                             
                          
                              echo '<input class="form-control" type="text" value="'.$departments['department_name'].'">';
                          
                      } else {
                          echo '<p>No departments found</p>';
                      }
                  } catch (PDOException $e) {
                      echo "Connection failed: " . $e->getMessage();
                  }
                }
                  ?>
                    
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">หน่วย</label>
                    
                    <?php
                    
                    $unit = $user['unit'];
                     try {
                      // คำสั่ง SQL สำหรับดึงข้อมูล department
                      $sql = "SELECT ID, unit_name FROM sa_unit WHERE ID = :unit";

                      // ใช้ Prepared Statement
                      $stmt = $conn->prepare($sql);
                      $stmt->bindParam(':unit', $unit);
                      // ประมวลผลคำสั่ง SQL
                      $stmt->execute();

                      // ดึงผลลัพธ์
                      $units = $stmt->fetch(PDO::FETCH_ASSOC);

                      // ตรวจสอบว่ามีข้อมูลหรือไม่
                      if ($units) {
                          
                          
                              echo '<input class="form-control" type="text" value="'.$units['unit_name'].'">';
                          
                      } else {
                          echo '<p>No Unit found</p>';
                      }
                  } catch (PDOException $e) {
                      echo "Connection failed: " . $e->getMessage();
                  }
                  ?>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">อีเมลอื่น ๆ </label>
                    <input class="form-control" type="text" value="<?php echo $user['email_other']; ?>">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="example-text-input" class="form-control-label">โทรศัพท์</label>
                    <input class="form-control" type="text" value="<?php echo $user['phone']; ?>">
                  </div>
                </div>
              </div>
              <hr class="horizontal dark">
              
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