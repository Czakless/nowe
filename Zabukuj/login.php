<?php
session_start();
include "db.php";

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if($role == "klient"){
        $sql = "SELECT * FROM users WHERE email='$email'";
    }else{
        $sql = "SELECT * FROM companies WHERE email='$email'";
    }

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == true){
        $user = mysqli_fetch_assoc($result);

        if($password == $user['password']){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $role;

            if($role == "klient") {
                header("Location: offerts.php");
            }else{
                header("Location: panel.php");
            }
            exit;
        }else{
            $message = "Nieprawidłowe hasło!";
        }
    }else{
        $message = "Nie znaleziono użytkownika!";
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
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
    <h2>Logowanie</h2>

    <?php
    if ($message != "") {
        echo "<p class='success'>$message</p>";
    }
    ?>

    <form method="POST" style="margin-bottom:10px;">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Hasło" required>
        <select name="role">
            <option value="klient">Klient</option>
            <option value="firma">Firma</option>
        </select>
        <button type="submit">Zaloguj się</button>
    </form>
    <p>Nie masz konta? <a href="register.php">Zarejestruj się</a></p>
</div>

<footer>
    <p>Strona została zrobiona przez</p>
    <strong>Mateusza Frątczaka i Tomasza Plutę</strong>
</footer>

</body>
</html>
