<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'] ?? null;
$user_name = $_SESSION['user_name'] ?? 'Misafir';
$user_email = $_SESSION['user_email'] ?? '';

if (!isset($user_id)) {
    header('location:login.php');
    exit();
}

if (isset($_POST['checkout'])) {

    $name = mysqli_real_escape_string($conn, $_POST['firstname'] ?? '');
    $number = $_POST['number'] ?? '';
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $method = mysqli_real_escape_string($conn, $_POST['method'] ?? '');
    $address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
    $city = mysqli_real_escape_string($conn, $_POST['city'] ?? '');
    $state = mysqli_real_escape_string($conn, $_POST['state'] ?? '');
    $country = mysqli_real_escape_string($conn, $_POST['country'] ?? '');
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode'] ?? '');

    $full_address = "$address, $city, $state, $country - $pincode";

    if (strlen($full_address) > 500) {
        $message[] = 'Adresiniz çok uzun, 500 karakterle sınırlandırıldı.';
        $full_address = substr($full_address, 0, 500);
    }

    $placed_on = date('d-M-Y');
    $cart_total = 0;
    $cart_products = [];

    if (empty($name) || empty($email) || empty($number) || empty($address) || empty($city) || empty($state) || empty($country) || empty($pincode)) {
        $message[] = 'Lütfen tüm alanları doldurun.';
    } else {
        $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");

        if (!$cart_query) {
            $message[] = 'Sepet verileri alınamadı: ' . mysqli_error($conn);
        } elseif (mysqli_num_rows($cart_query) > 0) {
            while ($cart_item = mysqli_fetch_assoc($cart_query)) {
                $cart_products[] = $cart_item['name'] . ' #' . $cart_item['book_id'] . ', (' . $cart_item['quantity'] . ')';
                $cart_total += ($cart_item['price'] * $cart_item['quantity']);
            }

            $total_books = implode(', ', $cart_products);

            $order_query = mysqli_query($conn, "SELECT * FROM `confirm_order` WHERE name = '$name' AND number = '$number' AND email = '$email' AND payment_method = '$method' AND address = '$full_address' AND total_books = '$total_books' AND total_price = '$cart_total'");

            if (!$order_query) {
                $message[] = 'Sipariş sorgusu başarısız: ' . mysqli_error($conn);
            } elseif (mysqli_num_rows($order_query) > 0) {
                $message[] = 'Sipariş zaten verilmiş.';
            } else {
                $insert_order = mysqli_query($conn, "INSERT INTO `confirm_order`(user_id, name, number, email, payment_method, address, total_books, total_price, order_date) VALUES('$user_id', '$name', '$number', '$email', '$method', '$full_address', '$total_books', '$cart_total', '$placed_on')");

                if (!$insert_order) {
                    $message[] = 'Sipariş kaydedilemedi: ' . mysqli_error($conn);
                } else {
                  if (!$insert_order) {
                    $message[] = 'Sipariş kaydedilemedi: ' . mysqli_error($conn);
                } else {
                    // Sipariş başarı mesajı
                    $message[] = 'Sipariş başarıyla verildi!';
                
                    // Stok güncelleme işlemi
                    $cart_items = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
                    if (mysqli_num_rows($cart_items) > 0) {
                        while ($item = mysqli_fetch_assoc($cart_items)) {
                            $book_id = $item['book_id'];
                            $quantity = $item['quantity'];
                
                            // Stok miktarını azalt
                            $update_stock = mysqli_query($conn, "UPDATE `book_info` SET stock = stock - $quantity WHERE bid = '$book_id'");


                
                            if (!$update_stock) {
                                $message[] = 'Stok güncellemesi sırasında bir hata oluştu: ' . mysqli_error($conn);
                            }
                        }
                    }
                
                    // Sepeti temizle
                    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('Sepet temizleme hatası: ' . mysqli_error($conn));
                }
                
                }
            }
        } else {
            $message[] = 'Sepetiniz boş.';
        }
    }
}
?>



