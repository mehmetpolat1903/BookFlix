<?php include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'] ?? null;

if (!$admin_id) {
    header('location:login.php'); // Giriş yapmayanları login.php'ye yönlendir
    exit; // Kodun geri kalanını çalıştırmayı durdur
}

$users_no = $conn->query("SELECT * FROM users_info ") or die('sorgu hatası');
$usercount = mysqli_num_rows( $users_no );
$admin_no = $conn->query("SELECT * FROM users_info WHERE user_type='Admin' ") or die('sorgu hatası');
$admin_count = mysqli_num_rows( $admin_no );
$books_no = $conn->query("SELECT * FROM book_info ") or die('sorgu hatası');
$bookscount = mysqli_num_rows( $books_no );
$orders = $conn->query("SELECT * FROM confirm_order ") or die('sorgu hatası');
$orders_count = mysqli_num_rows( $orders );
$msg_no = $conn->query("SELECT * FROM msg ") or die('sorgu hatası');
$msgcount = mysqli_num_rows( $msg_no );

// Sipariş tarihlerini ve kazançları çekme
$order_data = $conn->query("SELECT order_date, total_price FROM confirm_order ORDER BY order_date DESC LIMIT 7") or die('sorgu hatası');
// Sipariş tarihlerini ve kazancı veritabanından çekme
$order_data = $conn->query("SELECT order_date, total_price FROM confirm_order ORDER BY order_date DESC LIMIT 7") or die('sorgu hatası');
$order_dates = [];
$total_prices = [];
while ($row = $order_data->fetch_assoc()) {
    $order_dates[] = $row['order_date'];
    $total_prices[] = $row['total_price'];
}
?>



