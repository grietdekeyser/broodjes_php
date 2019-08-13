<!DOCTYPE>
<html>
<head>
    <meta charset="utf-8">
    <title>Bestel uw broodje</title>
</head>
<body>
    <!-- optie toevoegen om meerdere broodjes te bestellen -->
    <!-- prijs tonen besteld broodje -->
    <h1>Broodje bestellen</h1>
    <p>Dag <?php print($naamGebruiker); ?>!</p>
    
    <?php
    //foutmelding
        if (isset($error) && $error == "kiesbeleg") {
            ?>
            <p style="color: red">Gelieve het gewenste beleg te selecteren</p>
            <?php
        }
    ?>
    <?php
    //melding
        if (isset($broodjeBesteld) ) {
            ?>
            <p><strong>Uw broodje werd besteld. Kies uw extra broodje</strong></p>
            <?php
        }
    ?>
            
    <form action="" method="post">
            <label for="type">Kies het gewenste type broodje: </label>
            <br>
            <select name="type" id="type">
                <?php
                    foreach ($tabType as $type) {
                        print("<option value='" . $type->getId() . "' required");
                        if (isset($_POST["type"]) && $_POST["type"] == $type->getId()) {
                            print(" selected");
			}
                        print(">" . $type->getType() . " (&euro; " . $type->getPrijs() . ")</option>");
                    }
                ?>
            </select>
            <br>
            <br>
            Kies uw beleg:
            <br>
                <?php
                    foreach ($tabBeleg as $beleg) {
                        print("<input type='checkbox' name='beleg[]' value='" . $beleg->getId() . "'");
                        if (isset($_POST["beleg"])) {
                            foreach($_POST["beleg"] as $selected){
                                if ($selected == $beleg->getId()) {
                                    print(" checked");
                                }
                            }
                                   
			}
                        print(">" . $beleg->getBeleg() . " (+ &euro; " . $beleg->getPrijs() . ")<br>");
                    }
                ?>
            <br>
            <button name="bereken">Bereken kostprijs</button>
            <br>
            <?php
                if (isset($prijsBroodje)) {
                    ?>
                    <p>De kostprijs van een <?php print($typeBroodje); ?> broodje met <?php print($belegBroodje); ?> bedraagt € <?php print($prijsBroodje); ?> </p>
                    <?php
                }
            ?>
            <br>
            <button name="bestel">Bestel</button>
            <button name="bestelextra">Bestel nog een broodje</button>
    </form>
    <p>
            <a href="uitloggen.php">Uitloggen</a>
    </p>
</body>
</html>
