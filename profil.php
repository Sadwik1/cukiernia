<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Słodzik</title>
    <link rel="stylesheet" href="katalog.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<?php
ob_start();
session_start();
$_SESSION["zalogowany"] = false;
if ($_SESSION["zalogowany"] == false){
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
<main>
</main>
</body>
</html>