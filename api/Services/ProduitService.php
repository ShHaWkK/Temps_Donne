<?php

require_once './Repository/ProduitRepository.php';
require_once './Models/ProduitModel.php';

class ProduitService {
    private $produitRepository;

    public function __construct(ProduitRepository $produitRepository) {
        $this->produitRepository = $produitRepository;
    }

    public function getAllProduits() {
        return $this->produitRepository->findAll();
    }

    public function getProduitById($id) {
        return $this->produitRepository->findById($id);
    }

    public function saveProduit($data) {
        $produit = new ProduitModel($data);
        return $this->produitRepository->save($produit);
    }

    public function deleteProduit($id) {
        return $this->produitRepository->delete($id);
    }
}
?>