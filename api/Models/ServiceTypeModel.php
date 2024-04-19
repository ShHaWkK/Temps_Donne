<?php
class ServiceTypeModel
{
    public $id_serviceType;
    public $nom_Type_Service;

    public function __construct($data = [])
    {   $this->id_serviceType = $data['ID_ServiceType'] ?? null;
        $this->nom_Type_Service = $data['Nom_Type_Service'] ?? null;
    }
}
?>