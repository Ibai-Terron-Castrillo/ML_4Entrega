<html>

<head>
    <meta charset="UTF-8" />
    <title>Produktuen Kudeaketa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: Canvas;
            color: CanvasText;
            color-scheme: light dark;
        }

        table {
            width: 50%;
            text-align: center;
            padding: 10px;
        }

        td {
            padding: 5px;
        }
    </style>
</head>

<body>
    <h1>Produktuen Kudeaketa</h1>

    <?php

    if (isset($_GET['createEgin']) && $_GET['createEgin'] == 'true') {
        echo "<p style='color: green;'>Produktua gehitu da!</p>";
        $_GET['createEgin'] = 'false';
    }

    if (isset($_GET['updateEgin']) && $_GET['updateEgin'] == 'true') {
        echo "<p style='color: green;'>Produktua eguneratu da!</p>";
        $_GET['updateEgin'] = 'false';
    }

    if (isset($_GET['deleteEgin']) && $_GET['deleteEgin'] == 'true') {
        echo "<p style='color: green;'>Produktua ezabatu da!</p>";
        $_GET['deleteEgin'] = 'false';
    }

    $servername = "localhost:3306";
    $username = "root";
    $password = "1MG2024";
    $dbname = "markatze";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT * FROM produktuak WHERE 1";

    if (isset($_GET["search"])) {
        $search = $_GET["search"];
        $query .= " AND (izena LIKE '%$search%' OR mota LIKE '%$search%')";
    }

    if (isset($_GET["mota"]) && $_GET["mota"] != "") {
        $mota = $_GET["mota"];
        $query .= " AND mota = '$mota'";
    }

    $result = $conn->query($query);

    if (isset($_GET["create"])) {
        $izena = $_GET["izena"];
        $mota = $_GET["createmota"];
        $prezioa = $_GET["prezioa"];
        if (!empty($izena) && !empty($mota) && !empty($prezioa)) {
            $sql = "INSERT INTO produktuak (izena, mota, prezioa) VALUES ('$izena', '$mota', $prezioa)";
            if ($conn->query($sql) === TRUE) {
                header("Location: " . $_SERVER['PHP_SELF'] . "?createEgin=true");
                exit;
            } else {
                echo "Errorea: " . $conn->error . "";
            }
        }
    }

    if (isset($_GET["update"])) {
        $id = $_GET["id"];
        $izena = $_GET["izena"];
        $mota = $_GET["editmota"];
        $prezioa = $_GET["prezioa"];
        $sql = "UPDATE produktuak SET izena = '$izena', mota = '$mota', prezioa = $prezioa WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?updateEgin=true");
            exit;
        } else {
            echo "Errorea: " . $conn->error . "";
        }
    }

    if (isset($_GET["delete"])) {
        $id = $_GET["id"];
        $sql = "DELETE FROM produktuak WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?deleteEgin=true");
            exit;
        } else {
            echo "Errorea: " . $conn->error . "";
        }
    }
    ?>

    <h2>Bilaketa</h2>
    <form action="" method="GET">
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
        <input type="submit" value="Bilatu">
    </form>

    <a href="?createForm=true">
        <i class="fas fa-plus"></i> Produktua Gehitu
    </a>

    <?php if (isset($_GET['createForm']) && $_GET['createForm'] == "true"): ?>
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
    <?php if (isset($_GET['editForm']) && $_GET['editForm'] == "true"): ?>
        <h2>Produktua Eguneratu</h2>
        <form action="" method="GET">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <label>Izena:</label>
            <input type="text" name="izena" value="<?php echo $_GET['izena']; ?>" required>
            <label>Mota:</label>
            <select name="editmota" required>
                <option value="">-- Aukeratu mota --</option>
                <option value="Elektronika" <?php if ($_GET["editmota"] == "Elektronika") {
                    echo 'selected="selected"';
                } ?>>
                    Elektronika</option>
                <option value="Osagarriak" <?php if ($_GET["editmota"] == "Osagarriak") {
                    echo 'selected="selected"';
                } ?>>
                    Osagarriak</option>
                <option value="Biltegiratzea" <?php if ($_GET["editmota"] == "Biltegiratzea") {
                    echo 'selected="selected"';
                } ?>>
                    Biltegiratzea</option>
            </select>
            <label>Prezioa:</label>
            <input type="number" step="0.01" name="prezioa" value="<?php echo $_GET['prezioa']; ?>" required>
            <input type="submit" name="update" value="Eguneratu">
        </form>
    <?php endif; ?>
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
            echo "<tr><td colspan='5'>Ez dago daturik.</td></tr>";
        }
        ?>
    </table>

    <?php $conn->close(); ?>
</body>

</html>