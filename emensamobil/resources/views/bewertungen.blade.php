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
        <div class="row">
            <table>
                <th>gericht id</th>
                <th>bewertung</th>
                <th>bemerkung</th>
                @if(session('admin'))
                    <th></th>
                @endif

                @foreach($bewertungen as $row)
                    @if($row->hervorgehoben)
                        <tr class="hervorgehoben">
                    @else
                        <tr>
                    @endif
                    <td>{{$row->gericht_id}}</td>
                    <td>{{$row->sterne}}</td>
                    <td>{{$row->bemerkung}}</td>
                    @if(session('admin') && !$row->hervorgehoben)
                        <td><a href="{{url('/hervorheben?').http_build_query(['bewertungsid' => $row->id])}}">hervorheben</a></td>
                    @elseif (session('admin') && $row->hervorgehoben)
                        <td><a href="{{url('/abwaehlen?').http_build_query(['bewertungsid' => $row->id])}}">abw&auml;hlen</a></td>
                    @endif
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="row">
            <a href="/">zurück</a>
        </div>
    </div>
</body>
</html>
