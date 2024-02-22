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
                                    <h6>เพิ่มจำนวนผู้เข้าใช้บริการ <b><?php echo $Assessment['service_name']; ?></b></h6>
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
                    <div class="col-md-6">
                        <label>เลือกดูจากเดือน</label>
                        <input class="form-control" type="month" id="monthInput" name="monthInput">
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>ค้นหาจากชื่อ</label>
                            <input class="form-control" type="text" id="searchByName" name="searchByName" placeholder="ค้นหาจากชื่อ">
                        </div>
                        <div class="col-md-4">
                            <label>ค้นหาจากวันที่</label>
                            <input class="form-control" type="date" id="searchByDate" name="searchDate">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <span>หรือค้นหาจากช่วงวันที่ต้องการ</span>
                        <div class="col-md-4">
                            <Label>ค้นหาจากวันที่เริ่มต้น</Label>
                            <input class="form-control" type="date" id="start-date" name="startDate">
                        </div>
                        <div class="col-md-4">
                            <label>วันที่สิ้นสุด</label>
                            <input class="form-control" type="date" id="end-date" name="endDate">
                        </div>

                        <br>
                    </div>

                    <br>
                    <table id="myTable" class="table align-items-center mb-0">
                        <thead>
                            <tr>

                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ลำดับ</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">รหัส</th>
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


                <script>
                    // สร้างวัตถุ Date เพื่อเก็บข้อมูลเดือนปัจจุบัน
                    const currentDate = new Date();
                    // กำหนดค่าเริ่มต้นของ input แบบ "month" ให้เป็นเดือนปัจจุบัน
                    const monthInput = document.getElementById('monthInput');
                    const currentYear = currentDate.getFullYear();
                    const currentMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // เพิ่ม 0 หน้าตัวเลขถ้าน้อยกว่า 10
                    const defaultValue = `${currentYear}-${currentMonth}`;
                    monthInput.value = defaultValue;

                    $(document).ready(function() {
                        // DataTable initialization
                        var dataTable = $('#myTable').DataTable({
                            dom: 'Bfrtip',
                            buttons: [
                                'copy', 'excel', 'print'
                            ],
                            "paging": true,
                            "lengthChange": false,
                            "searching": false,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            "responsive": true,
                            "pageLength": 20, // Set the number of rows per page
                            "language": {
                                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                                "infoEmpty": "Showing 0 to 0 of 0 entries"
                            }
                        });



                        // Function to load data from the server using Ajax
                        function loadData() {
                            var searchName = $('#searchByName').val();
                            var searchDate = $('#searchByDate').val();
                            var startDate = $('#start-date').val();
                            var endDate = $('#end-date').val();
                            var monthInput = $('#monthInput').val();

                            // เพิ่ม service_id จาก URL ใน DataTables ajax
                            var urlParams = new URLSearchParams(window.location.search);
                            var service_id = urlParams.get('ID') || '';

                            $.ajax({
                                url: '../action/get_data.php',
                                method: 'POST',
                                data: {
                                    service_id: service_id,
                                    searchByName: searchName, // เปลี่ยนจาก searchName เป็น searchByName
                                    searchDate: searchDate,
                                    startDate: startDate, // เปลี่ยนจาก 'start-date' เป็น startDate
                                    endDate: endDate, // เปลี่ยนจาก 'end-date' เป็น endDate
                                    monthInput: monthInput
                                },
                                success: function(response) {
                                    // Clear the existing table data
                                    dataTable.clear().draw();

                                    // Parse the JSON response
                                    var data = JSON.parse(response);



                                    // Populate the table with data
                                    $.each(data, function(index, row) {




                                        var rowData = [
                                            index + 1,
                                            row.ID,
                                            row.Date,
                                            row.subservice_name,
                                            row.number_people,

                                            '<center><button class="editBtn">Edit</button> <button class="saveBtn" style="display:none;">Save</button> <button class="delBtn">Delete</button></center>',

                                        ];

                                        dataTable.row.add(rowData).draw();

                                        // เพิ่มตรวจสอบสถานะและเปลี่ยนสีปุ่ม

                                    });
                                }
                            });
                        }

                        // Load data when the page is ready
                        loadData();

                        // Search input keyup event
                        $('#searchByName').on('keyup', function(e) {
                            if (e.key === 'Enter' || e.keyCode === 13) {
                                loadData();
                            }
                        });

                        // Search input blur event
                        $('#searchByName').on('blur', function() {
                            loadData();
                        });

                        // Search date change event
                        $('#searchByName').on('change', function() {
                            loadData();
                        });

                        // Search date change event
                        $('#searchByDate').on('change', function() {
                            loadData();
                        });

                        // Search date change event
                        $('#end-date').on('change', function() {
                            loadData();
                        });

                        // Search date change event
                        $('#monthInput').on('change', function() {
                            loadData();
                        });

                        // Search button click event
                        $('#searchButton').on('click', function(e) {
                            e.preventDefault();
                            loadData();
                        });



                    


                    // JavaScript เพิ่มเติม


                    // ให้สร้างฟังก์ชันสำหรับรีเซ็ตค่า monthInput เป็นค่าว่าง
                    function resetMonthInput() {
                        document.getElementById('monthInput').value = '';
                    }

                    // ให้กำหนดความเรียบร้อยของปุ่มที่ต้องการให้รีเซ็ตค่า
                    document.getElementById('start-date').addEventListener('click', resetMonthInput);
                    document.getElementById('searchByDate').addEventListener('click', resetMonthInput);


                    // Edit button click event
                    $('#myTable').on('click', '.editBtn', function() {
                        var row = $(this).closest('tr');
                        var number_people = row.find('td:nth-child(5)').text();

                        var editField = '<input type="text" class="editField" value="' + number_people + '">';
                        row.find('td:nth-child(5)').html(editField); // Replace the table cell content with an input field
                        row.find('.editBtn').hide(); // Hide the edit button
                        row.find('.saveBtn').show(); // Show the save button


                    });

                    // Save button click event
                    $('#myTable').on('click', '.saveBtn', function() {
                        var row = $(this).closest('tr');
                        var editedValue = row.find('.editField').val(); // Get the edited value from the input field

                        row.find('td:nth-child(5)').text(editedValue); // Update the table cell content with the edited value
                        row.find('.editBtn').show(); // Show the edit button
                        row.find('.saveBtn').hide(); // Hide the save button

                        // Save data to your server using Ajax if needed


                        // Get the department ID
                        editedData = parseInt(editedValue);
                      
                        var number_peopleID = row.find('td:nth-child(2)').text();
                       
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

                                    loadData();

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
                        var row = $(this).closest('tr');
                        var number_peopleID = row.find('td:nth-child(2)').text();

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
                                                    loadData();
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
                    // });
                    
                });
                </script>


            </body>

</html>