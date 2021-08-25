<?php

  class User {
    private $id_users;
    private $pseudo;
    private $mail;
    private $password;

    public function id_users() {return $this->id_users;}
    public function pseudo() {return $this->pseudo;}
    public function mail() {return $this->mail;}
    public function password() {return $this->password;}

    public function setId_users($id) {
      $this->id_users =$id;
    }

    public function setPseudo($pseudo) {
      $this->pseudo =$pseudo;
    }

    public function setMail($mail) {
      $this->mail =$mail;
    }

    public function setPassword($password) {
      $this->password =$password;
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

  class UserManager {
    private function dbConnect() {
      $bdd = new PDO('mysql:host=localhost;dbname=livre;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      return $bdd;
    }

    public function add(User $user) {

      $req = $this->dbConnect()->prepare('INSERT INTO users(pseudo, mail, password) VALUES(:pseudo, :mail, :password)');
      $req->bindValue(':pseudo', $user->pseudo(), PDO::PARAM_STR);
      $req->bindValue(':mail', $user->mail());
      $req->bindValue(':password', $user->password(), PDO::PARAM_STR);
  
      $req->execute();

      return $this->dbConnect()->lastInsertId();
     }
  
     public function delete(User $user) {
       $this->dbConnect()->exec('DELETE FROM users WHERE id_users = '.$user->id_users());
     }
  
     public function get($id) {
      $id = (int) $id;
  
      $req = $this->dbConnect()->prepare('SELECT * FROM users WHERE id_users = ?');
      $req->execute(array($id));
      $donnees = $req->fetch(PDO::FETCH_ASSOC);
      $user = new User();
      $user->hydrate($donnees);
      return $user;
     }
  
     public function getAll() {
      $users = [];
  
      $req = $this->dbConnect()->query('SELECT * FROM users');
  
      while($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
        $user = new User();
        $user->hydrate($donnees);
        $users[] = $user;
      }
  
      return $users;
     }
  
     public function update(User $user) {
      $req = $this->dbConnect()->prepare('UPDATE users SET pseudo = :pseudo, mail = :mail, password = :password WHERE id_users = :id');
  
      $req->bindValue(':id', $user->id_users(), PDO::PARAM_INT);
      $req->bindValue(':pseudo', $user->pseudo(), PDO::PARAM_STR);
      $req->bindValue(':mail', $user->mail());
      $req->bindValue(':password', $user->password(), PDO::PARAM_STR);
  
      $req->execute();
     }
  
  
     public function login($pseudo) {
        $req = $this->dbConnect()->prepare('SELECT * FROM users WHERE pseudo = ?');
        $req->execute(array($pseudo));
        if($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            $user = new User();
            $user->hydrate($donnees);
            return $user;
        } else {
          return false;
        }
     }
  }

?>