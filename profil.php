<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Słodzik</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<?php
ob_start();
session_start();
if ($_SESSION["zalogowany"] == false or !isset($_SESSION["zalogowany"])) {
    header("location:logowanie.php");
}
?>
<header>
    <img class='rounded float-start' src="zdjecia/logo.png"  alt="logo cukierni Słodzik">
    <nav id="nav" class="navbar">
    <ul id="nav-con" class="nav justify-content-end nav-pills">
  <li id="nav-item" class="nav-item">
    <a id="nav-link" class="nav-link" aria-current="page" href="Katalog.php">Katalog</a>
  </li>
  <li id="nav-item" class="nav-item">
    <a id="nav-link" class="nav-link " href="index.php">Strona Główna</a>
  </li>
  <li id="nav-item" class="nav-item">
    <a id="nav-link" class="nav-link active" href="profil.php">Profil</a>
  </li>
</ul>
</nav>
</header>
<main id="profilMain" class="d-xl-flex justify-content-xl-start">
<article id='article' class="d-xl-flex flex-grow-0 flex-shrink-0 justify-content-xl-center">
  <h1>Historia Zamówień:</h1>
  <?php
  $conn = new mysqli("localhost", "root", "", "cukiernia");
  if ($conn->connect_error) {
    die("Połączenie z bazą danych nie powiodło się: " . $conn->connect_error);
  }

  $email = $_SESSION["email"];
  $haslo = $_SESSION["haslo"];
  $sql1 = "SELECT zamowienia.idZ, zamowienia.data_wykonania, produkty.nazwa, zamowienia.ilosc, produkty.cena 
          FROM produkty
          JOIN zamowienia ON produkty.idP = zamowienia.idP 
          JOIN klienci ON zamowienia.idK = klienci.idK 
          WHERE klienci.email = '$email' AND klienci.haslo = '$haslo'";
  $result = $conn->query($sql1);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<div id='card' class='card'>
              <div class='card-header'>
                  <h2 class='mb-0'>Zamówienie nr: " . $row["idZ"] . "</h2>
              </div>
              <div class='card-body'>
                  <p class='card-text'>Wykonane: " . $row["data_wykonania"] . "</p>
                  <p class='card-text'>Wypieki: " . $row["nazwa"] . " (Ilość: " . $row["ilosc"] . ", Cena: " . $row["cena"] . " zł)</p>
                  <p class='card-text'>Łączna cena: " . $row["ilosc"]*$row["cena"] . " zł</p>
              </div>
          </div>";
    }
  } else {
    echo "<p>Brak zamówień dla tego konta.</p>";
  }
  ?>
</article>
  <aside id='aside' class="d-xl-flex flex-grow-0 flex-shrink-0 justify-content-xl-center">
  <?php
                $sql2 = "SELECT * FROM klienci WHERE email = '$email' and haslo = '$haslo'";
                $result = $conn->query($sql2);
                while ($row = $result->fetch_assoc()) {
                  echo "<div id='card' class='card border-dark-subtle border rounded-0 border-2'>
                  <div class='card-header'>
                      <h5 class='mb-0'>Imię: </h5>
                  </div>
                  <div class='card-body'>
                      <p class='card-text'>" . $row["imie"] . "</p>
                  </div>
              </div>
              <div id='card' class='card border-dark-subtle border rounded-0 border-2'>
                  <div class='card-header'>
                      <h5 class='mb-0'>Nazwisko: </h5>
                  </div>
                  <div class='card-body'>
                      <p class='card-text'>" . $row["nazwisko"] . "</p>
                  </div>
              </div>
              <div id='card' class='card border-dark-subtle border rounded-0 border-2'>
                  <div class='card-header'>
                      <h5 class='mb-0'>Email: </h5>
                  </div>
                  <div class='card-body'>
                      <p class='card-text'>" . $row["email"] . "</p>
                  </div>
              </div>";
                }
            ?>
        <form action="" method="post">
    <input id="wyloguj" class="btn btn-dark" type="submit" value="Wyloguj" name="Wyloguj">
    <?php
  if (isset($_POST["Wyloguj"])) {
    session_destroy();
    header("location:logowanie.php");
  }
  ?>
  </form>
  </aside>

  
</main>
<footer class="text-center mt-4">
    <p>&copy; 2024 Cukiernia Slodzik</p>
</footer>
</body>
</html>