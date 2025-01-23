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


    /* Kontsulta exekutatzen dugu eta emaitzak jasotzen ditugu */
    $result = $conn->query($query);

    ?>

    <h2>Bilaketa</h2>
    <form action="" method="GET">
        <label>Bilatu:</label>
        <input type="text" name="search" placeholder="Izena edo mota bilatu" <label>Mota:</label>
        <select name="mota">

        </select>
        <input type="submit" value="Bilatu"> <!-- Bilaketa egin -->
    </form>

    

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