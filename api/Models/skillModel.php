<?php
class SkillModel
{
public $id_competence;
public $nom_competence;
public $description;

public function __construct($data)
{
$this->id_competence = $data['ID_Competence'];
$this->nom_competence = $data['Nom_Competence'];
$this->description = $data['Description'];
}
}
?>