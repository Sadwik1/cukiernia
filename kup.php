<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kup produkt</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<header>
    <img class='rounded float-start' src="zdjecia/logo.png" alt="logo cukierni Slodzik">

    <nav id="nav" class="navbar">
        <ul id="nav-con" class="nav justify-content-end nav-pills">
            <li id="nav-item" class="nav-item">
                <a id="nav-link" class="nav-link" href="Katalog.php">Katalog</a>
            </li>
            <li id="nav-item" class="nav-item">
                <a id="nav-link" class="nav-link" href="index.php">Strona Glowna</a>
            </li>
            <li id="nav-item" class="nav-item">
                <a id="nav-link" class="nav-link" href="profil.php">Profil</a>
            </li>
        </ul>
    </nav>
</header>
<main class="container mt-4">
    <?php
    session_start();

    // Polaczenie z baza danych
    $conn = new mysqli("localhost", "root", "", "cukiernia");

    // Sprawdzenie polaczenia
    if ($conn->connect_error) {
        die("<p class='text-danger'>Polaczenie z baza danych nie powiodlo sie: " . $conn->connect_error . "</p>");
    }

    // Sprawdzenie, czy ID produktu jest w sesji
    if (!isset($_SESSION['idP'])) {
        echo "<p class='text-danger'>Nie wybrano produktu do zakupu.</p>";
        echo "<a href='Katalog.php' class='btn btn-primary'>Powrot do katalogu</a>";
        exit;
    }

    $idP = intval($_SESSION['idP']);

    // Pobranie danych produktu
    $sql = "SELECT produkty.*, promocje.znizka 
            FROM produkty 
            LEFT JOIN promocje ON produkty.idP = promocje.idP
            WHERE produkty.idP = $idP";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $produkt = $result->fetch_assoc();
        $cena = round($produkt['cena'] - ($produkt['cena'] * $produkt['znizka']), 2);

        echo "<article class='product-article'>";
        echo "<div class='product-image'>";
        echo "<img class='rounded float-start' src='zdjecia/" . htmlspecialchars($produkt['zdjecie']) . "' alt='" . htmlspecialchars($produkt['nazwa']) . "'>";
        echo "</div>";
        echo "<div class='product-details'>";
        echo "<h2>" . htmlspecialchars($produkt['nazwa']) . "</h2>";
        echo "<p>Cena: <strong>$cena zl</strong></p>";
        echo "<p>Skladniki: " . htmlspecialchars($produkt['skladniki']) . "</p>";
        echo "<p>Wartosc odzywcza: " . htmlspecialchars($produkt['wartosc_odzywcza']) . "</p>";
        echo "</div>";
        echo "</article>";

        // Formularz realizacji zamowienia
        echo "<form method='POST' class='mt-4'>";
        echo "<label id='margin_kup_form' for='ilosc' class='form-label'>Ilosc:</label>";
        echo "<input id='margin_kup_form' type='number' class='form-control' id='ilosc' name='ilosc' min='1' value='1' required>";
        echo "<button id='margin_kup_form_but' type='submit' class='btn btn-success'>Zloz zamowienie</button>";
        echo "</form>";
    } else {
        echo "<p class='text-danger'>Nie znaleziono produktu o podanym ID.</p>";
        echo "<a href='Katalog.php' class='btn btn-primary'>Powrot do katalogu</a>";
    }

    // Obsluga zamowienia
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ilosc'])) {
        $ilosc = intval($_POST['ilosc']);

        if ($ilosc > 0) {
            $email = $_SESSION['email'];
            $haslo = $_SESSION['haslo'];

            // Pobranie idK na podstawie emaila i has³a
            $sql_klient = "SELECT idK FROM klienci WHERE email = ? AND haslo = ?";
            $stmt = $conn->prepare($sql_klient);
            $stmt->bind_param("ss", $email, $haslo);
            $stmt->execute();
            $result_klient = $stmt->get_result();

            if ($result_klient->num_rows > 0) {
                $row_klient = $result_klient->fetch_assoc();
                $idK = $row_klient['idK'];

                // Dodanie zamowienia do bazy danych
                $sql_zamowienie = "INSERT INTO zamowienia (idP, idK, ilosc, data_wykonania) 
                                VALUES ($idP, $idK, $ilosc, NOW())";

                if ($conn->query($sql_zamowienie)) {
                    echo "<p class='text-success mt-3'>Zamowienie zostalo pomyslnie zlozone! Produkt bedzie dostepny w naszej cukierni w przeciagu 2 dni roboczych. Dziekujemy za zakupy.</p>";
                } else {
                    echo "<p class='text-danger mt-3'>Wystapil blad podczas skladania zamowienia: " . $conn->error . "</p>";
                }
                } else {
                    echo "<p class='text-danger mt-3'>Podano nieprawidlowa ilosc.</p>";
             }
        }
    }

    $conn->close();
    ?>
</main>
<footer class="text-center mt-4">
    <p>&copy; 2024 Cukiernia Slodzik</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
