<?php
class Empleado {
    private $nombre;
    private $id;
    private $salarioBase;

    public function __construct($nombre, $id, $salarioBase) {
        $this->nombre = $nombre;
        $this->id = $id;
        $this->salarioBase = $salarioBase;
    }

    // Getters
    public function getNombre() {
        return $this->nombre;
    }

    public function getId() {
        return $this->id;
    }

    public function getSalarioBase() {
        return $this->salarioBase;
    }

    // Setters
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setSalarioBase($salarioBase) {
        $this->salarioBase = $salarioBase;
    }
}
?>
