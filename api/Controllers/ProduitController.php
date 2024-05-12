<?php

require_once './Services/ProduitService.php';
require_once './Helpers/ResponseHelper.php';

class ProduitController {
    private $produitService;

    public function __construct() {
        $this->produitService = new ProduitService(new ProduitRepository());
    }

    public function processRequest($method, $uri) {
        switch ($method) {
            case 'GET':
                if (isset($uri[3])) {
                    $this->getProduit($uri[3]);
                } else {
                    $this->getAllProduits();
                }
                break;
            case 'POST':
                $this->createProduit();
                break;
            case 'PUT':
                if (isset($uri[3])) {
                    $this->updateProduit($uri[3]);
                }
                break;
            case 'DELETE':
                if (isset($uri[3])) {
                    $this->deleteProduit($uri[3]);
                }
                break;
            default:
                ResponseHelper::sendNotFound("Method not supported.");
                break;
        }
    }

    private function getProduit($id) {
        $produit = $this->produitService->getProduitById($id);
        if (!$produit) {
            ResponseHelper::sendNotFound("Produit not found.");
        } else {
            ResponseHelper::sendResponse($produit);
        }
    }

    private function getAllProduits() {
        $produits = $this->produitService->getAllProduits();
        ResponseHelper::sendResponse($produits);
    }

    private function createProduit() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $this->produitService->saveProduit($data);
        ResponseHelper::sendResponse(['message' => 'Produit created successfully', 'id' => $id], 201);
    }

    private function updateProduit($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->produitService->saveProduit(array_merge(['id_produit' => $id], $data));
        ResponseHelper::sendResponse(['message' => 'Produit updated successfully']);
    }

    private function deleteProduit($id) {
        $this->produitService->deleteProduit($id);
        ResponseHelper::sendResponse(['message' => 'Produit deleted successfully']);
    }
}
