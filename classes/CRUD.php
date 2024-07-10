<?php
class CRUD extends PDO {
    // Constructeur pour initialiser la connexion à la base de données
    public function __construct(){
        parent::__construct('mysql:host=localhost;dbname=e2396498;port=3306; charset=utf8', 'e2396498','hwxwbUZdl5nmurjwLyPr');
    }

    // Méthode pour sélectionner toutes les lignes d'une table avec un tri optionnel
    public function select($table, $field = 'id', $order = 'ASC') {
        $sql = "SELECT * FROM $table ORDER BY $field $order";
        $stmt = $this->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour sélectionner une ligne spécifique d'une table par son ID
    public function selectById($table, $value, $field = 'id') {
        $sql = "SELECT * FROM $table WHERE $field = :value";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':value', $value, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour insérer des données dans une table
    public function insert($table, $data) {
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $stmt = $this->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $this->lastInsertId();
    }

    // Méthode pour mettre à jour des données dans une table
    public function update($table, $data, $value, $field = 'id') {
        $fields = '';
        foreach ($data as $key => $val) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ', ');

        $sql = "UPDATE $table SET $fields WHERE $field = :value";
        $stmt = $this->prepare($sql);

        foreach ($data as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }
        $stmt->bindValue(':value', $value, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Méthode pour supprimer une ligne d'une table
    public function delete($table, $value, $field = 'id') {
        try {
            $sql = "DELETE FROM $table WHERE $field = :value";
            $stmt = $this->prepare($sql);
            $stmt->bindValue(':value', $value, PDO::PARAM_INT); // En supposant que $value est un entier, ajuster si nécessaire
            $stmt->execute();
            return $stmt->rowCount() > 0; // Retourne vrai si au moins une ligne a été affectée
        } catch (PDOException $e) {
            // Gérer l'erreur de manière appropriée
            echo "Erreur : " . $e->getMessage();
            return false; // Retourne faux en cas d'erreur
        }
    }
}
?>
