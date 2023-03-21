<?php
set_time_limit(3600);
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "webcomics";
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificación de conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para seleccionar todas las URLs de imagen
$sql = "SELECT IDcomic, Cover FROM comics";
$result = $conn->query($sql);

// Directorio donde se guardarán las imágenes descargadas
$dir = "./fotos";

// Loop para descargar cada imagen y guardarla en la carpeta especificada
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $id = $row["IDcomic"];
        $url = $row["Cover"];
        $filename = $dir . "/" . $id . ".jpg"; // Cambiar la extensión de la imagen según corresponda
        file_put_contents($filename, file_get_contents($url));
        echo "Imagen descargada: " . $filename . "<br>";
    }
} else {
    echo "No se encontraron resultados";
}

// Cierre de la conexión a la base de datos
$conn->close();

?>