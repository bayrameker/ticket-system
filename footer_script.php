<!-- Js kısmı -->
    <script src="assets/js/core.min.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/script.js"></script>
<?php
if(isset($_SESSION['toast']))
{
?>
    <div class="toast"><div class="text"><?php echo $_SESSION['toast']; ?></div><div class="action"></div></div>
      <script>
      var toast = setInterval(function(){
          $('.toast').hide(300);
          clearInterval(toast);
      }, 3000);
      </script>
<?php
    unset($_SESSION['toast']);
}
?>