<?php
include 'config.php';
error_reporting(0);
session_start();

$user_id = $_SESSION['user_id'];

if (isset($_POST['add_to_cart'])) {
    if(!isset($user_id)){
        $message[]= 'Kitapları almak için giriş yapın';
     }else{
    $book_name = $_POST['book_name'];
    $book_id = $_POST['book_id'];
    $book_image = $_POST['book_image'];
    $book_price = $_POST['book_price'];
    $book_quantity = $_POST['quantity'];
    $total_price = number_format($book_price * $book_quantity);
    $select_book = $conn->query("SELECT * FROM cart WHERE name= '$book_name' AND user_id='$user_id' ") or die('sorgu başarısız');

    if (mysqli_num_rows($select_book) > 0) {
        $message[] = 'Bu kitap zaten sepetinizde var';
    } else {
        $conn->query("INSERT INTO cart (`book_id`,`user_id`,`name`, `price`, `image`, `quantity` ,`total`) VALUES('$book_id','$user_id','$book_name','$book_price','$book_image','$book_quantity', '$total_price')") or die('Sepete ekleme sorgusu başarısız');
        $message[] = 'Kitap sepete başarıyla eklendi';
    }
}

}
?>


<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index_book.css">
    <title>Seçilen Ürünler</title>

    <style>
/* Genel Ayarlar */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;600;700&display=swap');

* {
  margin: 0;
  padding: 0;
  font-family: 'Poppins', sans-serif;
  box-sizing: border-box;
}

body {
  background: linear-gradient(135deg, #000000, #444444, #888888);
  background-size: 300% 300%;
  animation: gradientMove 6s infinite alternate;
  min-height: 100vh;
  padding: 0 2rem;
  overflow-x: hidden;
}

/* Arka plan geçiş animasyonu */
@keyframes gradientMove {
  from {
    background-position: left bottom;
  }
  to {
    background-position: right top;
  }
}

/* Ürünler Konteyneri */
.show-products {
  padding-top: 40px;
  margin-top: 40px;
  text-align: center;
}

.show-products .box-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(22rem, 1fr));
  gap: 2.5rem;
  max-width: 1400px;
  margin: 0 auto;
}

.show-products .box-container .box {
  background: rgba(255, 255, 255, 0.95);
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  overflow: hidden;
  padding: 20px;
  text-align: center;
}

.show-products .box-container .box:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
}

.show-products .box img {
  max-height: 200px;
  margin: 0 auto 15px;
  border-radius: 10px;
}

.show-products .box .name {
  font-size: 1.5rem;
  color: #333;
  font-weight: 600;
  margin: 10px 0;
  text-transform: capitalize;
}

.show-products .box .price {
  font-size: 1.2rem;
  color: #007bff;
  font-weight: 500;
  margin-bottom: 20px;
}

