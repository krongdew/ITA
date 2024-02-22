<?php
session_start();
include '../action/connect.php';

if (!isset($_SESSION['user'])) {
  // ถ้าไม่มี session user แสดงว่ายังไม่ได้ Login
  header("Location: http://localhost:8080/index.php");
}

include '../components/timeout.php';
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
  body {
    font-family: 'Mitr', sans-serif;
  }

  p {
    font-family: 'Mitr', sans-serif;
  }
</style>

<body class="g-sidenav-show   bg-gray-100">
  <?php
  // เรียกใช้ Sidebar ตาม UserType
  if ($user['UserType'] === "admin") {

    include '../components/sidebar_admin.php';
  } else {
    include '../components/sidebar.php';
  }
  ?>
  <?php include '../components/navbar.php' ?>



  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">ผู้ใช้งานบริการในเดือนนี้</p>
                  <h5 id="respondent-count" class="font-weight-bolder"><!-- จำนวนผู้ทำแบบประเมินจะแสดงที่นี่ --></h5>

                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">จำนวนผู้ใช้บริการในปีนี้</p>
                  <h5 id="respondent-year" class="font-weight-bolder">

                  </h5>
                  <!-- <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder">+3%</span>
                      since last week
                    </p> -->
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                  <i class="fa-solid fa-face-smile text-lg opacity-10" aria-hidden="true"></i>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">บริการในหน่วยทั้งหมด</p>
                  <h5 class="font-weight-bolder">
                    <? // คำสั่ง SQL สำหรับนับจำนวนแถวในตาราง sa_services
                    $userdepartment = $user['department'];
                    $userDepartmentCondition = ($userdepartment == 0) ? '' : " WHERE service_Access = $userdepartment";

                    $sql = "SELECT COUNT(*) AS total_rows FROM sa_services $userDepartmentCondition";
                    // ดึงข้อมูลจากฐานข้อมูลโดยใช้ PDO
                    $stmt = $conn->query($sql);
                    // ดึงจำนวนแถวทั้งหมด
                    $totalRows = $stmt->fetch(PDO::FETCH_ASSOC)['total_rows'];
                    ?>
                    <? echo $totalRows; ?> บริการ
                  </h5>
                  <!-- <p class="mb-0">
                      <span class="text-danger text-sm font-weight-bolder">-2%</span>
                      since last quarter
                    </p> -->
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                  <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">จำนวน Users </p>
                    <h5 class="font-weight-bolder">
                      103,430
                    </h5>
                   <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder">+5%</span> than last month
                    </p> 
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> -->
    </div>
    <div class="row mt-4">
      <div class="col-lg-7 mb-lg-0 mb-4">
        <div class="card ">
          <div class="card-header pb-0 p-3">
            <div class="d-flex justify-content-between">
              <h6 class="mb-2">5 อันดับบริการที่มีผู้ใช้งานสูงสุดประจำเดือน</h6>
            </div>
          </div>
          <div class="table-responsive">
            <table id="Top5" class="table align-items-center ">
              <tbody>
                <tr>
                  <td class="w-30">
                    <div class="d-flex px-2 py-1 align-items-center">
                      <div>
                        <img src="../assets/img/icons/flags/US.png" alt="Country flag">
                      </div>
                      <div class="ms-4">
                        <p class="text-xs font-weight-bold mb-0">ชื่อบริการ:</p>
                        <h6 class="text-sm mb-0">ชื่อบริการ</h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="text-center">
                      <p class="text-xs font-weight-bold mb-0">จำนวนผู้ใช้:</p>
                      <h6 class="text-sm mb-0">2500</h6>
                    </div>
                  </td>

                </tr>



              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="card card-carousel overflow-hidden h-100 p-0">
          <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
            <div class="carousel-inner border-radius-lg h-100">
              <div class="carousel-item h-100 active" style="background-image: url('../assets/img/carousel-1.jpg');
      background-size: cover;">
                <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                  <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                    <i class="ni ni-camera-compact text-dark opacity-10"></i>
                  </div>
                  <h5 class="text-white mb-1">ข่าวสารประชาสัมพันธ์</h5>
                  <p>There’s nothing I really wanted to do in life that I wasn’t able to get good at.</p>
                </div>
              </div>
              <div class="carousel-item h-100" style="background-image: url('../assets/img/carousel-2.jpg');
      background-size: cover;">
                <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                  <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                    <i class="ni ni-bulb-61 text-dark opacity-10"></i>
                  </div>
                  <h5 class="text-white mb-1">ข่าวสารประชาสัมพันธ์</h5>
                  <p>That’s my skill. I’m not really specifically talented at anything except for the ability to learn.</p>
                </div>
              </div>
              <div class="carousel-item h-100" style="background-image: url('../assets/img/carousel-3.jpg');
      background-size: cover;">
                <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                  <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                    <i class="ni ni-trophy text-dark opacity-10"></i>
                  </div>
                  <h5 class="text-white mb-1">ข่าวสารประชาสัมพันธ์</h5>
                  <p>Don’t be afraid to be wrong because you can’t learn anything from a compliment.</p>
                </div>
              </div>
            </div>
            <button class="carousel-control-prev w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
          <div class="card-header pb-0 pt-3 bg-transparent">
            <h6 class="text-capitalize">ภาพรวมผู้ใช้งานของบริการ...</h6>
            <p class="text-sm mb-0">
              <i class="fa fa-arrow-up text-success"></i>
              <span class="font-weight-bold">เลือกปีที่ต้องการดู</span> <select id="yearFilter">
                <!-- ตัวเลือกจะถูกเติมโดย JavaScript -->
              </select>
            </p>
          </div>
          <div class="card-body p-3">
            <div class="chart">
              <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
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
    var myChart;
    var userdepartment = <?php echo $user['department']; ?>;
    var years = []; // เก็บปีที่มีอยู่ในข้อมูล
    var additionalNumber = 543;

    $(document).ready(function() {

      $("#yearFilter").on("change", function() {
        // ทำลาย chart ที่มีอยู่เดิม
        myChart.destroy();
        // เรียกใช้งานฟังก์ชัน chartcalling() เพื่อสร้าง chart ใหม่
        chartcalling();
      });

      // เพิ่ม dropdown เลือกปี
      $.ajax({
        url: "../action/get_years.php",
        type: "GET",
        dataType: "json",
        success: function(response) {
          years = response;

          // เติมตัวเลือกปีใน dropdown
          var yearDropdown = $("#yearFilter");
          years.forEach(function(year) {
            var yearAsNumber = parseInt(year);
            yearDropdown.append("<option value='" + year + "'>" + (yearAsNumber + additionalNumber) + "</option>");

          });
          // กำหนดการเรียกใช้ DataTables
          chartcalling();
        }
      });

      function chartcalling() {
        // ดึงข้อมูลผู้ใช้จาก PHP โดยใช้ AJAX
       
        // เช็คว่า myChart มีค่าอยู่หรือไม่ และไม่ใช่ null หรือ undefined
        if (myChart) {
          // ถ้ามี chart ให้ทำการทำลายเพื่อล้าง chart ทิ้ง
          myChart.destroy();
        }

        var selectedYear = $("#yearFilter").val();
     

        $.ajax({
          url: '../action/get_users_chart.php',
          type: 'GET',
          dataType: 'json',
          data: {
            userdepartment: userdepartment,
            selectedYear: selectedYear,
          },
          success: function(data) {
           
            var serviceLabels = [];
            var monthLabels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            var datasets = [];

            // สร้างข้อมูลของแต่ละบริการ
            for (var i = 0; i < data.length; i++) {
              var serviceData = [];
              for (var j = 0; j < monthLabels.length; j++) {
                serviceData.push(data[i][monthLabels[j]]);
              }
              serviceLabels.push(data[i]['service_Access']);
              // กำหนดสีให้แต่ละแท่งด้วยอาร์เรย์ของสี
              var barColors = ['#80BCBD', '#AAD9BB', '#D5F0C1', '#F9F7C9']; // ตัวอย่างสีที่แตกต่างกัน
              datasets.push({
                label: data[i]['service_name'],
                backgroundColor: barColors[i % barColors.length], // เลือกสีตามดัชนีแต่ละแท่ง
                borderColor: 'rgb(67, 104, 80, 1)',
                borderWidth: 1,
                data: serviceData
              });
            }

           
            // สร้างกราฟ Chart.js
            var ctx1 = document.getElementById("chart-line").getContext("2d");
            myChart = new Chart(ctx1, { // ลบ var หน้า myChart เพื่อทำให้ myChart เป็น global variable
              type: "bar",
              data: {
                labels: monthLabels,
                datasets: datasets
              },
              options: {
                // ตั้งค่าต่าง ๆ ตามต้องการ

                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                  legend: {
                    display: false,
                  }
                },
                interaction: {
                  intersect: false,
                  mode: 'index',
                },
                scales: {
                  y: {
                    grid: {
                      drawBorder: false,
                      display: true,
                      drawOnChartArea: true,
                      drawTicks: false,
                      borderDash: [5, 5]
                    },
                    ticks: {
                      display: true,
                      padding: 10,
                      color: '#fbfbfb',
                      font: {
                        size: 11,
                        family: "Open Sans",
                        style: 'normal',
                        lineHeight: 2
                      },
                    }
                  },
                  x: {
                    grid: {
                      drawBorder: false,
                      display: true,
                      drawOnChartArea: true,
                      drawTicks: false,
                      borderDash: [5, 5]
                    },
                    ticks: {
                      display: true,
                      color: '#ccc',
                      padding: 20,
                      font: {
                        size: 11,
                        family: "Open Sans",
                        style: 'normal',
                        lineHeight: 2
                      },
                    }
                  },
                },
              },
            });
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });

        // เมื่อมีการเปลี่ยนแปลงใน dropdown เลือกปี

      }

    });
  </script>

  <script>
    $(document).ready(function() {
      function getRespondentCount() {
        $.ajax({
          url: '../action/get_respondent.php',
          type: 'GET',
          dataType: 'json',
          data: {
            userdepartment: userdepartment,
          },
          success: function(data) {
            // อัพเดตจำนวนผู้ทำแบบประเมินในหน้า HTML
            $('#respondent-count').text(data.total_respondents);
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      }

      // เรียกฟังก์ชั่นเพื่อดึงข้อมูลในครั้งแรกเมื่อหน้าเว็บโหลดเสร็จ
      getRespondentCount();

      // ทำให้ฟังก์ชั่นเรียก AJAX แบบเป็นระยะ
      setInterval(getRespondentCount, 5000); // เรียกทุก 5 วินาที
    });
  </script>

  <script>
    $(document).ready(function() {
      function getRespondentYear() {
        $.ajax({
          url: '../action/get_respondent_year.php',
          type: 'GET',
          dataType: 'json',
          data: {
            userdepartment: userdepartment,
          },
          success: function(data) {
            $('#respondent-year').text(data.total_respondents);
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      }
      getRespondentYear();
      // ทำให้ฟังก์ชั่นเรียก AJAX แบบเป็นระยะ
      setInterval(getRespondentYear, 5000); // เรียกทุก 5 วินาที
    })
  </script>

  <script>
    $(document).ready(function() {
      // กำหนดค่าของตัวแปร userdepartment โดยใช้ PHP


      // เรียกใช้งานฟังก์ชัน getData() เมื่อเว็บโหลดขึ้นมาและทุก 5 วินาที
      getData();
      setInterval(getData, 5000);


      function getData() {
        $.ajax({
          url: '../action/get_top5_data.php',
          type: 'GET',
          dataType: 'json',
          data: {
            userdepartment: userdepartment,
          },
          success: function(data) {
            // เรียกฟังก์ชัน updateTable() เพื่อนำข้อมูลไปแสดงในตาราง
            updateTable(data);
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
          }
        });
      }

      function updateTable(data) {
        // เลือกตาราง Top5 ด้วย ID และล้างข้อมูลทั้งหมดทิ้ง
        $('#Top5 tbody').empty();

        // วนลูปข้อมูลและสร้างแถวใหม่ในตารางสำหรับแต่ละบริการ
        $.each(data, function(index, item) {
          var newRow = '<tr>' +
            '<td class="w-30">' +
            '<div class="d-flex px-2 py-1 align-items-center">' +
            '<div>' +
            '<p class="text-xs font-weight-bold mb-0">' + (index + 1) + '</p>' +
            '</div>' +
            '<div class="ms-4">' +
            '<p class="text-xs font-weight-bold mb-0">ชื่อบริการ:</p>' +
            '<h6 class="text-sm mb-0">' + item.service_name + '</h6>' +
            '</div>' +
            '</div>' +
            '</td>' +
            '<td>' +
            '<div class="text-center">' +
            '<p class="text-xs font-weight-bold mb-0">จำนวนผู้ใช้:</p>' +
            '<h6 class="text-sm mb-0">' + item.total_users + '</h6>' +
            '</div>' +
            '</td>' +
            '</tr>';

          // เพิ่มแถวใหม่ลงในตาราง
          $('#Top5 tbody').append(newRow);
        });
      }
    });
  </script>
  </script>


</body>

</html>