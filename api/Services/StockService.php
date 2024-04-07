<?php

require_once 'StockRepository.php';
require_once 'Models/StockModel.php';

class StockService {
    private $repository;

    public function __construct(StockRepository $repository) {
        $this->repository = $repository;
    }

    public function getAllStocks() {
        return $this->repository->findAll();
    }

    public function getStockById($id) {
        return $this->repository->findById($id);
    }

    public function addStock($data) {
        try {
            $stock = new StockModel($data);
            return $this->repository->save($stock);
        } catch (Exception $e) {
            
            throw $e;
        }
    }

    public function updateStock($id, $data) {
        try {
            $existingStock = $this->repository->findById($id);
            if (!$existingStock) {
                throw new Exception("Stock not found with ID: $id", 404);
            }
            $updatedStock = new StockModel(array_merge($existingStock, $data));
            return $this->repository->save($updatedStock);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteStock($id) {
        try {
            return $this->repository->delete($id);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
