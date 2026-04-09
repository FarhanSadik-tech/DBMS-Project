<?php
session_start();
include 'db.php';
if(isset($_POST['login'])){
    $u = $conn->real_escape_string($_POST['username']);
    $p = $conn->real_escape_string($_POST['password']);
    $res = $conn->query("SELECT * FROM Users WHERE username='$u' AND password='$p'");
    if($res->num_rows > 0){ $_SESSION['user'] = $u; header("Location: dashboard.php"); }
    else { $error = "Invalid Username or Password!"; }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title><link rel="stylesheet" href="style.css"></head>
<body style="justify-content: center; align-items: center; background: #2c3e50;">
    <form method="POST" style="width: 350px;">
        <h2 style="text-align:center; margin-bottom:20px;">Hospital Login</h2>
        <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <input name="username" placeholder="Username" required>
        <input name="password" type="password" placeholder="Password" required>
        <button class="btn btn-save" name="login" style="width:100%">Login</button>
    </form>
</body>
</html>