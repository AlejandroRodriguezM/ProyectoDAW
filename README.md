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
Se ha creado una nueva pagina llamada "admin_info_usuario.php" donde se podra ver la informacion de usuarios y se ha enlazado junto con la de "admin_actualizar_usuario.php"
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

27/12/2022 Log 4
Se ha modificado los ficheros de actualizar_usuario.php y "modify_user.php" para que no acepten el cambio si el nuevo nombre de usuario ya existe
Se ha arreglado bug a la hora de modificar nombre de usuario desde poanel administrador como de usuario nornal.

27/12/2022 Log 5
Se arreglado bug en el que no se podia actualizar datos de usuario si el campo "sobre mi" esta vacio.

27/12/2022 Log 6
Agregado en la base de datos de aboutuser, un nombre y apellidos del usuario, se pueden modificar desde panel de usuario normal o desde administrador, pueden estar vacios.

30/12/2022 Log 1
Se ha modificado el index para que solamente se necesite 1 contraseña para entrar.
Se ha modificado el svg para que este fijo en la pantalla para evitar errores en otro tipo de resoluciones en otras pantallas

31/12/2022 Log 1
Se ha modificado tanto el navbar donde anteriormente ponia "webComics" a un svg de bootstrap
Se ha modificado la barra de busqueda para que aparezca contenido hasta pincharla(posiblemente se cambie para mejorar la busqueda personalizada)
Primeros pasos en la busqueda de datos mediante in input text, por ahora solamente busca usuarios mediante nombre u email
Feliz año nuevo, por un 2023 lleno de metas cumplidas.

02/01/2023 Log 1
Se ha arreglado el buscador, pero no funciona correctamente. Solo guarda el ultimo dato del row.
Se han creado varias funciones para buscar y mostrar datos usando ajax en javascript.
Hay 2 ficheros en carpeta user, uno con terminacion test, que se usa para probar una funcion que solo toma datos, no la tabla completa.
Ahora es posible loggearse usando el email o el nombre de usuario.

02/01/2023 Log 2
Ya funciona la busqueda de usuarios mediante search.

03/01/2023 Log 1
Ahora el boton de busqueda despliega un fieldset con un buscador y 3 spans, que segun cual pulses, se mostrara una cosa u otra.
Queda el autocompletado.

06/01/2023 Log 1
Modificado ficheros en appLogin, para dejar de usar el fichero appCRUD.
Cambiado style de span, ya que daba error en otros ficheros.

06/01/2023 Log 2
Se ha cambiado el nombre de la funcion para cargar los span, de forma que se encuentra en "onload" en body.
Arreglado bug visual que no permitia mostrar el nombre del usuario logueado en la pantalla inicio.php

10/01/2023 Log 1
Se ha modificado la base de datos, ahora existen 2 tablas nuevas relacionadas con el envio de tickets entre usuario y administrador
Se ha modificado los ficheros javascript para tener el bootstrap de la version 5.2.3
Se ha modificado los estilos para adaprtarlo a los nuevos bootrap
Se ha añadido en inicio el css de bootstrap 5.2.3 pero no funciona correctamente por tener 2 ficheros de bootstrapp css extra(hay que solucionarlo)
Ahora inicio, infoPerfil y modificar.php permiten realizar las busquedas de usuarios.

14/01/2023 Log 1
Se ha modificado el login, para que de igual el tamaño de la contraseña, saltaba error.

02/02/2023 Log 1
Modificado todo el proyecto a bootstrap 5.2.3
Arreglado bugs visuales

02/02/2023 Log 2
Arreglada la seccion modal a la hora de tener tanto para la imagen como para el formulario de los tickets
Implementada la funcion para crear tickets
Creadas 2 nuevas paginas, segun sin eres usuario o administrador(Aun estan en creacion, no funcional)
Arreglado bugs visuales respecto al cambio de bootstrap a 5.2.3

03/02/2023 Log 1
Funcionalidad tickets medio funcional en admins

04/02/2023 Log 1
Funcionalidad de tickets terminada, ya es funcional
Cambios en los stylos de todos los ficheros para acomodarlos al bootstrap 5.2.3

04/02/2023 Log 2
Nuevo stylo para la bandeja de los tickets
Arreglado un bug en usuarios bloqueados que despues de desbloquear o editar se iba a la info del usuario

05/02/2023 Log 1
Incluida la base de datos con comics y las imagenes de portadas
La busqueda la funciona, queda funcionalidad para infoComics.php
database actualizada

05/02/2023 Log 2
Arreglado bug de clicks en el boton + bajo la lista de comics
Ahora ya existe pag de info de comics selecionado

