@extends('layouts.layout_home')

@section('title', 'E-Mensa')
@section('header')
    <header>
        <nav>
            <div class="row">
                <!-- E-Mensa Logo -->
                <div class="col-2">
                    <a href="/">
                        <img id="logo" alt="logo" src="img/e-mensa_logo.png">
                    </a>
                </div>
                <!-- Navigation Bar -->
                <div class="col-10">
                    <ul>
                        <li><a href="#ankuendigung">Ank&uuml;ndigung</a></li>
                        <li><a href="#speisen">Speisen</a></li>
                        <li><a href="#zahlen">Zahlen</a></li>
                        <li><a target="_blank" href="../beispiele/Wir_Sind.html">Kontakt</a></li>
                        <li><a href="#wichtig-fuer-uns">wichtig f&uuml;r uns</a></li>

                        <li><a><img id="userlogo" alt="userlogo" src="img/user-tie-solid.svg"></a></li>
                        @if(isset($_SESSION['login_ok']) && $_SESSION['login_ok'] == true)
                            <li>logged in</li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <hr>
@endsection
@section('main')
    <main>
        <div class="row main">
            <!-- leere spalte links -->
            <div class="col-2"></div>
            <!-- mittlere spalte mit inhalt der seite -->
            <div class="col-8">
                <i class="fas fa-user-circle"></i>
                @section('welcome_txt')
                    <!-- Ankündigung -->
                    <a name="ankuendigung"></a>
                    <div class="row">
                        <h1>Bald gibt es Essen auch online ;)</h1>
                    </div>
                    <!-- text box -->
                    <div class="row" id="textbox">
                        <p>Lorem Ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                            et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                            aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                            culpa qui officia deserunt mollit anim id est laborum.
                            C/O https://placeholder.com/text/lorem-ipsum/
                        </p>
                    </div>
                @endsection

                @section('meals')
                    <!-- tabelle

                    <a name="speisen"></a>
                    <div class="row">
                        <h1>K&ouml;stlichkeiten, die Sie erwarten</h1>
                        <table class="food-table">
                            <tr>
                                <th class="dish">Gericht</th>
                                <th class="preis-intern">Preis intern</th>
                                <th class="preis-extern">Preis extern</th>
                            </tr>
                            @foreach($gerichte as $row)
                                <tr>
                                    <td>{{$row['name']}}<sup>{{$row['GROUP_CONCAT(gericht_hat_allergen.code)']}}</sup></td>
                                    <td>{{$row['preis_intern']}}</td>
                                    <td>{{$row['preis_extern']}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div> -->
                    <div class="row" id="food-overview">
                        @foreach($gerichte as $row)
                            <div class="col-3">
                                <img src="img/gerichte/{{$row['bildname']}}" alt="{{$row['name']}}">
                                <span class="caption">{{$row['name']}}<sup>{{$row['GROUP_CONCAT(gericht_hat_allergen.code)']}}</sup><br>
                                    {{$row['preis_intern']}}&euro; intern/ {{$row['preis_extern']}}&euro; extern</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <table class="allergen-table">
                            <tr>
                                <th class="code">Allergencode</th>
                                <th class="allergen">Allergen</th>
                            </tr>
                            @foreach($allergene as $row)
                                <tr>
                                    <td>{{$row['code']}}</td>
                                    <td>{{$row['name']}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endsection
            </div>
            <!-- leere spalte rechts -->
            <div class="col-2"></div>
        </div>
    </main>
@endsection
@section('footer')
    <hr>
    <footer>
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>&copy; E-Mensa GmbH</li>
                    <li><a target="_blank" href="../../beispiele/Wir_Sind.html">About Us</a></li>
                    <li><a href="#">Impressum</a></li>
                </ul>
            </div>
        </div>
    </footer>
@endsection
