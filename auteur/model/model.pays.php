<?php
  class Pays {
    private $id_p;
    private $nom_p;

    public function id_p() {return $this->id_p;}
    public function nom_p() {return $this->nom_p;}

    public function setId_p($id) {
      $this->id_p = $id;
    }

    public function setNom_p($nom) {
      $this->nom_p = $nom;
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

  class PaysManager {
    private function dbConnect() {
      $bdd = new PDO('mysql:host=localhost;dbname=livre;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      return $bdd;
    }

    public function add(Pays $pays) {
      $req = $this->dbConnect()->prepare('INSERT INTO pays(nom_p) VALUES(:nom_p)');
      $req->bindValue(':nom_p', $pays->nom_p(), PDO::PARAM_STR);
      $req->execute();
      return $this->dbConnect()->lastInsertId();
    }

    public function delete(Pays $pays) {
      $this->dbConnect()->exec('DELETE FROM pays WHERE id_p = '.$pays->id_p());
    }

    public function get($id) {
      $id = (int) $id;
  
      $req = $this->dbConnect()->prepare('SELECT * FROM pays WHERE id_p = ?');
      $req->execute(array($id));
      $donnees = $req->fetch(PDO::FETCH_ASSOC);
      $pays = new Pays();
      $pays->hydrate($donnees);
      return $pays;
    }

    public function getAll() {
      $pays = [];
  
      $req = $this->dbConnect()->query('SELECT * FROM pays');
  
      while($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
        $p = new Pays();
        $p->hydrate($donnees);
        $pays[] = $p;
      }
  
      return $pays;
    }

    public function update(Pays $pays) {
      $req = $this->dbConnect()->prepare('UPDATE pays SET nom_p = :nom WHERE id_p = :id');
  
      $req->bindValue(':id', $pays->id_p(), PDO::PARAM_INT);
      $req->bindValue(':nom', $pays->nom_p(), PDO::PARAM_STR);
  
      $req->execute();
    }

    public function getAuteurByPays($pays) {
      $req = $this->dbConnect()->prepare('SELECT * FROM auteur, pays WHERE pays.id_p = ? AND pays.id_p = auteur.id_p');
      $req->execute(array($pays));
      $auteurs = [];
      while($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
        $aut = new Auteur();
        $aut->hydrate($donnees);
        $auteurs[] = $aut;
      }

      if(sizeof($auteurs) > 0) {
        return $auteurs;
      } else {
        return false;
      }
    }
  }
?>