<?php
session_start();
include "db.php";

$id = (int)$_GET['id'];

$hotel = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM hotels WHERE id = $id"));
$imageSrc = "data:image/jpeg;base64," . base64_encode($hotel['image']);
$message = "";

$emailValue = "";
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT email FROM users WHERE id = ".(int)$_SESSION['user_id']));
if ($user){
    $emailValue = $user['email'];
};

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $from = $_POST['date_from'];
    $to = $_POST['date_to'];

    if ($from > $to) {
        $message = "Data 'od' musi być wcześniejsza niż data 'do'.";
    } else {
        $check = mysqli_query($conn, "SELECT * FROM reservations WHERE hotel_id=$id AND NOT (date_to <= '$from' OR date_from >= '$to')");
        if (mysqli_num_rows($check)) {
            $message = "Wybrany termin jest już zarezerwowany!";
        } else {
            $res = mysqli_query($conn, "INSERT INTO reservations (hotel_id, name, email, date_from, date_to) VALUES ($id, '$name', '$email', '$from', '$to')");
            if ($res) {
                $message = "Rezerwacja została pomyślnie dodana!";
            } else {
                $message = "Błąd przy dodawaniu rezerwacji!";
            }
        }
    }
}

$occupied_dates = mysqli_fetch_all(mysqli_query($conn, "SELECT date_from, date_to FROM reservations WHERE hotel_id=$id ORDER BY date_from ASC"), MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rezerwacja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav><a href="offerts.php">⬅ Powrót</a></nav>

<div class="rezerwacja">
    <img src="<?= $imageSrc ?>" alt="Hotel">
    <h2><?= $hotel['name'] ?></h2>
    <p><strong>Miasto:</strong> <?= $hotel['city'] ?></p>
    <p><strong>Cena:</strong> <?= $hotel['price'] ?> zł / noc</p>

    <h3>Zajęte terminy</h3>
    <?php
    if (count($occupied_dates) > 0) {

        foreach ($occupied_dates as $d) {
            echo $d['date_from']." → ".$d['date_to']."<br>";
        }

    } else {
        echo "Brak rezerwacji – wszystkie terminy dostępne!";
    }
    ?>

    <h3>Zarezerwuj nocleg</h3>
    <?php
    if($message){
        echo "<p class='success'>$message</p>";
    }
    ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Imię i nazwisko" required>
        <input type="email" name="email" value="<?= $emailValue ?>" readonly required>
        <label>Data od:</label>
        <input type="date" name="date_from" required>
        <label>Data do:</label>
        <input type="date" name="date_to" required>
        <button type="submit">Zarezerwuj</button>
    </form>
</div>

<footer>
    <p>Strona została zrobiona przez</p>
    <strong>Mateusza Frątczaka i Tomasza Plutę</strong>
</footer>

</body>
</html>
