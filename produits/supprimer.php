<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    include_once '../config/Database.php';
    include_once '../models/Produits.php';

    $database = new Database();
    $db = $database->getConnexion();

    $produit = new Produits($db);

    $donnees = json_decode(file_get_contents("php://input"));

    if (!empty($donnees->id)) {

        $produit->id = $donnees->id;

        if ($produit->selectById()) {

            if ($produit->supprimer()) {
                http_response_code(200);
                echo json_encode(["message" => "La suppression a été effectuée"]);
            } else {
                http_response_code(503);
                echo json_encode(["message" => "La suppression n'a pas été effectuée"]);
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
