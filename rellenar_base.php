
<?php
include_once 'php/inc/header.inc.php';
// Creamos un array con las frases de comentarios de cómics genéricos
$comentarios_comics = array(
    "¡Una trama emocionante llena de acción y suspenso!",
    "Este cómic tiene unos personajes muy bien desarrollados y complejos.",
    "¡El dibujo es impresionante y cada viñeta es una obra de arte!",
    "La historia es increíblemente original y sorprendente.",
    "¡Un cómic que te mantiene pegado a sus páginas de principio a fin!",
    "Los diálogos son ingeniosos y llenos de humor.",
    "La trama es inteligente y te hace pensar.",
    "Los giros argumentales son impresionantes y te mantienen en vilo.",
    "El villano es uno de los más temibles y fascinantes que he visto.",
    "Los personajes secundarios tienen una personalidad muy marcada y aportan mucho a la trama.",
    "¡Este cómic es una montaña rusa emocional que no te puedes perder!",
    "La acción es intensa y está dibujada de forma espectacular.",
    "La trama está llena de sorpresas y nunca sabes qué esperar.",
    "Los temas que trata el cómic son profundos y reflexivos.",
    "La ambientación y el mundo en el que se desarrolla la historia están muy bien construidos.",
    "La relación entre los personajes es muy interesante y da lugar a momentos emotivos y divertidos.",
    "La trama está muy bien estructurada y no hay un solo momento aburrido.",
    "La historia te engancha desde el primer momento y no puedes dejar de leer.",
    "El cómic está lleno de referencias y guiños a otros cómics y películas.",
    "La violencia y la acción están muy bien dosificadas y no se hacen pesadas.",
    "La trama tiene una gran profundidad y trata temas muy actuales y relevantes.",
    "El cómic es muy divertido y te hace reír en más de una ocasión.",
    "Los personajes son muy humanos y sus problemas y conflictos son muy realistas.",
    "El dibujo es espectacular y cada viñeta es una obra de arte en sí misma.",
    "La trama es sorprendente y no te deja tiempo para respirar.",
    "La acción es trepidante y está muy bien coreografiada.",
    "El villano es muy carismático y su presencia en la trama es impresionante.",
    "Los diálogos son ingeniosos y están llenos de referencias pop.",
    "La historia es muy original y no se parece a nada que hayas leído antes.",
    "Los personajes tienen una química increíble y su relación es muy interesante de seguir."
);

function insertar_opiniones_aleatorias($comentarios_comics) {
    global $conection;
    // Obtenemos el número total de cómics en la tabla "comic"
    $total_comics = $conection->query("SELECT COUNT(*) as total FROM comics")->fetchColumn();

    // Preparamos la consulta SQL para insertar una opinión aleatoria
    $stmt = $conection->prepare("INSERT INTO opiniones_comics (id_comic,id_usuario, opinion, puntuacion, fecha_comentario) VALUES (? ,?, ?, ?, ?)");

    // Recorremos todos los cómics en la tabla "comic" y les asignamos una opinión aleatoria
    for ($id_comic = 7377; $id_comic <= $total_comics; $id_comic++) {
        // Escogemos una opinión aleatoria de la lista de frases de comentarios de cómics
        $opinion = $comentarios_comics[array_rand($comentarios_comics)];

        // Generamos una puntuación aleatoria entre 1 y 5
        $puntuacion = rand(1, 5);

        // Generamos una fecha aleatoria dentro de los últimos 5 años
        $fecha_comentario = date('Y-m-d', strtotime('-'.rand(0, 1825).' days'));

        // Ejecutamos la consulta con los valores aleatorios generados y el ID del cómic actual
        $stmt->execute([$id_comic,16, $opinion, $puntuacion, $fecha_comentario]);
    }
}
insertar_opiniones_aleatorias($comentarios_comics);
