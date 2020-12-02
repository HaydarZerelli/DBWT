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