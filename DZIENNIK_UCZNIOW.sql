PROMPT CREATE TABLE dziennik_uczniow
CREATE TABLE dziennik_uczniow (
  id                   NUMBER      NOT NULL,
  imie                 VARCHAR2(8) NULL,
  nazwisko             VARCHAR2(8) NULL,
  ocena_polski         INTEGER     NULL,
  ocena_mat            INTEGER     NULL,
  ocena_ang            INTEGER     NULL,
  ocena_inf            INTEGER     NULL,
  ocena_fizyka         INTEGER     NULL,
  srednia_arytmetyczna FLOAT(126)  NULL,
  srednia_geometryczna FLOAT(126)  NULL,
  srednia_harmoniczna  FLOAT(126)  NULL
)
  TABLESPACE users
/

PROMPT ALTER TABLE dziennik_uczniow ADD CONSTRAINT id_pk PRIMARY KEY
ALTER TABLE dziennik_uczniow
  ADD CONSTRAINT id_pk PRIMARY KEY (
    id
  )
  USING INDEX
    TABLESPACE users
/


