<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM hotels ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Oferty</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <div class="nav-left">
        <a href="index.php">Zabukuj.pl</a>
    </div>
    <div class="nav-right">
        <a href="contact.php">Kontakt</a>
        <a href="account.php">Konto</a>
        <a href="logout.php">Wyloguj się</a>
    </div>
</nav>

<main class="offers">
<?php
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $imageSrc = "data:image/jpeg;base64," . base64_encode($row['image']);
        echo '<div class="offer">';
        echo '<img src="'.$imageSrc.'" alt="Hotel">';
        echo '<h3>'.$row['name'].'</h3>';
        echo '<p class="city">'.$row['city'].'</p>';
        echo '<p class="price">'.$row['price'].' zł / noc</p>';
        echo '<a href="reservation.php?id='.$row['id'].'"><button>Zarezerwuj</button></a>';
        echo '</div>';
    }
}else{
    echo '<p style="text-align:center;">Brak ofert do wyświetlenia.</p>';
}
?>
</main>

<footer>
    <p>Strona została zrobiona przez</p>
    <strong>Mateusza Frątczaka i Tomasza Plutę</strong>
</footer>

</body>
</html>
