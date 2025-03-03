<?php
include 'config.php';
session_start();

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $select_users = $conn->query("SELECT * FROM users_info WHERE email = '$email' AND password = '$password'") or die('Sorgu Hatası!');

    if (mysqli_num_rows($select_users) == 1) {
        $row = mysqli_fetch_assoc($select_users);

        if ($row['user_type'] == 'Admin') {
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['Id'];
            header('location:admin_index.php');
        } else {
            $message[] = 'Bu kullanıcı bir Admin değildir!';
        }
    } else {
        $message[] = 'Hatalı E-posta veya Şifre!';
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Giriş</title>
    <style>
        /* Genel tasarım */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(to bottom right, rgba(0, 123, 255, 0.7), rgba(72, 201, 176, 0.7)),
                url('background.jpg') center/cover no-repeat;
            backdrop-filter: blur(10px);
        }

        .container {
            position: relative;
            width: 50%;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            text-align: center;
            padding: 40px;
            animation: fadeIn 1s ease-in-out;
        }

        .container h3 {
            font-size: 32px;
            color: #333;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .text_field {
            width: 90%;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #f5f5f5;
            font-size: 18px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .text_field:focus {
            border-color: #4CAF50;
            background: #e8f5e9;
            outline: none;
            box-shadow: 0 0 10px rgba(76, 175, 80, 0.5);
        }

        .btn {
            width: 90%;
            padding: 20px;
            border: none;
            border-radius: 8px;
            background: #4CAF50;
            color: white;
            font-size: 20px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
        }

        .btn:hover {
            background: #45a049;
            transform: translateY(-2px);
        }

        .link {
            text-decoration: none;
            color: #007BFF;
            margin: 10px;
            font-size: 18px;
            transition: color 0.3s;
        }

        .link:hover {
            color: #0056b3;
        }

        .message {
            margin: 15px 0;
            padding: 10px;
            background: #ff4d4d;
            color: white;
            border-radius: 5px;
            font-size: 14px;
        }

        /* Çizgi animasyonu */
        .line-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            border: 5px solid transparent;
            border-image: linear-gradient(45deg, red, black);
            border-image-slice: 1;
            pointer-events: none;
            z-index: 1;
            animation: borderMove 4s linear infinite;
        }

        @keyframes borderMove {
            0% {
                clip-path: inset(0% 100% 0% 0%);
            }

            25% {
                clip-path: inset(0% 0% 100% 0%);
            }

            50% {
                clip-path: inset(100% 0% 0% 0%);
            }

            75% {
                clip-path: inset(0% 0% 0% 100%);
            }

            100% {
                clip-path: inset(0% 100% 0% 0%);
            }
        }

        /* Fade-in animasyonu */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>

<body>
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="message">' . $msg . '</div>';
        }
    }
    ?>
    <div class="container">
        <div class="line-animation"></div>
        <form action="" method="post">
            <h3>Admin Giriş</h3>
            <input type="email" name="email" placeholder="E-posta Adresinizi Girin" required class="text_field">
            <input type="password" name="password" placeholder="Admin için özel şifreyi giriniz" required class="text_field">
            <input type="submit" value="Giriş Yap" name="login" class="btn">
            <p>
                <a class="link" href="index.php">Ana Sayfa</a> |
                <a class="link" href="Register.php">Üye Ol</a>
            </p>
        </form>
    </div>
</body>

</html>
