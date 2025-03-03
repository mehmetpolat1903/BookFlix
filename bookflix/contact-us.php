<?php
    include 'config.php';

    session_start();

    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    
    if(!isset($user_id)){
       header('location:login.php');
    }

    if(isset($_POST['send_msg'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $msg = mysqli_real_escape_string($conn, $_POST['msg']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);

        if(empty($name) || empty($msg) || empty($email) || empty($phone)) {
            $message[] = 'Tüm alanları doldurmalısınız!';
        } else {
            mysqli_query($conn, "INSERT INTO msg (user_id,name,email, number, msg) VALUES('$user_id','$name','$email','$phone','$msg')") or die('Mesaj gönderme sorgusu başarısız oldu');
            $message[] = 'Mesaj Başarıyla Gönderildi';
        }
    }
?>


<!DOCTYPE html>
<html lang="tr" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>İletişim</title>
  <link rel="stylesheet" href="style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/hello.css">
</head>

<body>

  <?php
  include 'index_header.php';
  ?>
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
  <div class="contact-section" >

    <h1>İletişim</h1>
    <h3>Merhaba, <span><?php echo $user_name;?> </span> &nbsp;size nasıl yardımcı olabiliriz?</h3>
    <div class="border"></div>
    <form class="contact-form" action="" method="post" onsubmit="return validateForm()">
      <input type="text" class="contact-form-text" name="name" id="name" placeholder="Adınız" pattern="[A-Za-zşŞıİğĞüÜçÇöÖ]+" title="Lütfen sadece harf girin.">
      <input type="email" class="contact-form-text" name="email" id="email" placeholder="E-posta adresiniz">
      <input type="text" class="contact-form-text" name="phone" id="phone" placeholder="Telefonunuz" pattern="\d+" title="Lütfen geçerli bir telefon numarası girin. Sadece sayılar izinlidir.">
      <textarea class="contact-form-text" name="msg" id="msg" placeholder="Mesajınız"></textarea>
      <input type="submit" class="contact-form-btn" name="send_msg" value="Gönder">
      <a href="index.php" class="contact-form-btn"  >Geri</a>
    </form>
  </div>

<?php include'index_footer.php';?>

<script>
// Hide the message after 5 seconds
setTimeout(() => {
  const box = document.getElementById('messages');
  box.style.display = 'none';
}, 5000);

// Form validation
function validateForm() {
  var name = document.getElementById('name').value;
  var email = document.getElementById('email').value;
  var phone = document.getElementById('phone').value;
  var msg = document.getElementById('msg').value;

  if (name == "" || email == "" || phone == "" || msg == "") {
    alert("Tüm alanları doldurmalısınız!");
    return false;
  }

  // Check if name contains only letters
  if (!/^[A-Za-zşŞıİğĞüÜçÇöÖ]+$/.test(name)) {
    alert("Adınız sadece harflerden oluşmalıdır!");
    return false;
  }

  // Check if phone contains only digits
  if (!/^\d+$/.test(phone)) {
    alert("Telefon numarası sadece sayılar içermelidir!");
    return false;
  }

  return true;
}
</script>
</body>

</html>
