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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #e0e5ec; /* Neumorphic background */
        }

        .main-container {
            display: flex;
            width: 900px;
            height: 500px;
            background: #f0f2f5;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 20px 20px 60px #bebebe, -20px -20px 60px #ffffff;
        }

        /* Left Side - Dark Blue with Illustration */
        .left-side {
            flex: 1;
            background: #1a1a4b;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            border-top-right-radius: 80px;
        }

        .illustration {
            width: 80%;
            max-width: 300px;
            margin-bottom: 20px;
        }

        /* Right Side - Login Form */
        .right-side {
            flex: 1.2;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #f0f2f5;
        }

        .brand-name {
            font-size: 24px;
            font-weight: bold;
            color: #1a1a4b;
            margin-bottom: 5px;
        }

        .brand-name span {
            color: #d90429; /* Red accent like EDU-X */
        }

        .welcome-text {
            color: #555;
            margin-bottom: 40px;
            font-size: 18px;
        }

        form {
            width: 100%;
            max-width: 320px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 12px;
            font-weight: bold;
            color: #666;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: none;
            outline: none;
            background: #f0f2f5;
            border-radius: 10px;
            color: #333;
            /* Neumorphic Input Shadow */
            box-shadow: inset 6px 6px 12px #d1d9e6, inset -6px -6px 12px #ffffff;
            transition: 0.3s;
        }

        input:focus {
            box-shadow: inset 2px 2px 5px #d1d9e6, inset -2px -2px 5px #ffffff;
        }

        .forgot-pass {
            display: block;
            text-align: right;
            font-size: 11px;
            color: #777;
            text-decoration: none;
            margin-top: 5px;
        }

        .btn-save {
            width: 100%;
            padding: 12px;
            margin-top: 30px;
            border: none;
            border-radius: 10px;
            background: #f0f2f5;
            color: #1a1a4b;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            /* Neumorphic Button Shadow */
            box-shadow: 6px 6px 12px #d1d9e6, -6px -6px 12px #ffffff;
            transition: 0.2s;
        }

        .btn-save:active {
            box-shadow: inset 4px 4px 8px #d1d9e6, inset -4px -4px 8px #ffffff;
            transform: scale(0.98);
        }

        .error-msg {
            color: #d90429;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <div class="main-container">
        <div class="left-side">
            <img src="logo.png" alt="Hospital Illustration" class="illustration">
            <p style="font-size: 12px; opacity: 0.7;">Secure Access Portal</p>
        </div>

        <div class="right-side">
            <div class="brand-name">SHM System-<span></span></div>
            <div class="welcome-text">Welcome !</div>

            <?php if(isset($error)) { ?>
              <p class="error-msg"><?php echo $error; ?></p>
            <?php } ?>

            <form method="POST">
                <div class="input-group">
                    <label>Username</label>
                    <input name="username" placeholder="kunal@bvp.com" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input name="password" type="password" placeholder="********" required>
                    <a href="#" class="forgot-pass">Forgot Password ?</a>
                </div>

                <button type="submit" class="btn btn-save" name="login">Log In</button>
            </form>
        </div>
    </div>

</body>
</html>