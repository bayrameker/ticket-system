


<?php

// öncelikle bağlantı dosyamızı ekliyoruz
require_once 'connection.php';

// yönetici kontrolü sağlıyoruz session açılmış mı açılmamış mı ?
require_once 'admin_security.php';

$db = new DB();
if(isset($_GET['update']))
{
    $updateData = $db->select('articles',['id'=>$_GET['update']]); 
    if($updateData['total_record']==1)
    {
        $updateData = $updateData['rs']->fetch_object();
    }
    else
    {
        unset($updateData);
    }
}
if(isset($_POST['update']) && !empty($updateData))
{
        if($db->update('articles',['title'=>$_POST['title'],'category'=>$_POST['category'],'description'=>$_POST['description'],'publish_date'=>date('Y-m-d',strtotime($_POST['publish_date']))],['id'=>$_POST['id']]))
        {
            $_SESSION['toast'] = "Yazı Yüklendi";
        }
        else
        {
            $_SESSION['toast'] = "Yanlış oldu";
        }
   
    header('location:article-list.php');
    die;
}
if(isset($_POST['save']))
{

    if($db->insert('articles',['title'=>$_POST['title'],'category'=>$_POST['category'],'description'=>$_POST['description'],'publish_date'=>date('Y-m-d',strtotime($_POST['publish_date'])),'datetime'=>date('Y-m-d H:i:s')]))
    {
        $_SESSION['toast'] = "Yazı Eklendi";
    }
    else
    {
        $_SESSION['toast'] = "Olmadı";
    }
    header('location:article-add.php');
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

    <!-- Main container -->
    <main class="main-container">


     

      <header class="header header-inverse">
        <div class="container">
          <div class="header-info">
            <div class="left">
              <br>
              <h2 class="header-title">
                  <?php
                  if(isset($updateData) && !empty($updateData))
                  {
                      ?>
                  <strong>Makaleyi</strong> Güncelle <small class="subtitle">
                  <?php
                  }else{
                      ?>
                  <strong>Yeni Makale</strong> Oluştur <small class="subtitle">
                  <?php
                  }
                  ?>
                  Müşterilere destek verecek bir makale oluşturun </small></h2>
            </div>
          </div>

          <div class="header-action">
            <nav class="nav">
              <a class="nav-link" href="article-list.php">Makaleler</a>
              <a class="nav-link <?php echo (isset($updateData) && !empty($updateData))?'':'active'; ?>" href="article-add.php">Yeni Ekle</a>
            </nav>
          </div>
        </div>
      </header><!--/.header -->





      <div class="main-content">
        <div class="container">
            <?php
                  if(isset($updateData) && !empty($updateData))
                  {
                      ?>
            <form class="row" method="post">

            <div class="col-lg-8">
              <div class="card shadow-1">
                <h4 class="card-title"><strong>Genel</strong> Bilgiler</h4>

                <div class="card-body">
                  <input class="form-control form-control-lg" name="title" required type="text" value="<?php echo $updateData->title; ?>" placeholder="Article Title">
                  <br>
                  <textarea data-provide="summernote" name="description" data-height="300px"><?php echo $updateData->description; ?></textarea>
                </div>
              </div>
            </div>


            <div class="col-lg-4">
              <div class="card shadow-1">
                <h4 class="card-title"><strong>Diğer</strong> Detaylar</h4>

                <div class="card-body">
                  <div class="form-group">
                    <label>Kategori</label>
                    <select title="Select a category" name="category" data-provide="selectpicker" data-width="100%" required>
                        <?php
                            $data = $db->select('category',['is_deleted'=>'0']);
                            if($data['total_record']>0)
                            {  
                                while($row = $data['rs']->fetch_object())
                                {
                            ?>
                                <option <?php echo ($updateData->category == $row->id)?'selected':''; ?> value="<?php echo $row->id; ?>"><?php echo $row->category; ?></option>
                                   <?php
                                }
                            }
                            ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Yayınlanma Tarihi</label>
                    <input class="form-control" value="<?php echo date('m/d/Y',strtotime($updateData->publish_date)); ?>" type="text" name="publish_date" required placeholder="Right now" data-provide="datepicker">
                  </div>
                </div>

                <footer class="card-footer flexbox">
                  <div class="text-right flex-grow">
                       <input type="hidden" name="id" value="<?php echo $updateData->id; ?>"/>
                    <button class="btn btn-bold btn-primary" name="update">Güncelle</button>
                  </div>
                </footer>

              </div>
            </div>

          </form>
            <?php
                  }else{
                      ?>
            
            
          <form class="row" method="post">

            <div class="col-lg-8">
              <div class="card shadow-1">
                <h4 class="card-title"><strong>Bilgiler</strong> </h4>

                <div class="card-body">
                  <input class="form-control form-control-lg" name="title" required type="text" placeholder="Yazı Başlığı">
                  <br>
                  <textarea data-provide="summernote" name="description" data-height="300px"></textarea>
                </div>
              </div>
            </div>


            <div class="col-lg-4">
              <div class="card shadow-1">
                <h4 class="card-title"><strong>Diğer</strong> Detaylar</h4>

                <div class="card-body">
                  <div class="form-group">
                    <label>Kategori</label>
                    <select title="Kategori Seç" name="category" data-provide="selectpicker" data-width="100%" required>
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

                  <div class="form-group">
                    <label>Yayınlanma Tarihi</label>
                    <input class="form-control" type="text" name="publish_date" required placeholder="Şu an" data-provide="datepicker">
                  </div>
                </div>

                <footer class="card-footer flexbox">
                  <div class="text-right flex-grow">
                    <button class="btn btn-bold btn-primary" name="save">Gönder</button>
                  </div>
                </footer>

              </div>
            </div>

          </form>
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