<?php
include 'utilidades_texto.php';

$frases = [
    "Esta es la primera frase.",
    "Esta es la segunda frase.",
    "Esta es la tercera frase."
];

echo '<table border="1">';
echo '<tr><th>Frase</th><th>Número de Palabras</th><th>Número de Vocales</th><th>Frase con Palabras Invertidas</th></tr>';

foreach ($frases as $frase) {
    $num_palabras = contar_palabras($frase);
    $num_vocales = contar_vocales($frase);
    $frase_invertida = invertir_palabras($frase);

    echo '<tr>';
    echo '<td>' . htmlspecialchars($frase) . '</td>';
    echo '<td>' . htmlspecialchars($num_palabras) . '</td>';
    echo '<td>' . htmlspecialchars($num_vocales) . '</td>';
    echo '<td>' . htmlspecialchars($frase_invertida) . '</td>';
    echo '</tr>';
}

echo '</table>';
?>
