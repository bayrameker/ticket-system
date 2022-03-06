<?php
if(!file_exists("./config/database.php"))
{
    header('location:install.php');
}
// öncelikle bağlantı dosyamızı ekliyoruz
require_once 'connection.php';
//require_once 'admin_security.php';

$db = new DB();
if(isset($_POST['save']))
{
    $id = time();
    $attachments = $db->uploadfiles($_FILES['attachments'],'uploads/'.$id."/");
    if($db->insert('ticket',['id'=>$id,'name'=>$_POST['name'],'email'=>$_POST['email'],'category'=>$_POST['category'],'subject'=>$_POST['subject'],'description'=>$_POST['description'],'status'=>$_POST['status'],'attachments'=>$attachments,'datetime'=>date('Y-m-d H:i:s')]))
    {
        $rsAdmin = $db->select('admin');
        if($rsAdmin['total_record'])
        {
            $domain = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."/";
            //$domain = ''; // sunucu üzerinde kullanılabilir

            $html= '<!DOCTYPE html>
            <html>
            <head>
            <title></title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <style type="text/css">
                /* FONTS */
                @media screen {
                    @font-face {
                      font-family: \'Lato\';
                      font-style: normal;
                      font-weight: 400;
                      src: local(\'Lato Regular\'), local(\'Lato-Regular\'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format(\'woff\');
                    }

                    @font-face {
                      font-family: \'Lato\';
                      font-style: normal;
                      font-weight: 700;
                      src: local(\'Lato Bold\'), local(\'Lato-Bold\'), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format(\'woff\');
                    }

                    @font-face {
                      font-family: \'Lato\';
                      font-style: italic;
                      font-weight: 400;
                      src: local(\'Lato Italic\'), local(\'Lato-Italic\'), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format(\'woff\');
                    }

                    @font-face {
                      font-family: \'Lato\';
                      font-style: italic;
                      font-weight: 700;
                      src: local(\'Lato Bold Italic\'), local(\'Lato-BoldItalic\'), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format(\'woff\');
                    }
                }

                /* CLIENT-SPECIFIC STYLES */
                body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
                table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
                img { -ms-interpolation-mode: bicubic; }

                /* RESET STYLES */
                img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
                table { border-collapse: collapse !important; }
                body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

                /* iOS BLUE LINKS */
                a[x-apple-data-detectors] {
                    color: inherit !important;
                    text-decoration: none !important;
                    font-size: inherit !important;
                    font-family: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                }

                /* MOBILE STYLES */
                @media screen and (max-width:600px){
                    h1 {
                        font-size: 32px !important;
                        line-height: 32px !important;
                    }
                }

                /* ANDROID CENTER FIX */
                div[style*="margin: 16px 0;"] { margin: 0 !important; }
            </style>
            </head>
            <body style="background-color: #f3f5f7; margin: 0 !important; padding: 0 !important;">

            

            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <!-- LOGO -->
                <tr>
                    <td bgcolor="#33cabb" align="center">
                        <!--[if (gte mso 9)|(IE)]>
                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                        <tr>
                        <td align="center" valign="top" width="600">
                        <![endif]-->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                            <tr>
                                <td align="center" valign="top" style="padding: 80px 10px 80px 10px;">
                                    <a href="#" target="_blank">
                                        <img alt="Logo" src="'.$domain.'assets/img/logo-light-lg.png" style="display: block; font-family: &apos;Lato&apos;, Helvetica, Arial, sans-serif; color: #ffffff; font-size: 18px;" border="0">
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <!--[if (gte mso 9)|(IE)]>
                        </td>
                        </tr>
                        </table>
                        <![endif]-->
                    </td>
                </tr>
                <!-- HERO -->
                <tr>
                    <td bgcolor="#33cabb" align="center" style="padding: 0px 10px 0px 10px;">
                        <!--[if (gte mso 9)|(IE)]>
                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                        <tr>
                        <td align="center" valign="top" width="600">
                        <![endif]-->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                            <tr>
                                <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: &apos;Lato&apos;, Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                                  <h1 style="font-size: 42px; font-weight: 400; margin: 0;">'.$_POST['subject'].'</h1>
                                </td>
                            </tr>
                        </table>
                        <!--[if (gte mso 9)|(IE)]>
                        </td>
                        </tr>
                        </table>
                        <![endif]-->
                    </td>
                </tr>
                
                <!-- COPY BLOCK -->
                <tr>
                    <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                        <!--[if (gte mso 9)|(IE)]>
                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                        <tr>
                        <td align="center" valign="top" width="600">
                        <![endif]-->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                          <!-- COPY -->
                          <tr>
                            <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: &apos;Lato&apos;, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;">
                              '.$_POST['description'].'
                            </td>
                          </tr>

                        </table>
                        <!--[if (gte mso 9)|(IE)]>
                        </td>
                        </tr>
                        </table>
                        <![endif]-->
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 10px 10px;">
                        <!--[if (gte mso 9)|(IE)]>
                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                        <tr>
                        <td align="center" valign="top" width="600">
                        <![endif]-->
                        <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                          <tr>
                            <td align="center" style="padding: 0 0 30px;">
                             <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 200px;">
                          <tr>
                            <td align="center" style="border-radius: 3px;max-width: 200px;" bgcolor="#33cabb"><a href="'.$domain.'ticket.php?ticket='.$id.'" target="_blank" style="font-size: 18px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 12px 50px; border-radius: 2px; border: 1px solid #33cabb; display: inline-block;">Go to Ticket</a></td>
                                </tr>
                                </table>
                            </td>
                          </tr>
                          <tr>
                            <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: &apos;Lato&apos;, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 25px;">
                              <p style="margin: 0;">'.$_POST['name'].'<br>'.$_POST['email'].'</p>
                            </td>
                          </tr>
                        </table>
                        <!--[if (gte mso 9)|(IE)]>
                        </td>
                        </tr>
                        
                        </table>
                        <![endif]-->
                    </td>
                </tr>
                
                <!-- FOOTER -->
                <tr>
                    <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                        <!--[if (gte mso 9)|(IE)]>
                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
                        <tr>
                        <td align="center" valign="top" width="600">
                        <![endif]-->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">


                          <!-- ADDRESS -->
                          <tr>
                            <td bgcolor="#f4f4f4" align="left" style="padding: 30px 30px 30px 30px; color: #aaaaaa; font-family: &apos;Lato&apos;, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 18px;">
                              <p style="margin: 0;">Designed using Deadlock</p>
                            </td>
                          </tr>
                        </table>
                        <!--[if (gte mso 9)|(IE)]>
                        </td>
                        </tr>
                        </table>
                        <![endif]-->
                    </td>
                </tr>
            </table>

            </body>

            </html>
            ';
            $rsAdmin = $rsAdmin['rs']->fetch_object();

            /*

             Mail kısmı smtp ile
            $db->sendmail($rsAdmin->username,$html,'New Ticket genetared in '.$db->config['site_name']);
            $db->sendmail($_POST['email'],$html,'New Ticket genetared in '.$db->config['site_name']); */
        }
        $_SESSION['toast'] = "Ticket Eklendi";
    }
    else
    {
        $_SESSION['toast'] = "Olmadı";
    }
    header('location:ticket-add.php');
    die;
}
?>
<!DOCTYPE html>
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

    <!-- Ana İçerik -->
    <main class="main-container">

      <header class="header header-inverse">
        <div class="container">
          <div class="header-info">
            <div class="left">
              <br>
              <h2 class="header-title"><strong>Yeni Destek</strong> Oluştur <small class="subtitle">Sorununuzu olabildiğince açıklayıcı bir şekilde açıklayın, böylece size daha hızlı yardımcı olabiliriz.</small></h2>
            </div>
          </div>

          <div class="header-action">
            <nav class="nav">
                 <?php 
                if(isset($_SESSION['user']))
                {
                ?>
              <a class="nav-link" href="ticket-list.php">Destekler</a>
                <?php
                }
                    ?>
              <a class="nav-link active" href="ticket-add.php">Yeni Ekle</a>
            </nav>
          </div>
        </div>
      </header><!--/.header -->


      <div class="main-content">
        <div class="container">
          <form class="row" method="post" enctype="multipart/form-data">


            <div class="col-md-7 col-xl-8">
              <div class="card shadow-1">
                <h4 class="card-title"><strong>Destek</strong> Bilgi</h4>

                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                          <label class="require">İsim</label>
                          <input class="form-control" type="text" name="name" required>
                        </div>
                         <div class="form-group col-md-6">
                          <label class="require">Mail</label>
                          <input class="form-control" type="email" name="email" required>
                        </div>
                    </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label class="require">Kategori</label>
                      <select class="form-control" name="category" data-provide="selectpicker" required>
                           <?php
                            $data = $db->select('category',['is_deleted'=>'0']);
                            if($data['total_record']>0)
                            {  
                                while($row = $data['rs']->fetch_object())
                                {
                            ?>
                                <option value="<?php echo $row->id; ?>"><?php echo $row->category; ?></option>
                                   <?php
                                }
                            }
                            ?>
                      </select>
                    </div>
                      <?php 
                if(isset($_SESSION['user']) && $_SESSION['user'] == $permiss)
                {
                ?>
                      <div class="form-group col-md-6">
                        <label class="require">Durumlar</label>
                        <select title="Hepsi" name="status" data-provide="selectpicker" data-width="100%" required>
                          <?php
                                   foreach($asset['status'] as $status => $color)
                                    {
                                ?>
                          <option title="<?php echo $status; ?>" data-content='<span class="badge badge-dot mr-2" style="background-color:<?php echo $color; ?>"></span> <?php echo $status; ?>'><?php echo $status; ?></option>
                            <?php
                                    }

                                ?>
                        </select>
                      </div>
                      <?php
                }
                      else
                      {
                          ?>
                      <input type="hidden" name="status" value="In Progress"/>
                      <?php
                      }
                    ?>
                    
                    <div class="form-group col-md-12">
                      <label class="require">Konu</label>
                      <input class="form-control" type="text" name="subject" required>
                    </div>
                  </div>

                  <hr>

                  <div class="form-group">
                    <label class="require">Açıklama</label>
                    <textarea data-provide="summernote" name="description" data-toolbar="slim" data-min-height="220"></textarea>
                  </div>


                </div>


                <footer class="card-footer text-right">
                  <a class="btn btn-secondary mr-2" href="#">İptal</a>
                  <button class="btn btn-primary" type="submit" name="save">Gönder</button>
                </footer>


              </div>
            </div>


            <div class="col-md-5 col-xl-4">
              <div class="card shadow-1">
                <h5 class="card-title">Ekler</h5>

                <div class="card-body">
                  <div class="input-group file-group">
                    <input type="text" class="form-control file-value" placeholder="Dosya Seç..." readonly>
                    <input type="file" multiple name="attachments[]">
                    <span class="input-group-append">
                      <button class="btn btn-light file-browser" type="button"><i class="fa fa-upload"></i></button>
                    </span>
                  </div>
                </div>
              </div>
            </div>


          </form>
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