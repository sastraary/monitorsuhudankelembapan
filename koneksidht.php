<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iot_database";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Mendapatkan data dari URL (GET)
$temperature = $_GET["temperature"];
$humidity = $_GET["humidity"];

// Menyimpan data ke tabel
$sql = "INSERT INTO sensor_data (temperature, humidity) VALUES ('$temperature', '$humidity')";
if (mysqli_query($conn, $sql)) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Menutup koneksi
mysqli_close($conn);
?>