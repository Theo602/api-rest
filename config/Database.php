<?php

class Database
{
    // Propriété de la base de données

    private $host = "localhost";
    private $db_name = "api_rest";
    private $username = "root";
    private $password = "";
    private $connexion;


    public function getConnexion()
    {

        // On commence par fermer la connexion si elle existait
        $this->connexion = null;

        // On essaie de se connecter
        try {
            $this->connexion = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                )
            );
        } catch (PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        // On retourne la connexion;
        return  $this->connexion;
    }
}
