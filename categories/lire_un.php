<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    include_once '../config/Database.php';
    include_once '../models/Categories.php';

    $database = new Database();
    $db = $database->getConnexion();

    $categorie = new Categories($db);

    $donnees = json_decode(file_get_contents("php://input"));


    if (!empty($donnees->id)) {

        $categorie->id = $donnees->id;

        if ($categorie->selectById()) {

            $categorie->lireUn();

            $data = [
                "id" => $categorie->id,
                "nom" => $categorie->nom,
                "description" => $categorie->description,
            ];

            http_response_code(200);
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "La categorie n'existe pas"]);
        }
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
