<?php
  require_once 'user/model.user.php';
  
  // Register
  function register() {
    $userManager = new UserManager();
    if(isset($_POST['register'])) {
      if($_POST['password'] != $_POST['verifyPassword']) {
        header('Location:index.php?action=register&errorRegister=mdp');
      } else {
        $post = array(
          'pseudo'=>$_POST['pseudo'],
          'mail'=>$_POST['mail'],
          'password'=>password_hash($_POST['password'], PASSWORD_DEFAULT)
        );
        $user = new User();
        $user->hydrate($post);
        $id = $userManager->add($user);
        $_SESSION['user'] = $id;
        $_SESSION['pseudo'] = $user->pseudo();
        $_SESSION['mail'] = $user->mail();
        header('Location: index.php');
      }
    } else {
      require 'user/view/view.register.php';
    }
  }

  // Login
  function login() {
    $userManager = new UserManager();
    if(isset($_POST['login'])) {
      $pseudo = $_POST['pseudo'];
      $pwd = $_POST['password'];
      $user = $userManager->login($pseudo);
      if($user) {
        if(password_verify($pwd, $user->password())) {
          $_SESSION['user'] = $user->id_users();
          $_SESSION['pseudo'] = $user->pseudo();
          $_SESSION['mail'] = $user->mail();
          header('Location: index.php');
        } else {
          header('Location: index.php?action=login&errorLogin=mdp');
        }
      } else {
        header('Location: index.php?action=login&errorLogin=pseudo');
      }
    } else {
      require 'user/view/view.login.php';
    }
  }

  // Logout
  function logout() {
    $_SESSION = array();
    session_destroy();
    header('Location: index.php');
  }

?>