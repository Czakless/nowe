<?php
include "db.php";

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if($role == "klient"){
        $table = "users";
        $name_field = "name";
    }else{
        $table = "companies";
        $name_field = "company_name";
    }

    $check = mysqli_query($conn, "SELECT * FROM $table WHERE email='$email'");
    
    if(mysqli_num_rows($check) > 0){
        $message = "Użytkownik o tym emailu już istnieje!";
    }else{
        $sql = "INSERT INTO $table ($name_field, email, password) VALUES ('$name', '$email', '$password')";
        if(mysqli_query($conn, $sql)){
            $message = "Rejestracja zakończona sukcesem! <a href='login.php'>Zaloguj się</a>";
        }else{
            $message = "Błąd rejestracji!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <div class="nav-left">
        <a href="index.php">Zabukuj.pl</a>
    </div>
    <div class="nav-right">
        <a href="contact.php">Kontakt</a>
    </div>
</nav>

<div class="rezerwacja">
    <h2>Rejestracja</h2>

    <?php
    if($message){
        echo "<p class='success'>$message</p>";
    }
    ?>

    <form method="POST"  style="margin-bottom:10px;" >
        <input type="text" name="name" placeholder="Imię / Nazwa firmy" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Hasło" required>
        <select name="role">
            <option value="klient">Klient</option>
            <option value="firma">Firma</option>
        </select>
        <button type="submit">Zarejestruj się</button>
    </form>
    <p>Masz już konto? <a href="login.php">Zaloguj się</a></p>
</div>

<footer>
    <p>Strona została zrobiona przez</p>
    <strong>Mateusza Frątczaka i Tomasza Plutę</strong>
</footer>

</body>
</html>
