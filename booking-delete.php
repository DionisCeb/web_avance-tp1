<?php
require_once 'classes/CRUD.php';

if (isset($_GET['id'])) {
    $booking_id = htmlspecialchars($_GET['id']);
    
    // Instancier l'objet CRUD
    $crud = new CRUD();

    // Tentative de suppression de la réservation
    if ($crud->delete('booking', $booking_id)) {
        // Suppression réussie
        header('Location: booking-list.php');
        exit();
    } else {
        // La suppression a échoué
        echo 'Échec de la suppression de la réservation.';
    }
} else {
    echo 'Numéro de réservation non fourni.';
}
?>
