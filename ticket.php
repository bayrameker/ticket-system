<?php 
// öncelikle bağlantı dosyamızı ekliyoruz
require_once 'connection.php';
$db = new DB();
$id = $_GET['ticket'];

$data = $db->query("SELECT T.*,C.`category`,C.`id` as category_id FROM `ticket` as T INNER JOIN `category` as C ON T.category = C.id AND C.is_deleted = 0 WHERE 1 AND T.is_deleted = 0 AND T.id = '$id'");

if($data->num_rows>0)
{
    $ticket = $data->fetch_object();
    
    if(isset($_POST['update']))
    {
        if($db->update('ticket',['category'=>$_POST['category'],'status'=>$_POST['status']],['id'=>$id]))
        {
            $_SESSION['toast'] = "ticket updated.";
        }
        else
        {
            $_SESSION['toast'] = "Something is wrong";
        }
        header('location:ticket.php?ticket='.$id);
        die;
    }
    
    if(isset($_POST['add']))
    {
        $attachments = $db->uploadfiles($_FILES['attachments'],'uploads/'.$id."/");
        if($db->insert('conversion',['ticket_id'=>$id,'description'=>$_POST['description'],'attachments'=>$attachments,'sender'=>(isset($_SESSION['user'])?'admin':'user'),'datetime'=>date('Y-m-d H:i:s')]))
        {
            
            
            $rsAdmin = $db->select('admin');
            if($rsAdmin['total_record'])
            {
                $rsAdmin = $rsAdmin['rs']->fetch_object();
                $domain = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."/";
                //$domain = '';

                $html= '<!DOCTYPE html>
                <html>
                <head>
                <title></title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <style type="text/css">
                    /* Fontlar */
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

                    /* Özel stil ayarı */
                    body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
                    table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
                    img { -ms-interpolation-mode: bicubic; }

                    /* Sıfırlama  */
                    img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
                    table { border-collapse: collapse !important; }
                    body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }

                    /* İos kısmı */
                    a[x-apple-data-detectors] {
                        color: inherit !important;
                        text-decoration: none !important;
                        font-size: inherit !important;
                        font-family: inherit !important;
                        font-weight: inherit !important;
                        line-height: inherit !important;
                    }

                    /* Mobil Css */
                    @media screen and (max-width:600px){
                        h1 {
                            font-size: 32px !important;
                            line-height: 32px !important;
                        }
                    }

                    /* Android ortalama ayarı */
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
                    <!-- Üst Kısım -->
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
                                      <h1 style="font-size: 42px; font-weight: 400; margin: 0;">'.$ticket->subject.'</h1>
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

                    <!-- d -->
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
                                <td align="center" style="border-radius: 3px;max-width: 200px;" bgcolor="#33cabb"><a href="'.$domain.'ticket.php?ticket='.$ticket->id.'" target="_blank" style="font-size: 18px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 12px 50px; border-radius: 2px; border: 1px solid #33cabb; display: inline-block;">Go to Ticket</a></td>
                                    </tr>
                                    </table>
                                </td>
                              </tr>
                              <tr>
                                <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: &apos;Lato&apos;, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 25px;">
                                  <p style="margin: 0;">'.(isset($_SESSION['user'])?$db->config['admin_name']:$ticket->name).'<br>'.(isset($_SESSION['user'])?$rsAdmin->username:$ticket->email).'</p>
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
                $email = (isset($_SESSION['user'])?$ticket->email:$rsAdmin->username);
                $db->sendmail($email,$html,'New reply on ticket '.$ticket->id);
            }
            
            
            
            $_SESSION['toast'] = "Yanıt Eklendi.";
        }
        else
        {
            $_SESSION['toast'] = "Olmadı";
        }
        header('location:ticket.php?ticket='.$id);
        die;
    }

    
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
    <style>
        .bootstrap-select .dropdown-toggle .filter-option
        {
            padding: 4px 10px;
        }
        .bootstrap-select .dropdown-toggle
        {
            padding: 12px;
        }
    </style>
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
                            <?php
                  if(isset($ticket))
                  {
                      echo $ticket->subject;
                  }
                  else
                  {
                      echo "404";
                  }
                  ?>

                        </h2>
                    </div>
                </div>

                <div class="header-action">
                    <nav class="nav">
                        <a class="nav-link" href="ticket-list.php">Destekler</a>
                        <?php 
                if(isset($_SESSION['user']))
                {
                ?>
                        <a class="nav-link" href="ticket-add.php">Yeni Ekle</a>
                        <?php
                }
                    ?>
                    </nav>
       <?php 
                if(isset($_SESSION['user']))
                {
                ?>
                    <div class="buttons">
                        <a class="btn btn-primary btn-float" href="ticket-add.php" title="Yeni Ticket Oluştur" data-provide="tooltip"><i class="ti-plus"></i></a>
                    </div>
                    <?php
                }
                    ?>
                </div>
            </div>
        </header>
        <!--/.header -->



        <div class="main-content">
            <div class="container">
                <?php
                  if(isset($ticket))
                  {
            ?>
                    <div class="row">

                        <div class="col-md-8 col-xl-9">

                            <div class="card shadow-1">
                                <header class="card-header bg-lightest">
                                    <div class="card-title flexbox">
                                        <!--                    <img class="avatar" src="assets/img/avatar/2.jpg" alt="...">-->
                                        <div>
                                            <h6 class="mb-0">
                                                <?php echo $ticket->name ?>
                                                <small class="sidetitle fs-11">
                          <span class="text-dark"><?php echo $ticket->email ?></span> - <span><?php echo $ticket->category; ?></span>
                        </small>
                                            </h6>
                                            <small><?php echo $db->time_elapsed_string($ticket->datetime); ?></small>
                                        </div>
                                    </div>
                                </header>


                                <div class="card-body">
                                    <div>
                                        <?php echo $ticket->description; ?>
                                    </div>
                                    <?php 
                      if(!empty($ticket->attachments))
                      {
                          $attachments = explode('|',$ticket->attachments);
                      
                    ?>
                                    <hr>
                                    <h6 class="text-lighter text-uppercase mb-12">
                                        <i class="fa fa-paperclip mr-2"></i>
                                        <small>Attchments (<?php echo count($attachments) ?>)</small>
                                    </h6>
                                    <div class="gap-items-2 gap-y row" data-provide="photoswipe">
                                        <?php foreach($attachments as $attachment){ ?>
                                        <a class="d-inline-block form-control col-3" target="_blank" href="<?php echo $attachment; ?>">
                                            <?php echo basename($attachment); ?>
                                        </a>
                                        <?php } ?>
                                    </div>
                                    <?php
                      }
                    ?>
                                </div>
                            </div>

                            <?php
                      $replay = $db->select('conversion',['ticket_id'=>$id]);
                      if($replay['total_record']>0)
                            {  
                                while($row = $replay['rs']->fetch_object())
                                {
                      ?>
                                <div class="card shadow-1">
                                    <header class="card-header bg-lightest">
                                        <div class="card-title flexbox">
                                            <!--                    <img class="avatar" src="assets/img/avatar/2.jpg" alt="...">-->
                                            <div>
                                                <h6 class="mb-0">
                                                    <?php echo ($row->sender=='admin')? $db->config['admin_name'] : $ticket->name ; ?>
                                                </h6>
                                                <small><?php echo $db->time_elapsed_string($row->datetime); ?></small>
                                            </div>
                                        </div>
                                    </header>
                                    <div class="card-body">
                                        <div>
                                            <?php echo $row->description; ?>
                                        </div>
                                        <?php 
                      if(!empty($row->attachments))
                      {
                          $attachments = explode('|',$row->attachments);
                      
                    ?>
                                        <hr>
                                        <h6 class="text-lighter text-uppercase mb-12">
                                            <i class="fa fa-paperclip mr-2"></i>
                                            <small>Attchments (<?php echo count($attachments) ?>)</small>
                                        </h6>
                                        <div class="gap-items-2 gap-y row" data-provide="photoswipe">
                                            <?php foreach($attachments as $attachment){ ?>
                                            <a class="d-inline-block form-control col-3" target="_blank" href="<?php echo $attachment; ?>">
                                                <?php echo basename($attachment); ?>
                                            </a>
                                            <?php } ?>
                                        </div>
                                        <?php
                      }
                    ?>
                                    </div>
                                </div>
                                <?php
                                }
                      }
                                    ?>



<?php 
                      if($ticket->status != 'Closed')
                      {
                            ?>
                                    <hr>

                                    <form class="card shadow-1" method="post" enctype="multipart/form-data">
                                        <h4 class="card-title"><strong>Yanıtla</strong></h4>

                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="require">Açıklama</label>
                                                <textarea name="description" data-provide="summernote" name="description" data-toolbar="slim" data-min-height="220"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>Ekler</label>
                                                <div class="input-group file-group">
                                                    <input type="text" class="form-control file-value" placeholder="Dosya Seç..." readonly>
                                                    <input type="file" multiple name="attachments[]">
                                                    <span class="input-group-append">
                        <button class="btn btn-light file-browser" type="button"><i class="fa fa-upload"></i></button>
                      </span>
                                                </div>
                                            </div>
                                        </div>

                                        <footer class="card-footer text-right">
                                            <button class="btn btn-bold btn-primary" name="add" type="submit">Gönder</button>
                                        </footer>
                                    </form>
                            <?php
                      }
                          ?>
                        </div>


                        <div class="col-md-4 col-xl-3">
  <?php 
                if(isset($_SESSION['user']))
                {
                ?>
                            <form class="card" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="text-uppercase fs-10">Destek :</label>
                                        <select title="Hepsi" name="status" data-provide="selectpicker" data-width="100%" required>
                          <?php
                                   foreach($asset['status'] as $status => $color)
                                    {
                                ?>
                          <option <?php echo ($status == $ticket->status)?'selected':''; ?> title="<?php echo $status; ?>" data-content='<span class="badge badge-dot mr-2" style="background-color:<?php echo $color; ?>"></span> <?php echo $status; ?>'><?php echo $status; ?></option>
                            <?php
                                    }

                                ?>
                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="text-uppercase fs-10">Desteği Şuraya Taşı:</label>
                                        <select class="form-control" name="category" data-provide="selectpicker" required>
                           <?php
                            $data = $db->select('category',['is_deleted'=>'0']);
                            if($data['total_record']>0)
                            {  
                                while($row = $data['rs']->fetch_object())
                                {
                            ?>
                                <option <?php echo ($row->id == $ticket->category_id)?'selected':''; ?> value="<?php echo $row->id; ?>"><?php echo $row->category; ?></option>
                                   <?php
                                }
                            }
                            ?>
                      </select>
                                    </div>
                                </div>

                                <footer class="card-footer text-right">
                                    <button class="btn btn-bold btn-primary" name="update">Kaydet</button>
                                </footer>
                            </form>
                        <?php
                }else{
                    ?>     
                            
                            <div class="card" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <h6>Destek durumu : <?php echo $ticket->status ?></h6>
                                    </div>
                                    <div class="form-group">
                                        <h6>Destek Kategorisi : <?php echo $ticket->category ?></h6>
                                    </div>
                                </div>
                            </div>
                                        
                            
                            <?php
                }
                    ?>
                        </div>


                    </div>
                    <?php
                  }
            else{
                ?>

                        <?php
            }
            ?>
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
