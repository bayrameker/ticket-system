<?php
// öncelikle bağlantı dosyamızı ekliyoruz
require_once 'connection.php';

// yönetici kontrolü sağlıyoruz session açılmış mı açılmamış mı ?
require_once 'admin_security.php';
$db = new DB();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detsek sistemi - scriptchief</title>
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
              <h2 class="header-title"><strong>Panel</strong> <small class="subtitle">Bazı bilgiler ve istatistikler
 </small></h2>
            </div>
          </div>
        </div>
      </header><!--/.header -->
<div class="main-content">
        <div class="container">
          <div class="row">


            <div class="col-6 col-lg-3">
              <div class="card shadow-1">
                <div class="card-body">
                  <div class="flexbox">
                    <h5>Makaleler</h5>
                    <div class="dropdown">
                      <span class="dropdown-toggle no-caret" data-toggle="dropdown"><i class="ti-more-alt rotate-90"></i></span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="article-list.php"><i class="ion-android-list"></i> Detaylar</a>
                        <a class="dropdown-item" href="article-add.php"><i class="ion-android-add"></i> Yeni Ekle</a>
                      </div>
                    </div>
                  </div>

                  <div class="text-center my-2">
                    <div class="fs-60 fw-400 text-info"><?php echo $db->count('articles',['is_deleted'=>0]); ?></div>
                    <span class="fw-400 text-muted">Toplam</span>
                  </div>
                </div>
                  <div class="progress mb-0">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 25%; height: 3px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>




            <div class="col-6 col-lg-3">
              <div class="card shadow-1">
                <div class="card-body">
                  <div class="flexbox">
                    <h5>Kategoriler</h5>
                    <div class="dropdown">
                      <span class="dropdown-toggle no-caret" data-toggle="dropdown"><i class="ti-more-alt rotate-90"></i></span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="category.php"><i class="ion-android-list"></i> Detaylar</a>
                        <a class="dropdown-item" href="category.php"><i class="ion-android-add"></i> Yeni Ekle</a>
                      </div>
                    </div>
                  </div>

                  <div class="text-center my-2">
                    <div class="fs-60 fw-400 text-danger"><?php echo $db->count('category',['is_deleted'=>0]); ?></div>
                    <span class="fw-400 text-muted">Toplam</span>
                  </div>
                </div>
                  <div class="progress mb-0">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 65%; height: 3px;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>



            <div class="col-6 col-lg-3">
              <div class="card shadow-1">
                <div class="card-body">
                  <div class="flexbox">
                    <h5>Destekler</h5>
                    <div class="dropdown">
                      <span class="dropdown-toggle no-caret" data-toggle="dropdown"><i class="ti-more-alt rotate-90"></i></span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="ticket-list.php"><i class="ion-android-list"></i> Detaylar</a>
                        <a class="dropdown-item" href="ticket-add.php"><i class="ion-android-add"></i> Yeni Ekle</a>
                      </div>
                    </div>
                  </div>

                  <div class="text-center my-2">
                    <div class="fs-60 fw-400 text-primary"><?php echo $db->count('ticket'," status IN ('In Progress','On Hold')  AND is_deleted = 0"); ?></div>
                    <span class="fw-400 text-muted">Açık</span>
                  </div>
                </div>
                  <div class="progress mb-0">
                  <div class="progress-bar" role="progressbar" style="width: 40%; height: 3px;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>



            <div class="col-6 col-lg-3">
              <div class="card shadow-1">
                <div class="card-body">
                  <div class="flexbox">
                    <h5>Destekler</h5>
                    <div class="dropdown">
                      <span class="dropdown-toggle no-caret" data-toggle="dropdown"><i class="ti-more-alt rotate-90"></i></span>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="ticket-list.php"><i class="ion-android-list"></i> Detaylar</a>
                        <a class="dropdown-item" href="ticket-add.php"><i class="ion-android-add"></i> Yeni Ekle</a>
                      </div>
                    </div>
                  </div>

                  <div class="text-center my-2">
                    <div class="fs-60 fw-400 text-dark"><?php echo $db->count('ticket'," status = 'Closed' AND is_deleted = 0"); ?></div>
                    <span class="fw-400 text-muted">Kapandı</span>
                  </div>
                </div>
                  <div class="progress mb-0">
                  <div class="progress-bar bg-dark" role="progressbar" style="width: 30%; height: 3px;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
              <div class="col-12 h-50px"></div>

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
