<?php
require_once 'clases.php';

$gestor = new GestorBiblioteca();
$recursos = $gestor->cargarRecursos();

// Obtener las acciones de los parámetros GET
$accion = $_GET['accion'] ?? '';
$id = $_GET['id'] ?? '';
$estado = $_GET['estado'] ?? '';
$tipo = $_GET['tipo'] ?? '';
$titulo = $_GET['titulo'] ?? '';
$autor = $_GET['autor'] ?? '';
$anioPublicacion = $_GET['anioPublicacion'] ?? '';
$estadoNuevo = $_GET['estadoNuevo'] ?? '';
$campoOrden = $_GET['campoOrden'] ?? 'id';
$direccionOrden = $_GET['direccionOrden'] ?? 'ASC';

// Estados legibles
$estadosLegibles = [
    'disponible' => 'DISPONIBLE',
    'prestado' => 'PRESTADO',
    'en_reparacion' => 'EN REPARACIÓN',
];

// Agregar o editar recurso
if ($accion === 'agregar' || $accion === 'editar') {
    $datos = [
        'id' => $id,
        'titulo' => $titulo,
        'autor' => $autor,
        'anioPublicacion' => $anioPublicacion,
        'estado' => $estado,
        'fechaAdquisicion' => date('Y-m-d'),
        'tipo' => $tipo,
    ];

    if ($tipo === 'Libro') {
        $datos['isbn'] = $_GET['isbn'] ?? '';
        $recurso = new Libro($datos);
    } elseif ($tipo === 'Revista') {
        $datos['numeroEdicion'] = $_GET['numeroEdicion'] ?? '';
        $recurso = new Revista($datos);
    } elseif ($tipo === 'DVD') {
        $datos['duracion'] = $_GET['duracion'] ?? '';
        $recurso = new DVD($datos);
    }

    if ($accion === 'agregar') {
        $gestor->agregarRecurso($recurso);
    } elseif ($accion === 'editar') {
        $gestor->actualizarRecurso($recurso);
    }

    // Redirigir para evitar reenvío de formularios
    header('Location: index.php');
    exit;
}

// Eliminar recurso
if ($accion === 'eliminar' && $id) {
    $gestor->eliminarRecurso($id);
    header('Location: index.php');
    exit;
}

// Cambiar estado de recurso
if ($accion === 'cambiar_estado' && $id && $estadoNuevo) {
    $gestor->actualizarEstadoRecurso($id, $estadoNuevo);
    header('Location: index.php');
    exit;
}

// Filtrar por estado
if ($estado) {
    $recursos = $gestor->buscarRecursosPorEstado($estado);
}

