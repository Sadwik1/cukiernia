<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Słodzik</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<header>
    <img class='rounded float-start' src="zdjecia/logo.png"  alt="logo cukierni Słodzik">

    <form  method="GET" action="">
        <select name="filtr" id="filtr" class="form-select" aria-label="Default select example">
            <option value="brak">Brak</option>
            <option value="torty">Torty</option>
            <option value="ciasta">Ciasta</option>
            <option value="ciasteczka">Ciasteczka</option>
        </select>
        <input class = "form-control" type="text" name="search" id="wysz" placeholder="Wyszukaj produkty..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button class="btn btn-dark" id="sub" type="submit">Szukaj</button>
    </form>
    <nav id="nav" class="navbar">
    <ul id="nav-con" class="nav justify-content-end nav-pills">
  <li id="nav-item" class="nav-item">
    <a id="nav-link" class="nav-link active" aria-current="page" href="Katalog.php">Katalog</a>
  </li>
  <li id="nav-item" class="nav-item">
    <a id="nav-link" class="nav-link " href="index.php">Strona Główna</a>
  </li>
  <li id="nav-item" class="nav-item">
    <a id="nav-link" class="nav-link" href="profil.php">Profil</a>
  </li>
</ul>
</nav>
</header>
<main>
    <?php

    // Połączenie z bazą danych
    $conn = new mysqli("localhost", "root", "", "cukiernia");

    // Sprawdzenie połączenia
    if ($conn->connect_error) {
        die("Połączenie z bazą danych nie powiodło się: " . $conn->connect_error);
    }

    // Funkcja wyświetlająca katalog produktów
    function wyswietlKatalog($search = '') {
        global $conn;

        // Przygotowanie zapytania z wyszukiwaniem
        $sql = "SELECT produkty.*, promocje.*, produkty.zdjecie as zdj, produkty.nazwa as naz FROM produkty left join promocje on produkty.idP = promocje.idP join kategorieproduktow on produkty.idKP = kategorieproduktow.idKP WHERE promocje.idPR is null or (promocje.data_rozpoczecia <= NOW() AND promocje.data_zakonczenia >= NOW())";
        $kat = false;
        $filtr = 'brak';
        if (isset($_GET['filtr'])) {
            $filtr = $_GET['filtr'];
        }
        if ($filtr === "brak") {
            $kat = false;
        } else{
            $sql .= " and kategorieproduktow.nazwa = '$filtr'";
            $kat = true;
        }
        if ($kat){
            if ($search) {
                $search = $conn->real_escape_string($search);
                $sql .= " and (produkty.nazwa LIKE '%$search%' OR skladniki LIKE '%$search%')";
            }
        }
        //  else {
        //     if ($search) {
        //         $search = $conn->real_escape_string($search);
        //         $sql .= " and produkty.nazwa LIKE '%$search%' OR skladniki LIKE '%$search%'";
        //     }
        // }
        $result = $conn->query($sql);

        // Wyświetlenie produktów jako artykuły
        $cena = 0;
        $znizka = 0;
        while ($row = $result->fetch_assoc()) {
            $cena = $row["cena"];
            $znizka = $row["znizka"];
            echo "<article class='product-article'>";
            echo "<div class='product-image'>";
            echo "<img class='rounded float-start' src='zdjecia/" . $row["zdj"] . "' alt='" . $row["naz"] . "'>";
            echo "</div>";
            echo "<div class='product-details'>";
            echo "<h2>" . $row["naz"] . "</h2>";
            echo "<p>Cena: " . round($cena-($cena*$znizka), 2) . " zł</p>";
            echo "<p>Składniki: " . $row["skladniki"] . "</p>";
            echo "<p>Wartość odżywcza: " . $row["wartosc_odzywcza"] . "</p>";
            echo "<button class='btn btn-success'>Zamów</button>";
            echo "</div>";
            echo "</article>";
        }
    }
    // Sprawdzenie, czy wyszukiwano
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    wyswietlKatalog($search);
    ?>
    </main>
    <footer>

    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>