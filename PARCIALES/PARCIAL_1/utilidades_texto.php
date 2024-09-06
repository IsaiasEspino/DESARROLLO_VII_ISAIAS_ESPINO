<?php
function contar_palabras($texto) {
    return str_word_count($texto);
}

function contar_vocales($texto) {
    $texto = strtolower($texto);
    $vocales = ['a', 'e', 'i', 'o', 'u'];
    $contador = 0;
    for ($i = 0; $i < strlen($texto); $i++) {
        if (in_array($texto[$i], $vocales)) {
            $contador++;
        }
    }
    return $contador;
}

function invertir_palabras($texto) {
    $palabras = explode(' ', $texto);
    $palabras_invertidas = array_reverse($palabras);
    return implode(' ', $palabras_invertidas);
}
?>
