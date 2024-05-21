<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .video-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        overflow: hidden;
    }

    .video-bg video {
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .login-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(255, 255, 255, 0.8);
        padding: 30px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    .login-container h1 {
        margin-top: 0;
    }

    .login-container input[type="text"],
    .login-container input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: none;
        border-radius: 3px;
        box-sizing: border-box;
    }

    .login-container input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        text-decoration: none;
        cursor: pointer;
        border-radius: 3px;
    }

    .login-container p {
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <div class="video-bg">
        <video autoplay loop muted>
            <source src="../video/index.mp4" type="video/mp4">
        </video>
    </div>

    <div class="login-container">
        <h1>Login</h1>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" value="Login">
        </form>

        <?php
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $url = 'https://game-auth-api-3o2r3t7hxa-et.a.run.app/login';
            $data = array(
                'username' => $username,
                'password' => $password
            );

            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/json\r\n",
                    'method'  => 'POST',
                    'content' => json_encode($data)
                )
            );

            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            if ($result === false) {
                echo "Error: Unable to connect to the API.";
            } else {
                $response = json_decode($result, true);
                if ($response['status'] === 'success') {
                    $_SESSION['user_id'] = $response['user_id'];
                    header('Location: product.php');
                    exit();
                } else {
                    echo "Login failed: " . $response['message'] . "<br>";
                    echo "Don't have an account? <a href='register.php'>Register here</a>";
                }
            }
        }
        ?>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>

</html>