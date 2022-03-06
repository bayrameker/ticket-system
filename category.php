<?php
// öncelikle bağlantı dosyamızı ekliyoruz
require_once 'connection.php';

// yönetici kontrolü sağlıyoruz session açılmış mı açılmamış mı ?
require_once 'admin_security.php';
$db = new DB();
if (isset($_GET['delete'])) {
    if ($db->update('category', ['is_deleted' => 1], ['id' => $_GET['delete']])) {
        $_SESSION['toast'] = "Catagory deleted.";
    }
    header('location:category.php');
    die;
}
if (isset($_GET['update'])) {
    $updateData = $db->select('category', ['id' => $_GET['update']]);
    if ($updateData['total_record'] == 1) {
        $updateData = $updateData['rs']->fetch_object();
    } else {
        unset($updateData);
    }
}
if (isset($_POST['update']) && !empty($updateData)) {
    $isExist = $db->select('category', "category = '" . $_POST['category'] . "' AND id != " . $_POST['id'] . " AND is_deleted = 0");
    if ($isExist['total_record'] == 0) {
        if ($db->update('category', ['category' => $_POST['category'], 'color' => $_POST['color']], ['id' => $_POST['id']])) {
            $_SESSION['toast'] = "Kategori Güncellendi.";
        } else {
            $_SESSION['toast'] = "Hatalı";
        }
    } else {
        $_SESSION['toast'] = "dd";
    }
    header('location:category.php');
    die;
}
if (isset($_POST['save'])) {
    $isExist = $db->select('category', ['category' => $_POST['category'], 'is_deleted' => '0']);
    if ($isExist['total_record'] == 0) {
        if ($db->insert('category', ['category' => $_POST['category'], 'color' => $_POST['color']])) {
            $_SESSION['toast'] = "Kategori Eklendi.";
        } else {
            $_SESSION['toast'] = "Yanlış";
        }
    } else {
        $_SESSION['toast'] = "dd";
    }
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
                            <h2 class="header-title"><strong>Kategori</strong> <small class="subtitle">Forumlarda, desteklerde ve makalelerde kullanılacak web sitesi kategorilerinizi yönetin
</small></h2>
                        </div>
                    </div>
                </div>
            </header><!--/.header -->





            <div class="main-content">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-7">
                            <div class="card shadow-1">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>İsim</th>
                                            <th class="w-100px text-center">Eylem</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$data = $db->select('category', ['is_deleted' => '0']);
if ($data['total_record'] > 0) {
    while ($row = $data['rs']->fetch_object()) {
        ?>
                                                <tr>
                                                    <td><span class="badge badge-ring badge-default mr-2 mt-2" style="background-color:<?php echo $row->color; ?>"></span> <?php echo $row->category; ?></td>
                                                    <td>
                                                        <nav class="nav gap-2 fs-16">
                                                            <a class="nav-link hover-primary cat-edit" href="category.php?update=<?php echo $row->id; ?>" data-provide="tooltip" title="Düzenle"><i class="ti-pencil"></i></a>
                                                            <a class="nav-link hover-danger cat-delete" onclick="return confirm('Emin Misin ?');" href="category.php?delete=<?php echo $row->id; ?>" data-provide="tooltip" title="Sil"><i class="ti-trash"></i></a>
                                                        </nav>
                                                    </td>
                                                </tr>
        <?php
    }
}
?>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="col-lg-5">
                            <form class="card shadow-1" method="post">
                                        <?php
                                        if (isset($updateData) && !empty($updateData)) {
                                            ?>
                                    <h5 class="card-title"><strong>Kategory güncelle</strong></h5>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="require">İsim</label>
                                            <input class="form-control" type="text" name="category" value="<?php echo $updateData->category; ?>" required id="cat-name">
                                        </div>
                                        <div class="form-group">
                                            <label>Renk</label>
                                            <input class="form-control" type="text" name="color" required value="<?php echo $updateData->color; ?>" data-provide="colorpicker">
                                        </div>
                                    </div>

                                    <footer class="card-footer text-right">
                                        <input type="hidden" name="id" value="<?php echo $updateData->id; ?>"/>
                                        <button class="btn btn-primary" name="update">Güncelle</button>
                                    </footer>
    <?php
} else {
    ?>
                                    <h5 class="card-title"><strong>Yeni Kategori Oluştur</strong></h5>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="require">İsim</label>
                                            <input class="form-control" type="text" name="category" required id="cat-name">
                                        </div>
                                        <div class="form-group">
                                            <label>Renk</label>
                                            <input class="form-control" type="text" name="color" required value="#33cabb" data-provide="colorpicker">
                                        </div>
                                    </div>

                                    <footer class="card-footer text-right">
                                        <button class="btn btn-primary" name="save">Kaydet</button>
                                    </footer>
    <?php
}
?>
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

