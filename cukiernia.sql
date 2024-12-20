-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2024 at 02:32 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cukiernia`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorieproduktow`
--

CREATE TABLE `kategorieproduktow` (
  `idKP` int(11) NOT NULL,
  `nazwa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategorieproduktow`
--

INSERT INTO `kategorieproduktow` (`idKP`, `nazwa`) VALUES
(1, 'ciasta'),
(2, 'ciasteczka'),
(3, 'torty');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `idK` int(11) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klienci`
--

INSERT INTO `klienci` (`idK`, `imie`, `nazwisko`, `email`, `haslo`) VALUES
(1, 'Jan', 'Kowalski', 'jan.kowalski@example.com', 'bzyczek123'),
(2, 'Anna', 'Nowak', 'anna.nowak@example.com', 'wryczek234'),
(3, 'Piotr', 'Wiśniewski', 'piotr.wisniewski@example.com', 'kopal965'),
(4, 'Wiktor', 'Sadłowski', 'sadwik2054@gmail.com', 'Sadwik2054');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `idP` int(11) NOT NULL,
  `nazwa` varchar(50) NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  `skladniki` text DEFAULT NULL,
  `wartosc_odzywcza` text DEFAULT NULL,
  `zdjecie` varchar(50) DEFAULT NULL,
  `idKP` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produkty`
--

INSERT INTO `produkty` (`idP`, `nazwa`, `cena`, `skladniki`, `wartosc_odzywcza`, `zdjecie`, `idKP`) VALUES
(1, 'Sernik', 15.99, 'Ser, biszkopty, śmietana', 'Wysoka zawartość tłuszczu', 'sernik.jpg', 1),
(2, 'Ciasto czekoladowe', 12.99, 'Czekolada, mąka, jajka', 'Średnia zawartość tłuszczu', 'ciasto_czekoladowe.jpg', 1),
(3, 'Pierniczki', 8.99, 'Mąka, miód, przyprawy', 'Niska zawartość tłuszczu', 'pierniczki.jpg', 2),
(4, 'Tort truskawkowy', 25.99, 'Biszkopt, krem, truskawki', 'Wysoka zawartość cukru', 'tort_truskawkowy.jpg', 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `promocje`
--

CREATE TABLE `promocje` (
  `idPR` int(11) NOT NULL,
  `idP` int(11) DEFAULT NULL,
  `znizka` decimal(6,5) NOT NULL,
  `nazwa` varchar(50) NOT NULL,
  `zdjecie` varchar(50) NOT NULL,
  `data_rozpoczecia` date DEFAULT NULL,
  `data_zakonczenia` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promocje`
--

INSERT INTO `promocje` (`idPR`, `idP`, `znizka`, `nazwa`, `zdjecie`, `data_rozpoczecia`, `data_zakonczenia`) VALUES
(1, 1, 0.15000, 'Roczna Promocja Sernikowa', 'zdjecia/roczne_promo_ser.jpg', '2024-01-01', '2024-12-31'),
(2, 3, 0.20000, 'Swiateczne Pierniki', 'zdjecia/swiateczna_oferta_pier.jpg', '2024-12-01', '2024-12-24'),
(3, 4, 0.10000, 'Miesiac Tortu', 'zdjecia/miesiac_tortu.jpg', '2024-11-01', '2024-12-31');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `idZ` int(11) NOT NULL,
  `idP` int(11) NOT NULL,
  `idK` int(11) NOT NULL,
  `ilosc` int(15) NOT NULL,
  `data_wykonania` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zamowienia`
--

INSERT INTO `zamowienia` (`idZ`, `idP`, `idK`, `ilosc`, `data_wykonania`) VALUES
(1, 1, 1, 2, '2023-12-14'),
(2, 3, 2, 1, '2023-12-18'),
(3, 4, 3, 1, '2024-01-22');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kategorieproduktow`
--
ALTER TABLE `kategorieproduktow`
  ADD PRIMARY KEY (`idKP`);

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`idK`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`idP`),
  ADD KEY `idKP` (`idKP`);

--
-- Indeksy dla tabeli `promocje`
--
ALTER TABLE `promocje`
  ADD PRIMARY KEY (`idPR`),
  ADD KEY `idP` (`idP`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`idZ`),
  ADD KEY `idP` (`idP`),
  ADD KEY `idK` (`idK`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorieproduktow`
--
ALTER TABLE `kategorieproduktow`
  MODIFY `idKP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `klienci`
--
ALTER TABLE `klienci`
  MODIFY `idK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
  MODIFY `idP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `promocje`
--
ALTER TABLE `promocje`
  MODIFY `idPR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `idZ` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `produkty_ibfk_1` FOREIGN KEY (`idKP`) REFERENCES `kategorieproduktow` (`idKP`);

--
-- Constraints for table `promocje`
--
ALTER TABLE `promocje`
  ADD CONSTRAINT `promocje_ibfk_1` FOREIGN KEY (`idP`) REFERENCES `produkty` (`idP`);

--
-- Constraints for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`idP`) REFERENCES `produkty` (`idP`),
  ADD CONSTRAINT `zamowienia_ibfk_2` FOREIGN KEY (`idK`) REFERENCES `klienci` (`idK`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
