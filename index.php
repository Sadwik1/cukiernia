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
    

    <section class="popular-products">
        <div class="container">
            <h2 class="text-center">Popularne Produkty</h2>
            <div class="row">
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
                    $sql = "SELECT * FROM produkty ORDER BY RAND() LIMIT 2"; // Wybieramy 3 losowe produkty
                    $result = $conn->query($sql);

                    // Wyświetlenie produktów jako artykuły
                    while ($row = $result->fetch_assoc()) {
                        echo "<div id='pop' class='col-md-4'>";
                        echo "<img id='popzdj' class='rounded' src='zdjecia/" . $row["zdjecie"] . "' alt='" . $row["nazwa"] . "'>";
                        echo "<div>";
                        echo "<h3>" . $row["nazwa"] . "</h3>";
                        echo "<p>Cena: " . $row["cena"] . " zł</p>";
                        echo "<button class='btn btn-success'>Zamów</button>";
                        echo "</div>";
                        echo "</div>";
                    }
                }

                // Wywołanie funkcji do wyświetlenia popularnych produktów
                wyswietlPopularneProdukty();
                ?>
            </div>
        </div>
    </section>

    <section class="promotions">
        <div class="container">
            <h2 class="text-center">Aktualne Promocje</h2>
            <div class="row">
                <?php
                // Funkcja wyświetlająca aktualne promocje
                // function wyswietlPromocje() {
                //     global $conn;

                //     $sql = "SELECT * FROM promocje WHERE data_rozpoczecia <= NOW() AND data_zakonczenia >= NOW()";
                //     $result = $conn->query($sql);

                //     while ($row = $result->fetch_assoc()) {
                //         echo "<div class='col-md-4'>";
                //         echo "<article class='promotion-article'>";
                //         echo "<div class='promotion-image'>";
                //         echo "<img class='rounded' src='zdjecia/" . $row["zdjecie"] . "' alt='" . $row["nazwa"] . "'>";
                //         echo "</div>";
                //         echo "<div class='promotion-details'>";
                //         echo "<h3>" . $row["nazwa"] . "</h3>";
                //         echo "<p>" . $row["opis"] . "</p>";
                //         echo "<p>Rabaty: " . $row["rabaty"] . "%</p>";
                //         echo "</div>";
                //         echo "</article>";
                //         echo "</div>";
                //     }
                // }

                // wyswietlPromocje();
                ?>
            </div>
        </div>
    </section>
</main>
<footer class="text-center">
    <p>&copy; 2023 Cukiernia Słodzik. Wszelkie prawa zastrzeżone.</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>