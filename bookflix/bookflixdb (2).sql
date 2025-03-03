-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 13 Oca 2025, 09:54:26
-- Sunucu sürümü: 10.4.27-MariaDB
-- PHP Sürümü: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `bookflixdb`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `book_info`
--

CREATE TABLE `book_info` (
  `bid` int(100) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `price` decimal(10,0) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `stock` int(11) NOT NULL DEFAULT 100,
  `discount` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `book_info`
--

INSERT INTO `book_info` (`bid`, `name`, `title`, `price`, `category`, `description`, `image`, `date`, `stock`, `discount`) VALUES
(1, 'Türk Tarihi', 'Prof. Dr. Ahmet Yaramış', '50', 'Tarih', 'Türklerin tarihsel gelişimini, kültürel, sosyal ve siyasi evrimlerini anlatan kapsamlı bir çalışmadır. Türklerin Orta Asya’dan Anadolu’ya kadar olan yolculukları ele alınır.', 'turk.jpeg', '2024-12-10 21:21:34', 97, '0.00'),
(4, 'Madame Bovary', 'Gustave Flaubert', '45', 'Dünya Klasikleri', 'Emma Bovary\'nin, sıkıcı ve memnuniyetsiz evliliğinden kaçma çabaları ve arzuları üzerine kurulu bir hikaye. Toplumun ve bireylerin romantizmle olan ilişkisini sorgular.', 'madambovary.jpeg', '2024-12-10 21:21:34', 96, '0.00'),
(5, 'Yüzyıllık Yalnızlık', 'Gabriel García Márquez', '55', 'Dünya Klasikleri', 'Kolombiya\'daki hayali Macondo kasabasında geçen ve Buendía ailesinin kuşaklar boyu süren hikayesini anlatan bu eser, büyülü gerçekçilik akımının en önemli örneklerinden biridir.', 'yuzyıllık.jpg', '2024-12-10 21:21:34', 33, '0.00'),
(6, 'Karamazov Kardeşler', 'Fyodor Dostoyevski', '70', 'Dünya Klasikleri', 'Aile bağları, din, özgür irade ve suçluluk temaları etrafında dönen bir psikolojik dramadır. Karamazov ailesinin üç kardeşi ve babaları arasındaki ilişkiler üzerinden felsefi tartışmalar yapılır.', 'karamazov.jpg', '2024-12-10 21:21:34', 99, '0.00'),
(7, '1984', 'George Orwell', '50', 'Dünya Klasikleri', 'Totaliter bir rejimin hâkim olduğu bir gelecekte, özgürlüklerin yok olduğu bir dünyayı anlatır. \"Büyük Birader\" ve sürekli izlenme konusu, bireysel özgürlükleri sorgular.', '1984.png', '2024-12-10 21:21:34', 2, '0.00'),
(8, 'Büyük Umutlar', 'Charles Dickens', '60', 'Dünya Klasikleri', 'Yoksul bir çocuğun, Pip\'in yaşamını ve toplumdaki yeriyle mücadelesini anlatır. Aynı zamanda aşk ve hırsın insanı nasıl şekillendirdiği üzerine derin bir bakış sunar.', 'umut.png', '2024-12-10 21:21:34', 96, '0.00'),
(9, 'İnce Memed', 'Yaşar Kemal', '55', 'Türk Klasikleri', 'Köyünden ayrılan İnce Memed\'in, zulme karşı mücadelesi anlatılır. Türk köylüsünün hayatı ve direnişi üzerinden toplumsal yapıyı ele alır.', 'ince.jpg', '2024-12-10 21:21:34', 7, '0.00'),
(10, 'Safahat', 'Mehmet Akif Ersoy', '40', 'Türk Klasikleri', 'Akif\'in şiirlerinden oluşan bu eser, toplumsal eleştiriler ve dini temalarla Türk milletinin manevi yapısını sorgular.', 'saf.jpeg', '2024-12-10 21:21:34', 24, '0.00'),
(11, 'Yalnızız', 'Peyami Safa', '50', 'Türk Klasikleri', 'İnsanların yalnızlık, iletişimsizlik ve kimlik arayışlarını işleyen bir roman. Türk toplumunun modernleşme sürecinde yaşadığı bunalımları ele alır.', 'yalnız.jpg', '2024-12-10 21:21:34', 3, '0.00'),
(12, 'Kuyucaklı Yusuf', 'Sabahattin Ali', '45', 'Türk Klasikleri', 'Aşk, kıskanlık ve haksızlık üzerine bir köy hikayesidir. Kuyucaklı Yusuf\'un zorlu yaşamını ve toplumsal eşitsizlikleri sorgular.', 'ali.jpg', '2024-12-10 21:21:34', 93, '0.00'),
(100, 'SEFİLLER', 'Victor Hugo', '400', 'Dünya Klasikleri', 'Fransa\'nın sosyal ve politik yapısını ele alarak, aşk, adalet, fedakarlık ve insanlık hallerini derinlemesine işler. Jean Valjean\'ın cezalandırılma süreci etrafında şekillenen epik bir hikayedir.', 'sefiller.jpg', '2024-12-04 16:30:19', 98, '0.00'),
(103, 'Don Kişot', 'Miguel de Cervantes', '150', 'Dünya Klasikleri', ' İdealist bir şövalye olan Don Kişot\'un, gerçeği ve hayali birbirinden ayıramayarak gerçekleştirdiği çılgınca serüvenler üzerinden insan doğası ve toplum eleştirisi yapılır.', 'don_kisot-1398.jpg', '2024-12-10 16:48:47', 4, '0.00'),
(106, 'Kara Kitap', 'Orhan Pamuk', '145', 'Türk Klasikleri', ' İstanbul\'da bir dedektifin kaybolan eşini bulmak için çıktığı yolculuk, kimlik, sevda ve bilinçaltı üzerine derin bir sorgulamadır.', 'kara kitap.jpg', '2024-12-10 20:57:05', 109, '0.00'),
(110, 'Evrenin Zerafeti', 'Biran Greene', '138', 'Bilimsel', ' Evrenin temel yapı taşlarını ve fiziksel yasalarını anlatan popüler bir bilim kitabıdır.', 'evrenin zarafeti.jpg', '2024-12-10 21:03:44', 97, '0.00'),
(112, 'Osmanlı Gerçekleri', 'Ahmet Şimşirgil', '175', 'Tarih', 'KAYI serisi ile 7’den 70’e herkese ulaşan Prof. Dr. Ahmet Şimşirgil, şimdi de OSMANLI GERÇEKLERİ başlıklı yepyeni bir seriyi okuyucularının beğenisine sunuyor. Şimşirgil, bu seriyle Osmanlı’nın kuruluşundan yıkılışına kadarki dönemle alakalı herkesin aklına takılan birçok soruya yine akıcı üslubu, temel kaynak referanslarla cevap verecek…\r\n\r\n \r\n\r\n* Osmanlı’yla Kayı boyunun ilişkisi nedir?\r\n\r\n* Ertuğrul Gazi, Muhyiddin İbnü’l-Arâbî ile karşılaştı mı? \r\n\r\n* Osmanlı İmparatorluğu Selçukluların devamı mıdır?\r\n\r\n * Osmanlı devlet adamlarının yetiştiği Enderun nasıl bir mektepti?\r\n\r\n * Osmanlı padişahları neden hacca gitmiyordu?\r\n\r\n * Yıldırım Bayezid ve Timur Han neden karşı karşıya geldiler?\r\n\r\n * Hangi Osmanlı padişahı Kâbe-i Muazzama’ya nasıl hizmetler götürdü?\r\n\r\n * Osmanlı vakıf sitemi nasıl işliyordu ve vakfiyelerde neler yazıyor?\r\n\r\n * Devşirme sistemi nedir ve Osmanlı\'da nasıl işlerdi? \r\n\r\n* Osmanlı padişahları kardeşlerini neden katletmiştir?\r\n\r\n \r\n\r\nOSMANLI GERÇEKLERİ serisinin ilk kitabıyla, yedi iklime 600 sene adaletle hükmetmiş Osmanlı’nın tartışılan meseleleri hakkında zihninizi kurcalayan hiçbir soru cevapsız kalmayacak…\r\n\r\n ', 'os.jpg', '2024-12-17 18:37:04', 45, '0.00'),
(113, 'Babalar ve Oğulları', 'Turgenyev', '135', 'Dünya Klasikleri', 'İvan Sergeyeviç Turgenyev (1818-1883):Avrupa’da ve ülkemizde eserleri ilk çevrilen 19. yüzyıl Rus yazarlarındandır. Dönemin Avrupalı bakış açısına sahip tek Rus yazarı olarak anılır. Rus toplumsal hayatını anlatırken aristokrat ve aydınları acımasızca alaya alır. Turgenyev adı, 1862’de yayımlanan ve nihilizmin simgesine dönüşen oğul Bazarov tipini yarattığı Babalar ve Oğullar romanıyla özdeşleşmiş gibidir.\r\n\r\nErgin Altay (1937): Yusuf Ziya Ortaç’ın Akbaba dergisinde yayımlanan ilk öykü çevirisi (Zoşçenko) günümüze, son elli yılın en önemli Rusça çevirmenlerindendir. Dostoyevski ve Tolstoy kadar, Gogol, Gonçarov ve Çehov da Altay’ın yetkinlikle dilimize kazandırdığı yazarlar arasındadır.\r\n\r\nKitaptan;\r\n\r\nI\r\n\r\n— Ne o, Pyotr? Hâlâ görünürlerde yok mu?\r\nKırkını biraz geçkin bir beyefendi, 1859’un 20 Mayıs’ında şapkasız, toz içinde paltosuyla, ekose pantolonuyla …\r\nŞosesi üzerindeki hanın alçak verandasına çıkınca genç, tombul yanaklı, çenesinde sarı tüyler yeni yeni bitmiş, ufak gözleri donuk bakan uşağına böyle seslenmişti.\r\nUşak, tek kulağında firuze küpesiyle; pomatlı, renkli saçıyla, kibar tavırlarıyla, kısacası, her şeyiyle tam bir zamane genciydi. Alçakgönüllü bir tavırla yola bakarak cevap verdi:\r\n“Yok efendim, gelen giden yok!”\r\n— Yok mu? diye yineledi bey.\r\nUşak bir kez daha cevap verdi:\r\n— Yok efendim.\r\nBey iç geçirip tahta sıraya oturdu. O, sıranın üzerinde ayaklarını altına almış, dalgın dalgın çevresine bakınarak oturadursun, gelin biz okurla tanıştıralım onu…', 'babalar-ve-ogullar2f23f6a7da25410181447d010953f712.jpg', '2025-01-11 13:56:54', 40, '0.00'),
(114, 'İzafiyet Teorisi', 'Albert Einstein', '205', 'bilim', 'Zekası ile hala dünyanın en popüler bilim insanı unvanını koruyan Einstein’in, bu üne sahip olmasını sağlayan kuram ve görüşlerini anlatan İzafiyet Teorisi, evrene ilgi duyan herkesin baş ucu kitabı olmaya aday. Albert Einstein, kendi ifadesiyle bu kitabı yazarken bir lise mezununun dahi anlayabileceği, ağdalı terimlerden uzak, sade bir dili benimsemeye özen gösterdi. Bu sayede her kesimden insana ulaşmayı hedefledi. Etrafınızda kolayca elle tutup gözle göremeyeceğiniz olayların anlaşılmasını sağlayan bu özel ve genel görelilik kuramları, yaradılıştan günümüze kadar geçerliliği kanıtlanmış olan en temel kurallardandır. Dolayısıyla fikir sahibi olmak isteyen herkesin rahatlıkla okuyabileceği şekilde yazılmıştır.', 'izafiyet-teorisi.jpg', '2025-01-11 13:58:59', 99, '0.00'),
(115, 'Satranç', 'Stefen zweig', '80', 'Dünya Klasikleri', 'Satranç kitabı, temelde bir satranç maçını anlatıyor gibi görünse de aslında konusu Nazi yönetimine bir eleştiri niteliğindedir. İnsan psikolojisinin derinliklerine girmemizi sağlayan bu kitap, Stefan Zweig’ın eşiyle birlikte intihar etmeden önce yazdığı son kitap olmasıyla da dikkat çeker.', 'satranç.jpeg', '2025-01-13 10:18:17', 200, '0.00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `book_id` int(20) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(20) NOT NULL,
  `image` varchar(25) NOT NULL,
  `quantity` int(25) NOT NULL,
  `total` double(10,2) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `cart`
--

INSERT INTO `cart` (`id`, `book_id`, `user_id`, `name`, `price`, `image`, `quantity`, `total`, `date`) VALUES
(203, 1, 3, 'Türk Tarihi', 50, 'turk.jpeg', 1, 50.00, '2025-01-02 13:15:14'),
(204, 4, 3, 'Madame Bovary', 45, 'madambovary.jpeg', 1, 45.00, '2025-01-02 13:15:20'),
(212, 5, 58, 'Yüzyıllık Yalnızlık', 55, 'yuzyıllık.jpg', 4, 220.00, '2025-01-13 10:15:22'),
(213, 110, 58, 'Evrenin Zerafeti', 138, 'evrenin zarafeti.jpg', 4, 552.00, '2025-01-13 10:15:34');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `confirm_order`
--

CREATE TABLE `confirm_order` (
  `order_id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(15) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `payment_method` varchar(20) NOT NULL,
  `total_books` varchar(500) NOT NULL,
  `order_date` varchar(100) NOT NULL,
  `payment_status` varchar(100) NOT NULL DEFAULT 'pending',
  `total_price` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `confirm_order`
--

INSERT INTO `confirm_order` (`order_id`, `user_id`, `name`, `email`, `number`, `address`, `payment_method`, `total_books`, `order_date`, `payment_status`, `total_price`) VALUES
(54, 58, 'emirali', 'e@gmail.com', '05318998192', 'Toki evleri fg 2b kat 2 daire 5, DENEME, DENEME, DENEME - DENEME', 'PayPal', 'Don Kişot #103, (5), sefiller #99, (1), SEFİLLER #100, (1)', '11.01.2025', 'completed', 1350.00),
(56, 58, 'emirali', 'polatalemdar@gmail.com', '05318998192', 'DENMEE, DENEME, DENEME, DENEME - 34343', 'PayPal', 'Karamazov Kardeşler #6, (1), Madame Bovary #4, (1)', '11.01.2025', 'completed', 115.00),
(57, 58, 'emirali', 'e@gmail.com', '05020845678', 'Celal Bayar Üniversitesi, Manisa, Yunusemre, Türkiye - 45100', 'PayPal', 'Türk Tarihi #1, (4)', '11.01.2025', 'completed', 50.00),
(58, 58, 'Alperen', 'alperensen@gmail.com', '05010848765', 'Bursa Uludağ üniversitesi, Bursa, Orhangazi, Türkiye - 16200', 'PayPal', 'İnce Memed #9, (1), Evrenin Zerafeti #110, (1)', '11.01.2025', 'completed', 193.00),
(59, 58, 'Polat', 'Polat@gmail.com', '04367889765', 'Adıyaman üniversitesi, adıyaman, kahta, türkiye - 01002', 'Credit Card', 'Evrenin Zerafeti #110, (3)', '11.01.2025', 'completed', 138.00),
(60, 58, 'emirali', 'e@gmail.com', '053156782190', 'Toki evleri fg 2b kat 2 daire 5, İstanbul, üsküdar, türkiye - 28900', 'Credit Card', 'Evrenin Zerafeti #110, (1)', '10-Dec-2024', 'pending', 138.00),
(61, 63, 'Polat', 'p@gmail.com', '05020845678', 'Toki evleri fg 2b kat 2 daire 5, tekirdağ, muratlı, türkiye - 23980', 'Credit Card', 'Kuyucaklı Yusuf #12, (2)', '10-Dec-2024', 'pending', 90.00),
(62, 63, 'Polat', 'p@gmail.com', '05318998192', 'LKFSDHIFHDSIFHSDHFSD, İstanbul, Fatih, türkiye - 34500', 'Credit Card', 'Kuyucaklı Yusuf #12, (1)', '11-Dec-2024', 'pending', 45.00),
(63, 58, 'emirali', 'e@gmail.com', '05828848778', 'DENEME, DENEME, sadjk, türkiye - 10200', 'PayPal', 'Kuyucaklı Yusuf #12, (4)', '11-Dec-2024', 'pending', 180.00),
(64, 58, 'polat', 'e@gmail.com', '05828848778', 'Alitaşı Mahallesi Atatürk Bulvarı No.144 Merkez, 02100 Merkez/Adıyaman, adıyaman, merkez, türkiye - 10200', 'PayPal', 'Madame Bovary #4, (3)', '11-Dec-2024', 'pending', 135.00),
(65, 58, 'emirali', 'e@gmail.com', '05828848778', 'bosabffj, fjndskjfbwf, fjklnwelnf, jkwfjkbe - 123879', 'Credit Card', 'SEFİLLER #100, (1)', '11.01.2025', 'completed', 400.00),
(66, 58, 'Alperen', 'e@gmail.com', '05020855674', 'DENEME DENEME DENEME, MANİSA, YUNUSEMRE, TÜRKİYE  - 45000', 'Credit Card', 'Büyük Umutlar #8, (4), Türk Tarihi #1, (2), Safahat #10, (1), Osmanlı Gerçekleri #112, (2), İzafiyet Teorisi #114, (1)', '11-Jan-2025', 'pending', 935.00),
(67, 58, 'emirali', 'polat', '05828282823', 'dsahkd, adıyaman, merkez, türkiye - 02450', 'Credit Card', 'Kara Kitap #106, (3)', '13-Jan-2025', 'pending', 435.00);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `msg`
--

CREATE TABLE `msg` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `number` varchar(15) DEFAULT NULL,
  `msg` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `msg`
--

INSERT INTO `msg` (`id`, `user_id`, `name`, `email`, `number`, `msg`, `date`) VALUES
(10, 58, 'MEHMET POLAT', 'polat@gmail.com', '5318 997 59 7', 'GAYET GÜZEL MC LDCN', '2025-01-11 14:22:53'),
(11, 58, 'ALPEREN ŞEN', 'a@gmail.com', '05010848402', 'DENEME DENEME DENEME', '2025-01-11 14:24:09');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users_info`
--

CREATE TABLE `users_info` (
  `Id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users_info`
--

INSERT INTO `users_info` (`Id`, `name`, `surname`, `email`, `password`, `user_type`) VALUES
(56, 'alperen', 'alperen', 'as@gmail.com', '23', 'Admin'),
(58, 'emirali', 'he', 'e@gmail.com', '12', 'User'),
(61, 'as', 'sd', 'a@gmail.com', '12', 'User'),
(62, 'emirali', 'şn', 'ee@gmail.com', '123', 'User'),
(63, 'Polat', 'Mehmet', 'p@gmail.com', '34', 'User'),
(64, '123', '23', 'ali@gmail.com', '1', 'User');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `book_info`
--
ALTER TABLE `book_info`
  ADD PRIMARY KEY (`bid`);

--
-- Tablo için indeksler `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `confirm_order`
--
ALTER TABLE `confirm_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Tablo için indeksler `msg`
--
ALTER TABLE `msg`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users_info`
--
ALTER TABLE `users_info`
  ADD PRIMARY KEY (`Id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `book_info`
--
ALTER TABLE `book_info`
  MODIFY `bid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- Tablo için AUTO_INCREMENT değeri `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- Tablo için AUTO_INCREMENT değeri `confirm_order`
--
ALTER TABLE `confirm_order`
  MODIFY `order_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Tablo için AUTO_INCREMENT değeri `msg`
--
ALTER TABLE `msg`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `users_info`
--
ALTER TABLE `users_info`
  MODIFY `Id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