05/02/2023 Log 3
Añadido un fotter en cada pagina al igual que solucionado un par de bugs de css
En la pagina inicial.php no se visualiza bien la imagen de perfil(queda por arreglar)
La pagina novedades.php muestra todos los comics pero no es capaz de dividir en filas de 10. posiblemente por el css

06/02/2023 Log 1
Novedades.php mejorada, ya muestra en filas de 10 comics cada uno
Se ha añadido barra  menu lateral con 3 desplegables
Solo funcionalidad estatica.

07/02/2023 Log 1
ya funciona el "mostrar mas" en novedades, donde solamente se muestran 30 interaciones cada vez que se pulsa el boton.
Arreglado un bug con la busquieda mediante input search
Ahora la barra lateral de menu con 3 desplegables funciona correctamente, pero no agrupa datos segun checkbox, suma las busquedas(queda pulir esta parte)
Arreglado en tiempo de carga a la base de datos

08/02/2023 Log 1
Ahora en la pagina novedades.php en la seccion de busqueda del menu lateral, se ha incluido un input text para hacer una busqueda autocompletada
Se ha añadido nuevos elementos decorativos en la pagina inicio(se encuentra de forma estatica la parte de comentarios, ya se trabajara para que se vuelva dinamica)
Se ha añadido nuevos videos de muestra en la pagina inicio, que seran sustituidos por videos que vayan con el tema de la web
Se ha añadido nuevos videos en about.php
Se ha mejorado la velocidad en general de la pagina con la refactorizacion de metodos de busqueda en base de datos
Se ha añadido un carousel con baners de paginas de interes.

08/02/2023 Log 2
Arreglado el permiso de usuarios y arreglado bugs visuales

08/02/2023 Log 3
Areglado bug de selecionar comic

10/02/2023 Log 3
Mejorada la funcionalidad de busqueda de comics.
Eliminado boton de "mostrar mas" ahora solamente lo hace con scrolleo del raton.
Arreglado bugs a la hora de mostrar con checkbox, ya no se repiten resultados.
Creado nuevo css para añadir parallax a la pagina de inicio(en pruebas)
Añadido nuevo boton en inicio en "Recomendaciones" que lleva a novedades.php
Ahora a selecionar un comic con el boton class ".add", se puede ver por consola su id_comic, se usara para mas adelante guardar dicho comic en la tabla de lista mysql

13/02/2023 Log 1
Nueva API llamada nueva_opinion.php para guardar datos de los comentarios sobre cada comic
Creado un nuevo fichero llamado comentarios.php donde se muestras los comentarios de cada comics de forma individual en infoComics.php
Nuevas hojas de estilo para hacer responsive el index para telefono y tablet
Nueva hoja de estilo para añadir comentarios
añadido la posibilidad de añadir comentarios a comics para puntuar el mismo de forma individual desde infoComics.php
Se muestran los comentarios de diferentes usuarios en infoComics.php segun el comic
Creadas 2 nuevas tablas en la base de datos para almacenar los comentarios de un comic en concreto y sobre la pagina en general(en proceso)

13/02/2023 Log 2
Cambios en parallax, en pruebas

13/02/2023 Log 3
Cambios en parallax arreglados y funcional, quizas se cambie mas adelante.
Se ha añadido la funcion de la pestaña "Mi coleccion" en el fichero mi_coleccion.php
Se han creado 2 ficheros nuevos relacionados a mi_coleccion.php:
 - mis_comics.php
 - listas_lectura.php
Para poder ver correctamente mis_comics.php, se ha creado otra API llamada comics_user.php, donde solamente se mostraran aquellos comics que tenga el usuario guardados en
la base de datos.
Se han creado mas de 10 funciones nuevas para contrololar todo lo relacionado a lo mencionado anteriormente.
Se ha modificado la base de datos y se han añadido 2 tablas nuevas.
Ahora se pueden guardar comics pulsando en el boton bajo la portada y desde infoComics.php se ha añadido un boton para añadir ese comic en concreto
Cuando un comic es guardado se mostrara de forma normal ya pulsado, si se vuelve a pulsar se eliminara de la base de datos.

24/02/2023 Log 1
Uso de la api de marvel para tener mas de 6000 comics nuevos y descripciones

24/02/2023 Log 2
Modificados ficheros php para poder visualizar correctamente los datos de la base de datos y modificacion de varios estilos.

25/02/2023 Log 1
Modificados las funciones javascript a la hora de seleccionar mediante checkbox diferentes datos para hacer una busqueda mas personalizada en novedades.php
Se han creado varias funciones nuevas referente a las listas de comics personalizadas y a la busqueda de datos en estas
Se han incorporado las funcionalidades de ver el contenido de las listas personalizadas,(aun queda por añadir la funcionalidad para agregar comics en estas.)

