<br>
<div class="coontainer-fluid">
  <div class="row justify-content-center">
    <div class="col-8">
      <h1>Home</h1>
      <p class="text-justify">
        <?php
          if(isset($_SESSION['user'])) {
            echo 'Bonjour '.$_SESSION['pseudo'].'<br>';
          }
        ?>
        WEWEWE MVC
      </p>
    </div>
  </div>
</div>