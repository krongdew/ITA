<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>Bar Chart Example</title>
</head>
<body>
  <canvas id="myChart" width="400" height="400"></canvas>

  <script>
    // ประกาศตัวแปร labels และ datasets และเตรียมข้อมูล
    var labels = ['Service 1', 'Service 2', 'Service 3'];
    var datasets = [
      {
        label: 'มกราคม',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
        data: [10, 20, 30]
      }
      // เพิ่ม datasets เดือนอื่น ๆ ตามต้องการ
    ];

    // สร้างกราฟแท่ง
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: datasets
      },
      options: {
        scales: {
          x: { stacked: true },
          y: { beginAtZero: true }
        }
      }
    });
  </script>
</body>
</html>
