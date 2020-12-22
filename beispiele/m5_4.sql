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