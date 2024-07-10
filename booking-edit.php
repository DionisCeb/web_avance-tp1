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
    <title>Booking Edit</title>
</head>
<body>
      <section class="form-section">
          <div class="structure">
              <div class="form-box form-box-center">
                  <div class="form-title">
                        <h1>Editer la réservation <span><?php echo $booking['booking_id'];?></span></h1>
                        <h2>Du client <span><?php echo $booking['client_name'] . " " . $booking['client_surname'];?></span></h2>
                  </div>
                  <form class="form-reservation" action="process_reservation.php" method="POST">
                  <select name="type" id="type">
                  <option value="">Choisir le type</option>
                  <option value="compact" <?php if ($booking['car_type'] === 'compact') echo 'selected'; ?>>Compacte</option>
                  <option value="sport" <?php if ($booking['car_type'] === 'sport') echo 'selected'; ?>>Sport</option>
                  <option value="suv" <?php if ($booking['car_type'] === 'suv') echo 'selected'; ?>>SUV</option>
                  <option value="luxury" <?php if ($booking['car_type'] === 'luxury') echo 'selected'; ?>>Voitures de luxe</option>
                  <option value="sedan" <?php if ($booking['car_type'] === 'sedan') echo 'selected'; ?>>Sedan</option>
              </select>

              <select name="make" id="make">
                  <option value="">Choisir la marque</option>
                  <option value="audi" <?php if ($booking['car_make'] === 'audi') echo 'selected'; ?>>Audi</option>
                  <option value="mercedes" <?php if ($booking['car_make'] === 'mercedes') echo 'selected'; ?>>Mercedes</option>
                  <option value="toyota" <?php if ($booking['car_make'] === 'toyota') echo 'selected'; ?>>Toyota</option>
                  <option value="ford" <?php if ($booking['car_make'] === 'ford') echo 'selected'; ?>>Ford</option>
              </select>

              <select name="model" id="model">
                  <option value="">Choisir le modèle</option>
                  <?php
                  $models = array(
                      'audi-a3' => 'Audi A3',
                      'audi-a4' => 'Audi A4',
                      'audi-r8' => 'Audi R8',
                      'mercedes-c-class' => 'Mercedes C-class',
                      'mercedes-a-class' => 'Mercedes A-class',
                      'mercedes-s-class' => 'Mercedes S-class',
                      'mercedes-amg-gt' => 'Mercedes AMG-GT',
                      'toyota-supra' => 'Toyota Supra',
                      'toyota-tacoma' => 'Toyota Tacoma',
                      'toyota-tundra' => 'Toyota Tundra',
                      'ford-f150' => 'Ford F-150',
                      'ford-mustang' => 'Ford Mustang'
                  );
                  foreach ($models as $value => $label) {
                      $selected = ($booking['car_model'] === $value) ? 'selected' : '';
                      echo "<option value=\"$value\" $selected>$label</option>";
                  }
                  ?>
              </select>

              <select name="color" id="color">
                  <option value="">Choisir la couleur</option>
                  <option value="white" <?php if ($booking['car_color'] === 'white') echo 'selected'; ?>>Blanche</option>
                  <option value="gray" <?php if ($booking['car_color'] === 'gray') echo 'selected'; ?>>Grise</option>
                  <option value="black" <?php if ($booking['car_color'] === 'black') echo 'selected'; ?>>Noire</option>
                  <option value="blue" <?php if ($booking['car_color'] === 'blue') echo 'selected'; ?>>Bleue</option>
              </select>
              <div class="check-in">
                  <input type="date" id="check-in-date" name="check-in-date" value="<?php echo $booking['check_in_date'] ?>">
                  <input type="time" id="check-in-time" name="check-in-time" value="<?php echo $booking['check_in_time'] ?>">
              </div>
              <div class="check-out">
                  <input type="date" id="check-out" name="check-out-date" value="<?php echo $booking['check_out_date'] ?>">
                  <input type="time" id="check-out-time" name="check-out-time" value="<?php echo $booking['check_out_time'] ?>">
              </div>
              <div class="name-surname">
                  <input type="text" name="nom" value="<?php echo $booking['client_name'] ?>">
                  <input type="text" name="prenom" value="<?php echo $booking['client_surname'] ?>">
              </div>
              <div class="email-phone">
                  <input type="email" name="email" value="<?php echo $booking['client_email'] ?>">
                  <input type="tel" name="telephone" placeholder="+1 439 678 9091" value="<?php echo $booking['client_phone'] ?>">
              </div>
              <div class="reserve-submit">
                  <input type="submit" name="submit" value="Modifier">
              </div>
          </form>
        </div>
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
