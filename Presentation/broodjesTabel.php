<!DOCTYPE html>
<!--Presentation/broodjesTabel.php-->
<html>
<head>
    <meta charset="utf-8">
    <title>Overzicht bestelde broodjes</title>
</head>
<body>
    <h1>Overzicht bestelde broodjes <?php print($naamGebruiker); ?></h1>
    <?php
        if (isset($error) && $error == "reedsbesteld") {
            ?>
            <p><strong>U hebt reeds een bestelling geplaatst vandaag. U kan slechts 1 bestelling per dag plaatsen.</strong></p>
            <br>
            <br>
            <?php
        }
        if (isset($error) && $error == "natienuur") {
            ?>
            <p><strong>Het is enkel mogelijk om broodjes te bestellen voor 10 uur.</strong></p>
            <?php
        }
        if ($tabBroodje) {
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Type broodje</th>
                        <th>Beleg</th>
                        <th>Prijs</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($tabBroodje as $broodje) {
                            print("<tr><td>" . $broodje->getType() . "</td>");
                            print("<td>" . $broodje->getBeleg() . "</td>");
                            print("<td>" . $broodje->getPrijs() . "</td></tr>");
                        }
                    ?>
                </tbody>
            </table>
            <?php
        } else {
            ?>
            <p>U heeft geen broodje(s) besteld vandaag.</p>
            <?php
        }
    ?>
    <p>
        <a href="uitloggen.php">Uitloggen</a>
    </p>
</body>
</html>