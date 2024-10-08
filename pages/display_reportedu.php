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
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/Mahidol_U.png">
  <link rel="icon" type="image/png" href="../assets/img/Mahidol_U.png">

  <title>
    รายงานสถิติจำนวนผู้เข้าใช้บริการตามปีการศึกษา
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
  <? include '../action/connect.php';
  ?>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // ตรวจสอบ URL เพื่อเปิดเมนูที่ถูกเลือก
      const urlParams = new URLSearchParams(window.location.search);
      const activeMenu = urlParams.get('active_menu');

      // หากมีค่า active_menu ใน URL ให้เปิดเมนูที่เลือก
      if (activeMenu === 'display_report') {
        const subMenu = document.getElementById('subMenu');
        subMenu.style.display = 'block'; // แสดงเมนู
      }
    });
  </script>

  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">

        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>รายงานสถิติจำนวนผู้เข้าใช้บริการ ตามปีการศึกษา</h6>
          </div>
         

          <div style="padding: 20px;">
            <label for="yearFilter">เลือกปีที่ต้องการดูข้อมูล:</label>
            <select id="yearFilter">
              <!-- ตัวเลือกจะถูกเติมโดย JavaScript -->
            </select>
            <!-- <label for="startMonthFilter">หรือเลือกเดือนเริ่มต้น:</label>
            <input type="month" id="startMonthFilter">

            <label for="endMonthFilter">เลือกเดือนสิ้นสุด:</label>
            <input type="month" id="endMonthFilter"> -->

            <br><br>
            <table id="myTable" class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th>งาน</th>
                  <th>ชื่อบริการ</th>
                  <th>ส.ค.</th>
                  <th>ก.ย.</th>
                  <th>ต.ค.</th>
                  <th>พ.ย.</th>
                  <th>ธ.ค.</th>
                  <th>ม.ค.</th>
                  <th>ก.พ.</th>
                  <th>มี.ค.</th>
                  <th>เม.ย.</th>
                  <th>พ.ค.</th>
                  <th>มิ.ย.</th>
                  <th>ก.ค.</th>
                  <th>ยอดรวม</th>
                  <th>หน่วยนับ</th>
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
      pdfMake.fonts = {
        thaiFont: {
          normal: 'THSarabun.ttf',
          bold: 'THSarabun-Bold.ttf',
          italics: 'THSarabun-Italic.ttf',
          bolditalics: 'THSarabun-BoldItalic.ttf'
        }
      };

      // สร้างฟังก์ชันเพื่อดึงข้อมูลแผนก
      function getDeaprtmentData(callback) {
        $.ajax({
          url: "../action/get_service_access.php",
          type: "GET",
          dataType: "json",
          success: function(response) {
            callback(response);
          },
          error: function(xhr, status, error) {
            console.error("Error fetching department data:", error);
          }
        });
      }

      $(document).ready(function() {
        var table;
        var globalDepartmentData;
        var years = []; // เก็บปีที่มีอยู่ในข้อมูล
        var additionalNumber = 543;


        // เพิ่ม dropdown เลือกปี
        $.ajax({
          url: "../action/get_year_report.php",
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
            initializeDataTable();
          },
          error: function(xhr, status, error) {
            console.error("Error fetching years:", error);
          }
        });

        function initializeDataTable() {
          var selectedYear = $("#yearFilter").val();
          var departmentData;

          getDeaprtmentData(function(response) {
            departmentData = response;
          });

          var userdepartment = <?php echo $user['department']; ?>

          table = $('#myTable').DataTable({
            responsive: true,
            dom: 'Brt',
            columns: [{
                data: "service_Access",
                visible: false,
                render: function(data) {
                  // หาข้อมูล department_name จาก departmentData แล้วแสดง
                  var departmentInfo = departmentData.find(function(dep) {
                    // return dep.ID === data;
                    return dep.ID.toString() === data;
                  });
                  return departmentInfo ? departmentInfo.department_name : '';

                },
              },
              {
                data: "service_id"
              },
              {
                data: 'Aug'
              },
              {
                data: 'Sep'
              },
              {
                data: 'Oct'
              },
              {
                data: 'Nov'
              },
              {
                data: 'Dec'
              },
              {
                data: 'Jan'
              },
              {
                data: 'Feb'
              },
              {
                data: 'Mar'
              },
              {
                data: 'Apr'
              },
              {
                data: 'May'
              },
              {
                data: 'Jun'
              },
              {
                data: 'Jul'
              },
              {
                data: null,
                render: function(data, type, row) {
                  var total = 0;
                  for (var key in data) {
                    if (data.hasOwnProperty(key) && key !== 'service_id' && key !== 'service_Access' && key !== 'service_ea') {
                      total += parseFloat(data[key]); // รวมค่าที่เก็บใน total
                    }
                  }
                  return total;
                }
              },
              {
                data: 'service_ea'
              },

             
            ],
            buttons: [
              'copyHtml5',
              {
                extend: 'excel',
                text: 'Excel',
                title: function() {
                  var selectedYear = parseInt(document.getElementById("yearFilter").value);
                  var additionalNumber = 543;
                  var yearAsNumber = selectedYear + additionalNumber;
                  return "รายงานสถิติจำนวนผู้เข้าใช้บริการ ประจำปีงบประมาณ " + yearAsNumber;
                },
                customize: function(xlsx) {
                  var sheet = xlsx.xl.worksheets['sheet1.xml'];
                  $('row c[r^="C"]', sheet).each(function() {
                    var originalValue = $('t', this).text();
                    var departmentName = originalValue.replace(/<\/?t>/g, '');
                    if (departmentName !== originalValue) {
                      $(this).html('<t>' + departmentName + '</t>');
                    }
                  });
                }
              },
              {
                extend: 'pdfHtml5',
                exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
                },
                customize: function(doc) {
                  doc.defaultStyle.font = 'thaiFont';
                  doc.defaultStyle.fontSize = 16;
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
              url: "../action/get_report_server_edu.php",
              type: "POST",
              dataType: "json",
              data: {
                selectedYear: selectedYear,
                userdepartment: userdepartment,

              }, // ส่งค่าปีที่เลือกไปด้วย
            },
            // ใช้ getDeaprtmentData เพื่อรับข้อมูลแผนกแล้วทำต่อไป
            drawCallback: function(settings) {
              var api = this.api();
              var rows = api.rows({
                page: 'current'
              }).nodes();
              var lastServiceAccess = null;

              // เรียกใช้ getDeaprtmentData เพื่อรับข้อมูลแผนก
              getDeaprtmentData(function(departmentData) {
                api.column(0, {
                  page: 'current'
                }).data().each(function(serviceAccess, i) {
                  if (lastServiceAccess !== serviceAccess) {
                    // หาข้อมูลแผนกจาก departmentData แล้วแสดง
                    var departmentInfo = departmentData.find(function(dep) {
                      return dep.ID.toString() === serviceAccess;
                    });

                    var departmentName = departmentInfo ? departmentInfo.department_name : '';

                    $(rows).eq(i).before(
                      '<tr class="group" style="background-color:#dbdbd9; color:black;"><td colspan="15"><b>' + departmentName + '</b></td></tr>'
                    );
                    lastServiceAccess = serviceAccess;
                  }
                });
              });
            },

          });
        }

        // เมื่อมีการเปลี่ยนแปลงใน dropdown เลือกปี
        $("#yearFilter").on("change", function() {
          // เรียกใช้ DataTables ใหม่เมื่อมีการเปลี่ยนแปลง
          table.destroy(); // ทำลาย DataTables เดิม
          initializeDataTable(); // เรียกใช้ DataTables ใหม่
        });
      });
    </script>


</body>

</html>