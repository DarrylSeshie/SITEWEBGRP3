<?php
require_once 'models/Donne.class.php';
class DonneManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getDonneForm($id_utilisateur)
    {
        $currentDate = date("Y-m-d");

        $sql = "SELECT produit.*, utilisateur.*, donne.* 
                FROM donne 
                JOIN produit ON produit.id_produit = donne.id_produit 
                JOIN utilisateur ON utilisateur.id_utilisateur = donne.id_utilisateur 
                WHERE donne.id_utilisateur = :id_utilisateur 
                AND produit.date_fin < CURDATE()";

        $donnes = [];

        try {
            $prep = $this->db->prepare($sql);
            $prep->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
            $prep->execute();
            $result = $prep->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $donneData) {
                $donne = new Donne();
                $donne->setIdProduit($donneData['id_produit']);
                $donne->setIdUtilisateur($donneData['id_utilisateur']);
                $donnes[] = $donne;
            }
        } catch (PDOException $e) {
            throw $e;
        } finally {
            $prep = null;
        }

        return $donnes;
    }
}
?>
