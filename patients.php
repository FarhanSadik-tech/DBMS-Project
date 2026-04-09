<?php session_start(); include 'db.php';
if(isset($_POST['add_p'])){
    $n = $_POST['name']; $p = $_POST['phone'];
    $conn->query("INSERT INTO Patients (name, phone) VALUES ('$n', '$p')");
}
if(isset($_POST['assign'])){
    $p_id = $_POST['p_id']; $d_id = $_POST['d_id'];
    $conn->query("UPDATE Patients SET assigned_doctor_id = $d_id WHERE patient_id = $p_id");
}
$patients = $conn->query("SELECT p.*, d.name as dname FROM Patients p LEFT JOIN Doctors d ON p.assigned_doctor_id = d.doctor_id");
$docs = $conn->query("SELECT * FROM Doctors");
$doc_list = $docs->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><title>Patients</title><link rel="stylesheet" href="style.css"></head>
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
        <h1>Patient Management</h1>
        <form method="POST">
            <h3>Register New Patient</h3>
            <input name="name" placeholder="Patient Name" required>
            <input name="phone" placeholder="Phone" required>
            <button class="btn btn-save" name="add_p">Register</button>
        </form>
        <table>
            <tr><th>Patient</th><th>Phone</th><th>Assigned Doctor</th><th>Assign Action</th></tr>
            <?php foreach($patients as $p){ ?>
            <tr>
                <td><?php echo $p['name']; ?></td>
                <td><?php echo $p['phone']; ?></td>
                <td style="color:blue"><?php echo $p['dname'] ?? 'Not Assigned'; ?></td>
                <td>
                    <form method="POST" style="box-shadow:none; padding:0; margin:0; display:flex; gap:10px;">
                        <input type="hidden" name="p_id" value="<?php echo $p['patient_id']; ?>">
                        <select name="d_id" style="margin:0;"><?php foreach($doc_list as $dl) echo "<option value='{$dl['doctor_id']}'>{$dl['name']}</option>"; ?></select>
                        <button class="btn btn-assign" name="assign">Assign</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>