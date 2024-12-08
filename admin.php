
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel administracyjny - Cukiernia Slodzik</title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<header>

</header>
<main>
    <?php
    $conn = new mysqli("localhost", "root", "", "cukiernia");
    if ($conn->connect_error) {
        die("Polaczenie z baza danych nie powiodlo sie: " . $conn->connect_error);
    }
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    function wyslij_powiadomienie($email, $temat, $wiadomosc) {
        $mail = new PHPMailer(true);

        // Konfiguracja serwera SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Host SMTP, np. Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'cukiernia.slodzik@gmail.com'; // Twój adres e-mail
        $mail->Password = 'slodzik2054'; // Has³o aplikacji (dla Gmail u¿yj has³a aplikacji)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Dane nadawcy i odbiorcy
        $mail->setFrom('cukiernia.slodzik@gmail.com', 'Cukiernia Slodzik');
        $mail->addAddress($email); // Odbiorca e-maila

        // Treœæ wiadomoœci
        $mail->isHTML(true);
        $mail->Subject = $temat;
        $mail->Body = $wiadomosc;

        $mail->send();
}
    ?>

    <!-- Dodawanie Kategorii Produktow -->
    <section>
        <h2 class="text-center">Dodaj Kategorie Produktow</h2>
        <div class="container">
            <form action="admin.php" method="POST">
                <div class="mb-3">
                    <label for="nazwa_kategorii" class="form-label">Nazwa Kategorii</label>
                    <input type="text" class="form-control" id="nazwa_kategorii" name="nazwa_kategorii" required>
                </div>
                <button type="submit" class="btn btn-primary" name="dodaj_kategorie">Dodaj Kategorie</button>
            </form>
        </div>
    </section>

    <section>
        <h2 class="text-center">Dodaj Produkty</h2>
        <div class="container">
            <form action="admin.php" method="POST">
                <div class="mb-3">
                    <label for="nazwa" class="form-label">Nazwa Produktu</label>
                    <input type="text" class="form-control" id="nazwa" name="nazwa" required>
                </div>
                <div class="mb-3">
                    <label for="cena" class="form-label">Cena</label>
                    <input type="number" class="form-control" id="cena" name="cena" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="skladniki" class="form-label">Skladniki</label>
                    <textarea class="form-control" id="skladniki" name="skladniki" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="wartosc_odzywcza" class="form-label">Wartosc Odzywcza</label>
                    <input type="text" class="form-control" id="wartosc_odzywcza" name="wartosc_odzywcza" required>
                </div>
                <div class="mb-3">
                    <label for="zdjecie" class="form-label">Zdjecie (nazwa pliku)</label>
                    <input type="text" class="form-control" id="zdjecie" name="zdjecie" required>
                </div>
                <div class="mb-3">
                    <label for="idKP" class="form-label">Kategoria</label>
                    <select class="form-select" id="idKP" name="idKP" required>
                        <option value="" disabled selected>Wybierz kategorie</option>
                        <?php
                        $kategorie = $conn->query("SELECT idKP, nazwa FROM kategorieproduktow");
                        while ($row = $kategorie->fetch_assoc()): ?>
                            <option value="<?= $row['idKP'] ?>"><?= $row['nazwa'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="dodaj_produkt">Dodaj Produkt</button>
            </form>
        </div>
    </section>

    <section>
        <h2 class="text-center">Dodaj Promocje</h2>
        <div class="container">
            <form action="admin.php" method="POST">
                <div class="mb-3">
                    <label for="nazwa_promocji" class="form-label">Nazwa Promocji</label>
                    <input type="text" class="form-control" id="nazwa_promocji" name="nazwa_promocji" required>
                </div>
                <div class="mb-3">
                    <label for="znizka" class="form-label">Znizka (%)</label>
                    <input type="number" class="form-control" id="znizka" name="znizka" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="data_rozpoczecia" class="form-label">Data Rozpoczecia</label>
                    <input type="date" class="form-control" id="data_rozpoczecia" name="data_rozpoczecia" required>
                </div>
                <div class="mb-3">
                    <label for="data_zakonczenia" class="form-label">Data Zakonczenia</label>
                    <input type="date" class="form-control" id="data_zakonczenia" name="data_zakonczenia" required>
                </div>
                <div class="mb-3">
                    <label for="idP" class="form-label">Produkt</label>
                    <select class="form-select" id="idP" name="idP" required>
                        <option value="" disabled selected>Wybierz produkt</option>
                        <?php
                        $produkty = $conn->query("SELECT idP, nazwa FROM produkty");
                        while ($row = $produkty->fetch_assoc()): ?>
                            <option value="<?= $row['idP'] ?>"><?= $row['nazwa'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="dodaj_promocje">Dodaj Promocje</button>
            </form>
        </div>
    </section>

    <section>
        <h2 class="text-center">Lista Kategorii Produktow</h2>
        <div class="container">
            <?php
            // Obsluga dodawania kategorii
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["dodaj_kategorie"])) {
                    $nazwa_kategorii = $_POST["nazwa_kategorii"];
                    $sql = "INSERT INTO kategorieproduktow (nazwa) VALUES ('$nazwa_kategorii')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success' role='alert'>Nowa kategoria zostala dodana pomyslnie.</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Blad: " . $sql . "<br>" . $conn->error . "</div>";
                    }
                }
            }

            // Wyswietlanie kategorii
            $sql = "SELECT * FROM kategorieproduktow";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table'>";
                echo "<thead><tr><th>ID</th><th>Nazwa</th></tr></thead><tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["idKP"] . "</td>";
                    echo "<td>" . $row["nazwa"] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>Brak kategorii w bazie danych.</p>";
            }
            ?>
        </div>
        <h2 class="text-center">Lista Produktow</h2>
        <div class="container">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["dodaj_produkt"])) {
                    $nazwa = $_POST["nazwa"];
                    $cena = $_POST["cena"];
                    $skladniki = $_POST["skladniki"];
                    $wartosc_odzywcza = $_POST["wartosc_odzywcza"];
                    $zdjecie = $_POST["zdjecie"];
                    $idKP = $_POST["idKP"];

                    $sql = "INSERT INTO produkty (nazwa, cena, skladniki, wartosc_odzywcza, zdjecie, idKP) VALUES ('$nazwa', '$cena', '$skladniki', '$wartosc_odzywcza', '$zdjecie', '$idKP')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success' role='alert'>Nowy produkt zostal dodany pomyslnie.</div>";
                        $temat = "Nowy produkt w ofercie!";
                        $wiadomosc = "Witaj! Dodaliœmy nowy produkt do naszej oferty: $nazwa.\nCena: $cena z³.";
                        $klienci = $conn->query("SELECT email FROM klienci");
                        while ($klient = $klienci->fetch_assoc()) {
                            wyslij_powiadomienie($klient['email'], $temat, $wiadomosc);
                        }
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Blad: " . $sql . "<br>" . $conn->error . "</div>";
                    }
                } elseif (isset($_POST["dodaj_promocje"])) {
                    $nazwa_promocji = $_POST["nazwa_promocji"];
                    $znizka = $_POST["znizka"];
                    $data_rozpoczecia = $_POST["data_rozpoczecia"];
                    $data_zakonczenia = $_POST["data_zakonczenia"];
                    $idP = $_POST["idP"];

                    $sql = "INSERT INTO promocje (nazwa, znizka, data_rozpoczecia, data_zakonczenia, idP) VALUES ('$nazwa_promocji', '$znizka', '$data_rozpoczecia', '$data_zakonczenia', '$idP')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success' role='alert'>Nowa promocja zostala dodana pomyslnie.</div>";
                        $temat = "Nowa promocja w Cukierni S³odzik!";
                        $wiadomosc = "Witaj! Uruchomiliœmy now¹ promocjê: $nazwa_promocji.\nZni¿ka: $znizka%.\nObowi¹zuje od: $data_rozpoczecia do $data_zakonczenia.";
                        $klienci = $conn->query("SELECT email FROM klienci");
                        while ($klient = $klienci->fetch_assoc()) {
                            wyslij_powiadomienie($klient['email'], $temat, $wiadomosc);
                        }
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Blad: " . $sql . "<br>" . $conn->error . "</div>";
                    }
                }
            }

            // Wyswietlanie produktow
            $sql = "SELECT p.idP, p.nazwa, p.cena, k.nazwa AS kategoria FROM produkty p JOIN kategorieproduktow k ON p.idKP = k.idKP";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table'>";
                echo "<thead><tr><th>ID</th><th>Nazwa</th><th>Cena</th><th>Kategoria</th><th>Akcje</th></tr></thead><tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["idP"] . "</td>";
                    echo "<td>" . $row["nazwa"] . "</td>";
                    echo "<td>" . $row["cena"] . " zl</td>";
                    echo "<td>" . $row["kategoria"] . "</td>";
                    echo "<td><form action='admin.php' method='POST' style='display:inline;'><input type='hidden' name='idP' value='" . $row["idP"] . "'><button type='submit' name='usun_produkt' class='btn btn-danger btn-sm'>Usun</button></form></td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>Brak produktow w bazie danych.</p>";
            }

            // Wyswietlanie promocji
            $sql = "SELECT pr.idPR, pr.nazwa, pr.znizka, pr.data_rozpoczecia, pr.data_zakonczenia, p.nazwa AS produkt FROM promocje pr JOIN produkty p ON pr.idP = p.idP";
            $result = $conn->query($sql);

            echo "<h3>Lista Promocji</h3>";
            if ($result->num_rows > 0) {
                echo "<table class='table'>";
                echo "<thead><tr><th>ID</th><th>Nazwa</th><th>Znizka</th><th>Rozpoczecie</th><th>Zakonczenie</th><th>Produkt</th><th>Akcje</th></tr></thead><tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["idPR"] . "</td>";
                    echo "<td>" . $row["nazwa"] . "</td>";
                    echo "<td>" . $row["znizka"] . " %</td>";
                    echo "<td>" . $row["data_rozpoczecia"] . "</td>";
                    echo "<td>" . $row["data_zakonczenia"] . "</td>";
                    echo "<td>" . $row["produkt"] . "</td>";
                    echo "<td><form action='admin.php' method='POST' style='display:inline;'><input type='hidden' name='idPR' value='" . $row["idPR"] . "'><button type='submit' name='usun_promocje' class='btn btn-danger btn-sm'>Usun</button></form></td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>Brak promocji w bazie danych.</p>";
            }

            // Obs³uga usuwania produktów
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["usun_produkt"])) {
                    $idP = $_POST["idP"];
                    $sql = "DELETE FROM produkty WHERE idP='$idP'";
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success' role='alert'>Produkt zosta³ usuniêty pomyœlnie.</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>B³¹d: " . $sql . "<br>" . $conn->error . "</div>";
                    }
                } elseif (isset($_POST["usun_promocje"])) {
                    $idPR = $_POST["idPR"];
                    $sql = "DELETE FROM promocje WHERE idPR='$idPR'";
                    if ($conn->query($sql) === TRUE) {
                        echo "<div class='alert alert-success' role='alert'>Promocja zosta³a usuniêta pomyœlnie.</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>B³¹d: " . $sql . "<br>" . $conn->error . "</div>";
                    }
                }
            }
            ?>
    <section>
    <h2 class="text-center">Przegladaj Zamowienia</h2>
    <div class="container">
        <?php
        // Pobieranie zamówieñ z bazy danych
        $sql = "SELECT 
                    zamowienia.idZ AS id_zamowienia, 
                    zamowienia.data_wykonania AS data, 
                    zamowienia.ilosc AS ilosc,
                    zamowienia.idP AS id_produktu,
                    produkty.nazwa AS nazwa_produktu,
                    klienci.imie AS klient_imie, 
                    klienci.nazwisko AS klient_nazwisko
                FROM zamowienia
                JOIN klienci ON zamowienia.idK = klienci.idK
                JOIN produkty ON zamowienia.idP = produkty.idP";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table'>";
            echo "<thead><tr>
                    <th>ID Zamowienia</th>
                    <th>Data Wykonania</th>
                    <th>Ilosc</th>
                    <th>Produkt</th>
                    <th>Klient</th>
                  </tr></thead><tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id_zamowienia"] . "</td>";
                echo "<td>" . $row["data"] . "</td>";
                echo "<td>" . $row["ilosc"] . "</td>";
                echo "<td>" . $row["nazwa_produktu"] . "</td>";
                echo "<td>" . $row["klient_imie"] . " " . $row["klient_nazwisko"] . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>Brak zamówieñ w bazie danych.</p>";
        }
        $conn->close();
        ?>
    </div>
</section>
    
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>