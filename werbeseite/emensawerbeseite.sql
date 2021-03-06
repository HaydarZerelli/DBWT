DROP DATABASE IF EXISTS `db_emensawerbeseite`;
CREATE DATABASE db_emensawerbeseite
    CHARACTER SET = 'UTF8mb4'
    COLLATE = 'utf8mb4_unicode_ci';

USE db_emensawerbeseite;

DROP TABLE IF EXISTS `gericht`;
CREATE TABLE gericht (
    id bigint primary key,
    name varchar(80) unique not null,
    beschreibung varchar(800) not null,
    erfasst_am date not null,
    vegetarisch boolean not null,
    vegan boolean not null,
    preis_intern double not null
                    check(preis_intern > 0),
    preis_extern double not null
                    check(preis_extern > preis_intern)
);

DROP TABLE IF EXISTS `allergen`;
CREATE TABLE allergen (
  code char(4) primary key,
  name varchar(300) not null,
  typ varchar(20) not null
);

DROP TABLE IF EXISTS `kategorie`;
CREATE TABLE kategorie (
    id bigint primary key,
    name varchar(80) not null,
    eltern_id bigint,
    bildname varchar(200)
);

DROP TABLE IF EXISTS `gericht_hat_allergen`;
CREATE TABLE gericht_hat_allergen (
    code char(4),
    constraint fk_allergen_gha
    foreign key (code) references allergen(code),
    id bigint not null,
    constraint fk_gericht_gha
    foreign key (id) references gericht(id),
    constraint pk_gericht_hat_allergen
    primary key(code, id)
);

DROP TABLE IF EXISTS `gericht_hat_kategorie`;
CREATE TABLE gericht_hat_kategorie (
    kategorie_id bigint not null,
    constraint fk_kategorie_ghk
    foreign key (kategorie_id) references kategorie(id)
            ,
    gericht_id bigint not null,
    constraint fk_gericht_ghk
    foreign key (gericht_id) references gericht(id)
);

DROP TABLE IF EXISTS `wunschgerichte`;
CREATE TABLE wunschgerichte (
    name varchar(80),
    beschreibung varchar(800) not null,
    erstellungs_datum date not null,
    nummer bigint auto_increment not null primary key,
    email varchar(320) not null,
    ersteller varchar(20) default 'anonym'
);

ALTER TABLE gericht ADD INDEX idx_gericht_name (name);
alter table gericht_hat_allergen drop constraint if exists fk_gericht_gha;
alter table gericht_hat_allergen add constraint fk_gericht_gha
    foreign key (id) references gericht(id)
        on delete cascade on update cascade;
alter table gericht_hat_kategorie drop constraint if exists fk_gericht_ghk;
alter table gericht_hat_kategorie add constraint fk_gericht_ghk
    foreign key (gericht_id) references gericht(id)
        on delete cascade on update cascade;
alter table gericht_hat_kategorie drop constraint if exists fk_kategorie_ghk;
alter table gericht_hat_kategorie add constraint fk_kategorie_ghk
    foreign key (kategorie_id) references kategorie(id)
        on delete no action on update cascade;
alter table kategorie drop constraint if exists fk_kategorie_eltern_kategorie;
alter table kategorie add constraint fk_kategorie_eltern_kategorie
    foreign key (eltern_id) references kategorie(id)
        on delete no action on update cascade;
alter table gericht_hat_allergen drop constraint if exists fk_allergen_gha;
alter table gericht_hat_allergen add constraint fk_allergen_gha
    foreign key (code) references allergen(code)
        on delete cascade on update cascade;
alter table gericht_hat_kategorie drop constraint if exists pk_gericht_hat_kategorie;
alter table gericht_hat_kategorie add constraint pk_gericht_hat_kategorie
    primary key(kategorie_id, gericht_id);

alter table gericht add bildname varchar(200) default '00_image_missing.jpg';

drop table if exists `benutzer`;
create table benutzer (
                          id bigint primary key auto_increment,
                          email varchar(100) unique not null,
                          passwort varchar(200) not null,
                          admin boolean,
                          anzahlfehler int not null default 0,
                          anzahlanmeldungen int not null default 0,
                          letzteanmeldung datetime,
                          letzterfehler datetime
);

create view view_suppe as
    select id, name, preis_intern, preis_extern
    from gericht
    where name like '%suppe%';

create view view_anmeldungen as
    select id as benutzer, anzahlanmeldungen
    from benutzer
    order by anzahlanmeldungen desc;

create view view_kategoriegerichte_vegetarisch as
    select k.name as kategorie, g.name as gericht
    from (select id as gid, name from gericht where vegetarisch=true) g
             right join gericht_hat_kategorie on gericht_id=gid
             right join kategorie k on k.id = gericht_hat_kategorie.kategorie_id;

DELIMITER ;;
CREATE OR REPLACE PROCEDURE anzahlanmeldungen (IN userid INT)
BEGIN
    UPDATE
        benutzer
    SET
        anzahlanmeldungen=anzahlanmeldungen+1
    WHERE
            id = userid;
END;;
DELIMITER ;

ALTER TABLE benutzer ADD COLUMN IF NOT EXISTS auth_token varchar(100);

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

alter table bewertungen add column updated_at timestamp;
alter table gericht add column updated_at timestamp;