<?php
session_start(); include 'db.php';
if(!isset($_SESSION['user'])) header("Location: index.php");

$patients = $conn->query("SELECT COUNT(*) as c FROM Patients")->fetch_assoc()['c'];
$doctors = $conn->query("SELECT COUNT(*) as c FROM Doctors")->fetch_assoc()['c'];
$beds = $conn->query("SELECT COUNT(*) as c FROM Beds WHERE status='Available'")->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard</title><link rel="stylesheet" href="style.css"></head>
<div class="sidebar">
    <h2 style="line-height: 1.2; text-align: center; margin-bottom: 30px;">
        SHM System <br>
        <span style="font-size: 11px; font-weight: normal; color: #bdc3c7; display: block; margin-top: 5px;">
            (Smart Hospital Management System)
        </span>
    </h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="doctors.php">Manage Doctors</a>
    <a href="patients.php">Manage Patients</a>
    <a href="beds.php">Beds & Admission</a>
    <a href="logout.php" style="color:#e74c3c">Logout</a>
</div>    <div class="main">
        <h1>Dashboard Overview</h1>
        <div class="card-grid">
            <div class="card"><h3>Total Patients</h3><h2><?php echo $patients; ?></h2></div>
            <div class="card"><h3>Active Doctors</h3><h2><?php echo $doctors; ?></h2></div>
            <div class="card"><h3>Available Beds</h3><h2><?php echo $beds; ?></h2></div>
        </div>
        <img src="My_Hos.jpg" style="width: 100%; border-radius: 15px; opacity: 0.8; height: 400px; object-fit: cover;">
    </div>
</body>
</html>