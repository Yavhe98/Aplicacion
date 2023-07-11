
 NOTA: el comando Cacls est  obsoleto, use Icacls.

 Muestra o modifica listas de control de acceso (ACL) de archivos

 CACLS archivo [/T] [/M] [/L] [/S[:SDDL]] [/E] [/C] [/G usuario:perm]
               [/R usuario [...]] [/P usuario:perm [...]] [/D usuario [...]]

    archivo       Muestra las ACL.
    /T            Cambia las ACL de archivos especificados en
                  el directorio actual y todos los subdirectorios.
    /L            Trabaja en el propio v¡nculo simb¢lico en lugar del destino.
    /M            Cambia las ACL de los vol£menes montados en un directorio.
    /S            Muestra la cadena SDDL para la DACL.
    /S:SDDL       Reemplaza las ACL por las especificadas en la cadena SDDL
                  (no v lido con /E, /G, /R, /P ni /D).
    /E            Edita la ACL en vez de remplazarla.
    /C            Contin£a, omitiendo los errores de acceso denegado.
    /G usuario:perm  Concede derechos de acceso del usuario.
                  Perm puede ser: R  Leer
                                  W  Escribir
                                  C  Cambiar (escribir)
                                  F  Control total
    /R usuario    Revoca derechos del usuario (solo v lida con /E).
    /P usuario:perm  Reemplaza derechos de acceso del usuario.
                  Perm puede ser: N  Ninguno
                                  R  Leer
                                  W  Escribir
                                  C  Cambiar (escribir)
                                  F  Control total
    /D usuario    Deniega acceso al usuario especificado.

 Se pueden usar comodines para especificar m s de un archivo.
 Puede especificar m s de un usuario.

 Abreviaturas:
    CI - Herencia de contenedor.
         ACE se heredar  por directorios.
    OI - Herencia de objeto.
         ACE se heredar  por archivos.
    IO - Solo heredar.
         ACE no se aplica al archivo o directorio actual.
    ID - Heredado.
         ACE se hered¢ de la ACL del directorio principal.
