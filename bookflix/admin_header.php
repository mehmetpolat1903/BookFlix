<!-- <?php 
// session_start();
// if(isset($_GET['logout'])){
//     header('location:login.php');
// }
// ?> -->

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/admin.css">
    <title>Yönetici Sayfası</title>
</head>
<body>
    
<header>
    <div class="mainlogo">
        <div class="logo">
            <a href="admin_index.php"><span>Kitap &</span>
            <span class="me">Molam</span></a>
        </div><p>Yönetici Paneli</p></div>
    <div class="nav">
        <a href="admin_index.php">Anasayfa</a>
        <a href="add_books.php">Kitap Ekle</a>
        <a href="admin_orders.php">Siparişler</a>
        <a href="message_admin.php">Mesajlar</a>
        <a href="users_detail.php">Kullanıcılar</a>
    </div>
    <div class="right">
        <div class="log_info">
            <p>Merhaba <?php echo $_SESSION['admin_name'];?></p> 
        </div>
        <a class="Btn" href="logout.php?logout=<?php echo $_SESSION['admin_name'];?>">Çıkış Yap</a>
    </div>
</header>

</body>
</html>
