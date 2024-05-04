<?php
class EntrepotRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function save($entrepot) {
        $stmt = $this->db->prepare("INSERT INTO Entrepots (nom, adresse, taille, nb_etageres, nb_etageres_max, nb_etageres_remplie, place_restante, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $entrepot->nom, $entrepot->adresse, $entrepot->taille, $entrepot->nb_etageres, $entrepot->nb_etageres_max, $entrepot->nb_etageres_remplie, $entrepot->place_restante, $entrepot->latitude, $entrepot->longitude
        ]);
        return $this->db->lastInsertId();
    }

    public function findAll() {
        $stmt = $this->db->query("SELECT * FROM Entrepots");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Entrepots WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($entrepot) {
        $stmt = $this->db->prepare("UPDATE Entrepots SET nom = ?, adresse = ?, taille = ?, nb_etageres = ?, nb_etageres_max = ?, nb_etageres_remplie = ?, place_restante = ?, latitude = ?, longitude = ? WHERE id = ?");
        $stmt->execute([
            $entrepot->nom, $entrepot->adresse, $entrepot->taille, $entrepot->nb_etageres, $entrepot->nb_etageres_max, $entrepot->nb_etageres_remplie, $entrepot->place_restante, $entrepot->latitude, $entrepot->longitude, $entrepot->id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Entrepots WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
