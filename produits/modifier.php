<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    include_once '../config/Database.php';
    include_once '../models/Produits.php';

    $database = new Database();
    $db = $database->getConnexion();

    $produit = new Produits($db);

    $donnees = json_decode(file_get_contents("php://input"));


    if (!empty($donnees->id) && !empty($donnees->nom) && !empty($donnees->description) && !empty($donnees->prix) && !empty($donnees->categories_id)) {

        $produit->id = $donnees->id;
        $produit->nom = $donnees->nom;
        $produit->description = $donnees->description;
        $produit->prix = $donnees->prix;
        $produit->categories_id = $donnees->categories_id;

        if ($produit->selectById()) {

            if ($produit->modifier()) {
                http_response_code(201);
                echo json_encode(["message" => "La modification a été effectuée"]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "La modification n'a pas été effectuée"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Le produit n'existe pas"]);
        }
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
