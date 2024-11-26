<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie Słodzik</title>
    <link rel="stylesheet" href="katalog.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<header>
    <h1>Logowanie</h1>
</header>
<main>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label class="form-label" for="email">Email: </label>
    <input class = "form-control" type="email" name="email" id="email">
    <label class="form-label" for="telefon">Telefon: </label>
    <input class = "form-control" type="text" name="telefon" id="telefon">
    <label class="form-label" for="haslo">Hasło(min 8 znaków): </label>
    <input class = "form-control" type="password" name="haslo" id="haslo" minlength="8" required>
    <button class="btn btn-dark" id="sub" type="submit">Zatwierdź</button>
</form>
<?php


if (!empty($_POST)) {
    $email = $_POST["email"];
    $telefon = $_POST["telefon"];
    $haslo = $_POST["haslo"];
    function logowanie(){
        $conn = new mysqli("localhost", "root", "", "cukiernia");
        if ($conn->connect_error) {
            die("Błąd połączenia: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM klienci WHERE (email = ? or telefon = ?) AND haslo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $telefon, $haslo);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            session_start();
            $_SESSION["zalogowany"] = true;
            header('Location: logowanie.php');
            echo "Zalogowano pomyślnie.";

        } else {
            echo "Nieprawidłowy email lub numer telefonu. <br>";
        }
        $stmt->close();
        $conn->close();
    }
    
    if (empty($email)){
        if (!preg_match('/^[0-9]{9}$/', $telefon)) {
            echo "Nieprawidłowy numer telefonu. <br>";
        } else {
            logowanie();
        }
    }   elseif (empty($telefon)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Nieprawidłowy email. <br>";
        } else {
            logowanie();
        }
    } else{
        echo "Nie wpisano ani telefonu ani emailu. <br>";
    }
}

?>
</main>
<footer>

</footer>
</body>
</html>