
drop table if exists `bewertungen`;
create table bewertungen (
    id bigint primary key auto_increment,
    benutzer_id bigint,
    constraint fk_bewertung_benutzer
        foreign key (benutzer_id) references benutzer(id),
    gericht_id bigint,
    constraint fk_bewertung_gericht
        foreign key (gericht_id) references gericht(id),
    hervorgehoben boolean,
    bewertungszeitpunkt timestamp default current_timestamp,
    sterne varchar(100) not null,
    bemerkung varchar(200)
);