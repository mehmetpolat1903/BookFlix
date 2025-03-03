<!DOCTYPE html>
<html lang="tr">
  <link rel="stylesheet" href="./css/hello.css">
  <style>
  /* Arka Plan */
body {
    background: linear-gradient(135deg, #3f5efb, #fc466b);
    min-height: 100vh;
    width: 100%;
    background-size: cover;
    background-attachment: fixed;
    overflow-x: hidden;
    position: relative;
    box-shadow: inset 0 0 50px rgba(0, 0, 0, 0.3); /* Gölgeleme efekti */
}

/* Noise Efekti */
body::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url("https://www.transparenttextures.com/patterns/noise.png");
    opacity: 0.05;
    z-index: 1;
    pointer-events: none;
}

/* Header */
header {
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 2%;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    border-bottom: 2px solid #ddd;
    position: sticky;
    top: 0;
    z-index: 1000;
}

/* Logo etrafındaki siyah kenarlıkları kaldır */
.logo a {
    font-size: 32px !important;
    font-weight: 700 !important;
    color: #fff !important;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4) !important;
    border: none !important; /* Siyah kenarlık kaldırıldı */
    padding: 0 !important; /* Padding sıfırlandı */
}
.logo a span {
    color: #fc466b;
}

/* Navigasyon */
.nav a {
    font-size: 18px;
    color: #3f5efb;
    padding: 8px 16px;
    border-radius: 5px;
    transition: all 0.3s ease;
}
.nav a:hover {
    color: white;
    background: #3f5efb;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}


/* Ürün Kutuları */
.show-products {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    min-height: 80vh; /* Sayfanın ortasında tutmak için */
}

.show-products .box-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    max-width: 1200px; /* İçeriği ortalamak için genişlik sınırlaması */
}

.show-products .box {
    background: rgba(255, 255, 255, 0.9);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3); /* Kutulara gölge ekledim */
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    transform: scale(1);
    position: relative;
    overflow: hidden;
}

.show-products .box:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4); /* Hover gölgesi */
}

