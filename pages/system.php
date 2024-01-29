<?php
session_start();
include '../action/connect.php';

if (!isset($_SESSION['user'])) {
    // ถ้าไม่มี session user แสดงว่ายังไม่ได้ Login
    header("Location: http://localhost:8080/index.php");
    
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
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@500&family=Kanit&family=Mitr:wght@300&display=swap" rel="stylesheet">
<style>
    body {
      font-family: 'Mitr', sans-serif;
    }
    .menu{
        display: flex;
        font-family: 'Mitr', sans-serif;
        
    }
    .menubox{
        box-sizing: border-box;
        text-align: center;
        color: white;
        padding: 20px;
        padding-top: 23px;
        margin: 10px;
        width: 150px;
        height: 150px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        font-weight: 700;
    }
</style>


</head>

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
              <h6>ตั้งค่าระบบ</h6>
            </div>
            
            <div class="card-body px-0 pt-0 pb-3 ">
                
              <div class="menu">
                <a href="./department.php"><div class="menubox" style="background-color: #81cbfc; border-radius:15px;"><img src="../assets/img/icons/hierarchical-structure.png"> <br>Edit Department</div></a>
                <a href="./unit.php"><div class="menubox" style="background-color: #8b81fc; border-radius:15px;">
                <img src="../assets/img/icons/department.png"> <br>Edit Unit</div></a>
                <a href="./user.php"><div class="menubox" style="background-color: #79d488; border-radius:15px;"><img src="../assets/img/icons/group.png"> <br>Edit User</div></a>
              </div>
              
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



</body>

</html>