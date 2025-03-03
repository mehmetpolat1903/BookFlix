<?php
include 'config.php';

// Oturum başlatma
session_start();

// Admin ID kontrolü
$admin_id = $_SESSION['admin_id'];

// Eğer admin ID yoksa, login sayfasına yönlendir
if(!isset($admin_id)){
   header('location:login.php');
}

// Kullanıcı silme işlemi
if (isset($_GET['delete_user'])) {
    $delete_id = $_GET['delete_user'];
    mysqli_query($conn, "DELETE FROM `users_info` WHERE Id = '$delete_id'") or die('query failed');
    header('location:users_detail.php');
}

// Kullanıcı güncelleme işlemi
if (isset($_POST['update_user'])) {

    $update_id = $_POST['update_id'];
    $update_name = $_POST['update_name'];
    $update_sname = $_POST['update_sname'];
    $update_email = $_POST['update_email'];
    $update_password = $_POST['update_password'];
    $update_user_type = $_POST['update_user_type'];

    mysqli_query($conn, "UPDATE `users_info` SET name = '$update_name', surname='$update_name', email ='$update_email', password = '$update_password', user_type='$update_user_type' WHERE Id = '$update_id'") or die('query failed');

    header('location:./users_detail.php');
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
    <title>Kullanıcı Verisi</title>
</head>

<body>
    <?php
    include 'admin_header.php';
    ?>
  
    <section class="show-products">
    <div class="box-container">

    <?php
      // Kullanıcı bilgilerini seçme
      $select_user = mysqli_query($conn, "SELECT Id,name,surname,email,password,user_type FROM users_info") or die('query failed');
      if(mysqli_num_rows($select_user) > 0){
         while($fetch_user = mysqli_fetch_assoc($select_user)){
   ?>
   <div class="box">
       <div class="name">Kullanıcı ID: <?php echo $fetch_user['Id']; ?></div>
      <div class="name">Adı: <?php echo $fetch_user['name']; ?>&nbsp;<?php echo $fetch_user['surname']; ?></div>
      <div class="name">E-posta: <?php echo $fetch_user['email']; ?></div>
      <div class="password">Şifre: <?php echo $fetch_user['password']; ?></div>
      <div class="price" style="color:<?php if($fetch_user['user_type'] == 'Admin'){ echo 'red'; }else{ echo 'blue'; } ?>;">Kullanıcı tipi: <?php echo $fetch_user['user_type']; ?></div>
      <a style="color:rgb(255, 187, 0);" href="users_detail.php?update_user=<?php echo $fetch_user['Id']; ?>">Güncelle</a>
      <a href="users_detail.php?delete_user=<?php echo $fetch_user['Id']; ?>" onclick="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?');">Sil</a>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">Henüz ürün eklenmedi!</p>';
   }
   ?>
    </div>
    </section>

    <section class="edit_user-form">
        <div class="edit-product-form">
            <?php
            // Kullanıcı güncelleme formu
            if (isset($_GET['update_user'])) {
                $update_id = $_GET['update_user'];
                $update_query = mysqli_query($conn, "SELECT * FROM `users_info` WHERE Id = '$update_id'") or die('query failed');
                if (mysqli_num_rows($update_query) > 0) {
                    while ($fetch_update = mysqli_fetch_assoc($update_query)) {
            ?>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="update_id" value="<?php echo $fetch_update['Id']; ?>">
                            <input type="text" value="<?php echo $fetch_update['name'] ?>" name="update_name" placeholder="Adı Girin" required class="box ">
                            <input type="text" value="<?php echo $fetch_update['surname'] ?>" name="update_sname" placeholder="Soyadı Girin" required class="box">
                            <input type="email" value="<?php echo $fetch_update['email'] ?>" name="update_email" placeholder="E-posta Girin" required class="box">
                            <input type="password" value="<?php echo $fetch_update['password'] ?>" name="update_password" placeholder="Şifre Girin" required class="box">
                            <select name="update_user_type" id="" required class="box">
                                <option value="User">Kullanıcı</option>
                                <option value="Admin">Admin</option>
                            </select>
                            <input type="submit" value="Güncelle" name="update_user" class="delete_btn">
                            <input type="reset" value="İptal" id="close-update_user" class="update_btn">
                        </form>
            <?php
                    }
                }
            } else {
                echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
            }
            ?>

        </div>
    </section>

    <script>
        // Güncelleme formunu kapatma
        document.querySelector('#close-update_user').onclick = () => {
            document.querySelector('.edit-product-form').style.display = 'none';
            window.location.href = 'users_detail.php';
        }
    </script>

</body>

</html>
