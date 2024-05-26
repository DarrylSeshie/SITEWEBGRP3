<?php

class DBManager
{
  private $db;

  public function connect()
  {
    try {
      $this->db = new PDO('mysql:host=127.0.0.1;dbname=ceref' , "root", "");
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      $msg = 'ERREUR PDO dans ' . $e->getFile() . ' Ligne : ' . $e->getLine() . ' : ' . $e->getMessage();
      die($msg); // Arrête le script et affiche l'erreur en cas d'échec de la connexion
    }
    return $this->db;
  }

  public function disconnect()
  {
    $this->db = null; 
  }
}

?>