<!DOCTYPE html>
<html lang="tr">
  <head>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/admin.css" />
    <title>KitapMolam Admin</title>
    <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap");

    * {
      text-decoration: none;
      margin: 0;
      padding: 0;
      font-family: "Poppins", sans-serif;
      box-sizing: border-box;
      outline: none;
      border: none;
    }

    body {
      background: linear-gradient(to right, #f7f4f0, #e9e4d4); /* Krem rengi ve beyaz geçiş */
      background-size: cover;
      background-position: center;
      color: #333;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      position: relative;
    }

   

    header {
      background: #f2f1f1;
      display: flex;
      justify-content: space-between;
      padding: 10px 1%;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
      border-bottom: 3px solid #ddd;
    }

    .logo a {
      display: flex;
      cursor: pointer;
    }

    .logo a span {
      color: rgb(255, 5, 5);
      font-weight: bold;
      font-size: 40px;
    }

    .logo a .me {
      color: black;
      font-weight: 500;
    }

    .nav a {
      padding: 0.5rem 1rem;
      color: rgb(2, 120, 238);
      font-weight: 600;
      transition: 0.3s ease;
    }

    .nav a:hover {
      color: rgb(255, 0, 0);
      border-bottom: 3px solid black;
    }

    header .right {
      align-items: center;
      display: flex;
    }

    header .right .Btn {
      color: rgb(15, 155, 248);
      margin: 0 15px;
      padding: 5px 3px;
      font-size: 25px;
      font-weight: 600;
      transition: 0.3s ease;
    }

    header .right .Btn:hover {
      color: rgb(255, 6, 6);
      border-bottom: 3px solid #0e0e0d;
    }

    header .right .log_info {
      font-size: 25px;
    }

    /* ************* Yönetici Ana Sayfa Bölümü ************************** */
    .main_box {
      display: grid;
      grid-template-columns: repeat(auto-fit, 17rem);
      justify-content: center;
      gap: 1.5rem;
      max-width: 1200px;
      margin: 0 auto;
      align-items: flex-start;
    }

    .card {
      position: relative;
      display: flex;
      flex-direction: column;
      background-color: #fff;
      border-radius: 1rem;
      border: 2px solid rgb(9, 218, 255);
      height: 362px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3);
    }

    .card-img-top {
      width: 64%;
      height: 130px;
      margin: auto;
      border-top-left-radius: 1rem;
      border-top-right-radius: 1rem;
    }

    .card img {
      vertical-align: middle;
      border-style: none;
      border-radius: 0.5rem;
    }

    .card-body {
      flex: 1;
      padding: 1.25rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .card-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .card-body h5 {
      font-size: 1.25rem;
      font-weight: 500;
      margin-bottom: 1rem;
    }

    .card-body p {
      font-size: 35px;
      font-weight: 700;
      margin: 0;
      color: #333;
    }

    .btn-primary {
      color: #fff;
      background-color: rgb(68, 109, 245);
      border-color: rgb(14, 13, 13);
    }

    .btn {
      font-weight: 400;
      padding: 0.375rem 0.75rem;
      font-size: 13px;
      border-radius: 0.25rem;
      transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out;
    }

    a {
      color: #ff0000;
      text-decoration: none;
      background-color: transparent;
    }
  </style>
  </head>

  <body>

    <?php include 'admin_header.php'; ?>
    <br/>
    
    
    
    <div class="main_box">
      
        <!-- Kartlar Kısmı (Mevcut Kodunuz) -->
        
        <div class="card" style="width: 15rem">
            <?php
                $total_pendings = 0;
                $select_pending = mysqli_query($conn, "SELECT total_price FROM `confirm_order` WHERE payment_status = 'pending'") or die('sorgu hatası');
                $total_completed = 0; // Başlangıç değeri ekledik

// Tamamlanan siparişleri sorgulama
$select_completed = mysqli_query($conn, "SELECT total_price FROM `confirm_order` WHERE payment_status = 'completed'") or die('sorgu hatası');

// Eğer sorgu sonuç döndürürse
if (mysqli_num_rows($select_completed) > 0) {
    while ($fetch_completed = mysqli_fetch_assoc($select_completed)) {
        $total_price = $fetch_completed['total_price'];
        $total_completed += $total_price; // Toplamı güncelle
    }
}

                if(mysqli_num_rows($select_pending) > 0){
                    while($fetch_pendings = mysqli_fetch_assoc($select_pending)){
                        $total_price = $fetch_pendings['total_price'];
                        $total_pendings += $total_price;
                    };
                };
            ?>
            <img class="card-img-top" src="./images/pen3.png" alt="Kart resmi" /> 
            <div class="card-body">
                <h5 class="card-title">Bekleyen Sipariş Fiyat (tl)</h5>
                <p class="card-text"> 
                <?php echo $total_pendings ?>
                </p>
                <div class="buttons" style="display: flex;">
                <a href="admin_orders.php" class="btn btn-primary">Detaylar</a>
                </div>
            </div>
        </div>

        <!-- Diğer Kartlar Kısmı (Mevcut Kodunuz) -->
        <div class="card" style="width: 15rem">
            <img class="card-img-top" src="./images/compn.png" alt="Kart resmi" />
            <div class="card-body">
                <h5 class="card-title">Tamamlanan Siparişler Sayısı</h5>
                <p class="card-text">
                <?php echo $total_completed; ?>
                </p>
                <div class="buttons" style="display: flex;">
                <a href="admin_orders.php" class="btn btn-primary">Detaylar</a>
                </div>
            </div>
        </div>

        <div class="card" style="width: 15rem">
            <img class="card-img-top" src="./images/orderpn.png" alt="Kart resmi" />
            <div class="card-body">
                <h5 class="card-title">Alınan Siparişler Sayısı</h5>
                <p class="card-text">
                <?php echo $orders_count; ?>
                </p>
                <a href="admin_orders.php" class="btn btn-primary">Detaylar</a>
            </div>
        </div>

        <div class="card" style="width: 15rem">
            <img class="card-img-top" src="./images/nu. books.png" alt="Kart resmi" />
            <div class="card-body">
                <h5 class="card-title">Mevcut Kitap Sayısı</h5>
                <p class="card-text">
                    <?php echo $bookscount; ?>
                </p>
                <div class="buttons">
                    <a href="total_books.php" class="btn btn-primary">Kitapları Gör</a>
                    <a href="add_books.php" class="btn btn-primary">Kitap Ekle</a>
                </div>
            </div>
        </div>

        <!-- Diğer Kartlar Kısmı (Mevcut Kodunuz) -->
        <div class="card" style="width: 15rem">
            <img class="card-img-top" src="./images/whatpm.png" alt="Kart resmi" />
            <div class="card-body">
                <h5 class="card-title">Kullanıcı Mesajları Sayısı</h5>
                <p class="card-text">
                <?php echo $msgcount; ?>
                </p>
                <a href="message_admin.php" class="btn btn-primary">Detaylar</a>
            </div>
        </div>

        <div class="card" style="width: 15rem">
            <img class="card-img-top" src="./images/adminpn2.png" alt="Kart resmi" />
            <div class="card-body">
                <h5 class="card-title">Kayıtlı Admin Sayısı</h5>
                <p class="card-text">
                    <?php echo $admin_count; ?>
                </p>
                <a href="users_detail.php" class="btn btn-primary">Detaylar</a>
            </div>
        </div>

        <div class="card" style="width: 15rem">
            <img class="card-img-top" src="./images/userspm.png" alt="Kart resmi" />
            <div class="card-body">
                <h5 class="card-title">Kayıtlı Kullanıcı Sayısı</h5>
                <p class="card-text">
                    <?php echo $usercount; ?>
                </p>
                <a href="users_detail.php" class="btn btn-primary">Detaylar</a>
            </div>
        </div>
        <style>
        /* Kartın arka planını ve kenarlığını kaldırma */
        .card {
            background-color: transparent; /* Şeffaf arka plan */
            box-shadow: none; /* Kart gölgesini kaldırma */
            border: none; /* Kenarlığı kaldırma */
        }

        /* Başlık stilini güncelleme */
        .card-title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }
        
    </style>
