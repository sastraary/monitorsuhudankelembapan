<?php
include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Sensor Suhu dan Kelembaban</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Style the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;

            
            font-weight: bold;
        }

        /* Page styling */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        h2, h3 {
            color: #333;
            text-align: center;
        }

        /* Chart container styling */
        canvas {
            margin: 20px auto;
            display: block;
            max-width: 600px;
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <h2>Data Sensor Suhu dan Kelembaban</h2>

    <!-- Tabel Data -->
    <table>
        <tr>
            <th>No</th>
            <th>Waktu</th>
            <th>Suhu (°C)</th>
            <th>Kelembaban (%)</th>
        </tr>
        <?php
        $no = 1;
        $data = mysqli_query($conn, "SELECT * FROM sensor_data ORDER BY timestamp DESC");
        $waktu = [];
        $temperature = [];
        $humidity = [];

        while($row = mysqli_fetch_array($data)) {
            echo "<tr>";
            echo "<td>".$no++."</td>";
            echo "<td>".$row['timestamp']."</td>";
            echo "<td>".$row['temperature']."</td>";
            echo "<td>".$row['humidity']."</td>";
            echo "</tr>";

            // Simpan data untuk grafik
            $waktu[] = $row['timestamp'];
            $temperature[] = $row['temperature'];
            $humidity[] = $row['humidity'];
        }
        ?>
    </table>

    <!-- Grafik Suhu -->
    <h3>Grafik Suhu</h3>
    <canvas id="suhuChart"></canvas>

    <!-- Grafik Kelembaban -->
    <h3>Grafik Kelembaban</h3>
    <canvas id="kelembabanChart"></canvas>

    <script>
        // Data untuk Grafik Suhu
        const waktuData = <?php echo json_encode($waktu); ?>;
        const suhuData = <?php echo json_encode($temperature); ?>;
        const kelembabanData = <?php echo json_encode($humidity); ?>;

        // Grafik Suhu
        const ctxSuhu = document.getElementById('suhuChart').getContext('2d');
        new Chart(ctxSuhu, {
            type: 'line',
            data: {
                labels: waktuData,
                datasets: [{
                    label: 'Suhu',
                    data: suhuData,
                    borderColor: 'rgb(255, 99, 132)',
                    fill: false,
                    tension: 0.1
                }]
            }
        });

        // Grafik Kelembaban
        const ctxKelembaban = document.getElementById('kelembabanChart').getContext('2d');
        new Chart(ctxKelembaban, {
            type: 'line',
            data: {
                labels: waktuData,
                datasets: [{
                    label: 'Kelembaban',
                    data: kelembabanData,
                    borderColor: 'rgb(54, 162, 235)',
                    fill: false,
                    tension: 0.1
                }]
            }
        });
    </script>
</body>
</html>
