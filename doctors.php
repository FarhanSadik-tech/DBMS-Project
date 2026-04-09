<?php session_start(); include 'db.php';
if(isset($_POST['add_doc'])){
    $n = $_POST['name']; $s = $_POST['specialty']; $p = $_POST['phone'];
    $conn->query("INSERT INTO Doctors (name, specialty, phone) VALUES ('$n', '$s', '$p')");
}
$docs = $conn->query("SELECT * FROM Doctors");
?>
<!DOCTYPE html>
<html>
<head><title>Doctors</title><link rel="stylesheet" href="style.css"></head>
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
</div>   
 <div class="main">
        <h1>Doctor Management</h1>
        <form method="POST">
            <h3>Add New Doctor</h3>
            <input name="name" placeholder="Doctor Name" required>
            <input name="specialty" placeholder="Specialty (e.g. Surgery)" required>
            <input name="phone" placeholder="Phone Number" required>
            <button class="btn btn-save" name="add_doc">Add Doctor</button>
        </form>
        <table>
            <tr><th>Name</th><th>Specialty</th><th>Phone</th></tr>
            <?php while($d = $docs->fetch_assoc()){ echo "<tr><td>{$d['name']}</td><td>{$d['specialty']}</td><td>{$d['phone']}</td></tr>"; } ?>
        </table>
    </div>
</body>
</html>