</head>
<body>
  <!-- PHP Kısmı (Sipariş verilerini çekiyoruz) -->
<?php
$order_data = $conn->query("SELECT order_date, total_price FROM confirm_order ORDER BY order_date ASC") or die('sorgu hatası');
$order_dates = [];
$total_prices = [];

if (mysqli_num_rows($order_data) > 0) {
    while ($row = mysqli_fetch_assoc($order_data)) {
        $order_dates[] = $row['order_date'];
        $total_prices[] = $row['total_price'];
    }
}
?>
  

    <!-- En Çok Sipariş Edilen Kitaplar Pasta Grafiği -->
    <div class="card" style="width: 25rem; margin-top: 30px; padding: 20px;">
        <div class="card-body">
            <h5 class="card-title">En Çok Sipariş Edilen Kitaplar</h5>
            <canvas id="topBooksChart" width="1000" height="1000"></canvas>
        </div>
    </div>

    <?php
    // Veritabanı bağlantısı
    $conn = new mysqli('localhost', 'root', '', 'bookflixdb');
    if ($conn->connect_error) {
        die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
    }

    // En çok sipariş edilen 7 kitabı sorgulama
    $query = "
        SELECT 
            total_books AS book_name, 
            COUNT(total_books) AS order_count 
        FROM 
            confirm_order 
        GROUP BY 
            total_books 
        ORDER BY 
            order_count DESC 
        LIMIT 7
    ";
    $result = $conn->query($query);

    $bookNames = [];
    $orderCounts = [];

    // Veriyi toplama
    while ($row = $result->fetch_assoc()) {
        $bookNames[] = $row['book_name'];
        $orderCounts[] = $row['order_count'];
    }

    // Veriyi JSON formatında dönüştürme
    $books = json_encode(['names' => $bookNames, 'sales' => $orderCounts]);

    $conn->close();
    ?>

    <script>
        // PHP'den gelen JSON verisini alıyoruz
        var topBooksData = <?php echo $books; ?>;

        // Kitap isimlerini ve satış miktarlarını alıyoruz
        var bookNames = topBooksData.names;
        var salesData = topBooksData.sales;

        // Pasta grafiği için Chart.js verisi
        var ctx = document.getElementById('topBooksChart').getContext('2d');
        var topBooksChart = new Chart(ctx, {
            type: 'pie', // Pasta grafiği tipi
            data: {
                labels: bookNames, // Kitap isimleri
                datasets: [{
                    label: 'Toplam Sipariş',
                    data: salesData, // Kitap sipariş miktarları
                    backgroundColor: [
                        '#FF5733', '#33FF57', '#3357FF', 
                        '#FFFF33', '#FF33A8', '#33FFFF', '#FF5733'
                    ], // Renkler
                    borderColor: ['#FFFFFF'], // Kenarlık rengi
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' sipariş';
                            }
                        }
                    }
                }
            }
        });
    </script>
<!-- HTML Kısmı -->
<!-- Sipariş Kazanç Grafiği -->
<div id="orderChartContainer" style="margin: 90px auto;">
    <h3 style="text-align: center;">Sipariş Kazanç Grafiği</h3>
    <canvas id="orderChart" style="width: 120% !important; height: 500px;"></canvas>
</div>

