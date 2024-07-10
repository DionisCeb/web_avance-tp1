<?php
require_once 'classes/CRUD.php';

// Instance CRUD
$crud = new CRUD();

// // Récupère les données combinées des tables de réservations, de clients et de voitures
$sql = "SELECT b.id AS booking_id, c.id AS client_id, ca.id AS car_id, c.name AS client_name, c.surname AS client_surname, 
               c.email AS client_email, c.phone AS client_phone, 
               b.check_in_date, b.check_in_time, b.check_out_date, b.check_out_time, 
               ca.type AS car_type, ca.make AS car_make, ca.model AS car_model, ca.color AS car_color
        FROM booking b
        INNER JOIN client c ON b.client_id = c.id
        INNER JOIN car ca ON b.car_id = ca.id";
$stmt = $crud->query($sql);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/main.css">
    <title>Booking list</title>
</head>
<body>
    <main class="admin-interface">
        <div class="admin-container">
            <h1>Gestion des réservations</h1>
            <table class="booking-list-table">
                <tr>
                    <th>id</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Date d'arrivée</th>
                    <th>L'heure d'arrivée</th>
                    <th>Jour de retour</th>
                    <th>L'heure de retour</th>
                    <th>Type de voiture</th>
                    <th>Marque de voiture</th>
                    <th>Modèle de voiture</th>
                    <th>Couleur de la voiture</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
                <?php foreach ($bookings as $booking): ?>
                <tr>
                <td><a href="booking-index.php?id=<?php echo htmlspecialchars($booking['booking_id']); ?>"><?php echo htmlspecialchars($booking['booking_id']); ?></a></td>
                    <td></a><?php echo htmlspecialchars($booking['client_name']); ?></td>
                    <td><?php echo htmlspecialchars($booking['client_surname']); ?></td>
                    <td><?php echo htmlspecialchars($booking['client_email']); ?></td>
                    <td><?php echo htmlspecialchars($booking['client_phone']); ?></td>
                    <td><?php echo htmlspecialchars($booking['check_in_date']); ?></td>
                    <td><?php echo htmlspecialchars($booking['check_in_time']); ?></td>
                    <td><?php echo htmlspecialchars($booking['check_out_date']); ?></td>
                    <td><?php echo htmlspecialchars($booking['check_out_time']); ?></td>
                    <td><?php echo htmlspecialchars($booking['car_type']); ?></td>
                    <td><?php echo htmlspecialchars($booking['car_make']); ?></td>
                    <td><?php echo htmlspecialchars($booking['car_model']); ?></td>
                    <td><?php echo htmlspecialchars($booking['car_color']); ?></td>
                    <td><button class="booking-list-btn edit-btn">Modifier</button></td>
                    <td><button class="booking-list-btn delete-btn">Supprimer</button></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
</body>
</html>
