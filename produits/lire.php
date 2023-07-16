<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    include_once '../config/Database.php';
    include_once '../models/Produits.php';

    $database = new Database();
    $db = $database->getConnexion();

    $produit = new Produits($db);

    $stmt = $produit->lire();

    if ($stmt->rowCount() > 0) {

        $tableauProduit = [];
        $tableauProduit['produits'] = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($row);

            $prod = [
                "id" => $id,
                "nom" => $nom,
                "description" => $description,
                "prix" => $prix,
                "categories_id" => $categories_id,
                "categories_nom" => $categories_nom
            ];

            $tableauProduit['produits'][] = $prod;
        }
        http_response_code(200);
        echo json_encode($tableauProduit);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
