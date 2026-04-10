<?php 
session_start(); 
include 'db.php';

// 1. Patient registration logic (Gender যোগ করা হয়েছে)
if(isset($_POST['add_p'])){
    $n = $conn->real_escape_string($_POST['name']); 
    $p = $conn->real_escape_string($_POST['phone']);
    $g = $conn->real_escape_string($_POST['gender']); // নতুন জেন্ডার ইনপুট
    $conn->query("INSERT INTO Patients (name, phone, gender) VALUES ('$n', '$p', '$g')");
}

// 2. Doctor assignment logic
if(isset($_POST['assign'])){
    $p_id = (int)$_POST['p_id']; 
    $d_id = (int)$_POST['d_id'];
    $conn->query("UPDATE Patients SET assigned_doctor_id = $d_id WHERE patient_id = $p_id");
}

// 3. Search logic
$search_where = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $s = $conn->real_escape_string($_GET['search']);
    $search_where = " WHERE p.name LIKE '%$s%' OR p.phone LIKE '%$s%' ";
}

// 4. JOIN query to fetch Patient, Doctor, Gender and Bed information
$patients = $conn->query("SELECT p.*, d.name as dname, b.bed_number 
                          FROM Patients p 
                          LEFT JOIN Doctors d ON p.assigned_doctor_id = d.doctor_id 
                          LEFT JOIN Bed_Allocations ba ON p.patient_id = ba.patient_id AND ba.discharge_date IS NULL
                          LEFT JOIN Beds b ON ba.bed_id = b.bed_id
                          $search_where 
                          ORDER BY p.patient_id DESC");

// 5. Fetch doctor list for dropdown
$docs_query = $conn->query("SELECT * FROM Doctors");
$doc_list = [];
if($docs_query) {
    while($row = $docs_query->fetch_assoc()) {
        $doc_list[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patients - SHM System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

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
        
        <select name="gender" required style="margin-bottom: 15px; width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        
        <button class="btn btn-save" name="add_p">Register</button>
    </form>

    <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ddd;">

    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <h3>Patient Records</h3>
        <form method="GET" style="box-shadow:none; padding:0; margin:0; display:flex; gap:10px; background:none; width:auto;">
            <input type="text" name="search" placeholder="Search by name or phone..." 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
                   style="width: 250px; margin:0;">
            <button class="btn btn-assign" type="submit">Search</button>
            <?php if(isset($_GET['search'])): ?>
                <a href="patients.php" class="btn btn-red" style="text-decoration:none; padding: 10px;">Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <table>
        <tr>
            <th>Patient Name</th>
            <th>Gender</th> <th>Phone</th>
            <th>Assigned Doctor</th>
            <th>Bed Number</th>
            <th>Assign Action</th>
        </tr>
        <?php if($patients && $patients->num_rows > 0){ ?>
            <?php while($p = $patients->fetch_assoc()){ ?>
            <tr>
                <td><?php echo $p['name']; ?></td>
                <td style="font-weight: 500;"><?php echo $p['gender']; ?></td> <td><?php echo $p['phone']; ?></td>
                <td style="color:blue; font-weight:bold;"><?php echo $p['dname'] ?? 'Not Assigned'; ?></td>
                <td style="color:green; font-weight:bold;">
                    <?php echo $p['bed_number'] ?? '<span style="color:gray; font-weight:normal;">No Bed</span>'; ?>
                </td>
                <td>
                    <form method="POST" style="box-shadow:none; padding:0; margin:0; display:flex; gap:10px; background:none;">
                        <input type="hidden" name="p_id" value="<?php echo $p['patient_id']; ?>">
                        <select name="d_id" style="margin:0; width: 150px;">
                            <option value="">Select Doctor</option>
                            <?php foreach($doc_list as $dl){ ?>
                                <option value="<?php echo $dl['doctor_id']; ?>" <?php echo ($p['assigned_doctor_id'] == $dl['doctor_id']) ? 'selected' : ''; ?>>
                                    <?php echo $dl['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <button class="btn btn-assign" name="assign">Assign</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6" style="text-align:center; color:red;">No patients found!</td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>