/* Butonlar */
.show-products .box .update_btn, .delete_btn {
  background: linear-gradient(45deg, #ff5722, #ff9100);
  padding: 12px 24px;
  margin: 8px;
  border-radius: 25px;
  color: white;
  font-size: 1rem;
  font-weight: bold;
  text-transform: capitalize;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.show-products .box .update_btn:hover, .delete_btn:hover {
  background: linear-gradient(45deg, #ff9100, #ff5722);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
  transform: translateY(-3px);
}
/* Kitap Detayları */
.details {
  padding: 30px;
  max-width: 1400px;
  margin: 50px auto 0;
  background: rgba(255, 255, 255, 0.9);
  border-radius: 15px;
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.details .row_box {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: center;
}

.details .col_box {
  flex: 1 1 45%;
  padding: 20px;
  text-align: center;
}

.details .col_box img {
  max-height: 400px;
  border-radius: 15px;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.details h3 {
  font-size: 2rem;
  color: #333;
  font-weight: 700;
  margin: 1.5rem 0;
}

.details label {
  font-size: 1.2rem;
  font-weight: 600;
  margin-top: 10px;
  display: inline-block;
}

.details input {
  width: 180px;
  height: 40px;
  padding: 5px;
  font-size: 1rem;
  margin-left: 10px;
  border-radius: 5px;
  border: 1px solid #007bff;
}

.details input:focus {
  outline: 2px solid #007bff;
  background-color: rgba(0, 123, 255, 0.1);
}

.details .buttons {
  margin-top: 20px;
}

.details .buttons a {
  background: linear-gradient(45deg, #42a5f5, #1e88e5);
  color: white;
  font-size: 1.1rem;
  font-weight: bold;
  padding: 12px 30px;
  margin-right: 15px;
  border-radius: 30px;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.details .buttons a:hover {
  background: linear-gradient(45deg, #1e88e5, #42a5f5);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  transform: translateY(-3px);
}

        .message {
  position: sticky;
  top: 0;
  margin: 0 auto;
  width: 61%;
  background-color: #fff;
  padding: 6px 9px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  z-index: 100;
  gap: 0px;
  border: 2px solid rgb(68, 203, 236);
  border-top-right-radius: 8px;
  border-bottom-left-radius: 8px;
}
.message span {
  font-size: 22px;
  color: rgb(240, 18, 18);
  font-weight: 400;
}
.message i {
  cursor: pointer;
  color: rgb(3, 227, 235);
  font-size: 15px;
}
    </style>
</head>

<body>
    <?php
    include 'index_header.php';
    ?>
        <?php
    if(isset($message)){
      foreach($message as $message){
        echo '
        <div class="message" id= "messages"><span>'.$message.'</span>
        </div>
        ';
      }
    }
    ?>
    <div class="details">
        <?php
        if (isset($_GET['details'])) {
            $get_id = $_GET['details'];
            $get_book = mysqli_query($conn, "SELECT * FROM `book_info` WHERE bid = '$get_id'") or die('sorgu başarısız');
            if (mysqli_num_rows($get_book) > 0) {
                while ($fetch_book = mysqli_fetch_assoc($get_book)) {
        ?>
                    <div class="row_box">
                        <form style="display: flex ;" action="" method="POST">
                            <div class="col_box">
                                <img src="./added_books/<?php echo $fetch_book['image']; ?>" alt="<?php echo $fetch_book['name']; ?>">
                            </div>
                            <div class="col_box">
                                <h4>Yazar: <?php echo $fetch_book['title']; ?></h4>
                                <h1>İsim: <?php echo $fetch_book['name']; ?></h1>
                                <h1>Kitap türü: <?php echo $fetch_book['category']; ?></h1>
                                <h3>Fiyat: ₺ <?php echo $fetch_book['price']; ?>/-</h3>
                                <label for="quantity">Adet:</label>
                                <input type="number" name="quantity" value="1" min="1" max="10" id="quantity">
                                <div class="buttons" style="text-align: center;"> <!-- Ortalamak için text-align kullanıyoruz -->
    <input class="hidden_input" type="hidden" name="book_name" value="<?php echo $fetch_book['name'] ?>">
    <input class="hidden_input" type="hidden" name="book_id" value="<?php echo $fetch_book['bid'] ?>">
    <input class="hidden_input" type="hidden" name="book_image" value="<?php echo $fetch_book['image'] ?>">
    <input class="hidden_input" type="hidden" name="book_price" value="<?php echo $fetch_book['price'] ?>">
    <input type="submit" name="add_to_cart" value="Sepete Ekle" class="btn" 
           style="display: inline-block; margin: 0 auto !important; padding: 10px 20px; background-color: #ff5722; color: white; border-radius: 5px;">
</div>
                                <h3>Kitap Detayları</h3>
                                <p><?php echo $fetch_book['description']; ?></p>
                            </div>
                        </form>
                    </div>
        <?php
                }
            }
        } else {
            echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
        }
        ?>
    </div>
    <script src="./js/admin.js"></script>
    <script>
setTimeout(() => {
  const box = document.getElementById('messages');

  // 👇️ elementi gizler (sayfada hala yer kaplar)
  box.style.display = 'none';
}, 5000);
</script>
</body>

</html>
