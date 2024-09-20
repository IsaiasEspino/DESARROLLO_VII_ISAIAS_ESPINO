<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

class Desarrollador extends Empleado implements Evaluable {
    private $lenguajePrincipal;
    private $nivelExperiencia;

    public function __construct($nombre, $id, $salarioBase, $lenguajePrincipal, $nivelExperiencia) {
        parent::__construct($nombre, $id, $salarioBase);
        $this->lenguajePrincipal = $lenguajePrincipal;
        $this->nivelExperiencia = $nivelExperiencia;
    }

    // Métodos únicos
    public function getLenguajePrincipal() {
        return $this->lenguajePrincipal;
    }

    public function getNivelExperiencia() {
        return $this->nivelExperiencia;
    }

    // Método de la interfaz Evaluable
    public function evaluarDesempenio() {
        // Lógica para evaluar el desempeño del desarrollador
        return "Evaluación del desempeño del desarrollador " . $this->getNombre();
    }
}
?>
