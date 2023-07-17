<?php

class Categories
{
    // Connexion
    private $connexion;
    private $table = "categories";

    // object properties
    public $id;
    public $nom;
    public $description;
    public $created_at;


    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db)
    {
        $this->connexion = $db;
    }


    /**
     * Lecture des categories
     *
     * @return mixed
     */
    public function lire()
    {

        $sql = "SELECT id, nom, description, created_at FROM " . $this->table;

        $query = $this->connexion->prepare($sql);
        $query->execute();
        return $query;
    }


    /**
     * Créer une categorie
     *
     * @return void
     */
    public function creer()
    {
        $sql = "INSERT INTO " . $this->table . " SET nom=:nom, description=:description";

        $query = $this->connexion->prepare($sql);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->description = htmlspecialchars(strip_tags($this->description));

        $query->bindParam(":nom", $this->nom, PDO::PARAM_STR);
        $query->bindParam(":description", $this->description, PDO::PARAM_STR);

        if ($query->execute()) {
            return true;
        }
        return false;
    }


    /**
     * Lire une categorie
     *
     * @return void
     */
    public function lireUn()
    {
        $sql = "SELECT  id, nom, description, created_at FROM " . $this->table . " WHERE id = :id LIMIT 0,1";

        $query = $this->connexion->prepare($sql);
        $query->bindParam(':id', $this->id, PDO::PARAM_INT);
        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $this->nom = $row['nom'];
        $this->description = $row['description'];
    }


    /**
     * Supprimer une categorie
     *
     * @return void
     */
    public function supprimer()
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";

        $query = $this->connexion->prepare($sql);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $query->bindParam(":id", $this->id, PDO::PARAM_INT);

        if ($query->execute()) {
            return true;
        }
        return false;
    }


    /**
     * Mettre à jour une categorie
     *
     * @return void
     */
    public function modifier()
    {
        $sql = "UPDATE " . $this->table . " SET nom = :nom, description = :description WHERE id = :id";

        $query = $this->connexion->prepare($sql);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->description = htmlspecialchars(strip_tags($this->description));

        $query->bindParam(":id", $this->id, PDO::PARAM_INT);
        $query->bindParam(":nom", $this->nom, PDO::PARAM_STR);
        $query->bindParam(":description", $this->description, PDO::PARAM_STR);

        if ($query->execute()) {
            return true;
        }
        return false;
    }


    /**
     * Vérifier si la categorie existe
     *
     * @return void
     */
    public function selectById()
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $query = $this->connexion->prepare($sql);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $query->bindParam(":id", $this->id, PDO::PARAM_INT);
        $query->execute();

        if ($query->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Vérifier si le nom de la categorie existe
     *
     * @return void
     */
    public function selectByName()
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE nom = :nom";
        $query = $this->connexion->prepare($sql);
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $query->bindParam(":nom", $this->nom, PDO::PARAM_STR);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
