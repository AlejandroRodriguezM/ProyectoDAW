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

16/12/2022 Log 1
Los ficheros HTML ahora son php.
Se ha añadido nuevos metodos para comprobar la contraseña y la codificacion de esta.
Ahora se crean cookies en php y se eliminan al salir de sesion
Se ha modificado el css con nuevos fondos background y he cambiado el tipo de cursos para añadir algo mas fresco.

16/12/2022 Log 2
Se ha creado un usuario default llamado "Guest" que permitira ver la web, pero no acceder a sus funcionalidades(aun en diseño)
Ahora las imagenes no se guardan como blob, si no como URL en forma de varchar en la base de datos.
Ahora las imagenes se recrean en una carpeta especial para cada usuario, en caso de no escoger una imagen de eprfil, se proporciona una default
Se han añadido nuevos metodos para acceder al "inicio.php"(posible nombre provisional).
Se han añadido nuevos metodos para crear a los usuarios, crear las imagenes de perfil y las carpetas individuales de cada usuario.
Se han corregido errores de seguridad.
Metodo en functions.inc.php que permite guardar palabras claves de sistema para evitar que se introduzca codigo sql en la base de datos y modificarla.

17/12/2022 Log 1
Ahora es posible entrar en la seccion "mi perfil" en el que podras modificar datos de tu usuario.
Aun no existen mas opciones por ahora.
El usuario "guest" no podra acceder a dichas opciones, al pulsar para ver las opciones, solamente podra o iniciar sesion o crear cuenta o salir.
Cuando se loguea con el usuario guest, a la hora de escoger "Iniciar sesion", se borran las cookies y las sessions del usuario.
Se han creado 2 nuevas paginas, sobre sobre la info de la pagina y enlaces importantes y otra donde se muestran los datos del usuario logueado

25/12/2022 Log 1
Se ha modificado la base de datos, ahora existen aparte de usuario "guest" existe el usuario "admin" y el usuario "user" corriente.
Con el usuario "admin" se puede accedery modificar la base de datos en temas relacionados a los usuarios, como la modificacion de estos.
Se han creado 4 ficheros nuevos, siendo estos la parte de la administracion de usuarios y un nuevo fichero en la carpeta "user" llamado "modify_user.php"
que se utilizara para modificar usuarios sin necesidad de estar logueados con esa cuenta.
Se ha mejorado la seguridad de acceso en la aplicaciones web(trabajo aun en curso)
Se ha creado una pagina donde se ve un crud de los usuarios en la base de datos al igual que otro para ver solamente usuarios bloqueados.
Codigo refactorizado para acceder de forma mas eficiente a funciones de la base de datos como funciones no relacionadas con esta.
Actualmente el proyecto se encuentra desornado debido al tamaño creciente de este, posiblemente se reordenen para que tengan mas sentido.
Eliminado bug que no permitia ver el nombre de usuario logueado cuando se modificaba este usuario.

25/12/2022 Log 2
Se ha añadido la funcionalidad de eliminar usuarios de privilegio "user" y "block"

25/12/2022 Log 1
Se ha añadido un model para aceptar cookies cuando es la primera vez que se visita la pagina
Ahora al pinchar la imagen de perfil, se mostrara en un model la imagen de perfil
Al modificar un perfil siendo administrador o modificar tuy perfil como user normal, podras pinchar tambien en la "imagen predeterminada" para esocger la imagen de perfil(Quizas quite esta funcionalidad)
Se ha añadido un condiciones y servicios que se deben de aceptar si se quiere registrar un usuario, utilizando un "model"

26/12/2022 Log 1
Añadida nuevas funciones para crear cookies de tipo "guest" (funciones sin uso debido a bugs)
Ahora las contraseñas pueden verse mediante un icono tipo "ojo" (solo funciona con una contraseña y no con varias en un mismo form)

26/12/2022 Log 2
Arreglado bug que no permitia mostrar correctamente datos cuando se modificaba el administrador desde el panel de admninistracion

26/12/2022 Log 3
Arreglado bug que no permitia cambiar de imagen de perfil desde perfil de usuario.
Se ha modificado las imagenes del crud de usuarios, para que al pulsarla nos lleve a su pagina de informacion
Cuando se accede a la pagina de informacion del usuario, solamente se podra modificar si es "admin" o "user" pero nunca guest.
Se ha creado una nueva pagina llamada "adminInfoUser.php" donde se podra ver la informacion de usuarios y se ha enlazado junto con la de "actualizandoUser.php"
Se ha arreglado un bug que no permitia mostrar datos esenciales como session o cookies cuando se modificaba un usuario administrador que este activo a la hora de realizar el cambio.
Se han arreglado errores de direccion de diferentes ficheros ya que se cambiaron nombres de las paginas.

27/12/2022 Log 1
Arreglado bug a la hora de guardar foto de perfil en la que no se seleccionaba ninguna nueva imagen desde modificar usuario normal
Arreglado bug a la hora de guardar foto de perfil en la que no se seleccionaba ninguna nueva imagen desde modificar usuario admin a si mismo u otros usuarios
Ahora cuando se modifique el perfil de un usuario, los datos basicos vienen ya cargados

27/12/2022 Log 2
Creada una nueva tabla en la base de datos llamada "aboutuser" donde se van guardando datos relativos al usuario como fecha de creacion del usuario, o una descripcion sobre ellos mismos
Creado nuevos metodos para almacenar datos de la cuenta desde modificacion y desde la misma creacion del usuario
Cuando se elimina un usuario ahora se borran todos los datos del resto de tablas referente a esa ID
El usaurio guest no mostrara datos sobre su usuario

27/12/2022 Log 3
Ahora el nombre de usuario es una clave primaria y no se puede repetir
La base de datos ha sido actualizada (Voz de avast antivirus)