# ProyectoDAW
Trabajo fin de curso del grado superior DAW

03/12/2022
Estructura basica de los html y carpetas donde se guardaran los ficheros del proyecto.

04/12/2022
Creada la base de datos(con posibles modificaciones) y importados los css de bootstrap y los js sweetAlert y el bundle de bootstrap.
Creadas las alertas de usuario a la hora de registrarlo(y a su vez, comprobar los datos a la hora de registrar un usuario).
El usuairo creado correctamente se guarda correctamente en la base de datos.
Primeras conexiones entre front end y backend usando js y php

06/12/2022
Desde index se puede controlar el acceso de usuario y creando variables de session en javaScript(Posiblemente lo cambie a php, segun vea el uso)
Una vez el usuario esta loggeado, no puede acceder a registro de nuevos usuarios.
Es posible salir de sesion y ya no es posible regresar a no ser que se introduzcan los datos nuevamente.

09/12/2022
Ahora es posible agregar imagen de perfil de usuario.
Se ha modificado la base de datos para añadir nuevos campos como "imagen de perfil usuario" y "privilage"
Todas las paginas son html, es posible que se cambiar a php para añadir funcionalidad y dinamismo.

16/12/2022
Los ficheros HTML ahora son php.
Se ha añadido nuevos metodos para comprobar la contraseña y la codificacion de esta.
Ahora se crean cookies en php y se eliminan al salir de sesion
Se ha modificado el css con nuevos fondos background y he cambiado el tipo de cursos para añadir algo mas fresco.

16/12/2022
Se ha creado un usuario default llamado "Guest" que permitira ver la web, pero no acceder a sus funcionalidades(aun en diseño)
Ahora las imagenes no se guardan como blob, si no como URL en forma de varchar en la base de datos.
Ahora las imagenes se recrean en una carpeta especial para cada usuario, en caso de no escoger una imagen de eprfil, se proporciona una default
Se han añadido nuevos metodos para acceder al "inicio.php"(posible nombre provisional).
Se han añadido nuevos metodos para crear a los usuarios, crear las imagenes de perfil y las carpetas individuales de cada usuario.
Se han corregido errores de seguridad.
Metodo en functions.inc.php que permite guardar palabras claves de sistema para evitar que se introduzca codigo sql en la base de datos y modificarla.


17/12/2022
Ahora es posible entrar en la seccion "mi perfil" en el que podras modificar datos de tu usuario.
Aun no existen mas opciones por ahora.
El usuario "guest" no podra acceder a dichas opciones, al pulsar para ver las opciones, solamente podra o iniciar sesion o crear cuenta o salir.
Cuando se loguea con el usuario guest, a la hora de escoger "Iniciar sesion", se borran las cookies y las sessions del usuario.
Se han creado 2 nuevas paginas, sobre sobre la info de la pagina y enlaces importantes y otra donde se muestran los datos del usuario logueado

25/12/2022
Se ha modificado la base de datos, ahora existen aparte de usuario "guest" existe el usuario "admin" y el usuario "user" corriente.
Con el usuario "admin" se puede accedery modificar la base de datos en temas relacionados a los usuarios, como la modificacion de estos.
Se han creado 4 ficheros nuevos, siendo estos la parte de la administracion de usuarios y un nuevo fichero en la carpeta "user" llamado "modify_user.php"
que se utilizara para modificar usuarios sin necesidad de estar logueados con esa cuenta.
Se ha mejorado la seguridad de acceso en la aplicaciones web(trabajo aun en curso)
Se ha creado una pagina donde se ve un crud de los usuarios en la base de datos al igual que otro para ver solamente usuarios bloqueados.
Codigo refactorizado para acceder de forma mas eficiente a funciones de la base de datos como funciones no relacionadas con esta.
Actualmente el proyecto se encuentra desornado debido al tamaño creciente de este, posiblemente se reordenen para que tengan mas sentido.
Eliminado bug que no permitia ver el nombre de usuario logueado cuando se modificaba este usuario.
