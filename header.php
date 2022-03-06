 <!-- Üst Kısım -->
<header class="topbar topbar-expand-lg topbar-secondary topbar-inverse">
    <div class="container">
        <div class="topbar-left">
            <span class="topbar-btn topbar-menu-toggler"><i>&#9776;</i></span>

            <div class="topbar-brand">
                <a href="index.php"><img src="assets/img/logo-lg.png" alt="..." style="width: 200px;"></a>
            </div>

            <div class="topbar-divider d-none d-md-block"></div>

            <nav class="topbar-navigation">
                <ul class="menu">


<?php

                            $permiso;
                            $data = $db->select('admin',['username'=> $_SESSION['user']]);
                            if($data['total_record']>0)
                            {  
                                while($row = $data['rs']->fetch_object())
                                {
                             $permiso=  $row->permission;  
                                   
                                }
                            }
                            ?>




                    <?php

                            $permiss;
                            $data = $db->select('adminn',['username'=> $_SESSION['user']]);
                            if($data['total_record']>0)
                            {  
                                while($row = $data['rs']->fetch_object())
                                {
                             $permiss=  $row->username;  
                                   
                                }
                            }
                            ?>


                    <?php


                    if (isset($_SESSION['user']) && $_SESSION['user'] == $permiss) {

                        
//$_SESSION['user'] //bu kullanıcı adını tutuyor




                        ?>



                      
                        <li class="menu-item active">
                            <a class="menu-link" href="index.php">
                                <span class="title"> Panel</span>
                            </a>
                        </li>

                        <li class="menu-item">
                            <a class="menu-link" href="category.php">
                                <span class="title">Kategori</span>
                            </a>
                        </li>

                        <li class="menu-item">
                            <a class="menu-link" href="user-add.php">
                                <span class="title">Kullanıcı</span>
                            </a>
                        </li>
                        <?php 
                    } else {
                        ?>
                        <li class="menu-item">
                            <a class="menu-link" href="login.php">
                                <span class="title">Admin  </span>
                            </a>
                        </li>
                         <li class="menu-item">
                            <a class="menu-link" href="user_login.php">
                                <span class="title">Yetkili</span>
                            </a>
                        </li>
    <?php
}
?>
                    <li class="menu-item">
                        <a class="menu-link" href="ticket-list.php">
                            <span class="title">Destekler</span>
                        </a>
                    </li>


                    <li class="menu-item">
                        <a class="menu-link" href="article-list.php">
                            <span class="title">Makaleler   </span>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>

<?php
if (isset($_SESSION['user'])) {
    ?>
            <div class="topbar-right">

                <ul class="topbar-btns">
                    <li class="dropdown">
                        <span class="topbar-btn" data-toggle="dropdown"><img class="avatar" src="<?php echo $db->config['admin_photo']; ?>" alt="..."></span>
                        <div class="dropdown-menu dropdown-menu-right">

                            <?php  if (isset($_SESSION['user']) && $_SESSION['user'] == $permiss) { ?>

                            <a class="dropdown-item" href="settings.php"><i class="ti-settings"></i> Ayarlar</a>
<?php } ?>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="logout.php"><i class="ti-power-off"></i> Çıkış</a>
                        </div>
                    </li>
                </ul>

            </div>
    <?php
}
?>
    </div>
</header>
<!-- Üst kısım bitiş -->