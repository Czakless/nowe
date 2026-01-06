<?php
session_start();
include "db.php";

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

$result = mysqli_query($conn, "SELECT * FROM $table WHERE id=$user_id");
$user = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $password = $_POST['password'];

    mysqli_query($conn, "UPDATE $table 
        SET $name_field='$name', password='$password'
        WHERE id=$user_id");

    $message = "Dane zostały zapisane!";
}

if(isset($_POST['delete'])){
    mysqli_query($conn, "DELETE FROM $table WHERE id=$user_id");
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Konto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <div class="nav-left">
        <?php
        if($table == "users") {
            echo '<a href="index.php">Zabukuj.pl</a>';
        } else {
            echo '<a href="panel.php">Panel firmy</a>';
        }
        ?>
    </div>
    <div class="nav-right">
        <?php
        if($table == "users") {
            echo '<a href="offerts.php">Oferty</a>';
            echo '<a href="contact.php">Kontakt</a>';
            echo '<a href="logout.php">Wyloguj się</a>';
        } else {
            echo '<a href="contact.php">Kontakt</a>';
            echo '<a href="logout.php">Wyloguj się</a>';
        }
        ?>
    </div>
</nav>


<div class="panel">
    <h2>Moje konto</h2>

    <?php
    if ($message) {
        echo "<p class='success'>$message</p>";
    }
    ?>

    <form method="POST">
        <label>Nazwa:</label>
        <input type="text" name="name" value="<?php echo $user[$name_field]; ?>" required>

        <label>Email:</label>
        <input type="email" value="<?php echo $user['email']; ?>" readonly>

        <label>Hasło:</label>
        <input type="password" name="password" value="<?php echo $user['password']; ?>" required>

        <button type="submit" name="update">Zapisz zmiany</button>
    </form>

    <form method="POST">
        <button type="submit" name="delete" style="background:red;">
            Usuń konto
        </button>
    </form>
</div>

<footer>
    <p>Strona została zrobiona przez</p>
    <strong>Mateusza Frątczaka i Tomasza Plutę</strong>
</footer>

</body>
</html>
