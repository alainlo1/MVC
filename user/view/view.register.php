<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-4">
      <form action="index.php?action=register" method="post">
        <div class="form-group">
          <label for="mail">Mail</label><br>
          <input class="form-control" type="text" id="mail" name="mail">
        </div>
        <div class="form-group">
          <label for="pseudo">Pseudo</label><br>
          <input class="form-control" type="text" id="pseudo" name="pseudo">
        </div>
        <div class="form-group">
          <label for="password">Mot de passe</label><br>
          <input class="form-control" type="password" id="password" name="password">
        </div>
        <div class="form-group">
          <label for="verifyPassword">Vérification</label><br>
          <input class="form-control" type="password" id="verifyPassword" name="verifyPassword">
        </div>
        <div class="text-center">
          <br>
          <button type="submit" name="register" class="btn btn-outline-success" value="register">Enregistrer</button>
        </div>
      </form>
      <?php
        if(isset($_GET['errorRegister'])) {
          switch ($_GET['errorRegister']) {
            case 'mdp':
              echo 'Les deux mots de passes ne sont pas égaux';
              break;
            
            default:
              echo 'Unknown Error register';
              break;
          }
        }
      ?>
    </div>
  </div>
</div>