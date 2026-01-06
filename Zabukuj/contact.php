<?php
session_start();

if(isset($_SESSION['user_id'])){

    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];
    $message = "";

    if($role == "klient"){
        $table = "users";
        $name_field = "name";
    } else {
        $table = "companies";
        $name_field = "company_name";
    }
} else {
    $table = "";
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kontakt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <div class="nav-left">
        <?php
        if($table == "companies") {
            echo '<a href="panel.php">Panel firmy</a>';
        } else {
            echo '<a href="index.php">Zabukuj.pl</a>';
        }
        ?>
    </div>
    <div class="nav-right">
        <?php
        if($table == "users") {
            echo '<a href="offerts.php">Oferty</a>';
        }
        ?>
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

<div class="rezerwacja">
    <h2>Kontakt</h2>

    <p>Masz pytania? Skontaktuj się z nami!</p>
    <p>Email: <strong>kontakt@zabukuj.pl</strong></p>
    <p>Telefon: <strong>123 456 789</strong></p>
    <p>Adres biura: <strong>ul. Przykładowa 1, 00-001 Warszawa</strong></p>
</div>

<footer>
    <p>Strona została zrobiona przez</p>
    <strong>Mateusza Frątczaka i Tomasza Plutę</strong>
</footer>

</body>
</html>
