<?php
require_once 'classes/CRUD.php';

// Instantiate CRUD object
$crud = new CRUD();

// Check if ID parameter exists in URL
if (isset($_GET['id'])) {
    // Sanitize the ID parameter
    $booking_id = htmlspecialchars($_GET['id']);
    
    try {
        // Prepare SQL query to fetch booking details with client and car info
        $sql = "SELECT 
                    b.id AS booking_id,
                    b.check_in_date,
                    b.check_in_time,
                    b.check_out_date,
                    b.check_out_time,
                    c.id AS client_id,
                    c.name AS client_name,
                    c.surname AS client_surname,
                    c.email AS client_email,
                    c.phone AS client_phone,
                    ca.id AS car_id,
                    ca.type AS car_type,
                    ca.make AS car_make,
                    ca.model AS car_model,
                    ca.color AS car_color
                FROM 
                    booking b
                    INNER JOIN client c ON b.client_id = c.id
                    INNER JOIN car ca ON b.car_id = ca.id
                WHERE 
                    b.id = :booking_id";
        
        // Prepare and execute SQL statement
        $stmt = $crud->prepare($sql);
        $stmt->bindValue(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Fetch the booking data
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($booking) {
            // Display the booking details
            ?>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="assets/css/main.css">
                <title>Booking Details</title>
            </head>
            <body>
                <section   ion class="reservation-result-section">
                    <div class="confirmation-container">
                        <div class="confirmation-header">
                            <h1>Détails de la réservation <span><?php echo $booking['booking_id'];?></span></h1>
                            <h2>Du client <span><?php echo $booking['client_name'] . " " . $booking['client_surname'];?></span></h2>
                        </div>
                        <div class="confirmation-text">
                            <div class="value-confirmation"><p>ID de réservation: <span><?php echo htmlspecialchars($booking['booking_id']); ?></span></p></div>
                            <div class="value-confirmation"><p>Nom du client: <span><?php echo htmlspecialchars($booking['client_name']); ?></span></p></div>
                            <div class="value-confirmation"><p>Prénom du client: <span><?php echo htmlspecialchars($booking['client_surname']); ?></span></p></div>
                            <div class="value-confirmation"><p>Email du client: <span><?php echo htmlspecialchars($booking['client_email']); ?></span></p></div>
                            <div class="value-confirmation"><p>Téléphone du client: <span><?php echo htmlspecialchars($booking['client_phone']); ?></span></p></div>
                            <div class="value-confirmation"><p>Date d'arrivée: <span><?php echo htmlspecialchars($booking['check_in_date']); ?></span></p></div>
                            <div class="value-confirmation"><p>Heure d'arrivée: <span><?php echo htmlspecialchars($booking['check_in_time']); ?></span></p></div>
                            <div class="value-confirmation"><p>Date de retour: <span><?php echo htmlspecialchars($booking['check_out_date']); ?></span></p></div>
                            <div class="value-confirmation"><p>Heure de retour: <span><?php echo htmlspecialchars($booking['check_out_time']); ?></span></p></div>
                            <div class="value-confirmation"><p>Type de voiture: <span><?php echo htmlspecialchars($booking['car_type']); ?></span></p></div>
                            <div class="value-confirmation"><p>Marque de voiture: <span><?php echo htmlspecialchars($booking['car_make']); ?></span></p></div>
                            <div class="value-confirmation"><p>Modèle de voiture: <span><?php echo htmlspecialchars($booking['car_model']); ?></span></p></div>
                            <div class="value-confirmation"><p>Couleur de voiture: <span><?php echo htmlspecialchars($booking['car_color']); ?></span></p></div>
                        </div>
                        <a href="booking-list.php" class="header-box_btn deals-link return-secondary-btn">Afficher la liste des réservations</a>
                        <a href="booking-edit.php?id=<?php echo htmlspecialchars($booking['booking_id']); ?>" class="header-box_btn deals-link return-secondary-btn secondary-edit-btn">Edit</a>
                        
                        <a href="booking-delete.php" class="header-box_btn deals-link return-secondary-btn secondary-delete-btn">Delete</a>
                    </div>
                </section>
            </body>
            </html>

            <?php
        } else {
            echo 'Booking not found.';
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
} else {
    echo 'Booking ID not provided.';
}
?>
