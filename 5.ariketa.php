<html>

<head>
    <meta charset="UTF-8" />
    <title>Produktuen Kudeaketa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Estilo orokorrak, atzeko planoa eta testuaren koloreak ezartzen ditu */
        body {
            background-color: Canvas;
            /* Atzeko planoaren kolorea */
            color: CanvasText;
            /* Testuaren kolorea */
            color-scheme: light dark;
            /* Kolore eskema (argia edo iluna) */
        }

        /* Taulako estiloa (zabalkundea, testuaren lerrokatzea eta tarteak) */
        table {
            width: 50%;
            /* Taulak duen zabalkundea, 50% */
            text-align: center;
            /* Testua zentratzea taulan */
            padding: 10px;
            /* Taulako gelaxken barruko tartea */
        }

        td {
            padding: 5px;
            /* Gelaxken barruko tartea */
        }
    </style>
</head>

<body>
    <h1>Produktuen Kudeaketa</h1>

    <?php

    /* Datubasearekin konektatzeko konfigurazioa */
    $servername = "localhost:3306"; /* Datubasearen zerbitzaria eta portua */
    $username = "root"; /* Datubasearen erabiltzailea */
    $password = "1MG2024"; /* Datubasearen pasahitza */
    $dbname = "markatze"; /* Datubasearen izena */

    /* Datubasearekin konektatzen saiatzen gara */
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); /* Konektatzean akatsa izanez gero, mezu bat bistaratzen da */
    }

    /* Produktuak datu-basean bilatzeko SQL kontsulta */
    $query = "SELECT * FROM produktuak WHERE 1"; /* Oinarrizko kontsulta guztia lortzeko */
    
    /* Bilaketa funtzionalitatea erabiltzaileak eskatu duenean */
    if (isset($_GET["search"])) {
        $search = $_GET["search"]; /* Bilaketa terminoaren balioa */
        $query .= " AND (izena LIKE '%$search%' OR mota LIKE '%$search%')"; /* Bilaketa terminoarekin bat datorren produktuak bilatzea */
    }

     /* Mota filtrarako aukera */
     if (isset($_GET["mota"]) && $_GET["mota"] != "") {
        $mota = $_GET["mota"]; /* Mota parametroaren balioa */
        $query .= " AND mota = '$mota'"; /* Mota parametroarekin bat datorren produktuak bilatzea */
    }


    /* Kontsulta exekutatzen dugu eta emaitzak jasotzen ditugu */
    $result = $conn->query($query);

     /* Produktu berria gehitzeko funtzionalitatea */
     if (isset($_GET["create"])) {
        $izena = $_GET["izena"]; /* Produktuaren izena */
        $mota = $_GET["createmota"]; /* Produktuaren mota */
        $prezioa = $_GET["prezioa"]; /* Produktuaren prezioa */
        /* Datuak osorik daudela egiaztatzen dugu */
        if (!empty($izena) && !empty($mota) && !empty($prezioa)) {
            /* Produktu berria insertatzeko SQL kontsulta */
            $sql = "INSERT INTO produktuak (izena, mota, prezioa) VALUES ('$izena', '$mota', $prezioa)";
            if ($conn->query($sql) === TRUE) {
                header("Location: " . $_SERVER['PHP_SELF'] . "?createEgin=true"); /* Produktuarekin ondo egindako ekintzaren berri ematea */
                exit;
            } else {
                echo "Errorea: " . $conn->error . ""; /* Insertatzean errore bat gertatuz gero */
            }
        }
    }

    ?>

<h2>Bilaketa</h2>
    <form action="" method="GET">
        <label>Bilatu:</label>
        <input type="text" name="search" placeholder="Izena edo mota bilatu"
        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"> <!-- Bilaketa terminoaren balioa erakusteko -->
        <label>Mota:</label>
        <select name="mota">
            <option value="">-- Aukeratu mota --</option>
            <option value="Elektronika" <?php echo (isset($_GET['mota']) && $_GET['mota'] == "Elektronika") ? "selected" : ""; ?>>Elektronika</option>
            <option value="Osagarriak" <?php echo (isset($_GET['mota']) && $_GET['mota'] == "Osagarriak") ? "selected" : ""; ?>>Osagarriak</option>
            <option value="Biltegiratzea" <?php echo (isset($_GET['mota']) && $_GET['mota'] == "Biltegiratzea") ? "selected" : ""; ?>>Biltegiratzea</option>
        </select>
        <input type="submit" value="Bilatu"> <!-- Bilaketa egin -->
    </form>

    <a href="?createForm=true">
        <i class="fas fa-plus"></i> Produktua Gehitu
    </a>

    <?php /* Produktu berri bat gehitzeko formularioa erakusteko logika */
    if (isset($_GET['createForm']) && $_GET['createForm'] == "true"): ?>
        <h2>Produktua Gehitu</h2>
        <form action="" method="GET">
            <label>Izena:</label>
            <input type="text" name="izena" required>
            <label>Mota:</label>
            <select name="createmota" required>
                <option value="">-- Aukeratu mota --</option>
                <option value="Elektronika">Elektronika</option>
                <option value="Osagarriak">Osagarriak</option>
                <option value="Biltegiratzea">Biltegiratzea</option>
            </select>
            <label>Prezioa:</label>
            <input type="number" step="0.01" name="prezioa" required>
            <input type="submit" name="create" value="Gehitu">
        </form>
    <?php endif; ?>

    <hr>

    <h2>Produktuen Zerrenda</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Izena</th>
            <th>Mota</th>
            <th>Prezioa</th>
            <th>Ekintzak</th>
        </tr>
        <?php
        /* Produktuak erakusteko logika */
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["izena"] . "</td>
                        <td>" . $row["mota"] . "</td>
                        <td>" . $row["prezioa"] . "€</td>
                        <td>
                            <a href='?editForm=true&id=" . $row["id"] . "&izena=" . $row["izena"] . "&editmota=" . $row["mota"] . "&prezioa=" . $row["prezioa"] . "'><i class='fas fa-pencil-alt'></i> Editatu</a> |
                            <a href='?delete=true&id=" . $row["id"] . "'><i class='fas fa-trash'></i> Ezabatu</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Ez dago daturik.</td></tr>"; /* Datubasean ez dago produkturik */
        }
        ?>
    </table>

    <?php $conn->close(); /* Datubasearen konekzioa itxita */ ?>
</body>

</html>