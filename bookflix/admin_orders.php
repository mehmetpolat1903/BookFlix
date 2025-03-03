<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}


if (isset($_POST['update_order'])) {

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   $date = date("d.m.Y");
   mysqli_query($conn, "UPDATE `confirm_order` SET payment_status = '$update_payment', order_date='$date' WHERE order_id = '$order_update_id'") or die('sorgu başarısız');

   $message[] = 'ödeme durumu güncellendi!';
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `confirm_order` WHERE order_id = '$delete_id'") or die('sorgu başarısız');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>siparişler</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="./css/hello.css">

   <style>
      .cart-btn1,
      .cart-btn2 {
         display: inline-block;
         margin-top: 0.4rem;
         padding: 0.2rem 0.8rem;
         cursor: pointer;
         color: white;
         font-size: 15px;
         border-radius: .5rem;
         text-transform: capitalize;
      }

      .cart-btn1 {
         margin-left: 40%;
         background-color: red;
      }

      .cart-btn2 {
         background-color: #ffa41c;
         color: black;
      }

      .placed-orders .title {
         text-align: center;
         margin-bottom: 20px;
         text-transform: uppercase;
         color: black;
         font-size: 40px;
      }

      .placed-orders .box-container {
         max-width: 1200px;
         margin: 0 auto;
         display: flex;
         flex-wrap: wrap;
         align-items: center;
         gap: 20px;
      }

      .placed-orders .box-container .empty {
       text-align: center;
       font-size: 20px;
       color: gray;
       }

      .placed-orders .box-container .box {
       flex: 1 1 400px;
       border-radius: .5rem;
       padding: 15px;
       border: 2px solid black; /* Kenar rengi siyah */
       background-color: #ffffff; /* Beyaz arka plan */
       box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* Gölgeleme */
       transition: transform 0.3s ease, box-shadow 0.3s ease; /* Hover animasyonu için */
      }

      .placed-orders .box-container .box p {
        padding: 10px 0 0 0;
        font-size: 18px;
        color: #333; /* Daha okunabilir koyu gri renk */
      }

      .placed-orders .box-container .box p span {
       color: #000; /* Siyah yazı rengi */
       font-weight: bold; /* Vurgulama */
       }

       .placed-orders .box-container .box:hover {
   transform: translateY(-5px); /* Hover durumunda hafif yukarı kaldır */
   box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3); /* Hover sırasında gölge artışı */
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

   <?php include 'admin_header.php'; ?>
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

   <section class="placed-orders">

      <h1 class="title">SİPARİŞLER</h1>

      <div class="box-container">
   <?php
   $select_orders = mysqli_query($conn, "SELECT * FROM `confirm_order`") or die('sorgu başarısız');
   if (mysqli_num_rows($select_orders) > 0) {
      while ($fetch_book = mysqli_fetch_assoc($select_orders)) {
         // Tarihi Türkçe formatına dönüştür
         $order_date = date("d.m.Y", strtotime($fetch_book['order_date']));
   ?>
         <div class="box">
            <p> Sipariş Tarihi : <span><?php echo $order_date; ?></span> </p>
            <p> Sipariş ID : <span>#<?php echo $fetch_book['order_id']; ?></span></p>
            <p> Adı : <span><?php echo htmlspecialchars($fetch_book['name']); ?></span> </p>
            <p> Telefon Numarası : <span><?php echo $fetch_book['number']; ?></span> </p>
            <p> E-posta : <span><?php echo $fetch_book['email']; ?></span> </p>
            <p> Adres : <span><?php echo htmlspecialchars($fetch_book['address']); ?></span> </p>
            <p> Ödeme Yöntemi : <span>
               <?php
               switch ($fetch_book['payment_method']) {
                  case 'credit_card':
                     echo 'Kredi Kartı';
                     break;
                  case 'bank_transfer':
                     echo 'Havale/EFT';
                     break;
                  case 'cash_on_delivery':
                     echo 'Kapıda Ödeme';
                     break;
                  default:
                     echo 'Bilinmeyen';
                     break;
               }
               ?>
            </span></p>
            <p> Siparişiniz : <span><?php echo htmlspecialchars($fetch_book['total_books']); ?></span> </p>
            <p> Toplam Fiyat : <span>₺ <?php echo number_format($fetch_book['total_price'], 2, ',', '.'); ?></span> </p>
            <form action="" method="post">
               <input type="hidden" name="order_id" value="<?php echo $fetch_book['order_id']; ?>">
               Ödeme Durumu :
               <select name="update_payment">
                  <option value="" selected disabled><?php echo ($fetch_book['payment_status'] === 'completed') ? 'Tamamlandı' : 'Beklemede'; ?></option>
                  <option value="pending">Beklemede</option>
                  <option value="completed">Tamamlandı</option>
               </select>
               <input type="submit" value="Güncelle" name="update_order" class="cart-btn2">
               <a class="cart-btn1" href="admin_orders.php?delete=<?php echo $fetch_book['order_id']; ?>" onclick="return confirm('Bu siparişi silmek istiyor musunuz?');">Sil</a>
            </form>
         </div>
   <?php
      }
   } else {
      echo '<p class="empty">Henüz sipariş verilmedi!</p>';
   }
   ?>
</div>


   </section>


   <!-- özel admin js dosyası bağlantısı  -->
   <script src="js/admin_script.js"></script>
   <script>
      setTimeout(() => {
         const box = document.getElementById('messages');

         // 👇️ öğeyi gizler (sayfada yer kaplamaya devam eder)
         box.style.display = 'none';
      }, 8000);
   </script>

</body>

</html>
