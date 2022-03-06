<?php

// öncelikle bağlantı dosyamızı ekliyoruz
require_once 'connection.php';

// yönetici kontrolü sağlıyoruz session açılmış mı açılmamış mı ?
require_once 'admin_security.php';



$db = new DB();
if(isset($_GET['delete']))
{
    if($db->update('ticket',['is_deleted'=>1],['id'=>$_GET['delete']]))
    {
        $_SESSION['toast'] = "Ticket Silindi.";
    }
    header('location:ticket-list.php');
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
              <h2 class="header-title"><strong>Destekler</strong> <small class="subtitle">Tüm Destekleriniz listesi bu sayfada mevcuttur.</small></h2>
            </div>
          </div>

          <div class="header-action">
            <nav class="nav">
              <a class="nav-link active" href="ticket-list.php">Destekler</a>
              <a class="nav-link" href="ticket-add.php">Yeni Ekle</a>
            </nav>

            <div class="buttons">
              <a class="btn btn-primary btn-float" href="ticket-add.php" title="Yeni Ticket ekle" data-provide="tooltip"><i class="ti-plus"></i></a>
            </div>
          </div>
        </div>
      </header><!--/.header -->





      <div class="main-content">
        <div class="container">
          <div class="row">

            <div class="col-md-4 col-xl-3 d-none d-md-block">
              <div class="card shadow-1">
                <h5 class="card-title"><strong>Filtreler</strong></h5>

                <form class="card-body" method="post">
                  <div class="form-group">
                    <label>durumlar</label>
                    <select title="Hepsi" name="status[]" multiple data-provide="selectpicker" data-width="100%">
                        <?php
                                   foreach($asset['status'] as $status => $color)
                                    {
                                ?>
                          <option <?php echo (isset($_POST['status']) && in_array($status,$_POST['status']))?'selected':''; ?> title="<?php echo $status; ?>" data-content='<span class="badge badge-dot mr-2" style="background-color:<?php echo $color; ?>"></span> <?php echo $status; ?>'><?php echo $status; ?></option>
                            <?php
                                    }

                                ?>
                    </select>
                  </div>


                  <div class="form-group">
                    <label>Kategoriler</label>
                    <select title="Hepsi" name="category[]"  multiple data-provide="selectpicker" data-width="100%">
                        <?php
                            $data = $db->select('category',['is_deleted'=>'0']);
                            if($data['total_record']>0)
                            {  
                                while($row = $data['rs']->fetch_object())
                                {

                                  $peromis = $row->category;

                                    if( $peromis == $permiso || $_SESSION['user'] == $permiss ){

                            ?>
                                <option <?php echo (isset($_POST['category']) && in_array($row->id,$_POST['category']))?'selected':''; ?> value="<?php echo $row->id; ?>"><?php echo $row->category; ?></option>
                                   <?php
                               }

                                }
                            }
                            ?>
                    </select>
                  </div>

                  <hr>

                  <div class="text-right">
                    <a class="btn btn-sm btn-bold btn-secondary mr-1" href="ticket-list.php">Sıfırla</a>
                    <button class="btn btn-sm btn-bold btn-primary" type="submit">Uygula</button>
                  </div>
                </form>
              </div>
            </div>


            <div class="col-md-8 col-xl-9">

              <div class="media-list media-list-divided media-list-hover" data-provide="selectall">
                  <div class="media-list-body bg-white b-1">
                    <?php
                    $where = "";
                    if(isset($_POST))
                    {
                        if(!empty($_POST['category']))
                        {
                            $where .= " AND T.category IN (".implode(",",$_POST['category']).")";
                        }
                        if(!empty($_POST['status']))
                        {
                            $where .= " AND T.status IN ('".implode("','",$_POST['status'])."')";
                        }
                    }
                    
                    $data = $db->query("SELECT T.*,C.`category`,COUNT(R.id) as replay FROM `ticket` as T INNER JOIN `category` as C ON T.category = C.id AND C.is_deleted = 0 LEFT JOIN `conversion` AS R ON R.`ticket_id` = T.`id`  WHERE 1 ".$where." AND T.is_deleted = 0 GROUP BY T.id ORDER BY T.datetime DESC");
                    if($data->num_rows>0)
                    {  
                        while($row = $data->fetch_object())
                        {

                          
                    ?>
                      <div class="media align-items-center">
                          <span class="badge badge-dot" style="background-color:<?php echo $asset['status'][$row->status]; ?>" title="<?php echo $row->status; ?>" data-provide="tooltip"></span>

                        <a class="media-body text-truncate" href="ticket.php?ticket=<?php echo $row->id ?>">
                          <h5 class="fs-15"><?php echo $row->subject; ?></h5>
                          <small class="opacity-65 fw-300">
                            #<?php echo $row->id; ?>
                            <span class="divider-dash"></span>
                            <?php echo $row->category; ?>
                            <span class="divider-dash"></span>
                            <?php echo $db->time_elapsed_string($row->datetime); ?>
                          </small>
                        </a>
                          
                        <div class="fs-20 text-fade"><?php echo $row->replay; ?></div>
                          <nav class="nav gap-2 fs-16">
                          <a class="nav-link hover-danger cat-delete" onclick="return confirm('Are you sure ?');" href="ticket-list.php?delete=<?php echo $row->id; ?>" data-provide="tooltip" title="Delete"><i class="ti-trash"></i></a>
                        </nav>
                      </div>
                    <?php  
                        }
                    }
                    else
                    {
                        ?>
                    <div class="media align-items-center text-center">
                       Kayıt Bulunamadı
                    </div>
                        <?php
                    }
                    ?>
                </div>
              </div>

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
