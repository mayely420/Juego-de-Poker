<?php
 // Repartir cartas
function repartirCartas() {

    $palos = array("Corazones", "Diamantes", "Picas", "Tréboles");
    $cartas = array("As", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K");
    $mazo = array();
    // Crear mazo de cartas
    foreach ($palos as $palo) {
        foreach ($cartas as $carta) {
            $mazo[] = $carta . " de " . $palo;
        }
    }
    // Mezclar mazo
    shuffle($mazo);
    
    // Repartir 5 cartas
    return array_slice($mazo, 0, 5);
}
function mostrarCartas($mazo) {
    foreach ($mazo as $carta) {
        echo $carta . "\n";
    }
}
function evaluarMano($mazo) {
    $valores = [];
    $palos = [];
    
    // Separar valores y palos
    foreach ($mazo as $carta) {
        list($valor, $palo) = explode(" de ", $carta);
        $valores[] = $valor;
        $palos[] = $palo;
    }
    $conteoValores = array_count_values($valores);
    $conteoPalos = array_count_values($palos);

    //  combinaciones
    if (esEscaleraReal($valores, $conteoPalos)) {
        echo "Resultado: Escalera Real\n";
    } elseif (esPoker($conteoValores)) {
        echo "Resultado: Póker\n";
    } elseif (esTrio($conteoValores)) {
        echo "Resultado: Trío\n";
    } elseif (esPar($conteoValores)) {
        echo "Resultado: Par\n";
    } else {
        echo "Resultado: Carta Alta\n";
    }
}
function esEscaleraReal($valores, $conteoPalos) {
    $valoresOrdenados = ["10", "Jota", "Reina", "Rey", "As"];
    sort($valores);
    return (array_values($conteoPalos)[0] == 5 && $valores == $valoresOrdenados);
    }

function esPoker($conteoValores) {
    return max($conteoValores) == 4;
}
function esTrio ($conteoValores) {
    return max($conteoValores) == 3;
}
function esPar($conteoValores) {
    return max($conteoValores) == 2;
}

$mazo_1 = repartirCartas();
echo "Cartas repartidas:\n";
mostrarCartas($mazo_1);

// Preguntar al jugador si desea descartar cartas
$descartar = readline("¿Desea descartar cartas? (si/no): ");
if ($descartar == 'si') {
    $cartasDescartadas = array();
    foreach ($mazo_1 as $i => $carta) {
        $descartarCarta = readline("¿Descartar carta " . ($i + 1) . "? (si/no): ");
        if ($descartarCarta == 'si') {
            $cartasDescartadas[] = $carta;
            unset($mazo_1[$i]);
        }
    }
    
    $cartasReemplazadas = repartirCartas();
    $mazo_1 = array_merge($mazo_1, array_slice($cartasReemplazadas, 0, count($cartasDescartadas)));
    echo "Cartas reemplazadas:\n";
    mostrarCartas($mazo_1);
}
evaluarMano($mazo_1);

?>
