<?php

abstract class Entrada {
    public $id;
    public $fecha_creacion;

    public function __construct($id, $fecha_creacion) {
        $this->id = $id;
        $this->fecha_creacion = $fecha_creacion;
    }

    abstract public function mostrar();
}


class EntradaUnaColumna extends Entrada {
    public $titulo;
    public $descripcion;

    public function __construct($id, $fecha_creacion, $titulo, $descripcion) {
        parent::__construct($id, $fecha_creacion);
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
    }

    public function mostrar() {
        return "<h2>{$this->titulo}</h2><p>{$this->descripcion}</p><small>Fecha: {$this->fecha_creacion}</small>";
    }
}


class EntradaDosColumnas extends Entrada {
    public $titulo1;
    public $descripcion1;
    public $titulo2;
    public $descripcion2;

    public function __construct($id, $fecha_creacion, $titulo1, $descripcion1, $titulo2, $descripcion2) {
        parent::__construct($id, $fecha_creacion);
        $this->titulo1 = $titulo1;
        $this->descripcion1 = $descripcion1;
        $this->titulo2 = $titulo2;
        $this->descripcion2 = $descripcion2;
    }

    public function mostrar() {
        return "
        <div style='display: flex;'>
            <div style='flex: 1;'>
                <h2>{$this->titulo1}</h2>
                <p>{$this->descripcion1}</p>
            </div>
            <div style='flex: 1;'>
                <h2>{$this->titulo2}</h2>
                <p>{$this->descripcion2}</p>
            </div>
        </div>
        <small>Fecha: {$this->fecha_creacion}</small>";
    }
}


class EntradaTresColumnas extends Entrada {
    public $titulo1;
    public $descripcion1;
    public $titulo2;
    public $descripcion2;
    public $titulo3;
    public $descripcion3;

    public function __construct($id, $fecha_creacion, $titulo1, $descripcion1, $titulo2, $descripcion2, $titulo3, $descripcion3) {
        parent::__construct($id, $fecha_creacion);
        $this->titulo1 = $titulo1;
        $this->descripcion1 = $descripcion1;
        $this->titulo2 = $titulo2;
        $this->descripcion2 = $descripcion2;
        $this->titulo3 = $titulo3;
        $this->descripcion3 = $descripcion3;
    }

    public function mostrar() {
        return "
        <div style='display: flex;'>
            <div style='flex: 1;'>
                <h2>{$this->titulo1}</h2>
                <p>{$this->descripcion1}</p>
            </div>
            <div style='flex: 1;'>
                <h2>{$this->titulo2}</h2>
                <p>{$this->descripcion2}</p>
            </div>
            <div style='flex: 1;'>
                <h2>{$this->titulo3}</h2>
                <p>{$this->descripcion3}</p>
            </div>
        </div>
        <small>Fecha: {$this->fecha_creacion}</small>";
    }
}


class GestorBlog {
    public $entradas = [];


    public function agregarEntrada(Entrada $entrada) {
        $entrada->id = count($this->entradas) + 1;
        $this->entradas[] = $entrada;
    }

    public function editarEntrada($id, Entrada $entradaEditada) {
        foreach ($this->entradas as &$entrada) {
            if ($entrada->id == $id) {
                $entrada = $entradaEditada;
                break;
            }
        }
    }


    public function eliminarEntrada($id) {
        foreach ($this->entradas as $index => $entrada) {
            if ($entrada->id == $id) {
                unset($this->entradas[$index]);

                $this->entradas = array_values($this->entradas);
                break;
            }
        }
    }


    public function moverEntrada($id, $direccion) {
        $index = array_search($this->obtenerEntrada($id), $this->entradas);
        if ($index !== false) {
            if ($direccion == 'up' && $index > 0) {
                $this->swap($index, $index - 1);
            } elseif ($direccion == 'down' && $index < count($this->entradas) - 1) {
                $this->swap($index, $index + 1);
            }
        }
    }


    public function obtenerEntrada($id) {
        foreach ($this->entradas as $entrada) {
            if ($entrada->id == $id) {
                return $entrada;
            }
        }
        return null;
    }


    private function swap($index1, $index2) {
        $temp = $this->entradas[$index1];
        $this->entradas[$index1] = $this->entradas[$index2];
        $this->entradas[$index2] = $temp;
    }
}
