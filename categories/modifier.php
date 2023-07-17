<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    include_once '../config/Database.php';
    include_once '../models/Categories.php';

    $database = new Database();
    $db = $database->getConnexion();

    $categorie = new Categories($db);

    $donnees = json_decode(file_get_contents("php://input"));


    if (!empty($donnees->id) && !empty($donnees->nom) && !empty($donnees->description)) {

        $categorie->id = $donnees->id;
        $categorie->nom = $donnees->nom;
        $categorie->description = $donnees->description;

        if ($categorie->selectById()) {

            if (!$categorie->selectByName()) {

                if ($categorie->modifier()) {
                    http_response_code(201);
                    echo json_encode(["message" => "La modification a été effectuée"]);
                } else {
                    http_response_code(503);
                    echo json_encode(["message" => "La modification n'a pas été effectuée"]);
                }
            } else {
                http_response_code(503);
                echo json_encode(["message" => "La référence de la catégorie " . $categorie->nom . " existe déjà"]);
            }
        } else {
            http_response_code(404);
            echo json_encode(["message" => "La categorie n'existe pas"]);
        }
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
