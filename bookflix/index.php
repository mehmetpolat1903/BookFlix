<?php
include 'config.php';

error_reporting(0);
session_start();

$user_id = $_SESSION['user_id'];

if (isset($_POST['add_to_cart'])) {
    if (!isset($user_id)) {
        $message[] = 'Kitapları alabilmek için lütfen giriş yapın';
    } else {
        $book_name = $_POST['book_name'];
        $book_id = $_POST['book_id'];
        $book_image = $_POST['book_image'];
        $book_price = $_POST['book_price'];
        $book_quantity = '1';

        $total_price = number_format($book_price * $book_quantity);

        $select_book = $conn->query("SELECT * FROM cart WHERE book_id= '$book_id' AND user_id='$user_id' ") or die('sorgu başarısız');
//veri tabanı kullmnarak sepet ekleme

        if (mysqli_num_rows($select_book) > 0) {
            $message[] = 'Bu kitap zaten sepetinizde';
        } else {
            $conn->query("INSERT INTO cart (`user_id`,`book_id`,`name`, `price`, `image`,`quantity` ,`total`) VALUES('$user_id','$book_id','$book_name','$book_price','$book_image','$book_quantity', '$total_price')") or die('Sepete ekleme sorgusu başarısız');
            $message[] = 'Kitap Sepete Başarıyla Eklendi';
            header('location:index.php');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;500;700&display=swap");

* {
    margin: 0 !important;
    padding: 0 !important;
    font-family: "Poppins", sans-serif !important;
    box-sizing: border-box !important;
    text-decoration: none !important;
}

/* Arka Plan */
body {
    background: radial-gradient(circle, #e0e0e0 50%, #333333 100%) !important;
    min-height: 100vh !important;
    width: 100% !important;
    background-size: cover !important;
    background-attachment: fixed !important;
    overflow-x: hidden !important;
    position: relative !important;
    box-shadow: inset 0 0 50px rgba(0, 0, 0, 0.3); /* Gölgeleme efekti */
}

/* Noise Efekti */
body::before {
    content: "" !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    background-image: url("https://www.transparenttextures.com/patterns/noise.png") !important;
    opacity: 0.05 !important;
    z-index: 1 !important;
    pointer-events: none !important;
}


/* Header */
header {
    background: rgba(255, 255, 255, 0.9) !important;
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    padding: 15px 2% !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important;
    border-bottom: 2px solid #ddd !important;
    position: sticky !important;
    top: 0 !important;
    z-index: 1000 !important;
}

.logo a {
    font-size: 28px !important;
    font-weight: 600 !important;
    color: #FFA500 !important; /* Turuncumsu sarı */
    text-shadow: 1px 1px rgba(0, 0, 0, 0.3) !important; /* Hafif bir gölge */
}


/* Navigasyon */
.nav a {
    font-size: 18px !important;
    color: #3f5efb !important;
    padding: 8px 16px !important;
    border-radius: 5px !important;
    transition: all 0.3s ease !important;
}
.nav a:hover {
    color: white !important;
    background: #3f5efb !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important;
}
/* Ürün kutularını içeren kapsayıcı */
.show-products {
    display: flex !important;
    justify-content: center !important;
    align-items: flex-start !important; /* Dikey hizalama üstte olacak */
    flex-wrap: wrap !important;
    overflow-y: auto !important; /* Dikey kaydırma etkinleştirildi */
    max-height: 80vh !important; /* Ürünler %80 ekran yüksekliğiyle sınırlı */
    padding: 10px !important; /* Kaydırma çubuğu için iç boşluk */
    border: 1px solid #ccc !important; /* Çerçeve ekledim */
    background-color: #f9f9f9 !important; /* Hafif arka plan rengi */
    scrollbar-width: thin; /* Kaydırma çubuğu inceltildi (Firefox için) */
}

/* Kaydırma çubuğu stili (Chrome, Edge, Safari) */
.show-products::-webkit-scrollbar {
    width: 8px; /* Kaydırma çubuğu genişliği */
}

.show-products::-webkit-scrollbar-thumb {
    background: #888; /* Kaydırma çubuğu rengi */
    border-radius: 10px; /* Yuvarlak kenar */
}

.show-products::-webkit-scrollbar-thumb:hover {
    background: #555; /* Hover durumunda renk koyulaştırıldı */
}

/* Ürün kutularını düzenleme */
.show-products .box-container {
    display: grid !important;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)) !important;
    gap: 20px !important;
    width: 100% !important;
    max-width: 1200px !important; /* İçeriği ortalamak için genişlik sınırlaması */
}

/* Ürün kutularının stili */
.show-products .box {
    background: rgba(255, 255, 255, 0.9) !important;
    padding: 15px !important;
    border-radius: 15px !important;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3) !important; /* Kutulara gölge */
    text-align: center !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease !important;
    transform: scale(1) !important;
    position: relative !important;
    overflow: hidden !important;
}

.show-products .box:hover {
    transform: scale(1.05) !important;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4) !important; /* Hover gölgesi */
}



