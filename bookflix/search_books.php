<?php
include 'config.php';  // Veritabanı bağlantı dosyasını dahil et

session_start();  // Oturumu başlat

if(isset($_SESSION['user_name'])){  // Kullanıcı giriş yaptıysa
   $user_id = $_SESSION['user_id'];  // Kullanıcı kimliğini al

   if (isset($_POST['add_to_cart'])) {  // Sepete ekle butonuna basıldıysa
      $book_name = $_POST['book_name'];  // Kitap adı
      $book_id = $_POST['book_id'];  // Kitap kimliği
      $book_image = $_POST['book_image'];  // Kitap görseli
      $book_price = $_POST['book_price'];  // Kitap fiyatı
      $book_quantity = '1';  // Varsayılan olarak 1 adet ekle

      $total_price = number_format($book_price * $book_quantity);  // Toplam fiyat hesapla
      $select_book = $conn->query("SELECT * FROM cart WHERE bid= '$book_id' AND user_id='$user_id' ") or die('query failed');  // Sepette bu kitap var mı kontrol et

      if (mysqli_num_rows($select_book) > 0) {  // Kitap zaten sepetteyse
          $message[] = 'Bu Kitap zaten sepette var';  // Mesaj ekle
      } else {  // Kitap sepette yoksa
         $conn->query("INSERT INTO cart (`user_id`,`book_id`,`name`, `price`, `image`,`quantity` ,`total`) VALUES('$user_id','$book_id','$book_name','$book_price','$book_image','$book_quantity', '$total_price')") or die('Sepete eklerken hata oluştu');  // Sepete ekle
         $message[] = 'Kitap Başarıyla Sepete Eklendi';  // Başarı mesajı
         header('location:index.php');  // Anasayfaya yönlendir
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>arama sayfası</title>  <!-- Sayfa başlığı -->

   <!-- Font Awesome CDN bağlantısı -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Özel CSS dosyası bağlantısı -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      .search-form form {  /* Arama formu stili */
         max-width: 1200px;
         margin: 30px auto;
         display: flex;
         gap: 15px;
      }

      .search-form form .search_btn {  /* Arama butonunun stili */
         margin-top: 0;
      }

      .search-form form .box {  /* Arama kutusunun stili */
         width: 100%;
         padding: 12px 14px;
         border: 2px solid rgb(0, 167, 245);
         font-size: 20px;
         color: black;
         border-radius: 5px;
      }

      .search_btn {  /* Arama butonu stili */
         display: inline-block;
         padding: 10px 25px;
         cursor: pointer;
         color: white;
         font-size: 18px;
         border-radius: 5px;
         text-transform: capitalize;
         background-color: rgb(0, 167, 245);
      }
   </style>
</head>

<body>

   <?php include 'index_header.php'; ?>  <!-- Üst başlık dahil et -->

   <section class="search-form">

      <form action="" method="POST">
         <input type="text" class="box" name="search_box" placeholder="ürün arayın...">  <!-- Arama kutusu -->
         <input type="submit" name="search_btn" value="ara" class="search_btn">  <!-- Arama butonu -->
      </form>

   </section>

   <div class="msg">
      <?php
      if (isset($_POST['search_btn'])) {  // Arama butonuna basıldıysa
         $search_box = $_POST['search_box'];  // Arama kutusundaki değeri al
         
         echo '<h4>"'. $search_box.'" için Arama Sonucu:</h4>';  // Arama sonuç mesajını göster
      };
      ?>
   </div>

   <section class="show-products">
      <div class="box-container">

         <?php
         if (isset($_POST['search_btn'])) {  // Arama butonuna basıldıysa
            $search_box = $_POST['search_box'];  // Arama kutusundaki değeri al

            
            $select_products = mysqli_query($conn, "SELECT * FROM `book_info` WHERE name LIKE '%{$search_box}%' OR title LIKE '%{$search_box}%' OR category LIKE '%{$search_box}%'");  // Kitapları ara
            if (mysqli_num_rows($select_products) > 0) {  // Kitap bulunduysa
               while ($fetch_book = mysqli_fetch_assoc($select_products)) {  // Her bir kitabı al
         ?>

                  <div class="box" style="width: 255px;height: 342px;">  <!-- Kitap kutusu -->
                     <a href="book_details.php?details=<?php echo $fetch_book['bid'];  // Kitap detaylarına git ?>"> <img style="height: 200px;width: 125px;margin: auto;" class="books_images" src="added_books/<?php echo $fetch_book['image']; ?>" alt=""></a>  <!-- Kitap görseli -->
                     <div style="text-align:left ;">
                        <div class="name" style="font-size: 12px;">Yazar: <?php echo $fetch_book['title']; ?></div>  <!-- Yazar adı -->
                        <div style="font-weight: 500; font-size:18px;" class="name">Adı: <?php echo $fetch_book['name']; ?></div>  <!-- Kitap adı -->
                     </div>
                     <div class="price">Fiyat: ₺ <?php echo $fetch_book['price']; ?>/-</div>  <!-- Fiyat bilgisi -->
                     
                     <!-- Sepete ekle butonu -->
                     <form action="" method="POST">
                        <input class="hidden_input" type="hidden" name="book_name" value="<?php echo $fetch_book['name'] ?>">  <!-- Kitap adı -->
                        <input class="hidden_input" type="hidden" name="book_image" value="<?php echo $fetch_book['image'] ?>">  <!-- Kitap görseli -->
                        <input class="hidden_input" type="hidden" name="book_price" value="<?php echo $fetch_book['price'] ?>">  <!-- Kitap fiyatı -->
                        <button onclick="myFunction()" name="add_to_cart"><img src="./images/cart2.png" alt="Sepete ekle">  <!-- Sepete ekle simgesi -->
                           <a href="book_details.php?details=<?php echo $fetch_book['bid']; echo '-name=', $fetch_book['name']; ?>" id="adventure" class="update_btn">Daha fazla bilgi</a>
                     </form>
                  </div>
         <?php
               }
            } else {  // Kitap bulunamadıysa
               echo '<p class="empty">"'. $search_box.'" için sonuç bulunamadı! </p>';  // Hata mesajı
            }
         };
         ?>
      </div>
   </section>

   <?php include 'index_footer.php'; ?>  <!-- Alt başlık dahil et -->

   <script src="js/script.js"></script>  <!-- JavaScript dosyasını dahil et -->

</body>

</html>
