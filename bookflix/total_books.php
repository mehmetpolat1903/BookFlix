<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM `book_info` WHERE bid = '$delete_id'") or die('sorgu başarısız');
  header('location:total_books.php');
}

if(isset($_POST['update_product'])){

  $update_p_id = $_POST['update_p_id'];
  $update_name = $_POST['update_name'];
  $update_title = $_POST['update_title'];
  $update_description = $_POST['update_description'];
  $update_price = $_POST['update_price'];
  $update_category = $_POST['update_category'];
  $update_stock = $_POST['update_stock'];
  mysqli_query($conn, "UPDATE `book_info` SET stock = '$update_stock' WHERE bid = '$update_p_id'") or die('sorgu başarısız');

  mysqli_query($conn, "UPDATE `book_info` SET name = '$update_name', title='$update_title', description ='$update_description', price = '$update_price', category='$update_category' WHERE bid = '$update_p_id'") or die('sorgu başarısız');

  $update_image = $_FILES['update_image']['name'];
  $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
  $update_image_size = $_FILES['update_image']['size'];
  $update_folder = './added_books/'.$update_image;
  $update_old_image = $_POST['update_old_image'];

  if(!empty($update_image)){
     if($update_image_size > 2000000){
        $message[] = 'görüntü dosyası çok büyük';
     }else{
        mysqli_query($conn, "UPDATE `book_info` SET image = '$update_image' WHERE bid = '$update_p_id'") or die('sorgu başarısız');
        move_uploaded_file($update_image_tmp_name, $update_folder);
        unlink('uploaded_img/'.$update_old_image);
     }
  }

  header('location:total_books.php');

}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/register.css">
  <title>Kitap Molam - Kitap Güncelleme</title>
  <style>
     .show-products {
        display: flex;
        justify-content: center;
        padding: 20px;
        max-height: 100vh; /* Yüksekliği sınırladım */
        overflow-y: scroll; /* Dikey kaydırma çubuğu ekledim */
        width: 100%;
        box-sizing: border-box;
     }

     .box-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
     }

     .box {
        width: 80%; /* Her kutu genişliğini %30 olarak ayarladım */
        text-align: center;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 8px;
        background-color: #f4f4f4;
        box-sizing: border-box;
     }

     .box img {
        width: 50%;
        height: auto;
        border-radius: 5px;
     }

     .alert {
        font-size: 16px;
        font-weight: bold;
        color: white;
        background-color: red;
        padding: 10px;
        border-radius: 5px;
        margin-top: 5px;
        text-align: center;
        width: 100%;
        box-sizing: border-box;
     }

     /* Butonların hizalanmasını sağladım */
     .box .delete_btn, .box .update_btn {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 15px;
        background-color: #f44336;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        text-align: center;
     }

     .box .update_btn {
        background-color: #4CAF50;
     }
  </style>
</head>

<body>
   
  <?php
  include './admin_header.php'
  ?>
  <?php
  if (isset($message)) {
    foreach ($message as $message) {
      echo '
        <div class="message"><span>' . $message . '</span><i onclick="this.parentElement.remove();">Kapat</i>
        </div>
        ';
    }
  }
  ?>
  <a class="update_btn" style="position: fixed ; z-index:100;" href="add_books.php">Daha Fazla Kitap Ekle</a>

  <section class="edit-product-form">
   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `book_info` WHERE bid = '$update_id'") or die('sorgu başarısız');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['bid']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="./added_books/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Kitap Adını Girin">
      <input type="text" name="update_title" value="<?php echo $fetch_update['title']; ?>" class="box" required placeholder="Yazar Adını Girin">
      <input type="text" name="update_description" value="<?php echo $fetch_update['description']; ?>" class="box" required placeholder="Kitap açıklamasını girin">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="Kitap fiyatını girin">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="Güncelle" name="update_product" class="delete_btn" >
      <input type="reset" value="İptal" id="close-update" class="update_btn" >
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>

<section class="show-products">
   <div class="box-container">

      <?php
               $select_book = mysqli_query($conn, "SELECT * FROM `book_info` ORDER BY date DESC") or die('sorgu başarısız');
         if(mysqli_num_rows($select_book) > 0){
            while($fetch_book = mysqli_fetch_assoc($select_book)){
      ?>
    <div class="box">
    <img class="books_images" src="added_books/<?php echo $fetch_book['image']; ?>" alt="">
    <div class="name">Yazar: <?php echo $fetch_book['title']; ?></div>
    <div class="name">Kitap Adı: <?php echo $fetch_book['name']; ?></div>
    <div class="price">Fiyat: ₺ <?php echo $fetch_book['price']; ?>/-</div>
    <div class="stock">Stok: <?php echo $fetch_book['stock']; ?></div>
    <?php if ($fetch_book['stock'] < 50): ?>
        <div class="alert">Stok bitmek üzere! En kısa sürede temin etmelisiniz.</div>
    <?php endif; ?>
    <a href="total_books.php?update=<?php echo $fetch_book['bid']; ?>" class="update_btn">Güncelle</a>
    <a href="total_books.php?delete=<?php echo $fetch_book['bid']; ?>" class="delete_btn" onclick="return confirm('Bu kitabı silmek istediğinizden emin misiniz?');">Sil</a>
    </div>
      <?php
         }
      }else{
         echo '<p class="empty">Henüz kitap eklenmedi!</p>';
      }
      ?>
   </div>
</section>

<script src="./js/admin.js"></script>
</body>

</html>
