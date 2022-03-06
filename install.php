<?php

// öncelikle bağlantı dosyamızı ekliyoruz
require_once 'connection.php';
if(file_exists("./config/database.php"))
{
    header('location:index.php');
    exit();
}
if(isset($_POST['submit']))
{
    if($_POST['password']!=$_POST['confirm'])
    {
        $error = "Account password is no match.";
    }
    
    if(!isset($error))
    {
        //parolayı sabitlemek için kullanılıyor 
        //$_POST['dbpassword'] = '';

        $con = new mysqli($_POST['dbhost'],$_POST['dbuser'],$_POST['dbpassword']);
        if ($con->connect_errno) {
            $error = "Bağlantı Hatası: ". $con->connect_error;
        }
        else{
            $my_file = './config/';
            if(chmod($my_file, 0777)){
                $my_file .= 'database.php';
                if($handle = fopen($my_file, 'w')){
                    $data = '<?php define("DBHOST","'.$_POST['dbhost'].'");';
                    $data .= ' define("DBUSER","'.$_POST['dbuser'].'");';
                    $data .= ' define("DBPASS","'.$_POST['dbpassword'].'");';
                    $data .= ' define("DBNAME","'.$_POST['dbname'].'"); ?>';
                    fwrite($handle, $data); 
                    
                    // DB ve tablolar
                    $con->query("CREATE DATABASE IF NOT EXISTS `".$_POST['dbname']."`;"); 
                    
                    //burada çift primary test et
                    $con->query("DROP TABLE IF EXISTS `".$_POST['dbname']."`.`admin`;"); 
                    $con->query("CREATE TABLE `".$_POST['dbname']."`.`admin` (
                                `id` INT NOT NULL AUTO_INCREMENT,
                                `username` VARCHAR(50) NOT NULL, 
                                `password` VARCHAR(50) NOT NULL,
                                `permission` VARCHAR(50) NOT NULL,
                                `publish_date` DATE  NOT NULL,
                                `datetime` DATETIME  NOT NULL , 
                                PRIMARY KEY (`id`)
                                );");

                    $con->query("DROP TABLE IF EXISTS `".$_POST['dbname']."`.`adminn`;"); 
                    $con->query("CREATE TABLE `".$_POST['dbname']."`.`adminn` (
                                  `username` varchar(50) PRIMARY KEY,
                                  `password` varchar(50) NOT NULL
                                );");

                    $con->query("INSERT INTO `".$_POST['dbname']."`.`adminn` VALUES('".$_POST['userName']."','".$_POST['password']."');");
                    
                    $con->query("DROP TABLE IF EXISTS `".$_POST['dbname']."`.`category`;"); 
                    $con->query("CREATE TABLE `".$_POST['dbname']."`.`category` (
                                `id` INT NOT NULL AUTO_INCREMENT,
                                `category` VARCHAR(50) NOT NULL,
                                `color` VARCHAR(10) NOT NULL,
                                `is_deleted` INT(1) NOT NULL DEFAULT '0' ,
                                PRIMARY KEY (`id`)
                                );");
                    
                    $con->query("DROP TABLE IF EXISTS `".$_POST['dbname']."`.`ticket`;"); 
                    $con->query("CREATE TABLE `".$_POST['dbname']."`.`ticket` ( 
                                `id` VARCHAR(10) NOT NULL,
                                `name` VARCHAR(50) NOT NULL,
                                `email` VARCHAR(100) NOT NULL,
                                `category` INT NOT NULL,
                                `subject` VARCHAR(200) NOT NULL,
                                `description` TEXT NOT NULL,
                                `attachments` VARCHAR(2000) NOT NULL,
                                `status` VARCHAR(50) NOT NULL,
                                `datetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                `is_deleted` INT(1) NOT NULL DEFAULT '0',
                                PRIMARY KEY (`id`)
                                );");
                    
                    $con->query("DROP TABLE IF EXISTS `".$_POST['dbname']."`.`conversion`;"); 
                    $con->query("CREATE TABLE `".$_POST['dbname']."`.`conversion` (
                                `id` INT NOT NULL AUTO_INCREMENT,
                                `ticket_id` VARCHAR(50) NOT NULL,
                                `description` TEXT NOT NULL,
                                `attachments` VARCHAR(2000) NOT NULL,
                                `sender` VARCHAR(10) NOT NULL DEFAULT 'user',
                                `datetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                PRIMARY KEY (`id`)
                                );");
                    
                    $con->query("DROP TABLE IF EXISTS `".$_POST['dbname']."`.`articles`;"); 
                    $con->query("CREATE TABLE `".$_POST['dbname']."`.`articles` ( 
                                `id` INT NOT NULL AUTO_INCREMENT ,
                                `title` VARCHAR(500) NOT NULL ,
                                `description` TEXT NOT NULL ,
                                `category` INT NOT NULL ,
                                `publish_date` DATE NOT NULL ,
                                `datetime` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
                                `is_deleted` INT(1) NULL DEFAULT '0' ,
                                PRIMARY KEY (`id`)
                                );");
                    
                    $con->query("DROP TABLE IF EXISTS `".$_POST['dbname']."`.`config`;"); 
                    $con->query("CREATE TABLE `".$_POST['dbname']."`.`config` ( 
                                `config_name` VARCHAR(100) NOT NULL ,
                                `config_value` VARCHAR(100) NOT NULL ,
                                PRIMARY KEY (`config_name`)
                                );");

                    // smtp verileri kullanılırsa 
                    $con->query("INSERT INTO `".$_POST['dbname']."`.`config`(`config_name`, `config_value`)
                                VALUES ('smtp_host', ''),('smtp_port', ''),
                                ('smtp_secure', ''),('smtp_email', ''),
                                ('smtp_password', ''),('site_name', ''),
                                ('admin_name', ''),('admin_photo', 'assets/img/avatar/1.jpg');");
                    
                } 
            } 
        }
        if(!isset($error))
        {
            header('location:index.php');
        }
    }
} ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Yükleme</title>
        <?php require_once 'head.php' ?>
    </head>

    <body class="layout-horizontal">
        <!-- Başlangıç Wrapper -->
        <div id="app" class="custom-wizard">
            <div class="content-wrapper">
                <div class="container-fluid">

                    <section class="content container-fluid">
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <a href="#" class="brand text-center d-block m-b-20">
                                            <img src="assets/img/logo-lg.png" alt="Logo" style="width: 200px;"/>
                                    </a>
                                        <br>
                                        <h5 class="sign-in-heading text-center m-b-20">Yükleme</h5>
                                        <?php
                                        if(isset($error))
                                        {
                                        ?>
                                        <div class="alert alert-danger">
                                            <?php echo $error; ?>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                        <form id="horizontal-wizard" method="post" action="">
                                            <h3>Hesap </h3>
                                            <section>
                                                <div class="form-group">
                                                    <label for="userName">Mail Adresi *</label>
                                                    <input type="email" value="<?php echo (isset($_POST['userName']))?$_POST['userName']:''; ?>" required class="form-control required email" name="userName" id="userName">
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Parola *</label>
                                                    <input id="password" required name="password" type="password" class="form-control required">
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirm">Parolayı onayla *</label>
                                                    <input id="confirm" required name="confirm" type="password" class="form-control required">
                                                </div>
                                            </section>
                                            <h3>Veritabanı bilgileri</h3>
                                            <section>
                                                <div class="form-group">
                                                    <label for="dbhost">Host  *</label>
                                                    <input type="text" value="<?php echo (isset($_POST['dbhost']))?$_POST['dbhost']:''; ?>" required class="form-control required" name="dbhost" id="dbhost" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="dbuser">Kullanıcı Adı *</label>
                                                    <input type="text" value="<?php echo (isset($_POST['dbuser']))?$_POST['dbuser']:''; ?>" required class="form-control required" name="dbuser" id="dbuser" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="dbpassword">Parola *</label>
                                                    <input type="text" value="<?php echo (isset($_POST['dbpassword']))?$_POST['dbpassword']:''; ?>" required class="form-control required" name="dbpassword" id="dbpassword" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="dbname">Veritabanı adı *</label>
                                                    <input type="text" value="<?php echo (isset($_POST['dbname']))?$_POST['dbname']:''; ?>" required class="form-control required" name="dbname" id="dbname" placeholder="">
                                                </div>
                                            </section>
                                            <section>
                                                <button type="submit" class="btn btn-primary" name="submit">Gönder</button>
                                            </section>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    </section>
                    </div>

                </div>

            </div>
            <!-- Bitiş Wrapper -->

            <?php require_once 'footer_script.php' ?>
    </body>

    </html>
