<?php

class Produits
{
    // Connexion
    private $connexion;
    private $table = "produits";

    // object properties
    public $id;
    public $nom;
    public $description;
    public $prix;
    public $categories_id;
    public $categories_nom;
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
     * Lecture des produits
     *
     * @return mixed
     */
    public function lire()
    {

        $sql = "SELECT c.nom as categories_nom, p.id, p.nom, p.description, p.prix, p.categories_id, p.created_at 
        FROM " . $this->table . " p LEFT JOIN categories c ON p.categories_id = c.id ORDER BY p.created_at DESC";

        $query = $this->connexion->prepare($sql);
        $query->execute();
        return $query;
    }


    /**
     * Créer un produit
     *
     * @return void
     */
    public function creer()
    {
        $sql = "INSERT INTO " . $this->table . " SET nom=:nom, prix=:prix, description=:description, categories_id=:categories_id";

        $query = $this->connexion->prepare($sql);

        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prix = htmlspecialchars(strip_tags($this->prix));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->categories_id = htmlspecialchars(strip_tags($this->categories_id));

        $query->bindParam(":nom", $this->nom, PDO::PARAM_STR);
        $query->bindParam(":prix", $this->prix, PDO::PARAM_STR);
        $query->bindParam(":description", $this->description, PDO::PARAM_STR);
        $query->bindParam(":categories_id", $this->categories_id, PDO::PARAM_INT);

        if ($query->execute()) {
            return true;
        }
        return false;
    }


    /**
     * Lire un produit
     *
     * @return void
     */
    public function lireUn()
    {
        $sql = "SELECT c.nom as categories_nom, p.id, p.nom, p.description, p.prix, p.categories_id, p.created_at 
        FROM " . $this->table . " p LEFT JOIN categories c ON p.categories_id = c.id WHERE p.id = ? LIMIT 0,1";

        $query = $this->connexion->prepare($sql);
        $query->bindParam(1, $this->id, PDO::PARAM_INT);
        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $this->nom = $row['nom'];
        $this->prix = $row['prix'];
        $this->description = $row['description'];
        $this->categories_id = $row['categories_id'];
        $this->categories_nom = $row['categories_nom'];
    }


    /**
     * Supprimer un produit
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
     * Mettre à jour un produit
     *
     * @return void
     */
    public function modifier()
    {
        $sql = "UPDATE " . $this->table . " SET nom = :nom, prix = :prix, description = :description, categories_id = :categories_id WHERE id = :id";

        $query = $this->connexion->prepare($sql);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prix = htmlspecialchars(strip_tags($this->prix));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->categories_id = htmlspecialchars(strip_tags($this->categories_id));

        $query->bindParam(":id", $this->id, PDO::PARAM_INT);
        $query->bindParam(":nom", $this->nom, PDO::PARAM_STR);
        $query->bindParam(":prix", $this->prix, PDO::PARAM_STR);
        $query->bindParam(":description", $this->description, PDO::PARAM_STR);
        $query->bindParam(":categories_id", $this->categories_id, PDO::PARAM_INT);

        if ($query->execute()) {
            return true;
        }
        return false;
    }


    /**
     * Vérifier si le produit existe
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
     * Vérifier si la reférence du produit existe
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