<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ödeme Sayfası</title>
  <style>
    body {
      font-family: Arial;
      font-size: 17px;
      padding: 8px;
      overflow-x: hidden;
    }

    * {
      box-sizing: border-box;
    }

    .row {
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      margin: 0 -16px;
      padding: 30px;
    }

    .col-25 {
      -ms-flex: 25%;
      flex: 25%;
    }

    .col-50 {
      -ms-flex: 50%;
      flex: 50%;
    }

    .col-75 {
      -ms-flex: 75%;
      flex: 75%;
    }

    .col-25,
    .col-50,
    .col-75 {
      padding: 0 16px;
    }

    .container {
      background-color: #f2f2f2;
      padding: 5px 20px 15px 20px;
      border: 1px solid lightgrey;
      border-radius: 3px;
    }

    input[type=text],
    select {
      width: 100%;
      margin-bottom: 20px;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 3px;
    }

    label {
      margin-bottom: 10px;
      display: block;
      color: black;
    }

    .icon-container {
      margin-bottom: 20px;
      padding: 7px 0;
      font-size: 24px;
    }

    .btn {
      background-color: rgb(28 146 197);
      color: white;
      padding: 12px;
      margin: 10px 0;
      border: none;
      width: 100%;
      border-radius: 3px;
      cursor: pointer;
      font-size: 17px;
    }

    .btn:hover {
      background-color: rgb(6 157 21);
      letter-spacing: 1px;
      font-weight: 600;
    }

    a {
      color: rgb(28 146 197);
    }

    hr {
      border: 1px solid lightgrey;
    }

    span.price {
      float: right;
      color: grey;
    }

    @media (max-width: 800px) {
      .row {
        flex-direction: column-reverse;
        padding: 0;
      }

      .col-25 {
        margin-bottom: 20px;
      }
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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://kit.fontawesome.com/493af71c35.js" crossorigin="anonymous"></script>

</head>

<body>
  <?php include 'index_header.php'; ?>

  <?php
  if (isset($message)) {
    foreach ($message as $message) {
      echo '
        <div class="message" id= "messages"><span>' . $message . '</span>
        </div>
        ';
    }
  }
  ?>

  <h1 class="title" style="text-align:center; margin-top:2rem; margin-bottom:2rem; font-size: 34px; color:#001c45">Ödeme
    Yapın</h1>

  <div class="row">
    <div class="col-75">
      <div class="container">
        <form action="" method="post">

          <div class="row">
            <div class="col-50">
              <h3>Kişisel Bilgiler</h3>
              <label for="firstname">Adınız</label>
              <input type="text" id="firstname" name="firstname" placeholder="Adınız" value="<?php echo $user_name ?>" required>
              <label for="email">E-posta</label>
              <input type="text" id="email" name="email" placeholder="E-posta Adresiniz" value="<?php echo $user_email ?>" required>
              <label for="number">Telefon Numarası</label>
              <input type="text" id="number" name="number" placeholder="Telefon Numaranız" required>
            </div>

            <div class="col-50">
              <h3>Adres</h3>
              <label for="address">Adres</label>
              <input type="text" id="address" name="address" placeholder="Sokak Adresi" required>
              <label for="city">İl</label>
              <input type="text" id="city" name="city" placeholder="Şehir Adı" required>
              <div class="row">
                <div class="col-50">
                  <label for="state">İlçe</label>
                  <input type="text" id="state" name="state" placeholder="İlçe" required>
                </div>
                <div class="col-50">
                  <label for="country">Ülke</label>
                  <input type="text" id="country" name="country" placeholder="Ülke" required>
                </div>
              </div>
              <label for="pincode">Posta Kodu</label>
              <input type="text" id="pincode" name="pincode" placeholder="Posta Kodu" required>
            </div>
          </div>

          <h3>Ödeme Yöntemi</h3>
          <label for="method">Ödeme Yöntemi</label>
          <select id="method" name="method">
            <option value="Credit Card">Kredi Kartı</option>
            <option value="PayPal">PayPal</option>
            <option value="Bank Transfer">Banka Transferi</option>
          </select>

          <input type="submit" value="Ödeme Yap" class="btn" name="checkout">

        </form>
      </div>
    </div>

    <div class="col-25">
  <div class="container">
    <?php
    // Sepet sorgusunu önce tanımlıyoruz
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Sorgu Hatası');
    ?>
    <h4>Sepetiniz 
      <span class="price" style="color:black">
        <i class="fa fa-shopping-cart"></i> 
        <b><?php echo mysqli_num_rows($cart_query); ?></b>
      </span>
    </h4>
    <hr>
    <?php
    $total = 0;
    if (mysqli_num_rows($cart_query) > 0) {
      while ($cart_item = mysqli_fetch_assoc($cart_query)) {
        echo '
          <p>' . htmlspecialchars($cart_item['name']) . ' x ' . $cart_item['quantity'] . ' 
          <span class="price">' . $cart_item['price'] . '₺</span></p>
        ';
        $total += ($cart_item['price'] * $cart_item['quantity']);
      }
    } else {
      echo '<p>Sepetiniz boş!</p>';
    }
    ?>
  </div>
</div>

        <hr>
        <p>Toplam <span class="price"><b><?php echo $total; ?>₺</b></span></p>
      </div>
    </div>
  </div>

  <script>
    let close = document.querySelector("#messages");
    close.addEventListener("click", function () {
      close.style.display = "none";
    });
  </script>

</body>

</html>
