<!DOCTYPE>
<!--Presentation/inlogForm.php-->
<html>
<head>
    <meta charset="utf-8">
    <title>Inloggen</title>
</head>
<body>
    <h1>Broodje bestellen</h1>    
    <h2>Inloggen</h2>
    <?php
    //meldingen
        if (isset($checkEmail)) {
            ?>
            <strong>Je account is succesvol geregistreerd. Binnen enkele ogenblikken zal je een e-mail ontvangen met een wachtwoord. Hiermee kan je inloggen.</strong>
            <br>
            <br>
            <br>
            <?php
        }
        if (isset($newPW)) {
            ?>
            <strong>Er werd een nieuw wachtwoord gegenereerd. Binnen enkele ogenblikken zal je een e-mail ontvangen met dit nieuwe wachtwoord. Hiermee kan je inloggen.</strong>
            <br>
            <br>
            <br>
            <?php
        }
    ?>
    <form action="inloggen.php?action=login" method="post">
        <label for="email">E-mailadres: </label>
        <input type="email" name="email" required <?php if (isset($_POST["email"])) { print("value='" . $_POST["email"] . "'");}?> >
        <?php
        //foutmelding
            if (isset($error) && $error == "emailunknown") {
                ?>
                <em style="color:red;">E-mail niet gekend, maak een account aan.</em>
                <?php
            }
        ?>
        <br>
        <br>
        <label for="wachtwoord">Wachtwoord: </label>
        <input type="password" name="wachtwoord" required>
        <?php
        //foutmelding
            if (isset($error) && $error == "passwordwrong") {
                ?>
                <em style="color:red;">Wachtwoord incorrect</em>
                <?php
            }
        ?>
        <br>
        <br>
        <button>Inloggen</button>
    </form>
    <p>
        Wachtwoord vergeten? <a href="inloggen.php?action=changePW">Vraag een nieuw wachtwoord aan.</a>
    </p>
    <?php
        if (isset($changePW)) {
            ?>
                <form action="inloggen.php?action=newPW" method="post">
                    <label for="email">E-mailadres: </label>
                    <input type="email" name="email" required>
                    <button>Vraag nieuw wachtwoord aan</button>
                </form>
            <?php
            if (isset($error) && $error == "emailnotknown") {
                ?>
                <em style="color:red;">E-mail niet gekend, maak een account aan.</em>
                <?php
            }
        }
    ?>
    <br>
    <p>
        Nog geen account? <a href="registratie.php">Maak een account.</a> 
    </p>
</body>
</html>