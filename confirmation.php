<?php
// Reprise de la séance
session_start(); 

// Vérifiez si des données de confirmation existent dans la session
if (isset($_SESSION['confirmation_data'])) {
    // Récuperer les données de confirmation de la session
    $confirmation_data = $_SESSION['confirmation_data'];

    // Annuler la variable de session après la récupération
    unset($_SESSION['confirmation_data']);
} else {
    // Gérer le cas où les données ne sont pas trouvées
    $confirmation_data = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/main.css">
    <title>Confirmation de la réservation</title>
</head>
<body>
    <section class="reservation-result-section">
        <div class="confirmation-container">
            <h1>Confirmation de la réservation</h1>
            <div class="confirmation-text">
                <?php if (!empty($confirmation_data)): ?>
                    <div class="value-confirmation"><p>Type de voiture: <span><?php echo htmlspecialchars($confirmation_data['type']); ?></span></p></div>
                    <div class="value-confirmation"><p>Marque de la voiture: <span><?php echo htmlspecialchars($confirmation_data['make']); ?></span></p></div>
                    <div class="value-confirmation"><p>Modèle de voiture: <span><?php echo htmlspecialchars($confirmation_data['model']); ?></span></p></div>
                    <div class="value-confirmation"><p>Couleur de la voiture: <span><?php echo htmlspecialchars($confirmation_data['color']); ?></span></p></div>
                    <div class="value-confirmation"><p>Date d'arrivée: <span><?php echo htmlspecialchars($confirmation_data['checkInDate']); ?></span></p></div>
                    <div class="value-confirmation"><p>Heure d'arrivée: <span><?php echo htmlspecialchars($confirmation_data['checkInTime']); ?></span></p></div>
                    <div class="value-confirmation"><p>Date de retour: <span><?php echo htmlspecialchars($confirmation_data['checkOutDate']); ?></span></p></div>
                    <div class="value-confirmation"><p>Heure de retour: <span><?php echo htmlspecialchars($confirmation_data['checkOutTime']); ?></span></p></div>
                    <div class="value-confirmation"><p>Nom: <span><?php echo htmlspecialchars($confirmation_data['nom']); ?></span></p></div>
                    <div class="value-confirmation"><p>Prénom: <span><?php echo htmlspecialchars($confirmation_data['prenom']); ?></span></p></div>
                    <div class="value-confirmation"><p>Email: <span><?php echo htmlspecialchars($confirmation_data['email']); ?></span></p></div>
                    <div class="value-confirmation"><p>Téléphone: <span><?php echo htmlspecialchars($confirmation_data['telephone']); ?></span></p></div>
                <?php else: ?>
                    <p>Les données de confirmation ne sont pas disponibles.</p>
                <?php endif; ?>
            </div>
            <a href="index.php" class="header-box_btn deals-link return-primary-btn">Retour à la page principale</a>
            <a href="booking-list.php" class="header-box_btn deals-link return-secondary-btn">Afficher la liste des réservations</a>
        </div>
    </section>
</body>
</html>
