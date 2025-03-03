<?php
include 'config.php';
session_start();

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);


   $select_users = $conn->query("SELECT * FROM users_info WHERE email = '$email' and password='$password' ") or die('query failed');

    if (mysqli_num_rows($select_users) ==1) {

        $row = mysqli_fetch_assoc($select_users);

        if ($row['user_type'] == 'Admin') {
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['Id'];
            header('location:admin_index.php');

        } elseif ($row['user_type'] == 'User') {
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_id'] = $row['Id'];
                header('location:index.php');
            }
        }
        else {
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
    <link rel="stylesheet" href="css/register.css" />
    <title>Giriş Yapın</title>
    <style>
       .container form .link{
            text-decoration: none; color:white;  border-radius: 17px; padding: 8px 18px; margin: 0px 10px; background: rgb(0, 0, 0); font-size: 20px;
        }
        .container form .link:hover{
            background: rgb(0, 167, 245);
        }
    </style>
</head>

<body>
    <?php
if(isset($message)){
      foreach($message as $message){
        echo '
        <div class="message" id="messages"><span>'.$message.'</span>
        </div>
        ';
      }
    }
    ?>
    <div class="container">
        <form action="" method="post">
            <h3 style="color:white">kitapmolam\'a giriş yapın <a href="index.php"><span>kitapmolam & </span><span>Keyif</span></a></h3>
            <input type="email" name="email" placeholder="E-posta Adresinizi Girin" required class="text_field">
            <input type="password" name="password" placeholder="Şifrenizi Girin" required class="text_field">
            <input type="submit" value="Giriş Yap" name="login" class="btn text_field">
            <p>Hesabınız Yok mu? <br> <a class="link" href="Register.php">Üye Ol</a><a class="link" href="index.php">Geri Dön</a></p>
        </form>
    </div>


    <script>
setTimeout(() => {
  const box = document.getElementById('messages');

  // 👇️ hides element (still takes up space on page)
  box.style.display = 'none';
}, 8000);
</script>
</body>

</html>
