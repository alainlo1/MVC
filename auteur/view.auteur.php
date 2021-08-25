<br>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-8">
      <table class="table">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date de Naissance</th>
            <th>Pays</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach ($tabAuteur as $value) {
              echo '
                <tr>
                  <td>'.$value['Nom'].'</td>
                  <td>'.$value['Prenom'].'</td>
                  <td>'.$value['Naissance'].'</td>
                  <td>'.$value['Pays'].'</td>
                </tr>
              ';
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

