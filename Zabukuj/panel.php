<?php
session_start();
include "db.php";

$company_id = $_SESSION['user_id'];
$message = "";

if(isset($_GET['delete'])){
    $delete_id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM hotels WHERE id=$delete_id AND company_id=$company_id");
    $message = "Hotel został usunięty!";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['name'];
    $city = $_POST['city'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $image = mysqli_real_escape_string($conn, $image);

        $sql = "INSERT INTO hotels (company_id, name, city, price, description, image) 
                VALUES ($company_id, '$name', '$city', $price, '$description', '$image')";

        if(mysqli_query($conn, $sql)) $message = "Hotel został dodany!";
        else $message = "Błąd dodawania hotelu!";
    } else{
        $message = "Wybierz poprawny plik obrazu!";
    }
}


$result_hotels = mysqli_query($conn, "SELECT * FROM hotels WHERE company_id=$company_id");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Panel</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <div class="nav-left">
        <a href="panel.php">Panel firmy</a>
    </div>
    <div class="nav-right">
        <a href="contact.php">Kontakt</a>
        <a href="account.php">Konto</a>
        <a href="logout.php">Wyloguj się</a>
    </div>
</nav>

<div class="panel">
    <h2>Panel firmy</h2>
    <h3>Dodaj hotel</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Nazwa hotelu" required>
        <input type="text" name="city" placeholder="Miasto" required>
        <input type="number" name="price" placeholder="Cena za noc" required>
        <input name="description" placeholder="Opis hotelu" required>
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Dodaj hotel</button>
    </form>

    <h3>Twoje hotele</h3>
    <?php while($h = mysqli_fetch_assoc($result_hotels)) { ?>
        <div class="hotel">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($h['image']); ?>" alt="Hotel">
            <div class="info">
                <h4><?php echo $h['name']; ?></h4>
                <p class="desc"><?php echo $h['description']; ?></p>
                <p class="city"><?php echo $h['city']; ?></p>
                <p class="price"><?php echo $h['price']; ?> zł / noc</p>
                <a href="?delete=<?php echo $h['id']; ?>" class="delete">Usuń</a>
            </div>
        </div>
    <?php } ?>
</div>

<footer>
    <p>Strona została zrobiona przez</p>
    <strong>Mateusza Frątczaka i Tomasza Plutę</strong>
</footer>

</body>
</html>
