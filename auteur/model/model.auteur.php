<?php
  require 'model.pays.php';

  class Auteur {

    private $id_a;
    private $nom_a;
    private $prenom_a;
    private $date_naissance_a;
    private $id_p;

    public function id_a() {return $this->id_a;}
    public function nom_a() {return $this->nom_a;}
    public function prenom_a() {return $this->prenom_a;}
    public function date_naissance_a() {return $this->date_naissance_a;}
    public function id_p() {return $this->id_p;}

    public function setId_a($id) {
      $this->id_a = $id;
    }

    public function setNom_a($nom) {
      $this->nom_a = $nom;
    }

    public function setPrenom_a($prenom) {
      $this->prenom_a = $prenom;
    }

    public function setDate_naissance_a($date_naissance) {
      $this->date_naissance_a = $date_naissance;
    }

    public function setId_p($id) {
      $this->id_p = $id;
    }

    public function hydrate(array $donnees) {
      foreach ($donnees as $key => $value) {
        $method = 'set'.ucfirst($key);
        if(method_exists($this, $method)) {
          $this->$method($value);
        }
      }
    }
  }

  class AuteurManager{
    private function dbConnect() {
      $bdd = new PDO('mysql:host=localhost;dbname=livre;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      return $bdd;
    }

    public function add(Auteur $auteur) {
      $req = $this->dbConnect()->prepare('INSERT INTO auteur(nom_a, prenom_a, date_naissance_a, id_p) VALUES(:nom, :prenom, :birth, :pays)');
      $req->bindValue(':nom', $auteur->nom_a(), PDO::PARAM_STR);
      $req->bindValue(':prenom', $auteur->prenom_a(), PDO::PARAM_STR);
      $req->bindValue(':birth', $auteur->date_naissance_a());
      $req->bindValue(':pays', $auteur->id_p());
  
      $req->execute();

      return $this->dbConnect()->lastInsertId();
    }

    public function delete(Auteur $auteur) {
      $this->dbConnect()->exec('DELETE FROM auteur WHERE id_a = '.$auteur->id_a());
    }

    public function get($id) {
      $id = (int) $id;
  
      $req = $this->dbConnect()->prepare('SELECT * FROM auteur WHERE id_a = ?');
      $req->execute(array($id));
      $donnees = $req->fetch(PDO::FETCH_ASSOC);
      $auteur = new Auteur();
      $auteur->hydrate($donnees);
      return $auteur;
    }

    public function getAll() {
      $auteur = [];
  
      $req = $this->dbConnect()->query('SELECT * FROM auteur');
  
      while($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
        $a = new Auteur();
        $a->hydrate($donnees);
        $auteur[] = $a;
      }
  
      return $auteur;
    }

    public function update(Auteur $auteur) {
      $req = $this->dbConnect()->prepare('UPDATE auteur SET nom_a = :nom, prenom_a = :prenom, date_naissance_a = :birth, id_p = :pays WHERE id_a = :id');
  
      $req->bindValue(':id', $auteur->id_a(), PDO::PARAM_INT);
      $req->bindValue(':nom', $auteur->nom_a(), PDO::PARAM_STR);
      $req->bindValue(':prenom', $auteur->prenom_a(), PDO::PARAM_STR);
      $req->bindValue(':birth', $auteur->date_naissance_a());
      $req->bindValue(':pays', $auteur->id_p(), PDO::PARAM_INT);
  
      $req->execute();
    }

    public function getPaysDetails($id) {
      $paysManager = new PaysManager();
      $res = $paysManager->get($id);
      return $res;
    }
  }
?>