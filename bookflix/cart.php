<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];
$user_name =$_SESSION['user_name'];

if(!isset($user_id)){
   header('location:login.php');
}


if(isset($_GET['remove'])){
    $remove_id=$_GET['remove'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id='$remove_id'") or die('sorgu hatası');
    $message[]='Başarıyla Kaldırıldı';
    header('location:cart.php');
}
if(isset($_POST['update'])){
    $update_cart_id =$_POST['cart_id'];
    $book_price=$_POST['book_price'];
    $update_quantity =$_POST['update_quantity'];
    $total_price =$book_price * $update_quantity;
    mysqli_query($conn, "UPDATE `cart` SET `quantity`='$update_quantity', `total`='$total_price' WHERE `id`='$update_cart_id'") or die('sorgu hatası');
    
    $message[]=''.$user_name.' sepetiniz başarıyla güncellendi';
}

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/hello.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepet</title>
    <style>

/* Arka plan geçişi */
body {
    background: linear-gradient(to right, #e0e0e0, #b0b0b0, #ffffff, #b0b0b0, #e0e0e0) !important; /* Siyah-beyaz geçişli arka plan */
    color: #333; /* Metin rengi */
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Sepet butonları */
.cart-btn1,
.cart-btn2 {
    display: inline-block;
    margin: auto;
    padding: 0.8rem 1.5rem;
    cursor: pointer;
    font-size: 14px;
    border-radius: 2rem;
    text-transform: capitalize;
    transition: all 0.3s ease;
    font-weight: bold;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

.cart-btn1 {
    margin-left: 40%;
    background: linear-gradient(45deg, #ffc107, #ff8b00);
    color: white;
    border: 2px solid #ff9800;
}

.cart-btn1:hover {
    background: linear-gradient(45deg, #ff9800, #ffc107);
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(255, 152, 0, 0.3);
}

.cart-btn2 {
    background: linear-gradient(45deg, #2196f3, #00bcd4);
    color: white;
    border: 2px solid #03a9f4;
}

.cart-btn2:hover {
    background: linear-gradient(45deg, #03a9f4, #2196f3);
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(3, 169, 244, 0.3);
}

/* Mesaj kutusu */
.message {
    position: sticky;
    top: 0;
    margin: 0 auto;
    width: 60%;
    background: linear-gradient(135deg, #8e44ad, #bdc3c7);
    padding: 12px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    z-index: 100;
    gap: 10px;
    border: 2px solid #03a9f4;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.message span {
    font-size: 18px;
    color: #f44336;
    font-weight: bold;
    text-shadow: 1px 1px rgba(0, 0, 0, 0.1);
}

.message i {
    cursor: pointer;
    color: #03a9f4;
    font-size: 20px;
    transition: transform 0.3s ease, color 0.3s ease;
}

.message i:hover {
    color: #0288d1;
    transform: scale(1.2);
}

/* Tablo düzenlemeleri */
table {
    width: 70%;
    margin: 10px auto;
    border-collapse: collapse; /* Tablo hücrelerinin birleşmesini sağlar */
}

th, td {
    padding: 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    font-size: 16px;
}

th {
    background: #f4f4f4;
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #f9f9f9; /* Alternatif satırların farklı renklerde olmasını sağlar */
}

/* Sepet formu */
.cart_form {
    padding: 20px;
    background: rgba(255, 255, 255, 0.9); /* Beyaz arka planla saydamlık */
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    margin: 20px;
}

/* Resimler ve metinler için stil */
img {
    max-width: 100%;
    height: auto;
}

.hidden_input {
    display: none;
}

.empty {
    font-size: 20px;
    color: #f44336;
    text-align: center;
    margin-top: 20px;
}

a {
    text-decoration: none;
}

/* İleri butonları */
a.cart-btn2 {
    margin-top: 15px;
    padding: 10px 20px;
    border-radius: 5px;
    background: #28a745;
    color: white;
    font-weight: bold;
    text-align: center;
}

a.cart-btn2:hover {
    background: #218838;
}

    </style>
</head>

<body>
    <?php
    include 'index_header.php';
    ?>
    <div class="cart_form">
    <?php
    if(isset($message)){
      foreach($message as $message){
        echo '
        <div class="message" id="messages"><span>'.$message.'</span>
        </div>
        ';
      }
    }
    ?>
        <table style="width: 70%; align-items:center; margin:10px auto;" >
            <thead>
                <th>Resim</th>
                <th>Adı</th>
                <th>Fiyat</th>
                <th>Miktar</th>
                <th>Toplam (₺)</th>
            </thead>
            <tbody>
                
                <?php
                $total = 0;
                $select_book = $conn->query("SELECT id, name,price, image ,quantity,total  FROM cart Where user_id= $user_id");
                if ($select_book->num_rows  > 0) {

                    while ($row = $select_book->fetch_assoc()) {
                ?>
                        <tr>
                            <td><img style="height: 90px;" src="./added_books/<?php echo $row['image']; ?>" alt=""></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td>
                                <form action="" method="POST">
                                    <input type="number" name="update_quantity" min="1" max="10" value="<?php echo $row['quantity']; ?>">
                                    <input type="hidden" name="cart_id" value="<?php echo $row['id']; ?>">
                                    <input class="hidden_input" type="hidden" name="book_price" value="<?php echo $row['price'] ?>">
                                <!-- <input type="submit" name="update" value="güncelle"> -->
                                <button style="background:transparent ;" name="update"><img style="height: 26px; cursor:pointer;" src="./images/update1.png" alt="güncelle"></button> | 
                                <a style="color: red;" href="cart.php?remove=<?php echo $row['id'];?>"> Kaldır</a>
                                </form>
                            </td>
                            <td><?php $sub_total=$row['price']*$row['quantity']; echo $subtotal=number_format($row['price']*$row['quantity']); ?></td>
                            </tr>

                <?php
                $total += $sub_total;
                    }
                } else {
                    echo '<p class="empty">Sepetinizde henüz bir şey yok !!!!!!!!</p>';
                }
                ?>
                <tr>
                    <th style="text-align:center;" colspan="3">Toplam</th>
                    <th colspan="2">₺ <?php echo $total; ?>/- </th>

                </tr>
                
            </tbody>
        </table>
        <a href="checkout.php" class="btn cart-btn1" style="display:<?php if($total>1){ echo 'inline-block'; }else{ echo 'none'; };?>" > &nbsp; Ödeme Yapmaya Geç</a> <a class="cart-btn2" href="index.php">Alışverişe Devam Et</a>
    </div>
    <?php include'index_footer.php'; ?>
    
    <script>
setTimeout(() => {
  const box = document.getElementById('messages');

  // 👇️ öğeyi gizler (hala sayfada yer kaplar)
  box.style.display = 'none';
}, 5000);
</script>

</body>

</html>
