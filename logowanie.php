<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie Słodzik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Basic-icons.css">
</head>
<body>
<header>
</header>
<main style="margin-top: 10vh;">
<div class="row d-flex justify-content-center">
    <div class="col-md-6 col-xl-4">
        <div class="card mb-5">
            <div class="card-body d-flex flex-column align-items-center">
                <div class="bs-icon-xl bs-icon-circle bs-icon-primary text-bg-dark bs-icon my-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664z"></path>
                    </svg>
                </div>
                <form class="text-center" method="post">
                    <div class="mb-3">
                        <input class="form-control" type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="password" name="haslo" placeholder="Hasło" minlength="8" required>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-dark d-block w-100" type="submit">Loguj</button>
                    </div>
                    <a href="rejestracja.php" class="text-muted text-decoration-none">Nie masz konta?</a>
                    <br>
                    <a href="reset_haslo.php" class="text-muted text-decoration-none">Zapomniałeś hasła?</a>
                </form>
                <?php
                ob_start();
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $email = $_POST["email"];
                    $haslo = $_POST["haslo"];

                    function logowanie($email, $haslo) {
                        $conn = new mysqli ("localhost", "root", "", "cukiernia");
                        if ($conn->connect_error) {
                            error_log("Connection error: " . $conn->connect_error);
                            return;
                        }
                        $sql = "SELECT * FROM klienci WHERE email = ? and haslo = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ss", $email, $haslo);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                                session_start();
                                session_regenerate_id();
                                $_SESSION["zalogowany"] = true;
                                $_SESSION["email"] = $email;
                                $_SESSION["haslo"] = $haslo;
                                echo "<p class='text-success'>Poprawnie zalogowano. <br></p>";
                                header('Location: profil.php');
                        } else {
                            echo "<p class='text-danger'>Nieprawidłowy email lub hasło. <br></p>";
                        }
                        $stmt->close();
                        $conn->close();
                    }

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo "<p class='text-danger'>Nieprawidłowy email. <br></p>";
                    } else {
                        logowanie($email, $haslo);
                    }
                }
                ?>
            </div>
        </div>
    </div>
</main>
<footer>
</footer>
</body>
</html>