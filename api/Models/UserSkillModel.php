<?php
class UserSkillModel
{
public $id_utilisateur;
public $id_competence;

public function __construct($data)
{
$this->id_utilisateur = $data['ID_Utilisateur'];
$this->id_competence = $data['ID_Competence'];
}
}
?>