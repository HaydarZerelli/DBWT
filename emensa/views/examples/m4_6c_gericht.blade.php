<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>6c_gericht</title>
    <style>
    </style>
</head>
<body>
<ul>

    @forelse($data as $a)
        <li>{{$a['name']}}, {{$a['preis_intern']}}&euro;</li>
    @empty
        <li>Es sind keine Geriche vorhanden.</li>
    @endforelse
</ul>
</body>
</html>