<!-- JavaScript Kısmı (Chart.js kullanarak grafik oluşturma) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // PHP'den alınan verileri JavaScript'e aktarma
    const orderDates = <?php echo json_encode($order_dates); ?>;
    const totalPrices = <?php echo json_encode($total_prices); ?>;

    // Canvas öğesini doğrudan alıp grafik oluşturma
    new Chart('orderChart', {
        type: 'bar',
        data: {
            labels: orderDates, // X ekseni: Tarihler
            datasets: [{
                label: 'Toplam Kazanç (TL)', // Grafiğin etiketi
                data: totalPrices, // Y ekseni: Kazançlar
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true, // Mobil uyumluluk
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Sipariş Tarihleri',
                        font: {
                            size: 16,  // X eksenindeki yazının büyüklüğü
                            weight: 'bold',  // Yazının kalınlığı
                        }
                    },
                    ticks: {
                        font: {
                            size: 14,  // X eksenindeki etiketlerin yazı büyüklüğü
                            weight: 'normal',  // Etiketlerin kalınlık ayarı
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Toplam Kazanç (TL)',
                        font: {
                            size: 16,  // Y eksenindeki yazının büyüklüğü
                            weight: 'bold',  // Yazının kalınlığı
                        }
                    },
                    ticks: {
                        font: {
                            size: 14,  // Y eksenindeki etiketlerin yazı büyüklüğü
                            weight: 'normal',  // Etiketlerin kalınlık ayarı
                        }
                    }
                }
            }
        }
    });
</script>
</body>
</html>
<?php
include 'config.php';

// Stoğu 50'nin altında olan kitapları sorgulama
$query = "SELECT name, stock FROM book_info WHERE stock < 50";
$result = $conn->query($query);

$lowStockBooks = [];
$lowStockCounts = [];

// Veriyi PHP dizilerine ekliyoruz
while ($row = $result->fetch_assoc()) {
    $lowStockBooks[] = $row['name'];  // Kitap ismini diziye ekliyoruz
    $lowStockCounts[] = $row['stock'];  // Stok miktarını diziye ekliyoruz
}

// Veriyi JSON formatında JavaScript'e aktarmak için
$lowStockBooksJson = json_encode($lowStockBooks);
$lowStockCountsJson = json_encode($lowStockCounts);

// Veritabanı bağlantısını kapatıyoruz
$conn->close();
?>
<style>
    /* Grafik kapsayıcı sınıfı */
    #lowStockChartContainer {
        width: 150%;  /* Grafik genişliği %100, ekranın tamamını kapsayacak şekilde */
        height: 450px;  /* Grafik yüksekliği 400px */
        margin-top: 100px;  /* Üstten 30px boşluk */
        margin-left: 40mm;  /* Grafiği 2mm sağa kaydırma */
    }
</style>
</head>
<body>
   
    <div id="lowStockChartContainer">
        <canvas id="lowStockChart"></canvas> <!-- Grafik canvas'ı -->
    </div>

    <script>
        // PHP'den gelen JSON verisini JavaScript'e aktarıyoruz
        var lowStockBooks = <?php echo $lowStockBooksJson; ?>;
        var lowStockCounts = <?php echo $lowStockCountsJson; ?>;

        // Grafik için canvas öğesini alıyoruz
        var ctx = document.getElementById('lowStockChart').getContext('2d');
        
        // Huni şeklinde stil için chart.js'i bar grafikle yapılandırıyoruz
        var lowStockChart = new Chart(ctx, {
            type: 'bar', // Bar grafik tipi kullanıyoruz
            data: {
                labels: lowStockBooks, // Kitap isimleri
                datasets: [{
                    label: 'Stok Miktarı',  // Grafikte görünen etiket
                    data: lowStockCounts,  // Kitapların stok miktarları
                    backgroundColor: 'rgba(139, 0, 0, 0.7)', // Bordo renk, şeffaflık 70%
                    borderColor: 'rgba(139, 0, 0, 1)', // Bordo kenar rengi
                    borderWidth: 1,  // Kenar kalınlığı
                    borderRadius: 50, // Kenarları yuvarlaklaştırarak huni şekli oluşturuyoruz
                }]
            },
            options: {
                responsive: true, // Grafik mobil uyumlu olacak
                maintainAspectRatio: false, // Aspect ratio'yu tutmuyoruz
                indexAxis: 'y', // Y ekseni boyunca yatay huni şeklinde gösterim
                scales: {
                    x: {
                        beginAtZero: true,  // X ekseninin sıfırdan başlaması
                        title: {
                            display: true,
                            text: 'Stok Miktarı',  // X ekseninin başlığı
                            font: {
                                size: 16,  // X ekseni başlık yazısının büyüklüğü
                                weight: 'bold'  // X ekseni başlık yazısının kalınlığı
                            }
                        },
                        ticks: {
                            font: {
                                size: 14  // X ekseni etiket yazılarının büyüklüğü
                            }
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Kitaplar',  // Y ekseninin başlığı
                            font: {
                                size: 16,  // Y ekseni başlık yazısının büyüklüğü
                                weight: 'bold'  // Y ekseni başlık yazısının kalınlığı
                            }
                        },
                        ticks: {
                            font: {
                                size: 14  // Y ekseni etiket yazılarının büyüklüğü
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>

