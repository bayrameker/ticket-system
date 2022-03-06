<?php

// öncelikle bağlantı dosyamızı ekliyoruz
require_once 'connection.php';
$db = new DB();
if(isset($_GET['delete']))
{
    if($db->update('articles',['is_deleted'=>1],['id'=>$_GET['delete']]))
    {
        $_SESSION['toast'] = "Yazı Silindi.";
    }
    header('location:article-list.php');
    die;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Script Chief - Destek sistemi</title>
    <?php
    require_once 'head.php';
    ?>
  </head>

  <body class="topbar-unfix">

    <?php 
    require_once 'header.php';
    ?>

    <!-- Ana İçerik  -->
    <main class="main-container">


      <header class="header header-inverse">
        <div class="container">
          <div class="header-info">
            <div class="left">
              <br>
              <h2 class="header-title"><strong>Makalaler</strong> <small class="subtitle">Bu sayfadaki tüm makalelerin listesini görebilirsiniz. </small></h2>
            </div>
          </div>

          <div class="header-action">
            <nav class="nav">
              <a class="nav-link active" href="article-list.php">Makaleler</a>
                <?php 
                if(isset($_SESSION['user']))
                {
                ?>
              <a class="nav-link" href="article-add.php">Yeni Ekle</a>
                <?php
                }
                    ?>
            </nav>
 <?php 
                if(isset($_SESSION['user']))
                {
                ?>
            <div class="buttons">
              <a class="btn btn-primary btn-float" href="article-add.php" title="Yeni Yazı Ekle" data-provide="tooltip"><i class="ti-plus"></i></a>
            </div>
              <?php
                }
                    ?>
          </div>
        </div>
      </header><!--/.header -->





      <div class="main-content">
        <div class="container">
          <div class="row">

            <div class="col-md-4 col-xl-3">
                <div class="card shadow-1">
                <h5 class="card-title"><strong>Filtreler</strong></h5>

                <form class="card-body" method="post">

                  <div class="form-group">
                    <label>Kategoriler</label>
                    <select title="Hepsi" name="category[]" multiple data-provide="selectpicker" data-width="100%" data-actions-box="true">
                      <?php
                            $data = $db->select('category',['is_deleted'=>'0']);
                            if($data['total_record']>0)
                            {  
                                while($row = $data['rs']->fetch_object())
                                {
                            ?>
                                <option <?php echo (isset($_POST['category']) && in_array($row->id,$_POST['category']))?'selected':''; ?> value="<?php echo $row->id; ?>"><?php echo $row->category; ?></option>
                                   <?php
                                }
                            }
                            ?>
                    </select>
                  </div>

                  <hr>

                  <div class="text-right">
                    <a class="btn btn-sm btn-bold btn-secondary mr-1" href="article-list.php">sıfırla</a>
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
                    }
                    
                    $data = $db->query("SELECT T.*,C.`category`,C.`color` FROM `articles` as T INNER JOIN `category` as C ON T.category = C.id AND C.is_deleted = 0  WHERE 1 ".$where." AND T.is_deleted = 0 ORDER BY T.datetime DESC");
                    if($data->num_rows>0)
                    {  
                        while($row = $data->fetch_object())
                        {
                    ?>
                  <div class="media align-items-center">
                   

                    <a class="media-body text-truncate pl-12" href="article.php?article=<?php echo $row->id; ?>">
                      <h5 class="fs-15"><?php echo $row->title; ?></h5>
                      <small class="opacity-75 fw-300">
                         <span style="color:<?php echo $row->color; ?>"><?php echo $row->category; ?></span>
                        <span class="divider-dash"></span>
                         <?php echo date('F j, Y',strtotime($row->publish_date)) ?> Yayınlandı
                      </small>
                    </a>

                    <a class="media-action hover-primary" href="article-add.php?update=<?php echo $row->id; ?>" data-provide="tooltip" title="Edit"><i class="ti-pencil"></i></a>
                    <a class="media-action hover-danger" onclick="return confirm('Are you sure ?');" href="article-list.php?delete=<?php echo $row->id; ?>" data-provide="tooltip" title="Delete" data-perform="delete-single" data-target=""><i class="ti-close"></i></a>
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
