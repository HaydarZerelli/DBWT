<?php
$gerichte = [
  ['desc' => "Rindfleisch mit Bambus, Kaiserschoten und rotem Paprika, dazu Mit Nudeln",
      'preis-ext' => 6.20, 'preis-int' => 3.50, 'bild' => "./img/rindfleisch-asia.jpg"
      ],
    ['desc' => "Spinatrisotto mit kleinen Samosateigecken und gemischter Salat",
        'preis-ext' => 5.30, 'preis-int' => 2.90, 'bild' => "./img/spinatrisotto.jpg"
    ],
    ['desc' => "Schnitzel Wiener Art mit Pommes und Beilagensalat",
        'preis-ext' => 5.0, 'preis-int' => 2.60, 'bild' => "./img/schnitzel.jpg"
    ],
    ['desc' => "Kartoffelsuppe mit Würstchen",
        'preis-ext' => 3.50, 'preis-int' => 2.10, 'bild' => "./img/kartoffelsuppe.jpg"
    ],
    ['desc' => "Pfannkuchen mit Nutella und Banane, dazu eine Kugel Vanilleeis",
        'preis-ext' => 3.50, 'preis-int' => 2.10, 'bild' => "./img/pfannkuchen.jpg"
    ]
];
// serialisiere $gerichte und schreibe ergebnis in /gerichte.txt
file_put_contents("./gerichte.txt",serialize($gerichte));