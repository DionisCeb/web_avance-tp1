<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/main.css">
    <title>Booking Delete</title>
</head>
<body>
    <section   ion class="reservation-result-section">
        <div class="confirmation-container">
            <div class="confirmation-header">
                <h1>Supprimer la réservation <span><?php echo $booking['booking_id'];?></span></h1>
                <h2>Du client <span><?php echo $booking['client_name'] . " " . $booking['client_surname'];?></span></h2>
            </div>
            <a href="booking-list.php" class="header-box_btn deals-link return-secondary-btn">Retour à la liste des réservations</a>
            <button class="header-box_btn deals-link return-secondary-btn secondary-delete-btn">Suprimmer</button>
        </div>
</section>
</body>
</html>