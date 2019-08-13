<!DOCTYPE>
<!--Presentation/registratieForm.php-->
<html>
<head>
    <meta charset="utf-8">
    <title>Registratie</title>
</head>
<body>
    <h1>Broodje bestellen</h1>    
    <h2>Registreren</h2>
        <form action="registratie.php?action=register" method="post">
            <label for="voornaam">Voornaam: </label>
            <input type="text" name="voornaam" required <?php if (isset($_POST["voornaam"])) { print("value='" . $_POST["voornaam"] . "'");}?> >
            <br>
            <br>
            <label for="familienaam">Familienaam: </label>
            <input type="text" name="familienaam" required <?php if (isset($_POST["familienaam"])) { print("value='" . $_POST["familienaam"] . "'");}?> >
            <br>
            <br>
            <label for="email">E-mailadres: </label>
            <input type="email" name="email" required <?php if (isset($_POST["email"])) { print("value='" . $_POST["email"] . "'");}?> >
            <?php
            //foutmelding
                if (isset($error) && $error == "emailexists") {
                    ?>
                    <em style="color:red;">Er bestaat reeds een gebruiker met dit e-mailadres. Log in om verder te gaan</em>
                    <?php
                    }
            ?>
            <br>
            <br>
            <button>Registreren</button>
        </form>
        <p>
            Reeds een account? <a href="inloggen.php">Inloggen.</a> 
        </p>
</body>
</html>
