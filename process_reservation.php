<?php
session_start(); // !!!! -->>>> Démarrer la session

require_once 'classes/CRUD.php';

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Instancier l'objet CRUD
    $crud = new CRUD();

    // Récupérer les données du formulaire
    $booking_id = isset($_POST['booking_id']) ? $_POST['booking_id'] : null;
    $client_id = isset($_POST['client_id']) ? $_POST['client_id'] : null;
    $car_id = isset($_POST['car_id']) ? $_POST['car_id'] : null;

    $type = $_POST['type'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $color = $_POST['color'];
    $checkInDate = $_POST['check-in-date'];
    $checkInTime = $_POST['check-in-time'];
    $checkOutDate = $_POST['check-out-date'];
    $checkOutTime = $_POST['check-out-time'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];

    try {
        $crud->beginTransaction(); // -->>> Démarrer une transaction SQL

        if ($booking_id) {
            // Mettre à jour les enregistrements existants

            // Mettre à jour les informations du client
            $clientData = array(
                'name' => $nom,
                'surname' => $prenom,
                'email' => $email,
                'phone' => $telephone,
            );
            $crud->update('client', $clientData, 'id', $client_id);

            // Mettre à jour les informations du véhicule
            $carData = array(
                'type' => $type,
                'make' => $make,
                'model' => $model,
                'color' => $color
            );
            $crud->update('car', $carData, 'id', $car_id);

            // Mettre à jour les informations de réservation
            $bookingData = array(
                'check_in_date' => $checkInDate,
                'check_in_time' => $checkInTime,
                'check_out_date' => $checkOutDate,
                'check_out_time' => $checkOutTime
            );
            $crud->update('booking', $bookingData, 'id', $booking_id);
        } else {
            // Insérer de nouveaux enregistrements

            // Insérer dans la table `client`
            $clientData = array(
                'name' => $nom,
                'surname' => $prenom,
                'email' => $email,
                'phone' => $telephone,
            );
            $client_id = $crud->insert('client', $clientData);

            // Insérer dans la table `car`
            $carData = array(
                'type' => $type,
                'make' => $make,
                'model' => $model,
                'color' => $color
            );
            $car_id = $crud->insert('car', $carData);

            // Insérer dans la table `booking`
            $bookingData = array(
                'car_id' => $car_id,
                'client_id' => $client_id,
                'check_in_date' => $checkInDate,
                'check_in_time' => $checkInTime,
                'check_out_date' => $checkOutDate,
                'check_out_time' => $checkOutTime
            );
            $booking_id = $crud->insert('booking', $bookingData);
        }

        // Valider la transaction
        $crud->commit();

        // Optionnellement, stocker les données du formulaire en session pour la page de confirmation
        $_SESSION['confirmation_data'] = [
            'type' => $type,
            'make' => $make,
            'model' => $model,
            'color' => $color,
            'checkInDate' => $checkInDate,
            'checkInTime' => $checkInTime,
            'checkOutDate' => $checkOutDate,
            'checkOutTime' => $checkOutTime,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'telephone' => $telephone
        ];

        // Rediriger vers la page de confirmation ou la liste des réservations
        if ($booking_id) {
            header('Location: confirmation.php');
        } else {
            header('Location: booking-list.php');
        }
        exit();
    } catch (PDOException $e) {
        $crud->rollBack(); // -->>>>> Annuler la transaction en cas d'erreur
        echo "Erreur : " . $e->getMessage(); // ->>>> Afficher l'erreur PDO
    }
}
?>
