create database zakladki;
use zakladki;

create table uzytkownik  (
  nazwa_uz varchar(16) not null primary key,
  haslo char(40) not null,
  email varchar(100) not null
);

create table zakladka  (
  nazwa_uz varchar(16) not null,
  URL_zak varchar(255) not null,
  index (nazwa_uz),
  index (URL_zak),
  primary key (nazwa_uz, URL_zak)
);

grant select, insert, update, delete
on zakladki.*
to uzyt_zak@localhost identified by 'haslo';
