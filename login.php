
<?php

session_start();
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id, username, password FROM users WHERE username = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $username
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $user = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    if ($user && password_verify($password, $user["password"])) {

        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        header("Location: index.php");
        exit();

    } else {

        $message = "Invalid username or password.";
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Login | Library Management System</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #071426, #102a43, #071426);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            background: #e63946;
            border-radius: 50%;
            top: -150px;
            left: -120px;
            opacity: 0.18;
        }

        body::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            background: #f4c430;
            border-radius: 50%;
            bottom: -150px;
            right: -100px;
            opacity: 0.16;
        }

        .login-container {
            width: 100%;
            max-width: 950px;
            min-height: 560px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: white;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
            position: relative;
            z-index: 2;
        }

        .welcome-section {
            background: linear-gradient(145deg, #e63946, #b91c2b);
            color: white;
            padding: 55px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: "";
            position: absolute;
            width: 230px;
            height: 230px;
            border: 35px solid rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            right: -90px;
            top: -70px;
        }

        .welcome-section::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            border: 25px solid rgba(244, 196, 48, 0.2);
            border-radius: 50%;
            left: -80px;
            bottom: -70px;
        }

        .logo {
            width: 75px;
            height: 75px;
            background: #f4c430;
            color: #071426;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            margin-bottom: 28px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.18);
        }

        .welcome-section h1 {
            font-size: 34px;
            line-height: 1.2;
            margin-bottom: 18px;
        }

        .welcome-section p {
            font-size: 16px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.88);
            max-width: 360px;
        }

        .line {
            width: 60px;
            height: 5px;
            background: #f4c430;
            border-radius: 10px;
            margin-top: 28px;
        }

        .login-section {
            padding: 55px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-section h2 {
            font-size: 30px;
            color: #071426;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #718096;
            margin-bottom: 32px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            color: #243447;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
            transition: 0.2s;
        }

        .form-group input:focus {
            border-color: #2878c8;
            box-shadow: 0 0 0 3px rgba(40, 120, 200, 0.12);
        }

        .login-button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: #2878c8;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 5px;
        }

        .login-button:hover {
            background: #1f64a8;
            transform: translateY(-1px);
        }

        .error-message {
            background: #fff1f2;
            color: #c62828;
            border-left: 4px solid #e63946;
            padding: 12px 14px;
            border-radius: 7px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .footer-text {
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            margin-top: 28px;
        }

        @media (max-width: 750px) {

            .login-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .welcome-section {
                padding: 35px;
                min-height: 300px;
            }

            .welcome-section h1 {
                font-size: 28px;
            }

            .logo {
                width: 60px;
                height: 60px;
                font-size: 30px;
                margin-bottom: 20px;
            }

            .login-section {
                padding: 35px;
            }

        }

    </style>

</head>

<body>

<div class="login-container">

    <div class="welcome-section">

        <div class="logo">📚</div>

        <h1>Library Management System</h1>

        <p>
            Manage books, members and loans easily
            from one simple and organized system.
        </p>

        <div class="line"></div>

    </div>


    <div class="login-section">

        <h2>Welcome Back</h2>

        <p class="subtitle">
            Login to access the library dashboard.
        </p>


        <?php if ($message != "") { ?>

            <div class="error-message">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php } ?>


        <form method="POST">

            <div class="form-group">

                <label>Username</label>

                <input
                    type="text"
                    name="username"
                    placeholder="Enter your username"
                    required
                >

            </div>


            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                >

            </div>


            <button type="submit" class="login-button">
                Login
            </button>

        </form>


        <div class="footer-text">
            Library Management System
        </div>

    </div>

</div>

</body>

</html>
