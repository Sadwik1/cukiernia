-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 18 Lis 2024, 00:12
-- Wersja serwera: 10.4.25-MariaDB
-- Wersja PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `cukiernia`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorieproduktow`
--

CREATE TABLE `kategorieproduktow` (
  `idKP` int(11) NOT NULL,
  `nazwa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `kategorieproduktow`
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
  `telefon` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `klienci`
--

INSERT INTO `klienci` (`idK`, `imie`, `nazwisko`, `email`, `telefon`) VALUES
(1, 'Jan', 'Kowalski', 'jan.kowalski@example.com', '123456789'),
(2, 'Anna', 'Nowak', 'anna.nowak@example.com', '987654321'),
(3, 'Piotr', 'Wiśniewski', 'piotr.wisniewski@example.com', '555123456');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `produkty`
--

INSERT INTO `produkty` (`idP`, `nazwa`, `cena`, `skladniki`, `wartosc_odzywcza`, `zdjecie`, `idKP`) VALUES
(1, 'Sernik', '15.99', 'Ser, biszkopty, śmietana', 'Wysoka zawartość tłuszczu', 'sernik.jpg', 1),
(2, 'Ciasto czekoladowe', '12.99', 'Czekolada, mąka, jajka', 'Średnia zawartość tłuszczu', 'ciasto_czekoladowe.jpg', 1),
(3, 'Pierniczki', '8.99', 'Mąka, miód, przyprawy', 'Niska zawartość tłuszczu', 'pierniczki.jpg', 2),
(4, 'Tort truskawkowy', '25.99', 'Biszkopt, krem, truskawki', 'Wysoka zawartość cukru', 'tort_truskawkowy.jpg', 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `idZ` int(11) NOT NULL,
  `idP` int(11) NOT NULL,
  `idK` int(11) NOT NULL,
  `ilosc` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `zamowienia`
--

INSERT INTO `zamowienia` (`idZ`, `idP`, `idK`, `ilosc`) VALUES
(1, 1, 1, 2),
(2, 3, 2, 1),
(3, 4, 3, 1);

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
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`idZ`),
  ADD KEY `idP` (`idP`),
  ADD KEY `idK` (`idK`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `kategorieproduktow`
--
ALTER TABLE `kategorieproduktow`
  MODIFY `idKP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `idK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `idP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `idZ` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `produkty_ibfk_1` FOREIGN KEY (`idKP`) REFERENCES `kategorieproduktow` (`idKP`);

--
-- Ograniczenia dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`idP`) REFERENCES `produkty` (`idP`),
  ADD CONSTRAINT `zamowienia_ibfk_2` FOREIGN KEY (`idK`) REFERENCES `klienci` (`idK`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
