<?php

$entrada = __DIR__ . '/../reports/phpunit.xml';
$salida = __DIR__ . '/../reports/reporte-golazo.html';

if (!is_file($entrada)) {
    fwrite(STDERR, "No se encontró el reporte XML de PHPUnit.\n");
    exit(1);
}

libxml_use_internal_errors(true);
$xml = simplexml_load_file($entrada, 'SimpleXMLElement', LIBXML_NONET);

if ($xml === false) {
    fwrite(STDERR, "No se pudo leer el reporte XML.\n");
    exit(1);
}

function escapar($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

$casos = $xml->xpath('//testcase') ?: [];
$total = count($casos);
$fallos = 0;
$errores = 0;
$omitidas = 0;
$comprobaciones = 0;
$tiempo = 0;
$filas = '';

foreach ($casos as $caso) {
    $comprobaciones += (int) $caso['assertions'];
    $tiempo += (float) $caso['time'];

    $estado = 'APROBADA';
    $clase = 'aprobada';
    $detalle = '';

    if (isset($caso->failure)) {
        $fallos++;
        $estado = 'FALLIDA';
        $clase = 'fallida';
        $detalle = (string) $caso->failure;
    } elseif (isset($caso->error)) {
        $errores++;
        $estado = 'ERROR';
        $clase = 'fallida';
        $detalle = (string) $caso->error;
    } elseif (isset($caso->skipped)) {
        $omitidas++;
        $estado = 'OMITIDA';
        $clase = 'omitida';
    }

    $nombre = preg_replace('/^test_/', '', (string) $caso['name']);
    $nombre = ucfirst(str_replace('_', ' ', $nombre));

    $filas .= '<tr>';
    $filas .= '<td><strong>' . escapar($nombre) . '</strong>';
    $filas .= '<small>' . escapar($caso['class']) . '</small>';

    if ($detalle !== '') {
        $filas .= '<details><summary>Ver detalle</summary><pre>';
        $filas .= escapar($detalle) . '</pre></details>';
    }

    $filas .= '</td>';
    $filas .= '<td><span class="estado ' . $clase . '">';
    $filas .= $estado . '</span></td>';
    $filas .= '<td>' . (int) $caso['assertions'] . '</td>';
    $filas .= '<td>' . number_format((float) $caso['time'], 3) . ' s</td>';
    $filas .= '</tr>';
}

$aprobadas = $total - $fallos - $errores - $omitidas;
$porcentaje = $total > 0 ? round($aprobadas / $total * 100, 1) : 0;

$tituloEstado = $fallos + $errores > 0
    ? 'Hay resultados por revisar'
    : ($omitidas > 0
        ? 'Ejecución con pruebas omitidas'
        : ($total > 0 ? 'Todas las pruebas aprobadas' : 'Sin pruebas registradas'));

$tiempoTexto = number_format($tiempo, 3);
$fecha = gmdate('d/m/Y H:i') . ' UTC';
$commit = escapar(substr(getenv('GITHUB_SHA') ?: 'Local', 0, 7));
$ejecucion = escapar(getenv('GITHUB_RUN_NUMBER') ?: 'Local');

$html = <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>El Golazo | Reporte de pruebas</title>
<style>
:root {
    --fondo: #071b14;
    --panel: #102b21;
    --texto: #f1f8f3;
    --suave: #abc6b5;
    --verde: #b4f569;
    --borde: #294b39;
}
* { box-sizing: border-box; }
body {
    margin: 0;
    background: var(--fondo);
    color: var(--texto);
    font-family: "Segoe UI", Arial, sans-serif;
}
.contenedor { max-width: 1160px; margin: auto; padding: 36px 24px; }
.marca {
    display: flex; align-items: center; gap: 12px;
    font-size: 20px; font-weight: 800;
}
.escudo {
    display: grid; place-items: center;
    width: 46px; height: 50px;
    background: var(--verde); color: #092517;
    border-radius: 12px 12px 20px 20px; font-size: 26px;
}
.etiqueta {
    color: var(--verde); font-size: 12px;
    letter-spacing: 3px; font-weight: 700;
}
.hero {
    position: relative; overflow: hidden;
    margin-top: 28px; padding: 44px;
    border: 1px solid #406743; border-radius: 24px;
    background: repeating-linear-gradient(
        90deg, #174c31 0, #174c31 80px,
        #1b5637 80px, #1b5637 160px
    );
}
.cancha {
    position: absolute; right: -24px; top: 24px;
    width: 420px; height: 235px;
    border: 2px solid #ffffff35;
    border-radius: 4px; opacity: .7;
}
.cancha::before {
    content: ""; position: absolute;
    left: 50%; top: 0; height: 100%;
    border-left: 2px solid #ffffff35;
}
.cancha::after {
    content: ""; position: absolute;
    width: 100px; height: 100px; border-radius: 50%;
    border: 2px solid #ffffff35;
    left: calc(50% - 50px); top: calc(50% - 50px);
}
.hero-contenido { position: relative; z-index: 1; max-width: 650px; }
h1 { font-size: clamp(32px, 5vw, 52px); margin: 16px 0; letter-spacing: -2px; }
.hero p { color: #d3e8da; max-width: 530px; line-height: 1.6; }
.resultado {
    display: inline-block; margin-top: 12px;
    padding: 11px 17px; border-radius: 30px;
    background: #092b20; color: var(--verde);
    border: 1px solid #658e50; font-weight: 700;
}
.datos { display: flex; flex-wrap: wrap; gap: 20px; margin-top: 24px; color: #c4ddcc; font-size: 13px; }
.tarjetas { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin: 24px 0; }
.tarjeta { background: var(--panel); padding: 24px; border-radius: 18px; border: 1px solid var(--borde); }
.tarjeta span { color: var(--suave); font-size: 13px; }
.numero { font-size: 40px; font-weight: 800; margin-top: 10px; }
.verde { color: var(--verde); }
.panel { background: var(--panel); border: 1px solid var(--borde); border-radius: 20px; padding: 26px; margin-top: 20px; }
.cabecera { display: flex; justify-content: space-between; gap: 20px; align-items: center; }
h2 { font-size: 20px; margin: 0 0 8px; }
p { line-height: 1.6; }
.descripcion { color: var(--suave); font-size: 14px; margin: 0; }
.porcentaje { color: var(--verde); font-size: 34px; font-weight: 800; }
.barra { height: 10px; background: #071b14; border-radius: 20px; margin-top: 20px; overflow: hidden; }
.barra div { height: 100%; background: var(--verde); width: {$porcentaje}%; }
.tabla { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; margin-top: 22px; min-width: 650px; }
th { text-align: left; color: var(--suave); font-size: 12px; padding: 14px 12px; border-bottom: 1px solid var(--borde); }
td { padding: 19px 12px; border-bottom: 1px solid var(--borde); font-size: 14px; }
tr:last-child td { border-bottom: 0; }
small { display: block; margin-top: 7px; color: var(--suave); font-size: 12px; overflow-wrap: anywhere; }
.estado { display: inline-block; padding: 7px 11px; border-radius: 20px; font-size: 11px; font-weight: 800; }
.aprobada { color: #c4fa94; background: #28462c; }
.fallida { color: #ffc0b9; background: #58332f; }
.omitida { color: #ffe2a6; background: #51452b; }
details { margin-top: 12px; }
summary { cursor: pointer; color: #ffc0b9; }
pre { white-space: pre-wrap; overflow-wrap: anywhere; font-size: 12px; }
.nota { color: var(--suave); font-size: 13px; }
footer { padding: 26px 0 8px; color: var(--suave); text-align: center; font-size: 12px; }
button {
    background: var(--verde); color: #092517; border: 0;
    padding: 12px 18px; border-radius: 10px; font-weight: 800; cursor: pointer;
}
@media(max-width: 760px) {
    .tarjetas { grid-template-columns: repeat(2, 1fr); }
    .hero { padding: 28px; }
    .cancha { opacity: .25; }
    .cabecera { flex-wrap: wrap; }
}
@media print {
    body { background: white; color: black; }
    .hero, .panel, .tarjeta { background: white; color: black; border-color: #bbb; }
    .hero p, .datos, .descripcion, .nota, small, th, footer,
    .tarjeta span, .verde, .porcentaje, .etiqueta { color: #234d32; }
    .cancha, button { display: none; }
    .contenedor { padding: 0; }
    .tarjetas { break-inside: avoid; }
    tr { break-inside: avoid; }
}
</style>
</head>
<body>
<main class="contenedor">
    <div class="marca"><div class="escudo">⚽</div> EL GOLAZO</div>

    <section class="hero">
        <div class="cancha" aria-hidden="true"></div>
        <div class="hero-contenido">
            <div class="etiqueta">CALIDAD Y PRUEBAS DE SOFTWARE</div>
            <h1>La calidad también<br>se juega en equipo.</h1>
            <p>Reporte automatizado de pruebas del sistema web de reservas
            del Complejo Deportivo El Golazo.</p>
            <div class="resultado">{$tituloEstado}</div>
            <div class="datos">
                <span>Ejecución: #{$ejecucion}</span>
                <span>Commit: {$commit}</span>
                <span>Generado: {$fecha}</span>
            </div>
        </div>
    </section>

    <section class="tarjetas">
        <div class="tarjeta"><span>PRUEBAS EJECUTADAS</span><div class="numero">{$total}</div></div>
        <div class="tarjeta"><span>APROBADAS</span><div class="numero verde">{$aprobadas}</div></div>
        <div class="tarjeta"><span>FALLOS</span><div class="numero">{$fallos}</div></div>
        <div class="tarjeta"><span>COMPROBACIONES</span><div class="numero">{$comprobaciones}</div></div>
    </section>

    <section class="panel">
        <div class="cabecera">
            <div>
                <h2>Marcador de la ejecución</h2>
                <p class="descripcion">Porcentaje de pruebas aprobadas sobre el total registrado.</p>
            </div>
            <div class="porcentaje">{$porcentaje}%</div>
        </div>
        <div class="barra"><div></div></div>
        <p class="nota">Errores: {$errores} · Omitidas: {$omitidas} ·
        Suma de tiempos de los casos: {$tiempoTexto} s.
        Este porcentaje no representa cobertura de código.</p>
    </section>

    <section class="panel">
        <div class="cabecera">
            <div>
                <h2>Resultados por caso de prueba</h2>
                <p class="descripcion">Detalle obtenido del reporte XML de PHPUnit.</p>
            </div>
            <button onclick="window.print()">Imprimir / Guardar PDF</button>
        </div>
        <div class="tabla">
            <table>
                <thead><tr>
                    <th>CASO DE PRUEBA</th><th>RESULTADO</th>
                    <th>COMPROBACIONES</th><th>TIEMPO</th>
                </tr></thead>
                <tbody>{$filas}</tbody>
            </table>
        </div>
    </section>

    <footer>
        EL GOLAZO · Chincha · Reporte de integración continua · PHPUnit
    </footer>
</main>
</body>
</html>
HTML;

if (file_put_contents($salida, $html) === false) {
    fwrite(STDERR, "No se pudo guardar el reporte HTML.\n");
    exit(1);
}

echo "Reporte visual generado: reports/reporte-golazo.html\n";