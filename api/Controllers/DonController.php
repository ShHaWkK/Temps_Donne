<?php


class DonController
{
    private $donService;

    public function processRequest($method, $uri)
    {
        try {
            switch ($method) {
                case 'GET':
                    if (isset($uri[3])) {
                        $this->getDon($uri[3]);
                    } else {
                        $this->getAllDons();
                    }
                    break;
                case 'POST':
                    $this->createDon();
                    break;
                case 'PUT':
                    if (isset($uri[3])) {
                        $this->updateDon($uri[3]);
                    }
                    break;
                case 'DELETE':
                    if (isset($uri[3])) {
                        $this->deleteDon($uri[3]);
                    }
                    break;
                default:
                    ResponseHelper::sendResponse(['message' => 'Method Not Allowed'], 405);
                    break;
            }
        } catch (Exception $e) {
            ResponseHelper::sendResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function __construct()
    {
        $db = connectDB();
        $donRepository = new DonRepository($db);
        $this->donService = new DonService($donRepository);
    }

    public function getAllDons()
    {
        $dons = $this->donService->getDons();
        if (!$dons) {
            ResponseHelper::sendNotFound("No dons found.");
        } else {
            ResponseHelper::sendResponse($dons);
        }
    }

    public function getDon($id)
    {
        $don = $this->donService->getDonById($id);
        if (!$don) {
            ResponseHelper::sendNotFound("Don not found.");
        } else {
            ResponseHelper::sendResponse($don);
        }
    }

    public function createDon()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $don = new Don(null, $data['montant'], $data['type_don'], $data['date_don'], $data['id_donateur'], $data['commentaires'], $data['id_source']);
        $result = $this->donService->createDon($don);
        if ($result) {
            ResponseHelper::sendResponse(['message' => 'Don created successfully.']);
        } else {
            ResponseHelper::sendResponse(['message' => 'Failed to create don.'], 500);
        }
    }
}
    ?>