/* Butonlar */
button, .update_btn, .delete_btn {
    background: linear-gradient(45deg, #3f5efb, #fc466b);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}
button:hover, .update_btn:hover, .delete_btn:hover {
    background: linear-gradient(45deg, #fc466b, #3f5efb);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

/* Bildirim */
.message {
    position: fixed;
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(255, 255, 255, 0.9);
    padding: 10px 20px;
    border-radius: 10px;
    border: 2px solid #3f5efb;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.message span {
    font-size: 16px;
    color: #fc466b;
    font-weight: 500;
}
.message i {
    cursor: pointer;
    color: #3f5efb;
    font-size: 18px;
}
/*iletişim formu*/
.contact-form-btn {
    background: linear-gradient(45deg, #4CAF50, #2C6B30); /* Daha doğal bir yeşil geçiş */
    color: white;
    border-radius: 15px; /* Daha yumuşak köşeler */
    padding: 10px 25px; /* Daha kompakt buton */
    font-weight: 600; /* Daha belirgin yazı */
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); /* Hafif daha belirgin gölge */
}
.contact-form-btn:hover {
    background: linear-gradient(45deg, #2C6B30, #4CAF50); /* Geçiş yönünü tersine çevir */
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4); /* Daha güçlü gölge */
}

/*sub menü ksımı*/
.sub-menu-wrap {
    position: fixed;
    top: 10%; /* Yüksekliği biraz daha aşağıya al */
    right: 2%; /* Menü sağa doğru kaydırılmış */
    width: 280px; /* Menü genişliği biraz daha küçük */
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s ease-in-out;
    z-index: 100;
}
.sub-menu-wrap.open-menu {
    max-height: 350px; /* Menü görünür olduğunda daha kısa */
}
.sub-menu {
    background: #f8f8f8; /* Daha açık gri arka plan */
    padding: 15px;
    margin: 5px;
    border-radius: 10px; /* Daha yuvarlak köşeler */
}

    .user-info {
      display: flex;
      align-items: center;
    }
    .user-info h3 {
      font-weight: 500;
    }
    .user-info img {
      width: 60px;
      border-radius: 50%;
      margin-right: 15px;
    }
    .sub-menu hr {
      border: 0;
      height: 1px;
      width: 100%;
      background: #ccc;
      margin: 15px 10px;
    }
    .sub-menu-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #444444; /* Daha koyu metin rengi */
    margin: 12px 0;
    padding: 8px 12px; /* Öğelere daha fazla iç boşluk ekler */
    background: #f8f8f8; /* Yumuşak bir arka plan rengi */
    border-radius: 8px; /* Kenarları yuvarlatır */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Hafif bir gölge efekti */
    transition: background-color 0.3s ease; /* Arka plan rengini yumuşak bir şekilde değiştirir */
}

.sub-menu-link p {
    width: 100%;
    font-size: 18px; /* Yazı boyutunu uygun tutar */
    margin: 0; /* Varsayılan margin'i sıfırlar */
}

.sub-menu-link img {
    width: 35px; /* Daha küçük resimler */
    background: #dcdcdc; /* Daha yumuşak gri arka plan */
    border-radius: 50%; /* Yuvarlak resimler */
    padding: 6px;
    margin-right: 12px; /* Resim ile yazı arasına boşluk bırakır */
}

.sub-menu-link span {
    font-size: 20px; /* Simge boyutunu küçük tutar */
    transition: transform 0.3s ease; /* Simge hareketini yumuşatır */
}

.sub-menu-link:hover {
    background-color: #e0e0e0; /* Hover durumunda arka plan rengini değiştirir */
}

.sub-menu-link:hover span {
    transform: translateX(8px); /* Simge biraz daha fazla hareket eder */
}

.sub-menu-link:hover p {
    font-weight: 700; /* Hover durumunda yazıyı kalın yapar */
}


.link_btn {
    background-color: #8B4513; /* Kahverengi yerine daha yumuşak bir ton */
    padding: 8px 15px; /* Daha geniş buton */
    border-radius: 12px; /* Daha yuvarlak köşeler */
    margin-left: 12px;
    color: white;
    font-weight: 600; /* Yazıyı daha belirgin yap */
}

  </style>
<body>
  <header>
    <div class="logo">
      <a href="index.php">
        <span>Kitap&</span>
        <span class="me">Molam</span>
      </a>
    </div>
    <div class="nav">
      <a href="index.php">Ana Sayfa</a>
      <div class="dropdown">

        <div class="dropdown-content">
  <?php
  $categories_query = mysqli_query($conn, "SELECT DISTINCT category FROM book_info");
  while ($category = mysqli_fetch_assoc($categories_query)) {
      $category_name = $category['category'];
      echo '<a href="index.php#' . urlencode($category_name) . '">' . htmlspecialchars($category_name) . '</a>';
  }
  ?>
</div>

      </div>
      <a href="contact-us.php">İletişim</a>
      <a href="cart.php">Sepet</a>
      <a href="orders.php">Siparişler</a>
    </div>
    <div class="user-box" style="display: flex; align-items:center;">
      <a class="Btn" href="search_books.php">
        <img style="height:30px;" src="./images/sea2.png" alt="">
      </a>
      <?php 
      if (isset($_SESSION['user_name'])) {
        echo '<img style="height:40px; margin-left:10px;" src="images/ds2.png" class="user-pic" onclick="toggleMenu()" />';
      } else {
        echo '<div class="use_links">
          <a class="link_Btn" style="background-color: rgb(0, 167, 245); padding: 6px; border-radius: 10px; margin-left: 10px; color: white; font-weight: 500;" href="login.php">Giriş Yap</a>
          <a class="link_Btn" style="background-color: rgb(0, 167, 245); padding: 6px; border-radius: 10px; margin-left: 10px; color: white; font-weight: 500;" href="register.php">Kayıt Ol</a>
        </div>';
      }
      ?>
    </div>
  </header>
  <div class="sub-menu-wrap" id="subMenu">
    <div class="sub-menu">
      <div class="user-info">
        <img src="images/ds2.png" />
        <div class="user-info" style="display: block;">
          <h3>Merhaba, <?php echo $_SESSION['user_name'] ?></h3>
          <h6><?php echo $_SESSION['user_email'] ?></h6>
        </div>
      </div>
      <hr />
      <a href="cart.php" class="sub-menu-link">
        <p>Sepet</p>
        <span>></span>
      </a>
      <a href="contact-us.php" class="sub-menu-link">
        <p>İletişim</p>
        <span>></span>
      </a>
      <a href="orders.php" class="sub-menu-link">
        <p>Sipariş Geçmişi</p>
        <span>></span>
      </a>
      <a href="logout.php" class="sub-menu-link">
        <p style="background-color: red; border-radius:9px; text-align:center; color:white; font-weight:500; margin-top:5px; padding:5px;">Çıkış Yap</p>
      </a>
    </div>
  </div>
  <script>
    let subMenu = document.getElementById("subMenu");
    function toggleMenu() {
      subMenu.classList.toggle("open-menu");
    }
  </script>
</body>
</html>
