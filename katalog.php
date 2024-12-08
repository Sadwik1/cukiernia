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
    <img class='rounded float-start' src="zdjecia/logo.png" alt="logo cukierni Słodzik">

    <form method="GET" action="">
        <select name="filtr" id="filtr" class="form-select" aria-label="Default select example">
            <option value="brak">Brak</option>
            <option value="torty">Torty</option>
            <option value="ciasta">Ciasta</option>
            <option value="ciasteczka">Ciasteczka</option>
        </select>
        <input class="form-control" type="text" name="search" id="wysz" placeholder="Wyszukaj produkty..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button class="btn btn-dark" id="sub" type="submit">Szukaj</button>
    </form>
    <nav id="nav" class="navbar">
        <ul id="nav-con" class="nav justify-content-end nav-pills">
            <li id="nav-item" class="nav-item">
                <a id="nav-link" class="nav-link active" aria-current="page" href="Katalog.php">Katalog</a>
            </li>
            <li id="nav-item" class="nav-item">
                <a id="nav-link" class="nav-link" href="index.php">Strona Główna</a>
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

    // Funkcja do obliczenia średniej liczby gwiazdek
    function obliczSredniaGwiazdek($idP) {
        global $conn;
        $sql = "SELECT AVG(ilosc_gwiazdek) as srednia FROM opinie WHERE idP = $idP";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return round($row['srednia'], 1); // Zaokrąglenie do 1 miejsca po przecinku
        }
        return 0;
    }

    // Dodanie opinii
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idP'], $_POST['ilosc_gwiazdek'])) {
        $idP = intval($_POST['idP']);
        $ilosc_gwiazdek = intval($_POST['ilosc_gwiazdek']);

        $sql = "INSERT INTO opinie (idP, ilosc_gwiazdek) VALUES ($idP, $ilosc_gwiazdek)";
        if ($conn->query($sql)) {
            echo "<script>alert('Dziękujemy za Twoją opinię!');</script>";
        } else {
            echo "<script>alert('Wystąpił błąd podczas dodawania opinii.');</script>";
        }
    }

    // Funkcja wyświetlająca katalog produktów
    function wyswietlKatalog($search = '') {
        global $conn;

        // Przygotowanie zapytania
        $sql = "SELECT produkty.*, promocje.*, produkty.zdjecie as zdj, produkty.nazwa as naz, produkty.idP as idProdukt 
                FROM produkty 
                LEFT JOIN promocje ON produkty.idP = promocje.idP 
                JOIN kategorieproduktow ON produkty.idKP = kategorieproduktow.idKP 
                WHERE promocje.idPR IS NULL 
                  OR (promocje.data_rozpoczecia <= NOW() AND promocje.data_zakonczenia >= NOW())";

        if (isset($_GET['filtr']) && $_GET['filtr'] !== 'brak') {
            $filtr = $conn->real_escape_string($_GET['filtr']);
            $sql .= " AND kategorieproduktow.nazwa = '$filtr'";
        }

        if ($search) {
            $search = $conn->real_escape_string($search);
            $sql .= " AND (produkty.nazwa LIKE '%$search%' OR skladniki LIKE '%$search%')";
        }

        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $idP = $row["idProdukt"];
            $cena = $row["cena"];
            $znizka = $row["znizka"];
            $srednia_gwiazdek = obliczSredniaGwiazdek($idP);

            echo "<article class='product-article'>";
            echo "<div class='product-image'>";
            echo "<img class='rounded float-start' src='zdjecia/" . $row["zdj"] . "' alt='" . $row["naz"] . "'>";
            echo "</div>";
            echo "<div class='product-details'>";
            echo "<h2>" . $row["naz"] . "</h2>";
            echo "<p>Cena: " . round($cena - ($cena * $znizka), 2) . " zł</p>";
            echo "<p>Składniki: " . $row["skladniki"] . "</p>";
            echo "<p>Wartość odżywcza: " . $row["wartosc_odzywcza"] . "</p>";
            echo "<p>Średnia ocena: " . str_repeat("⭐", floor($srednia_gwiazdek)) . " (" . $srednia_gwiazdek . " / 5)</p>";

            // Formularz dodawania opinii
            echo "<form method='POST' class='opinion-form'>";
            echo "<label for='ilosc_gwiazdek'>Oceń produkt:</label>";
            echo "<select name='ilosc_gwiazdek' id='ilosc_gwiazdek' class='form-select'>";
            for ($i = 1; $i <= 5; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            echo "</select>";
            echo "<input type='hidden' name='idP' value='$idP'>";
            echo "<button id='dodaj_op' class='btn btn-primary mt-2' type='submit'>Dodaj</button>";
            echo "</form>";
            if (!isset($_SESSION)) {
                session_start();
            }
            if (isset($_SESSION['zalogowany'])) {
                if ($_SESSION['zalogowany'] == true) {
                    $_SESSION['idP'] = $idP;
                    echo "<a href='kup.php' class='btn btn-success mt-2'>Zamów</a>";
                } 
            } else {
                echo "<a href='logowanie.php' class='btn btn-success mt-2'>Zaloguj się, aby zamówić</a>";
            }
            echo "</div>";
            echo "</article>";
        }
}
            

    // Sprawdzenie, czy wyszukiwano
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    wyswietlKatalog($search);
    ?>
</main>
<footer class="text-center mt-4">
    <p>&copy; 2024 Cukiernia Slodzik</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
