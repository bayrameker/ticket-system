<?php
if(!file_exists("./config/database.php"))
{
    header('location:install.php');
}
// öncelikle bağlantı dosyamızı ekliyoruz
require_once 'connection.php';
if(isset($_SESSION['user']))
{
	header('location:index.php');
}
if(isset($_POST['login']))
{
	$db = new DB();
	$login = [];
	$login['username'] = $_POST['username'];
	$login['password'] = $_POST['password'];	
	$loginData = $db->select('adminn',$login);
	if($loginData['total_record']==1)
	{
		$_SESSION['user'] = $_POST['username'];
		header("location:index.php");
	}
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Script Chief - Destek</title>
        <?php require_once 'head.php' ?>
    </head>

    <body class="layout-horizontal">
        <div class="container-fluid">
            <form class="sign-in-form" method="POST" action="">
                <div class="row">
                    <div class="col-md-4 offset-md-4" style="margin-top:8%;">
                        <div class="card">
                    <div class="card-body">
                        <a href="#" class="brand text-center d-block m-b-20">
                            <img src="assets/img/logo-lg.png" alt="Logo" style="width: 200px;"/>
					</a>
                        <h5 class="sign-in-heading text-center m-b-20">hesabınıza giriş yapın</h5>
                        <div class="form-group">
                            <label for="inputEmail" class="sr-only">Mail adresi</label>
                            <input type="email" name="username" id="inputEmail" class="form-control" placeholder="Email address" required="">
                        </div>

                        <div class="form-group">
                            <label for="inputPassword" class="sr-only">Parola</label>
                            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required="">
                        </div>
                        <button name="login" class="btn btn-primary btn-rounded btn-floating btn-lg btn-block" type="submit">Giriş</button>
                    </div>
                </div>
                    </div>
                </div>
            </form>
        </div>
    </body>

    </html>
