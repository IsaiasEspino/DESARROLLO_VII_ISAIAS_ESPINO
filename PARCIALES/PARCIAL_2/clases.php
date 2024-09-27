<?php

// Interfaz Prestable
interface Prestable {
    public function obtenerDetallesPrestamo(): string;
}

// Clase abstracta RecursoBiblioteca que implementa la interfaz Prestable
abstract class RecursoBiblioteca implements Prestable {
    public $id;
    public $titulo;
    public $autor;
    public $anioPublicacion;
    public $estado;
    public $fechaAdquisicion;
    public $tipo;

    public function __construct($datos) {
        foreach ($datos as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Método abstracto que se implementará en las clases hijas
    abstract public function obtenerDetallesPrestamo(): string;
}

// Clase Libro que hereda de RecursoBiblioteca
class Libro extends RecursoBiblioteca {
    public $isbn;

    public function __construct($datos) {
        parent::__construct($datos);
        $this->isbn = $datos['isbn'] ?? null;
    }

    public function obtenerDetallesPrestamo(): string {
        return "Libro: {$this->titulo}, ISBN: {$this->isbn}, Estado: {$this->estado}";
    }
}

// Clase Revista que hereda de RecursoBiblioteca
class Revista extends RecursoBiblioteca {
    public $numeroEdicion;

    public function __construct($datos) {
        parent::__construct($datos);
        $this->numeroEdicion = $datos['numeroEdicion'] ?? null;
    }

    public function obtenerDetallesPrestamo(): string {
        return "Revista: {$this->titulo}, Edición No.: {$this->numeroEdicion}, Estado: {$this->estado}";
    }
}

// Clase DVD que hereda de RecursoBiblioteca
class DVD extends RecursoBiblioteca {
    public $duracion;

    public function __construct($datos) {
        parent::__construct($datos);
        $this->duracion = $datos['duracion'] ?? null;
    }

    public function obtenerDetallesPrestamo(): string {
        return "DVD: {$this->titulo}, Duración: {$this->duracion} minutos, Estado: {$this->estado}";
    }
}

// Clase GestorBiblioteca para gestionar los recursos
class GestorBiblioteca {
    private $recursos = [];

    public function cargarRecursos() {
        $json = file_get_contents('biblioteca.json');
        $data = json_decode($json, true);
        
        foreach ($data as $recursoData) {
            switch ($recursoData['tipo']) {
                case 'Libro':
                    $recurso = new Libro($recursoData);
                    break;
                case 'Revista':
                    $recurso = new Revista($recursoData);
                    break;
                case 'DVD':
                    $recurso = new DVD($recursoData);
                    break;
                default:
                    throw new Exception("Tipo de recurso no reconocido");
            }
            $this->recursos[] = $recurso;
        }
        
        return $this->recursos;
    }

    public function agregarRecurso(RecursoBiblioteca $recurso) {
        $this->recursos[] = $recurso;
    }

    public function eliminarRecurso($id) {
        $this->recursos = array_filter($this->recursos, function($recurso) use ($id) {
            return $recurso->id != $id;
        });
    }

    public function actualizarRecurso(RecursoBiblioteca $recurso) {
        foreach ($this->recursos as &$r) {
            if ($r->id == $recurso->id) {
                $r = $recurso;
                break;
            }
        }
    }

    public function actualizarEstadoRecurso($id, $nuevoEstado) {
        foreach ($this->recursos as &$recurso) {
            if ($recurso->id == $id) {
                $recurso->estado = $nuevoEstado;
                break;
            }
        }
    }

    public function buscarRecursosPorEstado($estado) {
        return array_filter($this->recursos, function($recurso) use ($estado) {
            return $recurso->estado === $estado;
        });
    }

    public function listarRecursos($filtroEstado = '', $campoOrden = 'id', $direccionOrden = 'ASC') {
        $recursosFiltrados = $filtroEstado ? $this->buscarRecursosPorEstado($filtroEstado) : $this->recursos;
        usort($recursosFiltrados, function($a, $b) use ($campoOrden, $direccionOrden) {
            if ($direccionOrden === 'ASC') {
                return $a->$campoOrden <=> $b->$campoOrden;
            } else {
                return $b->$campoOrden <=> $a->$campoOrden;
            }
        });
        return $recursosFiltrados;
    }
}

// Arreglo para mapear los estados a valores legibles
$estadosLegibles = [
    'disponible' => 'DISPONIBLE',
    'prestado' => 'PRESTADO',
    'en_reparacion' => 'EN REPARACIÓN'
];

?>
