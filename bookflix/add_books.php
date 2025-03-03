<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

if (isset($_POST['add_books'])) {
    $bname = mysqli_real_escape_string($conn, $_POST['bname']);
    $btitle = mysqli_real_escape_string($conn, $_POST['btitle']);
    $category = mysqli_real_escape_string($conn, $_POST['Category']);
    $price = $_POST['price'];
    $desc = mysqli_real_escape_string($conn, $_POST['bdesc']);
    $img = $_FILES["image"]["name"];
    $img_temp_name = $_FILES["image"]["tmp_name"];
    $img_file = "./added_books/" . $img;
    $stock = isset($_POST['stock']) && is_numeric($_POST['stock']) ? (int)$_POST['stock'] : null;

    // Form doğrulama
    $errors = [];
    if (empty($bname)) $errors[] = 'Lütfen kitap adını girin.';
    if (empty($btitle)) $errors[] = 'Lütfen yazar adını girin.';
    if (empty($price) || !is_numeric($price)) $errors[] = 'Lütfen geçerli bir fiyat girin.';
    if (empty($category)) $errors[] = 'Lütfen bir kategori seçin.';
    if (empty($desc)) $errors[] = 'Lütfen kitap açıklamasını girin.';
    if (empty($img)) $errors[] = 'Lütfen bir resim seçin.';
    if ($stock === null || $stock < 0) $errors[] = 'Lütfen geçerli bir stok miktarı girin.';

    if (empty($errors)) {
        $add_book_query = "INSERT INTO book_info(`name`, `title`, `price`, `category`, `description`, `image`, `stock`) 
                           VALUES('$bname', '$btitle', '$price', '$category', '$desc', '$img', '$stock')";
        $add_book = mysqli_query($conn, $add_book_query) or die('Sorgu başarısız');

        if ($add_book) {
            move_uploaded_file($img_temp_name, $img_file);
            $message[] = 'Yeni kitap başarıyla eklendi.';
        } else {
            $message[] = 'Kitap eklenemedi.';
        }
    } else {
        $message = $errors;
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `book_info` WHERE bid = '$delete_id'") or die('Sorgu başarısız');
    header('location:add_books.php');
    exit();
}

if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_title = mysqli_real_escape_string($conn, $_POST['update_title']);
    $update_description = mysqli_real_escape_string($conn, $_POST['update_description']);
    $update_price = is_numeric($_POST['update_price']) ? $_POST['update_price'] : 0;
    $update_stock = isset($_POST['update_stock']) && is_numeric($_POST['update_stock']) ? $_POST['update_stock'] : 0;
    $update_category = mysqli_real_escape_string($conn, $_POST['update_category']);

    mysqli_query($conn, "UPDATE `book_info` SET 
        name = '$update_name', 
        title = '$update_title', 
        description = '$update_description', 
        price = '$update_price', 
        category = '$update_category', 
        stock = '$update_stock' 
        WHERE bid = '$update_p_id'") or die('Sorgu başarısız');

    if (!empty($_FILES['update_image']['name'])) {
        $update_image = $_FILES['update_image']['name'];
        $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
        $update_image_size = $_FILES['update_image']['size'];
        $update_folder = './added_books/' . $update_image;
        $update_old_image = $_POST['update_old_image'];

        if ($update_image_size > 2000000) {
            $message[] = 'Resim dosya boyutu çok büyük.';
        } else {
            mysqli_query($conn, "UPDATE `book_info` SET image = '$update_image' WHERE bid = '$update_p_id'") or die('Sorgu başarısız');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            if (file_exists('./added_books/' . $update_old_image)) {
                unlink('./added_books/' . $update_old_image);
            }
        }
    }

    header('location:add_books.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/register.css">
  <title>Kitap Ekle</title>
</head>


<body>
  <?php
  include './admin_header.php'
  ?>
  <?php
  if (isset($message)) {
    foreach ($message as $message) {
      echo '
        <div class="message" id="messages"><span>' . $message . '</span>
        </div>
        ';
    }
  }
  ?>
  
<a class="update_btn" style="position: fixed ; z-index:100;" href="total_books.php">Tüm Kitapları Görüntüle</a>
  <div class="container_box">
  <form action="" method="POST" enctype="multipart/form-data">
    <h3>Kitapları <a href="index.php"><span>Kitap & </span><span>Molam</span></a> sitesine ekleyin</h3>
    <input type="text" name="bname" placeholder="Kitap Adını Girin" class="text_field ">
    <input type="text" name="btitle" placeholder="Yazar Adını Girin" class="text_field">
    <input type="number" min="0" name="price" class="text_field" placeholder="Kitap fiyatını girin">
    <select name="Category" required class="text_field">
        <option value="bilim">Bilimsel</option>
        <option value="Dünya Klasikleri">Dünya Klasikleri</option>
        <option value="Türk Klasikleri">Türk Klasikleri</option>
        <option value="Tarih">Tarih</option>
        <option value="Din">Din</option>
        <option value="Felsefe">Felsefe</option>
        <option value="Roman">Roman</option>
    </select>
    <textarea name="bdesc" placeholder="Kitap açıklamasını girin" class="text_field" cols="18" rows="5"></textarea>
    <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="text_field">
    <input type="number" min="0" name="stock" placeholder="Stok miktarını girin" class="text_field">
    <input type="submit" value="Kitap Ekle" name="add_books" class="btn text_field">
</form>

  </div>

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
   <select name="update_category" value="<?php echo $fetch_update['category']; ?>" required class="text_field">
    <option value="bilim">Bilimsel</option>
    <option value="Dünya Klasikleri">Dünya Klasikleri</option>
    <option value="Türk Klasikleri">Türk Klasikleri</option>
    <option value="Tarig">Tarih</option>
    <option value="Din">Din</option>
    <option value="Felsefe">Felsefe</option>
    <option value="Roman">Roman</option>
</select>

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
         $select_book = mysqli_query($conn, "SELECT * FROM book_info ORDER BY date DESC LIMIT 2;") or die('sorgu başarısız');
         if(mysqli_num_rows($select_book) > 0){
            while($fetch_book = mysqli_fetch_assoc($select_book)){
      ?>
       <div class="box">
         <img class="books_images" src="added_books/<?php echo $fetch_book['image']; ?>" alt="">
         <div class="name">Yazar: <?php echo $fetch_book['title']; ?></div>
         <div class="name">Adı: <?php echo $fetch_book['name']; ?></div>
         <div class="price">Fiyat: ₺ <?php echo $fetch_book['price']; ?>/-</div>
         <a href="add_books.php?update=<?php echo $fetch_book['bid']; ?>" class="update_btn">Güncelle</a>
         <a href="add_books.php?delete=<?php echo $fetch_book['bid']; ?>" class="delete_btn" onclick="return confirm('Kitabı silmek istediğinize emin misiniz?');">Sil</a>
      </div>

      <?php
         }
      }else{
         echo '<p class="empty">Henüz kitap eklenmedi!</p>';
      }
      ?>
   </div>

</section>

</body>

</html>
