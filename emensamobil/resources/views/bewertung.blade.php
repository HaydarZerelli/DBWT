
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{asset('bewertung.css')}}">
    <title>Bewertung</title>
</head>
<body>
<div class="container">
    <div class="row" id="bewertung">
        <div class="col-6 form">
        <form name="bewertung" target="_self" action="/bewertung_verarbeiten" method="post">
            @csrf
            <fieldset>
                <legend> Bewertung: {{$data[0]->name}}</legend>
                <label>Wie war das Gericht?</label>
                <select name="sterne" required>
                    <option value = "sehr gut" selected>sehr gut</option>
                    <option value = "gut">gut</option>
                    <option value = "schlecht">schlecht</option>
                    <option value = "sehr schlecht">sehr schlecht</option>
                </select><br>
                <label>Kommentar</label>
                <textarea name="kommentar" id="kommentar" cols="auto" rows="5" placeholder="Wie hat dir das gericht gefallen?" required></textarea><br>
                <input type="hidden" name="submitted" value="1">
                <input type="hidden" name="id" value="{{$request->gerichtid}}">
                <button type="submit">Absenden</button>
            </fieldset>
        </form>
        </div>
        <div class="col-6">
            <img src="img/gerichte/{{$data[0]->bildname}}" alt="{{$data[0]->name}}">
        </div>
    </div>
</div>
</body>
</html>
