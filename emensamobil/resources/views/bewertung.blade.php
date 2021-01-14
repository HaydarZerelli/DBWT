
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="index.css">
    <title>Bewertung</title>
</head>
<body>
<div class="container">
    <div class="row">
        <form name="bewertung" target="_self" action="/bewertung_verarbeiten" method="post">
            @csrf
            <fieldset>
                <legend> Bewertung </legend>
                <label>Sterne</label><br>
                <select name="sterne" required>
                    <option value = "5" selected>5</option>
                    <option value = "4">4</option>
                    <option value = "3">3</option>
                    <option value = "2">2</option>
                    <option value = "1">1</option>
                    <option value = "0">0</option>
                </select><br>
                <label>Kommentar</label><br>
                <textarea name="kommentar" id="kommentar" cols="60" rows="5" placeholder="Wie hat dir das gericht gefallen?" required></textarea><br>
                <input type="hidden" name="submitted" value="1">
                <button type="submit">Absenden</button>
            </fieldset>
        </form>
    </div>
</div>
</body>
</html>
