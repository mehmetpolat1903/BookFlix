<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if (isset($_GET['delete_msg'])) {
    $msg_id = $_GET['delete_msg'];
    mysqli_query($conn, "DELETE FROM `msg` WHERE id = '$msg_id'") or die('sorgu hatası');
    header('location:message_admin.php');
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/register.css">
    <link rel="stylesheet" href="./css/index_book.css">
    <title>Mesajlar</title>
</head>

<body>
    <?php
    include 'admin_header.php';
    ?>
        <section class="show-products">
    <div class="box-container">

   <?php
      $select_user = mysqli_query($conn, "SELECT id,name,email,number,msg,date FROM msg") or die('sorgu hatası');
      if(mysqli_num_rows($select_user) > 0){
         while($fetch_user = mysqli_fetch_assoc($select_user)){
   ?>
   <div class="box">
       <div class="name">Mesaj ID: <?php echo $fetch_user['id']; ?></div>
      <div class="name">İsim: <?php echo $fetch_user['name']; ?></div>
      <div class="name">E-posta: <?php echo $fetch_user['email']; ?></div>
      <div class="password">Numara: <?php echo $fetch_user['number']; ?></div>
      <div class="price">Mesaj: <?php echo wordwrap($fetch_user['msg'],30,"<br>\n",TRUE); ?></div>
      <div class="price">Tarih: <?php echo $fetch_user['date']; ?></div>
      <a href="message_admin.php?delete_msg=<?php echo $fetch_user['id']; ?>" onclick="return confirm('bu mesajı silmek istiyor musunuz?');">Sil</a>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">Henüz alınan bir mesaj yok!</p>';
   }
   ?>
    </div>
    </section>
</body>

</html>
