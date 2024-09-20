<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

class Gerente extends Empleado implements Evaluable {
    private $departamento;
    private $bono;

    public function __construct($nombre, $id, $salarioBase, $departamento) {
        parent::__construct($nombre, $id, $salarioBase);
        $this->departamento = $departamento;
        $this->bono = 0;
    }

    // Métodos únicos
    public function asignarBono($bono) {
        $this->bono = $bono;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    // Método de la interfaz Evaluable
    public function evaluarDesempenio() {
        // Lógica para evaluar el desempeño del gerente
        return "Evaluación del desempeño del gerente " . $this->getNombre();
    }
}
?>
