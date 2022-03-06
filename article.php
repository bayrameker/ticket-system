<?php 
// öncelikle bağlantı dosyamızı ekliyoruz
require_once 'connection.php';
$db = new DB();
$id = $_GET['article'];

$data = $db->query("SELECT T.*,C.`category`,C.`color` FROM `articles` as T INNER JOIN `category` as C ON T.category = C.id AND C.is_deleted = 0 WHERE 1 AND T.is_deleted = 0 AND T.id = '$id'");

if($data->num_rows>0)
{
    $article = $data->fetch_object();
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

    <!-- Ana İçerik -->
    <main class="main-container">

        <header class="header header-inverse">
            <div class="container">
                <div class="header-info">
                    <div class="left">
                        <br>
                        <h2 class="header-title">
                            <?php
                  if(isset($article))
                  {
                      echo $article->title;
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
                        <a class="nav-link" href="article-list.php">Makaleler</a>
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
                        <a class="btn btn-primary btn-float" href="article-add.php" title="Create new ticket" data-provide="tooltip"><i class="ti-plus"></i></a>
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
                  if(isset($article))
                  {
            ?>
                    <div class="row">

                        <div class="col-md-12">

                            <div class="card shadow-1">
                                <header class="card-header bg-lightest">
                                    <div class="card-title flexbox">
                                        <div>
                                            <h5 class="fs-15"><?php echo $article->title; ?></h5>
                                          <small class="opacity-75 fw-300">
                                             <span style="color:<?php echo $article->color; ?>"><?php echo $article->category; ?></span>
                                            <span class="divider-dash"></span>
                                            <?php echo date('F j, Y',strtotime($article->publish_date)) ?>
                                          </small>
                                        </div>
                                    </div>
                                </header>


                                <div class="card-body">
                                    <div>
                                        <?php echo $article->description; ?>
                                    </div>
                                </div>
                            </div>
   
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
