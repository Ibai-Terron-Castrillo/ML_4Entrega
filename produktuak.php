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
    /* Produktuak gehitu, eguneratu edo ezabatutakoan mezua erakusten du */
    if (isset($_GET['createEgin']) && $_GET['createEgin'] == 'true') {
        echo "<p style='color: green;'>Produktua gehitu da!</p>"; /* Produktua gehitu dela adierazten du */
        $_GET['createEgin'] = 'false'; /* Parametroa resetatzen du */
    }

    if (isset($_GET['updateEgin']) && $_GET['updateEgin'] == 'true') {
        echo "<p style='color: green;'>Produktua eguneratu da!</p>"; /* Produktua eguneratu dela adierazten du */
        $_GET['updateEgin'] = 'false'; 
    }

    if (isset($_GET['deleteEgin']) && $_GET['deleteEgin'] == 'true') {
        echo "<p style='color: green;'>Produktua ezabatu da!</p>"; /* Produktua ezabatuta izan dela adierazten du */
        $_GET['deleteEgin'] = 'false';
    } 

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

    /* Bilaketa egin bada, galderara parametroa gehitzen du */

    if (isset($_GET["search"])) {
        $search = $_GET["search"];
        $query .= " AND (izena LIKE '%$search%' OR mota LIKE '%$search%')";
    }

    /* Mota filtra egin bada, galderara mota gehitzen du */

    if (isset($_GET["mota"]) && $_GET["mota"] != "") {
        $mota = $_GET["mota"];
        $query .= " AND mota = '$mota'";
    }

    /* Galdera exekutatzen du eta emaitzak gordetzen ditu */

    $result = $conn->query($query);

    /* Produktu berria gehitu nahi denean */
    if (isset($_GET["create"])) {
        $izena = $_GET["izena"];
        $mota = $_GET["createmota"];
        $prezioa = $_GET["prezioa"];
        if (!empty($izena) && !empty($mota) && !empty($prezioa)) {

            /* Produktu berria datu-basean gehitzen du */

            $sql = "INSERT INTO produktuak (izena, mota, prezioa) VALUES ('$izena', '$mota', $prezioa)";
            if ($conn->query($sql) === TRUE) {
                header("Location: " . $_SERVER['PHP_SELF'] . "?createEgin=true"); /* Success: orri berriz kargatzen du */
                exit;
            } else {
                echo "Errorea: " . $conn->error . ""; /* Errorra bistaratzen du */
            }
        }
    }

    /* Produktu bat eguneratu nahi denean */
    if (isset($_GET["update"])) {
        $id = $_GET["id"];
        $izena = $_GET["izena"];
        $mota = $_GET["editmota"];
        $prezioa = $_GET["prezioa"];
        $sql = "UPDATE produktuak SET izena = '$izena', mota = '$mota', prezioa = $prezioa WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?updateEgin=true"); /* Success: orri berriz kargatzen du */
            exit;
        } else {
            echo "Errorea: " . $conn->error . ""; /* Errorra bistaratzen du */
        }
    }

    /* Produktu bat ezabatu nahi denean */

    if (isset($_GET["delete"])) {
        $id = $_GET["id"];
        $sql = "DELETE FROM produktuak WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?deleteEgin=true"); /* Orri berriz kargatzen du */
            exit;
        } else {
            echo "Errorea: " . $conn->error . ""; /* Errorra bistaratzen du */
        }
    }
    ?>

  <!-- Bilaketa formularioa -->

