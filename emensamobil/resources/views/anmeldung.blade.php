<h3>{{$fehlermeldung}}</h3>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="index.css">
    <title>Login</title>
</head>
<body>
<div class="container">
    <div class="row">
        <form name="wunschgericht" target="_self" action="/anmeldung_verifizieren" method="post">
            @csrf
            <fieldset>
                <legend> Anmeldung </legend>
                <label>E-Mail:</label><br>
                <input type="email" size="64" name="email" placeholder="e-mail" required><br>
                <label>Passwort:</label><br>
                <input type="password" size="64" name="pw" placeholder="Passwort" required><br>
                <input type="hidden" name="submitted" value="1">
                <button type="submit">Anmelden</button>
            </fieldset>
        </form>
    </div>
</div>
</body>
</html>
