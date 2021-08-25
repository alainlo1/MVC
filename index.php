<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/8688d368c4.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="assets/css/style.css">
  <title>Livres</title>
</head>
<body>
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container-fluid">
      <a href="index.php" class="navbar-brand">
        <img src="assets/img/logo.jpg" alt="Logo" width="30" height="24">
        Livres
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse menu" id="navbarScroll">
        <?php
          if(isset($_SESSION['user'])) {
        ?>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="index.php?action=auteur" class="nav-link">
                Auteurs
              </a>
            </li>
          </ul>
        <?php
          }
        ?>
        <span class="clear"></span>
        <ul class="navbar-nav">
          <?php if(!isset($_SESSION['user'])) { ?>
            <li class="nav-item">
              <a href="index.php?action=login" class="nav-link">
              <i class="fas fa-sign-in-alt"></i>
              </a>
            </li>
            <li class="nav-item">
            <a href="index.php?action=register" class="nav-link">
              <i class="fas fa-user-circle"></i>
            </a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a href="index.php?action=deco" class="nav-link">
              <i class="fas fa-sign-out-alt"></i>
              </a>
            </li>
            <li class="nav-item">
              <a href="index.php?action=admin" class="nav-link">
                Admin
              </a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>
  <?php
    require './user/controller.user.php';
    require './admin/controller.admin.php';
    require './auteur/controller.auteur.php';
    if(isset($_GET['action'])) {
      $action = $_GET['action'];
      switch ($action) {
        case 'register':
          register();
          break;
        case 'deco':
          logout();
          break;
        case 'login':
          login();
          break;
        case 'admin':
          header('Location: admin.php');
          break;
        case 'auteur':
          auteur();
          break;
        default:
          require 'assets/view.home.php';
          break;
      }
    } else {
      require 'assets/view.home.php';
    }
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</body>
</html>