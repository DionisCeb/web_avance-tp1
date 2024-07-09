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
                    <th>Prenom</th>
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
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Dionis</td>
                    <td>Cebanu</td>                   
                    <td>dionis@gmail.com</td>
                    <td>342 323 4323</td>
                    <td>25.09.24</td>
                    <td>10:00</td>
                    <td>28.09.24</td>
                    <td>15:00</td>
                    <td>SUV</td>
                    <td>Toyota</td>
                    <td>Tundra</td>
                    <td>Noire</td>
                    <td><button class="booking-list-btn edit-btn">Edit</button></td>
                    <td><button class="booking-list-btn delete-btn">Delete</button></td>
                </tr>
                
            </table>
        </div>
    </main>
</body>
</html>