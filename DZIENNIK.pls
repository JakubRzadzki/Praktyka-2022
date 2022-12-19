PROMPT CREATE OR REPLACE PACKAGE dziennik
CREATE OR REPLACE package dziennik
is
    type t_uczniowie is table of dziennik_uczniow%rowtype;
procedure wyczysc_dziennik_uczniow;
procedure wypelnij_dziennik_uczniow;
procedure dodaj_ucznia(p_imie varchar2, p_nazwisko varchar2, p_ocena_polski number,p_ocena_mat number, p_ocena_ang number, p_ocena_inf number, p_ocena_fizyka number);
procedure aktualizuj(p_id number);
FUNCTION DAJ_DANE_UCZNIOW(p_rodzaj_sredniej VARCHAR2,
p_srednia_od NUMBER
DEFAULT NULL, p_srednia_do NUMBER DEFAULT NULL)
RETURN t_uczniowie pipelined;
end;
/

PROMPT CREATE OR REPLACE PACKAGE BODY dziennik
CREATE OR REPLACE package BODY dziennik
is




  procedure wyczysc_dziennik_uczniow

  is

   begin
      delete from dziennik_uczniow;
   commit;

  END;



        procedure wypelnij_dziennik_uczniow



        is
           z_ocena_polski NUMBER;
          z_ocena_mat NUMBER;
          z_ocena_ang NUMBER;
          z_ocena_inf NUMBER;
          z_ocena_fizyka NUMBER;
          z_srednia_aryt NUMBER;
          z_srednia_geom NUMBER;
          z_srednia_harm NUMBER;
           Z_ID NUMBER;

         begin

        for i in 1..100 loop
                   SELECT nVL(mAX(ID), 0) + 1 into Z_ID FROM DZIENNIK_uCZNIOW;
          z_ocena_polski := Dbms_Random.Value(1, 5);
          z_ocena_mat := Dbms_Random.Value(1, 5);
          z_ocena_ang := Dbms_Random.Value(1, 5);
          z_ocena_inf := Dbms_Random.Value(1, 5);
          z_ocena_fizyka := Dbms_Random.Value(1, 5);


          z_srednia_aryt := ROUND(((z_ocena_polski + z_ocena_mat +z_ocena_ang+z_ocena_inf+z_ocena_fizyka)/5),2);
          z_srednia_geom := ROUND((power((z_ocena_polski * z_ocena_mat *z_ocena_ang*z_ocena_inf*z_ocena_fizyka), 1/5.0)),2);
          z_srednia_harm :=  ROUND((5/((1/z_ocena_polski)+(1/z_ocena_mat)+(1/z_ocena_ang)+(1/z_ocena_inf)+(1/z_ocena_fizyka))),2);
       INSERT INTO dziennik_uczniow (ID, imie, nazwisko, ocena_polski, ocena_mat, ocena_ang, ocena_inf, ocena_fizyka,srednia_arytmetyczna,srednia_geometryczna,srednia_harmoniczna)
        values(Z_ID, dbms_random.string('a', 8), dbms_random.string('a', 8),z_ocena_polski, z_ocena_mat, z_ocena_ang, z_ocena_inf, z_ocena_fizyka,z_srednia_aryt, z_srednia_geom,z_srednia_harm);
          end loop;
        commit;



        END;

            procedure dodaj_ucznia(p_imie varchar2, p_nazwisko varchar2, p_ocena_polski number,p_ocena_mat number, p_ocena_ang number, p_ocena_inf number, p_ocena_fizyka number)
       is

          z_srednia_aryt NUMBER;
          z_srednia_geom NUMBER;
          z_srednia_harm NUMBER;
          Z_ID NUMBER;
        begin

          SELECT nVL(mAX(ID), 0) + 1 into Z_ID FROM DZIENNIK_uCZNIOW;

          z_srednia_aryt := ROUND(((p_ocena_polski + p_ocena_mat +p_ocena_ang+p_ocena_inf+p_ocena_fizyka)/5),2);
          z_srednia_geom := ROUND((power((p_ocena_polski * p_ocena_mat *p_ocena_ang*p_ocena_inf*p_ocena_fizyka), 1/5.0)),2);
          z_srednia_harm :=  ROUND((5/((1/p_ocena_polski)+(1/p_ocena_mat)+(1/p_ocena_ang)+(1/p_ocena_inf)+(1/p_ocena_fizyka))),2);

          INSERT INTO dziennik_uczniow (ID, imie, nazwisko, ocena_polski, ocena_mat, ocena_ang, ocena_inf, ocena_fizyka,srednia_arytmetyczna,srednia_geometryczna,srednia_harmoniczna)
        values(Z_ID, p_imie, p_nazwisko,p_ocena_polski,p_ocena_mat,p_ocena_ang,p_ocena_inf,p_ocena_fizyka, z_srednia_aryt, z_srednia_geom,z_srednia_harm);

          end;

           procedure aktualizuj(p_id number)
                      is
                      z_srednia_aryt NUMBER;
          z_srednia_geom NUMBER;
          z_srednia_harm NUMBER;
                      begin

                         for c_du in (select * from dziennik_uczniow where id = p_id) LOOP
                            z_srednia_aryt := ROUND(((c_du.ocena_polski + c_du.ocena_mat +c_du.ocena_ang+c_du.ocena_inf+c_du.ocena_fizyka)/5),2);
                            z_srednia_geom := ROUND((power((c_du.ocena_polski * c_du.ocena_mat *c_du.ocena_ang*c_du.ocena_inf*c_du.ocena_fizyka), 1/5.0)),2);
                            z_srednia_harm :=  ROUND((5/((1/c_du.ocena_polski)+(1/c_du.ocena_mat)+(1/c_du.ocena_ang)+(1/c_du.ocena_inf)+(1/c_du.ocena_fizyka))),2);

                            update dziennik_uczniow set srednia_arytmetyczna = z_srednia_aryt,
                                                        srednia_geometryczna = z_srednia_geom,
                                                        srednia_harmoniczna = z_srednia_harm
                            where id = c_du.id;
                            end loop;

                      end;


                       FUNCTION DAJ_DANE_UCZNIOW(p_rodzaj_sredniej VARCHAR2, p_srednia_od NUMBER DEFAULT NULL, p_srednia_do NUMBER DEFAULT NULL) RETURN t_uczniowie pipelined


      is

       begin

           if p_rodzaj_sredniej = 'arytmetyczna' then

               for c_du IN (select * from dziennik_uczniow where srednia_arytmetyczna between Nvl(p_srednia_od, 0) and Nvl(p_srednia_do, 6)) loop

                  pipe row(c_du);

                end loop;
           elsif p_rodzaj_sredniej = 'geometryczna' then

               for c_du IN (select * from dziennik_uczniow where srednia_geometryczna between p_srednia_od and p_srednia_do) loop

                  pipe row(c_du);

                end loop;
            elsif p_rodzaj_sredniej = 'harmoniczna' then

               for c_du IN (select * from dziennik_uczniow where srednia_harmoniczna between p_srednia_od and p_srednia_do) loop

                  pipe row(c_du);

                end loop;

             end if;


       end;


end;
/

