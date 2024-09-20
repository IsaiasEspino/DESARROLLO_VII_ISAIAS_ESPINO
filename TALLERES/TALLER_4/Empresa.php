<?php
require_once 'Empleado.php';
require_once 'Gerente.php';
require_once 'Desarrollador.php';

class Empresa {
    private $empleados = [];

    // Método para agregar empleados
    public function agregarEmpleado(Empleado $empleado) {
        $this->empleados[] = $empleado;
    }

    // Método para listar empleados
    public function listarEmpleados() {
        foreach ($this->empleados as $empleado) {
            echo "Nombre: " . $empleado->getNombre() . ", ID: " . $empleado->getId() . "\n";
        }
    }

    // Método para calcular la nómina total
    public function calcularNomina() {
        $total = 0;
        foreach ($this->empleados as $empleado) {
            $total += $empleado->getSalarioBase();
        }
        return $total;
    }

    // Método para realizar evaluaciones de desempeño
    public function evaluarDesempenioEmpleados() {
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Evaluable) {
                echo $empleado->evaluarDesempenio() . "\n";
            }
        }
    }
}
?>