// Listar y ordenar
$recursos = $gestor->listarRecursos($estado, $campoOrden, $direccionOrden);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Biblioteca</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <h1>Gestión de Biblioteca</h1>

    <!-- Formulario de filtro y ordenación -->
    <form method="GET">
        <label for="estado">Filtrar por estado:</label>
        <select name="estado" id="estado">
            <option value="">Todos</option>
            <?php foreach ($estadosLegibles as $key => $label): ?>
                <option value="<?= $key ?>" <?= $estado == $key ? 'selected' : '' ?>><?= $label ?></option>
            <?php endforeach; ?>
        </select>

        <label for="campoOrden">Ordenar por:</label>
        <select name="campoOrden" id="campoOrden">
            <option value="id" <?= $campoOrden == 'id' ? 'selected' : '' ?>>ID</option>
            <option value="titulo" <?= $campoOrden == 'titulo' ? 'selected' : '' ?>>Título</option>
            <option value="autor" <?= $campoOrden == 'autor' ? 'selected' : '' ?>>Autor</option>
            <option value="anioPublicacion" <?= $campoOrden == 'anioPublicacion' ? 'selected' : '' ?>>Año</option>
        </select>

        <label for="direccionOrden">Dirección:</label>
        <select name="direccionOrden" id="direccionOrden">
            <option value="ASC" <?= $direccionOrden == 'ASC' ? 'selected' : '' ?>>Ascendente</option>
            <option value="DESC" <?= $direccionOrden == 'DESC' ? 'selected' : '' ?>>Descendente</option>
        </select>

        <button type="submit">Aplicar</button>
    </form>

    <!-- Tabla de recursos -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Año</th>
                <th>Estado</th>
                <th>Detalles de préstamo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recursos as $recurso): ?>
                <tr>
                    <td><?= $recurso->id ?></td>
                    <td><?= $recurso->titulo ?></td>
                    <td><?= $recurso->autor ?></td>
                    <td><?= $recurso->anioPublicacion ?></td>
                    <td><?= $estadosLegibles[$recurso->estado] ?? $recurso->estado ?></td>
                    <td><?= $recurso->obtenerDetallesPrestamo() ?></td>
                    <td>
                        <a href="index.php?accion=editar&id=<?= $recurso->id ?>">Editar</a>
                        <a href="index.php?accion=eliminar&id=<?= $recurso->id ?>" onclick="return confirm('¿Seguro que deseas eliminar este recurso?')">Eliminar</a>
                        <form method="GET" style="display:inline;">
                            <input type="hidden" name="accion" value="cambiar_estado">
                            <input type="hidden" name="id" value="<?= $recurso->id ?>">
                            <select name="estadoNuevo">
                                <option value="disponible">Disponible</option>
                                <option value="prestado">Prestado</option>
                                <option value="en_reparacion">En reparación</option>
                            </select>
                            <button type="submit">Cambiar estado</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Formulario para agregar/editar recursos -->
    <h2>Agregar/Editar Recurso</h2>
    <form method="GET">
        <input type="hidden" name="accion" value="<?= $accion === 'editar' ? 'editar' : 'agregar' ?>">
        <label for="id">ID:</label>
        <input type="text" name="id" id="id" value="<?= $id ?>" required>

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?= $titulo ?>" required>

        <label for="autor">Autor:</label>
        <input type="text" name="autor" id="autor" value="<?= $autor ?>" required>

        <label for="anioPublicacion">Año de Publicación:</label>
        <input type="number" name="anioPublicacion" id="anioPublicacion" value="<?= $anioPublicacion ?>" required>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado">
            <option value="disponible">Disponible</option>
            <option value="prestado">Prestado</option>
            <option value="en_reparacion">En reparación</option>
        </select>

        <label for="tipo">Tipo de Recurso:</label>
        <select name="tipo" id="tipo" onchange="mostrarCamposEspecificos()">
            <option value="Libro">Libro</option>
            <option value="Revista">Revista</option>
            <option value="DVD">DVD</option>
        </select>

        <!-- Campos específicos de cada tipo de recurso -->
        <div id="camposLibro" style="display:none;">
            <label for="isbn">ISBN:</label>
            <input type="text" name="isbn" id="isbn">
        </div>
        <div id="camposRevista" style="display:none;">
            <label for="numeroEdicion">Número de Edición:</label>
            <input type="number" name="numeroEdicion" id="numeroEdicion">
        </div>
        <div id="camposDVD" style="display:none;">
            <label for="duracion">Duración (minutos):</label>
            <input type="number" name="duracion" id="duracion">
        </div>

        <button type="submit"><?= $accion === 'editar' ? 'Actualizar' : 'Agregar' ?> Recurso</button>
    </form>

    <script>
        function mostrarCamposEspecificos() {
            var tipo = document.getElementById('tipo').value;
            document.getElementById('camposLibro').style.display = (tipo === 'Libro') ? 'block' : 'none';
            document.getElementById('camposRevista').style.display = (tipo === 'Revista') ? 'block' : 'none';
            document.getElementById('camposDVD').style.display = (tipo === 'DVD') ? 'block' : 'none';
        }
        mostrarCamposEspecificos(); 
    </script>
</body>
</html>
