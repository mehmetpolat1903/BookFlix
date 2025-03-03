<?php

include 'config.php'; 
session_start(); 

$user_id = $_SESSION['user_id']; 

if (!isset($user_id)) { 
   header('location:login.php'); 
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Siparişler</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="./css/hello.css">

   <style>
      /* Genel Stil */
      body {
         font-family: 'Arial', sans-serif;
         background: linear-gradient(to right, #e0e0e0, #b0b0b0, #ffffff, #b0b0b0, #e0e0e0) !important;
          color: #333

      }

      .placed-orders .title {
         text-align: center;
         margin-bottom: 20px;
         text-transform: uppercase;
         color: black;
         font-size: 40px;
         font-weight: bold;
      }

      .placed-orders .box-container {
         max-width: 1200px;
         margin: 0 auto;
         display: flex;
         flex-wrap: wrap;
         gap: 20px;
         justify-content: center;
      }

      .placed-orders .box-container .box {
         flex: 1 1 400px;
         border-radius: 10px;
         padding: 15px;
         border: 2px solid black; /* Kenarlar siyah */
         background-color: white;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
         transition: transform 0.2s ease-in-out;
      }

      .placed-orders .box-container .box:hover {
         transform: translateY(-5px);
         box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
      }

      .placed-orders .box-container .box p {
         padding: 10px 0;
         font-size: 18px;
         font-weight: 500;
         color: #555;
      }

      .placed-orders .box-container .box p span {
         color: black;
         font-weight: bold;
      }

      .placed-orders .box-container .empty {
         text-align: center;
         font-size: 20px;
         color: #777;
      }
   </style>
</head>
<body>
   
<?php include 'index_header.php'; ?>

<section class="placed-orders">

   <h1 class="title">Siparişlerim</h1>

   <div class="box-container">

      <?php
        $select_book = mysqli_query($conn, "SELECT * FROM `confirm_order` WHERE user_id = '$user_id' ORDER BY order_date DESC") or die('Sorgu başarısız');
        
        if (mysqli_num_rows($select_book) > 0) {
            while ($fetch_book = mysqli_fetch_assoc($select_book)) {
               // Tarihi Türkçe formata çevir
               $formatted_date = date('d M Y', strtotime($fetch_book['order_date']));
               $turkish_months = [
                  'Jan' => 'Ocak', 'Feb' => 'Şubat', 'Mar' => 'Mart', 'Apr' => 'Nisan',
                  'May' => 'Mayıs', 'Jun' => 'Haziran', 'Jul' => 'Temmuz', 'Aug' => 'Ağustos',
                  'Sep' => 'Eylül', 'Oct' => 'Ekim', 'Nov' => 'Kasım', 'Dec' => 'Aralık'
               ];
               $formatted_date = strtr($formatted_date, $turkish_months);
      ?>
      <div class="box">
         <p> Sipariş Tarihi: <span><?php echo $formatted_date; ?></span> </p>
         <p> Sipariş ID: <span>#<?php echo $fetch_book['order_id']; ?></span> </p>
         <p> İsim: <span><?php echo $fetch_book['name']; ?></span> </p>
         <p> Telefon Numarası: <span><?php echo $fetch_book['number']; ?></span> </p>
         <p> E-posta: <span><?php echo $fetch_book['email']; ?></span> </p>
         <p> Adres: <span><?php echo $fetch_book['address']; ?></span> </p>
         <p> Ödeme Yöntemi: <span><?php echo $fetch_book['payment_method']; ?></span> </p>
         <p> Siparişiniz: <span><?php echo $fetch_book['total_books']; ?></span> </p>
         <p> Toplam Fiyat: <span>₺ <?php echo $fetch_book['total_price']; ?></span> </p>
         <p> Ödeme Durumu: 
            <span style="color:<?php if ($fetch_book['payment_status'] == 'pending') { echo 'orange'; } else { echo 'green'; } ?>;">
               <?php echo $fetch_book['payment_status'] == 'pending' ? 'Beklemede' : 'Tamamlandı'; ?>
            </span> 
         </p>
      </div>
      <?php
       }
      } else {
         echo '<p class="empty">Henüz hiçbir sipariş vermediniz!</p>';
      }
      ?>
   </div>

</section>

<?php include 'index_footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
