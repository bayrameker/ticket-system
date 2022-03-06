<?php

// burada veritabanı bilgileri oluşturulmuş ise install yani yükleme kısmını atla komutu veriliyor.
if(!file_exists("./config/database.php"))
{
    header('location:install.php');
}

// eğer kullanıcı oturumu ile ilgili  bir session tanımlanmışsa login sayfasına yönlendirme yapmıyoruz.
if(!isset($_SESSION['user']))
{
    //require_once('login.php'); //login gerekli değil session kontrolü sağlandı
    header('location:ticket-add.php');
    die;
}
?>