<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cukiernia</title>
    <link rel="stylesheet" href="katalog.css">
</head>
<body>
    <h1>Cukiernia</h1>

    <form method="GET" action="">
        <input type="text" name="search" placeholder="Wyszukaj produkty..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit">Szukaj</button>
    </form>

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
        $sql = "SELECT * FROM produkty";
        if ($search) {
            $search = $conn->real_escape_string($search);
            $sql .= " WHERE nazwa LIKE '%$search%' OR skladniki LIKE '%$search%'";
        }
        $result = $conn->query($sql);

        // Wyświetlenie produktów jako artykuły
        while ($row = $result->fetch_assoc()) {
            echo "<article class='product-article'>";
            echo "<div class='product-image'>";
            echo "<img src='" . $row["zdjecie"] . "' alt='" . $row["nazwa"] . "'>";
            echo "</div>";
            echo "<div class='product-details'>";
            echo "<h2>" . $row["nazwa"] . "</h2>";
            echo "<p>Cena: " . $row["cena"] . " zł</p>";
            echo "<p>Składniki: " . $row["skladniki"] . "</p>";
            echo "<p>Wartość odżywcza: " . $row["wartosc_odzywcza"] . "</p>";
            echo "<button class='order-button'>Zamów</button>"; // Przycisk zamówienia
            echo "</div>";
            echo "</article>";
        }
    }

    // Sprawdzenie, czy wyszukiwano
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    wyswietlKatalog($search);
    ?>
</body>
</html>