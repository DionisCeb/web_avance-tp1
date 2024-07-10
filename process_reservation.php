<?php
session_start(); // Start session

require_once 'classes/CRUD.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Instantiate CRUD object
    $crud = new CRUD();

    // Retrieve form data
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
        $crud->beginTransaction();

        $clientData = array(
            'name' => $nom,
            'surname' => $prenom,
            'email' => $email,
            'phone' => $telephone,
        );
        $client_id = $crud->insert('client', $clientData);

        // Insert into `car` table
        $carData = array(
            'type' => $type,
            'make' => $make,
            'model' => $model,
            'color' => $color
        );
        $car_id = $crud->insert('car', $carData);

        // Insert into `booking` table
        $bookingData = array(
            'car_id' => $car_id,
            'client_id' => $client_id,
            'check_in_date' => $checkInDate,
            'check_in_time' => $checkInTime,
            'check_out_date' => $checkOutDate,
            'check_out_time' => $checkOutTime
        );
        $booking_id = $crud->insert('booking', $bookingData);

        // Commit transaction
        $crud->commit();

        // Store form data in session
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

        // Redirect to confirmation page
        header('Location: confirmation.php');
        exit();
    } catch (PDOException $e) {
        $crud->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
