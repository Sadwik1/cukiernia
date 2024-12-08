<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona Główna - Cukiernia Słodzik</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<header>
    <img class='rounded float-start' src="zdjecia/logo.png" alt="logo cukierni Słodzik">
    <section id='startText' class="hero">
        <div class="container text-center">
            <h2>Witamy w Cukierni Słodzik</h2>
            <p>Oferujemy najsmaczniejsze ciasta, torty i ciasteczka.</p>
        </div>
    </section>
    <nav id="nav" class="navbar">
        <ul id="nav-con" class="nav justify-content-end nav-pills">
            <li id="nav-item" class="nav-item">
                <a id="nav-link" class="nav-link" href="Katalog.php">Katalog</a>
            </li>
            <li id="nav-item" class="nav-item">
                <a id="nav-link" class="nav-link active" aria-current="page" href="index.php">Strona Główna</a>
            </li>
            <li id="nav-item" class="nav-item">
                <a id="nav-link" class="nav-link" href="profil.php">Profil</a>
            </li>
        </ul>
    </nav>
</header>
<main>
    

    <section>
            <h2 class="text-center">Popularne Produkty</h2>
                <?php
                // Połączenie z bazą danych
                $conn = new mysqli("localhost", "root", "", "cukiernia");

                // Sprawdzenie połączenia
                if ($conn->connect_error) {
                    die("Połączenie z bazą danych nie powiodło się: " . $conn->connect_error);
                }

                // Funkcja wyświetlająca popularne produkty
                function wyswietlPopularneProdukty() {
                    global $conn;

                    // Przygotowanie zapytania do pobrania popularnych produktów
                    $sql = "SELECT produkty.*, promocje.*, produkty.zdjecie as zdj, produkty.nazwa as naz FROM produkty left join promocje on produkty.idP = promocje.idP join kategorieproduktow on produkty.idKP = kategorieproduktow.idKP WHERE promocje.idPR is null or (promocje.data_rozpoczecia <= NOW() AND promocje.data_zakonczenia >= NOW()) ORDER BY RAND() LIMIT 2"; // Wybieramy 3 losowe produkty
                    $result = $conn->query($sql);

                    // Wyświetlenie produktów jako artykuły
                    while ($row = $result->fetch_assoc()) {
                        $cena = $row["cena"];
            $znizka = $row["znizka"];
            echo "<article class='popular-article'>";
            echo "<div class='popular-image'>";
            echo "<img class='rounded float-start' src='zdjecia/" . $row["zdj"] . "' alt='" . $row["naz"] . "'>";
            echo "</div>";
            echo "<div class='popular-details'>";
            echo "<h2>" . $row["naz"] . "</h2>";
            echo "<p>Cena: " . round($cena-($cena*$znizka), 2) . " zł</p>";
            echo "<p>Składniki: " . $row["skladniki"] . "</p>";
            echo "<p>Wartość odżywcza: " . $row["wartosc_odzywcza"] . "</p>";
            echo "<button class='btn btn-success'>Zamów</button>";
            echo "</div>";
            echo "</article>";
                    }
                }

                // Wywołanie funkcji do wyświetlenia popularnych produktów
                wyswietlPopularneProdukty();
                ?>
    </section>

    <section>
            <h2 class="text-center">Aktualne Promocje</h2>
                <?php
                 function wyswietlPromocje() {
                     global $conn;

                     $sql = "SELECT produkty.*, promocje.*, produkty.zdjecie as zdj, produkty.nazwa as naz FROM produkty left join promocje on produkty.idP = promocje.idP join kategorieproduktow on produkty.idKP = kategorieproduktow.idKP WHERE promocje.data_rozpoczecia <= NOW() AND promocje.data_zakonczenia >= NOW()";
                     $result = $conn->query($sql);

                     while ($row = $result->fetch_assoc()) {
                         $cena = $row["cena"];
                         $znizka = $row["znizka"];
                         echo "<article class='promotion-article'>";
                         echo "<div class='promotion-image'>";
                         echo "<img class='rounded' src='zdjecia/" . $row["zdj"] . "' alt='" . $row["naz"] . "'>";
                         echo "</div>";
                         echo "<div class='promotion-details'>";
                         echo "<h3>" . $row["naz"] . "</h3>";
                         echo "<p>Cena: " . round($cena-($cena*$znizka), 2) . " zł</p>";
                         echo "<p>Składniki: " . $row["skladniki"] . "</p>";
                         echo "<p>Wartość odżywcza: " . $row["wartosc_odzywcza"] . "</p>";
                         echo "<p>Rabaty: " . $znizka*100 . "%</p>";
                         echo "<button class='btn btn-success'>Zamów</button>";
                         echo "</div>";
                         echo "</article>";
                     }
                 }

                 wyswietlPromocje();
                ?>
    </section>
</main>
<footer class="text-center">
    <p>&copy; 2023 Cukiernia Słodzik. Wszelkie prawa zastrzeżone.</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>