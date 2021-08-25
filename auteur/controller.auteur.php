<?php

  require_once 'auteur/model/model.auteur.php';
  require_once 'auteur/model/model.pays.php';


  function auteur() {
    $paysManager = new PaysManager();
    $auteurManager = new AuteurManager();

    $auteurs = $auteurManager->getAll();

    $tabAuteur = [];
    foreach ($auteurs as $value) {
      $pays = $paysManager->get($value->id_p());
      $auteurFull = [
        'Nom' => $value->nom_a(),
        'Prenom' => $value->prenom_a(),
        'Naissance' => $value->date_naissance_a(),
        'Pays' => $pays->nom_p()
      ];
      $tabAuteur[] = $auteurFull;
    }

    require 'auteur/view.auteur.php';

  }

?>