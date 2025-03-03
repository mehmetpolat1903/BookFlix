<head>
    <style>
        * {
            text-decoration: none;
            list-style: none;
            color: black;
        }

        footer {
    background-color: rgba(200, 200, 200, 0.8); /* Açık gri */
}


        h2 {
            font-size: 20px;
            font-weight: 700;
        }

        .flex {
            display: flex;
        }

        ul li:not(:first-child) {
            padding: 5px;
        }

        .short_links ul {
            margin: 0 110px;
        }
        .sub_main .dropdown .dropbtn {
            border: none;
            cursor: pointer;
        }

        /* Dropdown içerik container'ı */
        .sub_main .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Dropdown içeriği (Varsayılan olarak gizli) */
        .sub_main .dropdown .dropdown-content {
            display: none;
            position: absolute;
            background-color: #CCCCCC;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        /* Dropdown içindeki bağlantılar */
        .sub_main .dropdown .dropbtn  .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Dropdown bağlantılarında hover (üzerine gelince) rengi değiştir */
        .sub_main .dropdown .dropbtn .dropdown-content a:hover {background-color: #f1f1f1}

        /* Dropdown menüsünü hover ile göster */
        .sub_main .dropdown:hover .dropdown-content {
            display: flex;
            flex-direction: column;
        }
    </style>
    <link rel="stylesheet" href="./css/hello.css">
</head>

<footer style="margin: 30px auto 0;">
    <div class="main" style="align-items:center; padding:40px; ">
        <div class="sub_main">
            <div class="short_links flex" style="justify-content:center; ">
                <ul>
                    <h2>Hızlı Linkler</h2>
                    <li><a href="index.php">Ana Sayfa</a></li>
                    <li>
                        <div class="dropdown">
                            <a class="dropbtn">Kategori🔻</a>
                            <div class="dropdown-content">
                                <a href="index.php#Adventure">Macera</a>
                                <a href="index.php#Magical">Büyülü</a>
                                <a href="index.php#Knowledge">Bilgi</a>
                            </div>
                        </div>
                    </li>
                    <li><a href="about-us.php">Hakkımızda</a></li>
                </ul>
                <?php
                if(isset($_SESSION['user_name'])){echo'
                <ul class="account">
                    <h2>Hesap</h2>
                    <li><a href="">Profil</a></li>
                    <li><a href="cart.php">Sepet</a></li>
                    <li><a href="orders.php">Sipariş Geçmişi</a></li>
                    <li><a href="logout.php">Çıkış Yap</a></li>
                </ul>';}
                ?>
                <ul>
                    <h2>İletişim</h2>
                    <li><a href="contact-us.php">İletişim Formu</a></li>
                    <li>+905324851596</li>
                    <li>email mcbu@ogr.cbu.edu.tr</li>
                    <li>Adres: Manisa Celal Bayar Ünşversitesi Bilgisayar Programcılığı Bölümü</li>
                </ul>

            </div>
        </div>
        <div style=" align-items:center; justify-content:center; margin:20px 0 0 ;" class="cmsg flex">
            <p>Alperen Şen ve Mehmet Polat tarafından yapılmıştır  | Telif Hakkı &copy; <script>
                    document.write(new Date().getFullYear())
                </script> Tüm Haklar Saklıdır &nbsp</p>
            <div style="font-size: 30px;" class="logo">
                <a href="index.php"><span style="font-size: 15px;"> Kitap & </span>
                    <span class="me" style="font-size: 15px;">Molam</span></a>
            </div> 
        </div>
    </div>
</footer>
