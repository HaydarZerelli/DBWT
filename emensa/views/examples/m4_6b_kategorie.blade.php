<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>6b_kategorie</title>
    <style>
        li:nth-child(even) {
            font-weight: bold;
        }
    </style>
</head>
<body>
<ul>

    @forelse($data as $a)
        <li>{{$a['name']}}</li>
    @empty
        <li>Keine Daten vorhanden.</li>
    @endforelse
</ul>
</body>
</html>

