<?php

// Ruta de la imagen de referencia
$imagenReferencia = './juja/-1.JPG';

// Ruta de la carpeta con las imágenes a comparar
$carpetaImagenes = './fotos/';

// Obteniendo la lista de archivos en la carpeta
$archivos = scandir($carpetaImagenes);

// Iterando sobre cada archivo
foreach ($archivos as $archivo) {
  // Comprobando si el archivo es una imagen
  $extension = pathinfo($archivo, PATHINFO_EXTENSION);
  if (in_array($extension, array('jpg'))) {
    // Cargando la imagen con GD
    $imagen = imagecreatefromjpeg($carpetaImagenes . $archivo);

    // Obteniendo la anchura y altura de la imagen
    $anchura = imagesx($imagen);
    $altura = imagesy($imagen);

    // Cargando la imagen de referencia con GD
    $imagenReferencia = imagecreatefromjpeg($imagenReferencia);

    // Obteniendo la anchura y altura de la imagen de referencia
    $anchuraReferencia = imagesx($imagenReferencia);
    $alturaReferencia = imagesy($imagenReferencia);

    // Verificando si las imágenes tienen el mismo tamaño
    if ($anchura == $anchuraReferencia && $altura == $alturaReferencia) {
      // Inicializando la variable que almacenará la diferencia de píxeles
      $diferencias = 0;

      // Iterando sobre cada píxel de las imágenes
      for ($x = 0; $x < $anchura; $x++) {
        for ($y = 0; $y < $altura; $y++) {
          // Obteniendo el valor RGB de cada píxel
          $rgb = imagecolorat($imagen, $x, $y);
          $rgbReferencia = imagecolorat($imagenReferencia, $x, $y);

          // Comparando los valores RGB de cada píxel
          if ($rgb != $rgbReferencia) {
            // Si los valores son diferentes, se incrementa el contador de diferencias
            $diferencias++;
          }
        }
      }

      // Verificando si las imágenes son iguales o no
      if ($diferencias == 0) {
        // Si las imágenes son iguales, se modifica la imagen por otra
        $nuevaImagen = './juja/0.jpg';
        imagejpeg($imagen, $nuevaImagen);
      } else {
        echo 'El archivo ' . $archivo . ' es diferente a la imagen de referencia.';
      }
    } else {
      echo 'El archivo ' . $archivo . ' tiene un tamaño diferente a la imagen de referencia.';
    }

    // Liberando la memoria utilizada por las imágenes
    imagedestroy($imagen);
    imagedestroy($imagenReferencia);
  }
}

?>