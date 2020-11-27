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
    foreign key (code) references allergen(code)
            on delete cascade
            on update cascade,
    id bigint not null,
    foreign key (id) references gericht(id)
            on delete cascade
            on update cascade,
    primary key(code, id)
);

DROP TABLE IF EXISTS `gericht_hat_kategorie`;
CREATE TABLE gericht_hat_kategorie (
    kategorie_id bigint not null,
    foreign key (kategorie_id) references kategorie(id)
            on delete cascade
            on update cascade,
    gericht_id bigint not null,
    foreign key (gericht_id) references gericht(id)
            on delete cascade
            on update cascade,
    primary key(kategorie_id, gericht_id)
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