<h2>Bilaketa</h2>
<form action="" method="GET">

    <!-- Bilatzailearen sarea: Izena edo mota -->

    <label>Bilatu:</label>
    <input type="text" name="search" placeholder="Izena edo mota bilatu"
        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"> <!-- Aurreko bilaketa bat egon bada, balioa erakusten du -->

    <!-- Produktuaren mota aukeratzeko sarea -->

    <label>Mota:</label>
    <select name="mota">

        <!-- Mota aukeratzeko aukera -->

        <option value="">-- Aukeratu mota --</option>
        <option value="Elektronika" <?php echo (isset($_GET['mota']) && $_GET['mota'] == "Elektronika") ? "selected" : ""; ?>>Elektronika</option>
        <option value="Osagarriak" <?php echo (isset($_GET['mota']) && $_GET['mota'] == "Osagarriak") ? "selected" : ""; ?>>Osagarriak</option>
        <option value="Biltegiratzea" <?php echo (isset($_GET['mota']) && $_GET['mota'] == "Biltegiratzea") ? "selected" : ""; ?>>Biltegiratzea</option>
    </select>

    <!-- Bilatzeko botoia -->

    <input type="submit" value="Bilatu">
</form>

<!-- Produktua gehitzeko esteka -->

<a href="?createForm=true">
    <i class="fas fa-plus"></i> Produktua Gehitu
</a>

<!-- Produktua gehitzeko formularioa, erabiltzaileak pasatzen badu -->

<?php if (isset($_GET['createForm']) && $_GET['createForm'] == "true"): ?>
    <h2>Produktua Gehitu</h2>
    <form action="" method="GET">

        <!-- Izena sartu -->

        <label>Izena:</label>
        <input type="text" name="izena" required>
        
        <!-- Mota aukeratu -->

        <label>Mota:</label>
        <select name="createmota" required>
            <option value="">-- Aukeratu mota --</option>
            <option value="Elektronika">Elektronika</option>
            <option value="Osagarriak">Osagarriak</option>
            <option value="Biltegiratzea">Biltegiratzea</option>
        </select>
        
        <!-- Prezioa sartu -->

        <label>Prezioa:</label>
        <input type="number" step="0.01" name="prezioa" required>
        
        <!-- Produktua gehitzeko botoia -->

        <input type="submit" name="create" value="Gehitu">
    </form>
<?php endif; ?>

<hr>

<!-- Produktua editatzeko formularioa -->

<?php if (isset($_GET['editForm']) && $_GET['editForm'] == "true"): ?>
    <h2>Produktua Eguneratu</h2>
    <form action="" method="GET">

        <!-- Produktuaren ID ezkutua -->

        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
        
        <!-- Izena editatzeko sarea -->

        <label>Izena:</label>
        <input type="text" name="izena" value="<?php echo $_GET['izena']; ?>" required>
        
        <!-- Mota editatzeko sarea -->

        <label>Mota:</label>
        <select name="editmota" required>
            <option value="">-- Aukeratu mota --</option>

            <!-- Mota hautatua izan bada, selektatuta uzten da -->

            <option value="Elektronika" <?php if ($_GET["editmota"] == "Elektronika") { echo 'selected="selected"'; } ?>>Elektronika</option>
            <option value="Osagarriak" <?php if ($_GET["editmota"] == "Osagarriak") { echo 'selected="selected"'; } ?>>Osagarriak</option>
            <option value="Biltegiratzea" <?php if ($_GET["editmota"] == "Biltegiratzea") { echo 'selected="selected"'; } ?>>Biltegiratzea</option>
        </select>
        
        <!-- Prezioa editatzeko sarea -->

        <label>Prezioa:</label>
        <input type="number" step="0.01" name="prezioa" value="<?php echo $_GET['prezioa']; ?>" required>
        
        <!-- Produktua eguneratzeko botoia -->

        <input type="submit" name="update" value="Eguneratu">
    </form>
<?php endif; ?>

<!-- Produktuen zerrenda erakusten du  -->

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
                        <!-- Editatzeko esteka (Enlace para editar) -->
                        <a href='?editForm=true&id=" . $row["id"] . "&izena=" . $row["izena"] . "&editmota=" . $row["mota"] . "&prezioa=" . $row["prezioa"] . "'><i class='fas fa-pencil-alt'></i> Editatu</a> |
                        <!-- Ezabatzeko esteka (Enlace para eliminar) -->
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