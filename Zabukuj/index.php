<?php
session_start();
include "db.php";
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zabukuj</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <div class="nav-left">
        <a href="index.php">Zabukuj.pl</a>
    </div>
    <div class="nav-right">
        <a href="offerts.php">Oferty</a>
        <a href="contact.php">Kontakt</a>
        <?php
        if(isset($_SESSION['user_id'])) {
            echo '<a href="account.php">Konto</a>';
            echo '<a href="logout.php">Wyloguj się</a>';
        } else {
            echo '<a href="login.php">Zaloguj się</a>';
        }
        ?>
    </div>
</nav>

<section class="hero">
    <div class="hero-content">
        <h1 style="margin-bottom:20px;">Znajdź idealne miejsce na wypoczynek</h1>
        <a href="offerts.php" class="hero-button">Sprawdź oferty</a>
    </div>
</section>

<main class="offers">

<?php
$sql = "SELECT * FROM hotels ORDER BY id DESC LIMIT 3";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $imageSrc = "data:image/jpeg;base64," . base64_encode($row['image']);
?>
    <div class="offer">
        <img src="<?php echo $imageSrc; ?>" alt="Hotel">
        <h3><?php echo $row['name']; ?></h3>
        <p class="city"><?php echo $row['city']; ?></p>
        <p class="price"><?php echo $row['price']; ?> zł / noc</p>
        <a href="reservation.php?id=<?php echo $row['id']; ?>"><button>Sprawdź</button></a>
    </div>
<?php
}
?>

</main>

<footer>
    <p>Strona została zrobiona przez</p>
    <strong>Mateusza Frątczaka i Tomasza Plutę</strong>
</footer>

</body>
</html>
