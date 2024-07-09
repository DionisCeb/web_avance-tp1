<?php

require_once 'classes/CRUD.php';

/*Instance du crud*/
$crud = new CRUD();
/*Verifier si le formulaire a ete summit*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Confirmation</title>
</head>
<body>
    <h1>Reservation Confirmation</h1>
    <?php
    echo $type;
    echo $make;
    echo $model;
    echo $color;
    echo $checkInDate;
    echo $checkInTime;
    echo $checkOutDate;
    echo $checkOutTime;
    echo $nom;
    echo $prenom;
    echo $email;
    echo $telephone;
    ?>
    <a href="index.php">Return on the main page</a>
</body>
</html>