27/02/2023 Log 1
Se han factorizado varios scripts referentes a guardar un comic con nuestro usuario
Se ha añadido la funcionalidad de guardar o quitar comics de nuestras listas personalizadas
Se han mejorado los terminos de busqueda, ahora cada paramentro tiene su propio href para buscar de forma independiente datos
Se ha añadido varios ficheros nuevos php que sirven para mostrar comcis de una lista de lectura unicada y de los comics guardados en esta y los posibles que se puedan guardar
Se han creado nuevas funciones js para guardar y quitar comics de dichas listas
Se ha mejorado la base de datos, ahora alberga mas de 15000 entradas en la tabla "comics" y "descripcion_comics"
Se han eliminado bugs respecto a la hora de realizar busquedas

20/03/2023 Log 1
Se han cambiado la barra de busqueda, ahora esta en el navbar principar sin muestras de posibles busquedas relacionadas.
Se ha aplicado el parallax a diferentes paginas, aun falta por terminar.
Se ha mejorado la muestra de comics u usuarios en la busqueda, ahora solamente muestran de 5 en 5 los comics, y a medida que se scrollea la pagina aparecen mas.
Se han modificado diferentes funciones para la busqueda de comics.
Se ha creado una nueva api para mostrar los comics en la busqueda.
Se han modificado estilos css para que sean mas acordes a la pagina y mejoren su visibilidad.
Se han arreglado diferentes bugs que no permitian guardar comics en diferentes paginas

21/03/2023 Log 1
Se ha modificado la base de datos, se han descargado todas las portadas y ahora estan en local, las imagenes en red siguen guardadas como copia de seguridad
Añadida funcionalidad para poder editar o eliminar lista de lectura.
Se ha limitado el acceso y control de usuario al usuario guest.
Se han creado 2 nuevas apis para la eliminacion de listas o modificacion de estas.

21/03/2023 Log 2
Se ha mejorado la seguridad a la hora de usar la base de datos.
Se ha añadido funcionalidad para eliminar usuario de forma correcta
Ahora si el usuario invitado hace uso de la alguna funcion de usuario logueado, le aparecera un error
Se ha creado nueva api para eliminar usuarios
Se ha mejorado varios aspectos de diferentes ficheros css
La base de datos ha vuelto al log del 20/03/2023 Log 1 por errores a la hora de subir a github y por el gran peso que suponian las imagenes 

22/03/2023 Log 1
Se han creado 2 nuevas apis, para poder bloquear usuarios y para poder hacer que un usuario sea inactivo.
Se ha mejorado la velocidad de carga de datos de los comics que tienes guardados.
Ahora es posible escribir comentarios sobre la pagina de forma dinamica, ya no es estatica.
A la hora de buscar un usuario ahora podemos ver el numero de comics que tiene guardado y cuantas listas de lecturas tiene(Se mejorara para poder ver dichas listas o comics)
Se ha añadido parallax a mas paginas.
Ahora el fichero llamado index.php, se llama login.php(index.php sera la landing page que aun no esta creada)

24/03/2023 Log 1
Se han creado 7 nuevas apis, para controlar la amistad con otro usuario:
 - Para agregar como amigo
 - Para dejar de ser amigo
 - Para enviar peticion de amistad
 - Para cancelar peticion de amistad
 - Para bloquear un usuario
 - Para desbloquear un usuario
 - Cambiar la privacidad de una cuenta
Se han mejorado los estilos de todas las paginas del proyecto
Se han añadido nuevas pestañas en la zona "mi perfil" para ver las solicitudes de amistad, ver los amigos que tienes y ver las solicitudes que has mandado
Ahora es posible mandar solicitud de amistad a otros usuarios, al igual que poder bloquearlos, rechazar invitacion o cancelar solicitud de amistad
Se han arreglado varios bugs que no permitian ver ciertos datos siendo administrador
Se han añadido nuevas tablas a la base de datos
Se han añadido alrededor de 15 funciones nuevas para el uso de las apis

03/04/2023 Log 1
Se han creado nuevas apis, para controlar el bloqueo de un usuario a la pagina
Se ha limpiado el codigo en funciones_dataBase.inc.php
Se ha añadido ampliamente la seguridad y la posible inyeccion de codigo a la base de datos en el fichero mencionado anteriormente
Se han eliminado funciones que no tenian ningun uso
Se han cambiado el nombre de funciones
Se ha creado una nueva columna en aboutuser para que registre la ultima hora de conexion de un usuario
Se ha mejorado varios bugs que raltentizaban la pagina a la hora de buscar comics con mas de 1 palabra