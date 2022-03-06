<?php 

// öncelikle bağlantı dosyamızı ekliyoruz
require_once 'connection.php';


// yönetici kontrolü sağlıyoruz session açılmış mı açılmamış mı ?
require_once 'admin_security.php';




$db = new DB();
   if(isset($_POST['update']))
    {
        if(isset($_FILES['admin_photo']) && !empty($_FILES['admin_photo']['name']))
        {
            if($_FILES['admin_photo']['error'] == 0)
            {
                $path = 'assets/img/avatar/'.microtime(true)."_".$_FILES['admin_photo']['name'];
                move_uploaded_file($_FILES['admin_photo']['tmp_name'], $path);
                $_POST['admin_photo'] = $path;
            }
            else
            {
                $_SESSION['toast'] = "Error in fileuploading.";
                header('location:settings.php');
                die;
            }
        }
       
        foreach($_POST as $config_name => $config_value)
        {
            $db->update('config',['config_value'=>$config_value],['config_name'=>$config_name]);
        }
        $_SESSION['toast'] = "Configration updated.";
        header('location:settings.php');
        die;
    }
$rsConfig = $db->select('config');
$config = [];
while($row=$rsConfig['rs']->fetch_object())
{
    $config[$row->config_name] = $row->config_value;
}
?>
<!DOCTYPE php>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Script Chief - Destek</title>
    <?php
    require_once 'head.php';
    ?>
</head>

<body class="topbar-unfix">

    <?php 
    require_once 'header.php';
    ?>

    <!-- Main container -->
    <main class="main-container">

        <header class="header header-inverse">
            <div class="container">
                <div class="header-info">
                    <div class="left">
                        <br>
                        <h2 class="header-title">
                            Site Yapılandırması
                        </h2>
                    </div>
                </div>
            </div>
        </header>
        <!--/.header -->



        <div class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <form class="card shadow-1" method="post" enctype="multipart/form-data">
                            <h4 class="card-title"><strong>Site Yapılandırması</strong></h4>

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="require">Site ismi</label>
                                    <input type="text" name="site_name" value="<?php echo $config['site_name']; ?>" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="require">Admin İsmi</label>
                                    <input type="text" name="admin_name" value="<?php echo $config['admin_name']; ?>" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="require">Admin Profil Fotoğrafı</label>
                                    <input type="file" name="admin_photo" class="form-control"/>
                                </div>
                            </div>
                            <h4 class="card-title"><strong>Mail Yapılandırması</strong></h4>

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="require">SMTP Host</label>
                                    <input type="text" name="smtp_host" value="<?php echo $config['smtp_host']; ?>" class="form-control" required placeholder="smtp.gmail.com"/>
                                </div>
                                <div class="form-group">
                                    <label class="require">SMTP Port</label>
                                    <input type="text" name="smtp_port" value="<?php echo $config['smtp_port']; ?>" class="form-control" required placeholder="587"/>
                                </div>
                                <div class="form-group">
                                    <label class="require">SMTP Güvenlik</label>
                                    <input type="text" name="smtp_secure" value="<?php echo $config['smtp_secure']; ?>" class="form-control" required placeholder="tls"/>
                                </div>
                                <div class="form-group">
                                    <label class="require">Mail</label>
                                    <input type="text" name="smtp_email" value="<?php echo $config['smtp_email']; ?>" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label class="require">Parola</label>
                                    <input type="text" name="smtp_password" value="<?php echo $config['smtp_password']; ?>" class="form-control" required/>
                                </div>
                            </div>

                            <footer class="card-footer text-right">
                                <button class="btn btn-bold btn-primary" name="update" type="submit">Güncelle</button>
                            </footer>
                        </form>
                    </div>
                </div>
            </div>
        </div>




        <?php 
        require_once 'footer.php';
        ?>
    </main>

    <?php
      require_once 'footer_script.php';
      ?>

</body>

</html>
