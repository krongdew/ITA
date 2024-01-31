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
    $AssessmentID  = $_GET['ID'];


    // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
    try {
        // เตรียมคำสั่ง SQL
        $stmt = $conn->prepare("SELECT * FROM sa_services WHERE ID  = :AssessmentID ");
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
                                    <h6>เพิ่มจำนวนผู้เข้าใช้บริการ</h6>
                                    <br>
                                    <button class="badge badge-sm bg-gradient-success" style="border: 0px;" onMouseOver="this.style.color='red'" onMouseOut="this.style.color='white'" id="button-service" onclick="toggleAddForm()">เพิ่มจำนวนผู้เข้าใช้</button>

                                </div>

                                <div class="card-body px-0 pt-0 pb-2">
                                    <div id="add-form" style="display: none;">
                                        <form method="post" action="../action/add_report_base.php">
                                            <div class="container-fluid py-4">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="card">
                                                            <div class="card-header pb-0">
                                                                <div class="d-flex align-items-center">
                                                                    <p class="mb-0">เพิ่มจำนวนผู้เข้าใช้บริการของ <b><?php echo $Assessment['service_name']; ?></b></p>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <div class="form-group">
                                                                            <label for="example-text-input" class="form-control-label">วันที่บันทึก</label>
                                                                            <input class="form-control" type="hidden" id="id" name="service_id" value="<?php echo $Assessment['ID']; ?>">
                                                                            <input class="form-control" type="date" id="Date" name="Date" onchange="checkDuplicateDate()" required>
                                                                            <span id="dateAlert" style="color: red;"></span>
                                                                        </div>
                                                                    </div>

                                                                    <?php
                                                                    try {
                                                                        $service_id = $Assessment['ID'];

                                                                        // คำสั่ง SQL สำหรับดึงข้อมูล department
                                                                        $sql = "SELECT ID, subservice_name FROM sa_subservices WHERE service_id = :service_id";

                                                                        // ใช้ Prepared Statement
                                                                        $stmt = $conn->prepare($sql);
                                                                        $stmt->bindParam(':service_id', $service_id);
                                                                        // ประมวลผลคำสั่ง SQL
                                                                        $stmt->execute();

                                                                        // ดึงผลลัพธ์
                                                                        $subservice_names = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                                        // ตรวจสอบว่ามีข้อมูลหรือไม่
                                                                        if (count($subservice_names) > 0) {
                                                                            foreach ($subservice_names as $subservice) {
                                                                                echo '<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">บริการ</label><br>';
                                                                                echo '<span>' . $subservice['subservice_name'] . '</span>';
                                                                                echo '<input type="hidden" class="form-control" name="subservice_names[' . $subservice['ID'] . ']" value="' . $subservice['subservice_name'] . '" >';
                                                                                echo '</div>';
                                                                                echo '</div>';
                                                                                echo '<div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="example-text-input" class="form-control-label">จำนวนคนเข้าใช้บริการ</label>
                                                    <input class="form-control" type="text" id="number_people" name="number_people[' . $subservice['ID'] . ']" required>
                                                </div>
                                            </div>';
                                                                            }
                                                                        } else {
                                                                            echo '<p>No departments found</p>';
                                                                        }
                                                                    } catch (PDOException $e) {
                                                                        echo "Connection failed: " . $e->getMessage();
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <br>
                                                                <button type="submit" class="btn btn-primary btn-sm ms-auto">บันทึก</button>

                                        </form>


                                        <a href="../pages/services.php"><button type="button" class="btn btn-primary btn-sm ms-auto">ยกเลิกและกลับไปหน้าบริการ</button></a>
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
                <div style="padding: 20px;">
                    <table id="myTable" class="table align-items-center mb-0">
                        <thead>
                            <tr>

                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ลำดับ</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">วันที่บันทึก</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">บริการย่อย</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">จำนวนผู้ใช้</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">actions</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
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
                <script>
                    function checkDuplicateDate() {
                        // Get selected service_id and Date
                        var service_id = document.getElementById('id').value;
                        var date = document.getElementById('Date').value;

                        // AJAX request to check for duplicate date
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', '../action/check_duplicate_date.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState == 4 && xhr.status == 200) {
                                var response = xhr.responseText;

                                // Display alert message based on the response
                                var dateAlert = document.getElementById('dateAlert');
                                if (response === 'duplicate') {
                                    dateAlert.innerHTML = 'วันที่นี้มีการบันทึกไว้แล้ว';
                                    // You may also disable the submit button or take other actions
                                } else {
                                    dateAlert.innerHTML = '';
                                }
                            }
                        };

                        // Send data to the server
                        xhr.send('service_id=' + service_id + '&date=' + date);
                    }
                </script>
                <!-- ส่วนที่เพิ่มเข้าไป -->
                <!-- <script>
    function updatedata() {
      $('#myTable').DataTable().ajax.reload();
    }


    $(document).ready(function() {
      // ให้ฟังก์ชันทำงานเมื่อมีการกด submit ฟอร์ม
      $('form').submit(function(e) {
        e.preventDefault(); // ป้องกันให้ฟอร์ม submit ตามปกติ

        // ทำการส่งข้อมูลไปยังไฟล์ PHP ตาม URL ที่ระบุใน action
        $.ajax({
          type: 'POST',
          url: '../action/add_services.php',
          data: $(this).serialize(), // เพิ่ม CSRF Token ในข้อมูลที่ส่ง
          success: function(response) {
            // เมื่อเพิ่มข้อมูลเสร็จสิ้น, แสดง popup box
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
          },
          error: function(error) {
            // กรณีเกิดข้อผิดพลาด
            Swal.fire({
              icon: 'error',
              title: 'เกิดข้อผิดพลาด',
              text: 'ไม่สามารถบันทึกข้อมูลได้'
            });
          }
        });
      });
    });
  </script> -->

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
                        var globalsubserviceData; // ประกาศตัวแปรที่ถูกส่งเข้าไปนอกฟังก์ชัน success

                        // เพิ่ม service_id จาก URL ใน DataTables ajax
                        var urlParams = new URLSearchParams(window.location.search);
                        var service_id = urlParams.get('ID') || '';
                        // ดึงข้อมูลจาก sa_department
                        $.ajax({
                            url: "../action/get_subservice_data.php", // แก้ไข URL ให้ตรงกับที่เก็บโค้ด PHP ที่ดึงข้อมูล sa_department
                            type: "GET",
                            dataType: "json",
                            success: function(response) {
                                globalsubserviceData = response; // ใช้ตัวแปรที่ถูกส่งเข้าไปนอกฟังก์ชัน success
                                var table = $('#myTable').DataTable({
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

                                        // เพิ่มคอลัมน์ตามต้องการ
                                    ],
                                    buttons: [
                                        'copyHtml5',
                                        'excelHtml5',
                                        {
                                            extend: 'pdfHtml5',
                                            exportOptions: {
                                                columns: [0, 1, 2, 3, 4] // ระบุคอลัมน์ที่จะ export (index 0, 1, 2)
                                            },
                                            customize: function(doc) {
                                                doc.defaultStyle.font = 'thaiFont'; // หรือใช้ชื่อ font ที่คุณต้องการ
                                                doc.defaultStyle.fontSize = 16; // ตั้งค่าขนาดตัวอักษรที่นี่ (เป็นตัวเลข)

                                                // ... รายละเอียดอื่น ๆ

                                            }
                                        }
                                    ],
                                    "autoWidth": false,
                                    "lengthMenu": [10, 25, 50, 75, 100],
                                    "pageLength": 10,
                                    "serverSide": true,
                                    "ajax": {
                                        "url": "../action/get_people_server.php",
                                        "type": "POST",
                                        "dataType": "json",
                                        "data": {
                                            service_id: service_id // ส่งค่า service_id ไปที่ get_people_server.php
                                        }
                                    },
                                    "columns": [{
                                            "data": null,
                                            "render": function(data, type, row, meta) {
                                                return meta.settings._iDisplayStart + meta.row + 1;
                                            }
                                        },
                                        {
                                            "data": "Date",

                                        },
                                        {
                                            "data": "subservice_id",
                                            render: function(data) {
                                                // ให้หาข้อมูล department_name จาก globalDepartmentData แล้วแสดง
                                                var subserviceData = globalsubserviceData.find(function(dep) {
                                                    return dep.ID === data;
                                                });
                                                return subserviceData ? subserviceData.subservice_name : '';
                                            },
                                        },
                                        {
                                            "data": "number_people",
                                            "className": "editable"
                                        },

                                        {
                                            "data": null,
                                            "render": function(data, type, row) {

                                                return '<button class="editBtn">Edit</button> <button class="saveBtn" style="display:none;">Save</button> <button class="delBtn">Delete</button>';
                                            },
                                            "orderable": false
                                        },


                                    ],
                                    order: [
                                        [0, 'asc'],
                                    ],
                                });
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.error('Error fetching department data:', errorThrown);
                            }
                        });

                        // Edit button click event
                        $('#myTable').on('click', '.editBtn', function() {
                            var row = $(this).closest('tr');
                            row.find('td.editable').prop('contenteditable', true);
                            row.find('.editBtn').hide();
                            row.find('.saveBtn').show();

                            // Set focus to the first editable field (department_name)
                            row.find('.editable:eq(0)').focus();

                            // Add border styling to the editable fields
                            row.find('.editable').css({
                                'border': '2px solid #337ab7', // Change the color as needed
                                'border-radius': '5px', // Optional: Add border-radius for rounded corners
                            });
                        });

                        // Save button click event
                        $('#myTable').on('click', '.saveBtn', function() {
                            var row = $(this).closest('tr');
                            var data = $('#myTable').DataTable().row($(this).parents('tr')).data();
                            row.find('td.editable').prop('contenteditable', false);
                            row.find('.editBtn').show();
                            row.find('.saveBtn').hide();

                            // Save data to your server using Ajax if needed
                            // Get the edited data
                            var editedData = {
                                number_people: row.find('.editable:eq(0)').text(),

                                // Add other fields as needed
                            };

                            // Get the department ID
                            var number_peopleID = data.ID


                            // Save data to your server using Ajax
                            $.ajax({
                                url: '../action/update_numberpeople.php',
                                type: 'POST',
                                data: {
                                    number_peopleID: number_peopleID,
                                    editedData: editedData
                                },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status === 'success') {
                                        // Reload DataTable to display updated data

                                        $('#myTable').DataTable().ajax.reload();

                                    } else {
                                        Swal.fire(
                                            'เกิดข้อผิดพลาด!',
                                            'เกิดข้อผิดพลาดในการแก้ไขข้อมูล.',
                                            'error'
                                        );
                                    }
                                }
                            });

                        });

                        // Event listener สำหรับปุ่ม Delete
                        $('#myTable').on('click', '.delBtn', function() {
                            var data = $('#myTable').DataTable().row($(this).parents('tr')).data();
                            var number_peopleID = data.ID;

                            // แสดง SweetAlert 2 สำหรับยืนยันการลบ
                            Swal.fire({
                                title: 'คุณต้องการลบข้อมูลหรือไม่?',
                                text: "หากคุณลบที่นี่ จะลบทั้งบริการหลักและบริการย่อยทั้งหมด",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'ใช่, ลบ!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // ทำการลบในฐานข้อมูลด้วย Ajax
                                    $.ajax({
                                        url: '../action/delete_people.php',
                                        type: 'POST',
                                        data: {
                                            number_peopleID: number_peopleID
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