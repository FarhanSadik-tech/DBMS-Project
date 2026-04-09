<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// ১. বেড অ্যাসাইন করার লজিক
if(isset($_POST['assign_bed'])){
    $patient_id = (int)$_POST['patient_id'];
    $bed_id = (int)$_POST['bed_id'];

    // চেক করা হচ্ছে বেডটি আসলেই ফাঁকা আছে কিনা
    $check = $conn->query("SELECT status FROM Beds WHERE bed_id=$bed_id AND status='Available'");
    if($check->num_rows > 0){
        // বেড বরাদ্দ করা
        $conn->query("INSERT INTO Bed_Allocations (patient_id, bed_id) VALUES ($patient_id, $bed_id)");
        // বেড স্ট্যাটাস আপডেট করা
        $conn->query("UPDATE Beds SET status='Occupied' WHERE bed_id=$bed_id");
        echo "<script>alert('Bed assigned successfully!');</script>";
    } else {
        echo "<script>alert('Sorry, this bed is already occupied!');</script>";
    }
}

// ২. ডিসচার্জ করার লজিক
if(isset($_POST['discharge'])){
    $alloc_id = (int)$_POST['allocation_id'];
    
    // প্রথমে বেড আইডি খুঁজে বের করা
    $res = $conn->query("SELECT bed_id FROM Bed_Allocations WHERE allocation_id=$alloc_id");
    $data = $res->fetch_assoc();
    $bed_id = $data['bed_id'];

    // ডিসচার্জ ডেট আপডেট করা
    $conn->query("UPDATE Bed_Allocations SET discharge_date = NOW() WHERE allocation_id = $alloc_id");
    // বেড আবার ফাঁকা করে দেওয়া
    $conn->query("UPDATE Beds SET status='Available' WHERE bed_id = $bed_id");
    echo "<script>alert('Patient discharged and bed is now free!');</script>";
}

// ডেটা ফেচিং
$available_beds = $conn->query("SELECT * FROM Beds WHERE status='Available'");
$all_patients = $conn->query("SELECT * FROM Patients");
$active_admissions = $conn->query("SELECT ba.allocation_id, p.name as p_name, b.bed_number, ba.admission_date 
                                   FROM Bed_Allocations ba 
                                   JOIN Patients p ON ba.patient_id = p.patient_id 
                                   JOIN Beds b ON ba.bed_id = b.bed_id 
                                   WHERE ba.discharge_date IS NULL");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Beds & Admission</title>
    <link rel="stylesheet" href="style.css">
</head>
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
        <h1>Beds & Admission Management</h1>

        <div style="display: flex; gap: 20px;">
            <section style="flex: 1;">
                <form method="POST">
                    <h3>Assign a Bed</h3>
                    <label>Select Patient:</label>
                    <select name="patient_id" required>
                        <?php while($p = $all_patients->fetch_assoc()){ ?>
                            <option value="<?php echo $p['patient_id']; ?>"><?php echo $p['name']; ?> (ID: <?php echo $p['patient_id']; ?>)</option>
                        <?php } ?>
                    </select>

                    <label>Select Available Bed:</label>
                    <select name="bed_id" required>
                        <?php while($b = $available_beds->fetch_assoc()){ ?>
                            <option value="<?php echo $b['bed_id']; ?>"><?php echo $b['bed_number']; ?> - <?php echo $b['bed_type']; ?></option>
                        <?php } ?>
                    </select>
                    <button class="btn btn-save" name="assign_bed" style="width:100%; margin-top:10px;">Assign Bed</button>
                </form>
            </section>

            <section style="flex: 2;">
                <h3>Active Admissions</h3>
                <table>
                    <tr>
                        <th>Patient</th>
                        <th>Bed</th>
                        <th>Admitted At</th>
                        <th>Action</th>
                    </tr>
                    <?php if($active_admissions->num_rows > 0){ 
                        while($row = $active_admissions->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $row['p_name']; ?></td>
                            <td><?php echo $row['bed_number']; ?></td>
                            <td><?php echo $row['admission_date']; ?></td>
                            <td>
                                <form method="POST" style="box-shadow:none; padding:0; background:none;">
                                    <input type="hidden" name="allocation_id" value="<?php echo $row['allocation_id']; ?>">
                                    <button class="btn btn-red" name="discharge">Discharge</button>
                                </form>
                            </td>
                        </tr>
                    <?php } } else { echo "<tr><td colspan='4'>No active admissions.</td></tr>"; } ?>
                </table>
            </section>
        </div>
    </div>
</body>
</html>