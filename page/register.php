<?php
            session_start();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $_POST['username'];
                $password = $_POST['password'];

                $url = 'https://game-auth-api-3o2r3t7hxa-et.a.run.app/register';
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
                        header('Location: login.php');
                        exit();
                    } else {
                        echo "Registration failed: " . $response['message'];
                    }
                }
            }
            ?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .container {
        position: relative;
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 1;
    }

    .video-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: -1;
    }

    .video-container video {
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .form-container {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }

    .form-container h1 {
        text-align: center;
        margin-top: 0;
    }

    .form-container form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .form-container input {
        margin: 0.5rem 0;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        max-width: 300px;
    }

    .form-container input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
    }

    .form-container p {
        text-align: center;
        margin-top: 1rem;
    }

    .form-container a {
        color: #4CAF50;
        text-decoration: none;
    }
    </style>
</head>

<body>
    <div class="video-container">
        <video autoplay loop muted>
            <source src="../video/index.mp4" type="video/mp4">
        </video>
    </div>

    <div class="container">
        <div class="form-container">
            <h1>Register</h1>
            <form method="POST" action="">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <input type="submit" value="Register">
            </form>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>

</html>