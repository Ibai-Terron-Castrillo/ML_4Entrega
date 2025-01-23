<html>

<head>
    <meta charset="UTF-8" />
    <title>Produktuen Kudeaketa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* HTML orriko estiloak definitzen ditu */
        body {
            background-color: Canvas; /* Atzeko kolorea */
            color: CanvasText; /* Testuaren kolorea */
            color-scheme: light dark; /* Arbelaren koloreak argi eta iluna moduan */
        }

        /* Taulen estiloak */
        table {
            width: 50%; /* Taula %50 zabalera */
            text-align: center; /* Testua erdian lerrokatu */
            padding: 10px; /* Taularen barruko espazioaren zabalera */
        }

        td {
            padding: 5px; /* Zelulen barruko espazioa */
        }
    </style>
</head>

<body>
    <h1>Produktuen Kudeaketa</h1>

    <?php

    /* Datu-basearekin konektatzen da */

    $servername = "localhost:3306";
    $username = "root";
    $password = "1MG2024";
    $dbname = "markatze";

    /* Konektatzen saiatzen da eta errore bat balego gelditzen da */

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); /* Konektatzeko errore bat badago, mezu bat erakusten da */
    }

    /* Datu-baseko produktuak bilatzeko SQL galdera sortzen du */

    $query = "SELECT * FROM produktuak WHERE 1";

    /* Bilaketa terminoa badago, kontsulta gehitzen da */

    if (isset($_GET["search"])) {
        $search = $_GET["search"]; /* Bilaketa terminoaren balioa */
        $query .= " AND (izena LIKE '%$search%' OR mota LIKE '%$search%')";
    }

    /* Mota filtratzeko aukera */
    if (isset($_GET["mota"]) && $_GET["mota"] != "") {
        $mota = $_GET["mota"]; /* Mota parametroaren balioa */
        $query .= " AND mota = '$mota'"; /* Mota parametroarekin bat datorren produktuak bilatzea */
    }


    /* Galdera exekutatzen du eta emaitzak gordetzen ditu */

    $result = $conn->query($query);

    ?>

  <!-- Bilaketa formularioa -->

<h2>Bilaketa</h2>
<form action="" method="GET">

    <!-- Bilatzailearen sarea: Izena edo mota -->

    <label>Bilatu:</label>
    <input type="text" name="search" placeholder="Izena edo mota bilatu"
    value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    <label>Mota:</label>
    <select name="mota">
        <option value="">-- Aukeratu mota --</option>
        <option value="Elektronika" <?php echo (isset($_GET['mota']) && $_GET['mota'] == "Elektronika") ? "selected" : ""; ?>>Elektronika</option>
        <option value="Osagarriak" <?php echo (isset($_GET['mota']) && $_GET['mota'] == "Osagarriak") ? "selected" : ""; ?>>Osagarriak</option>
        <option value="Biltegiratzea" <?php echo (isset($_GET['mota']) && $_GET['mota'] == "Biltegiratzea") ? "selected" : ""; ?>>Biltegiratzea</option>
        </select>
        <input type="submit" value="Bilatu"> <!-- Bilaketa egin -->
    </form>


<!-- Produktuen zerrenda erakusten du  -->

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

    /* Produktuak taulan erakusten ditu */

    if ($result->num_rows > 0) {

        // Produktuak taulan gehitzen dira 

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["izena"] . "</td>
                    <td>" . $row["mota"] . "</td>
                    <td>" . $row["prezioa"] . "€</td>
                    <td>
                        <!
                        <a href='?editForm=true&id=" . $row["id"] . "&izena=" . $row["izena"] . "&editmota=" . $row["mota"] . "&prezioa=" . $row["prezioa"] . "'><i class='fas fa-pencil-alt'></i> Editatu</a> |
                        
                        <a href='?delete=true&id=" . $row["id"] . "'><i class='fas fa-trash'></i> Ezabatu</a>
                    </td>
                </tr>";
        }
    } else {
        
        echo "<tr><td colspan='5'>Ez dago daturik.</td></tr>";
    }
    ?>
</table>
    <?php $conn->close(); ?> <!-- Datu-basea itxita uzten du -->
</body>

</html>
