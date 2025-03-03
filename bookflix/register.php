<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $name = trim($_POST['Name']);
    $Sname = trim($_POST['Sname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $cpassword = trim($_POST['cpassword']);

    // Boş alan kontrolü
    if (empty($name) || empty($Sname) || empty($email) || empty($password) || empty($cpassword)) {
        $message[] = 'Hiçbir alan boş bırakılamaz!';
    } elseif (preg_match('/\d/', $name) || preg_match('/\d/', $Sname)) {
        // Ad ve soyad sayı içermemeli
        $message[] = 'Ad ve soyad sayı içermemelidir!';
    } else {
        $name = mysqli_real_escape_string($conn, $name);
        $Sname = mysqli_real_escape_string($conn, $Sname);
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);
        $cpassword = mysqli_real_escape_string($conn, $cpassword);

        $select_users = $conn->query("SELECT * FROM users_info WHERE email = '$email'") or die('Sorgu hatası');

        if (mysqli_num_rows($select_users) != 0) {
            $message[] = 'Kullanıcı zaten mevcut!';
        } else {
            if ($password != $cpassword) {
                $message[] = 'Şifreler uyuşmuyor.';
            } else {
                mysqli_query($conn, "INSERT INTO users_info(`name`, `surname`, `email`, `password`, `user_type`) VALUES('$name','$Sname','$email','$password','User')") or die('Sorgu hatası');
                $message[] = 'Başarıyla kayıt olundu';
            }
        }
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
    <title>Kayıt Ol</title>
    <style>
        .container2 {
            display: flex;
            justify-content: center;
            background-image: linear-gradient(45deg, rgba(0, 0, 3, 0.1), rgba(0, 0, 0, 0.5)), url(../bgimg/2.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            height: 98vh;
        }
        .container form .link {
            text-decoration: none;
            color: white;
            border-radius: 17px;
            padding: 8px 18px;
            margin: 0px 10px;
            background: rgb(0, 0, 0);
            font-size: 20px;
        }
        .container form .link:hover {
            background: rgb(0, 167, 245);
        }
    </style>
</head>
<body>
<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '<div class="message" id="messages"><span>' . $msg . '</span></div>';
    }
}
?>
<div class="container">
    <form action="" method="post">
        <h3 style="color:white">Kayıt Ol <a href="index.php"><span>Kitap&Molam</span><span> </span></a></h3>
        <input type="text" name="Name" placeholder="Adınızı Girin" required class="text_field">
        <input type="text" name="Sname" placeholder="Soyadınızı Girin" required class="text_field">
        <input type="email" name="email" placeholder="E-posta Adresinizi Girin" required class="text_field">
        <input type="password" name="password" placeholder="Şifrenizi Girin" required class="text_field">
        <input type="password" name="cpassword" placeholder="Şifreyi Onaylayın" required class="text_field">
        <input type="submit" value="Kayıt Ol" name="submit" class="btn text_field">
        <p>Zaten Hesabınız Var mı? <br> <a class="link" href="login.php">Giriş Yap</a><a class="link" href="index.php">Geri</a></p>
    </form>
</div>

<script>
setTimeout(() => {
    const box = document.getElementById('messages');
    if (box) {
        box.style.display = 'none';
    }
}, 8000);
</script>
</body>
</html>