/* Butonlar */
button, .update_btn, .delete_btn {
    background: linear-gradient(45deg, #3f5efb, #fc466b) !important;
    color: white !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 10px 10px !important;
    font-weight: bold !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2) !important;
}
button:hover, .update_btn:hover, .delete_btn:hover {
    background: linear-gradient(45deg, #fc466b, #3f5efb) !important;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3) !important;
}

/* Bildirim */
.message {
    position: fixed !important;
    top: 10px !important;
    left: 50% !important;
    transform: translateX(-50%) !important;
    background: rgba(255, 255, 255, 0.9) !important;
    padding: 10px 20px !important;
    border-radius: 10px !important;
    border: 2px solid #3f5efb !important;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2) !important;
    z-index: 1000 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
}
.message span {
    font-size: 16px !important;
    color: #fc466b !important;
    font-weight: 500 !important;
}
.message i {
    cursor: pointer !important;
    color: #3f5efb !important;
    font-size: 18px !important;
}

/* İletişim Formu */
.contact-form-btn {
    background: linear-gradient(45deg, #000, #3f5efb) !important;
    color: white !important;
    border-radius: 20px !important;
    padding: 12px 30px !important;
    font-weight: bold !important;
    cursor: pointer !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3) !important;
}
.contact-form-btn:hover {
    background: linear-gradient(45deg, #3f5efb, #000) !important;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5) !important;
}

    </style>
    <title>Kitap & Molam</title>

</head>

<body>
    <?php include 'index_header.php' ?>
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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    </ol>
    <div class="static-image-container">
    <img class="static-image" src="images/kitap3.png" alt="Kitap 3">
</div>

<style>
/* Görselin konteyneri */
.static-image-container {
    width: 100%; /* Konteyner genişliği tam ekran olacak */
    max-height: 500px; /* Maksimum yükseklik */
    overflow: hidden; /* Taşmaları gizle */
    display: flex; /* Görseli ortalamak için kullanılır */
    justify-content: center; /* Yatayda ortalar */
    align-items: center; /* Dikeyde ortalar */
    background-color: #f5f5f5; /* Arka plan rengi, isteğe bağlı */
}

/* Görselin stili */
.static-image {
    width: 2000px; height: 1000px; /* Görselin en boy oranını korur */
    height: 100%; /* Konteynerin yüksekliğini doldurur */
    object-fit: cover; /* Görselin konteynere düzgün sığmasını sağlar */
    border-radius: 10px; /* Hafif köşe yuvarlama */
}
</style>


    <section id="New">

        <div class="container px-5 mx-auto">
            <h2 class="m-8 font-extrabold text-4xl text-center border-t-2 " style="color: rgb(218,165,32);">
                Yeni Gelenler
            </h2>
        </div>
    </section>
    <section class="show-products">
    <div class="box-container">

        <?php
        $select_book = mysqli_query($conn, "SELECT * FROM `book_info` ORDER BY date DESC") or die('Sorgu başarısız');

        if (mysqli_num_rows($select_book) > 0) {
            while ($fetch_book = mysqli_fetch_assoc($select_book)) {
                $is_discounted = $fetch_book['stock'] <= 5; // İndirim kontrolü
                $discounted_price = $is_discounted ? number_format($fetch_book['price'] * 0.75, 2) : $fetch_book['price'];
        ?>

                <div class="box" style="width: 255px; height: 400px;">
                    <a href="book_details.php?details=<?php echo $fetch_book['bid']; ?>">
                        <img style="height: 200px;width: 125px;margin: auto;" class="books_images" src="added_books/<?php echo $fetch_book['image']; ?>" alt="Kitap Görseli">
                    </a>
                    <div style="text-align:left;">
                        <div style="font-weight: 500; font-size:18px; text-align: center;" class="name">
                            <?php echo $fetch_book['name']; ?>
                        </div>
                    </div>
                    <div class="price">
                        Fiyat: ₺ <?php echo $discounted_price; ?>
                        <?php if ($is_discounted) { ?>
                            <span style="color: red; font-weight: bold; font-size: 16px;">%25 İndirim!</span>
                        <?php } ?>
                    </div>
                    <form action="" method="POST">
                        <input type="hidden" name="book_name" value="<?php echo $fetch_book['name']; ?>">
                        <input type="hidden" name="book_id" value="<?php echo $fetch_book['bid']; ?>">
                        <input type="hidden" name="book_image" value="<?php echo $fetch_book['image']; ?>">
                        <input type="hidden" name="book_price" value="<?php echo $fetch_book['price']; ?>">
                        <button onclick="myFunction()" name="add_to_cart">
                            <img src="./images/cart2.png" alt="Sepete Ekle">
                        </button>
                        <a href="book_details.php?details=<?php echo $fetch_book['bid']; ?>" class="update_btn">Daha Fazla</a>
                    </form>
                </div>
        <?php
            }
        } else {
            echo '<p class="empty">Henüz ürün eklenmedi!</p>';
        }
        ?>
    </div>
</section>

    <?php include 'index_footer.php'; ?>

    <script>
        setTimeout(() => {
            const box = document.getElementById('messages');

            // 👇️ öğeyi gizler (sayfada hala yer kaplar)
            box.style.display = "none";
        }, 4000);
    </script>
</body>

</html>
