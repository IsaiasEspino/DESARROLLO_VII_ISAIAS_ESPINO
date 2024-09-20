<?php
require_once 'Empresa.php';
require_once 'Gerente.php';
require_once 'Desarrollador.php';

// Crear instancia de Empresa
$empresa = new Empresa();

// Crear empleados
$gerente = new Gerente("Carlos", 1, 5000, "Ventas");
$desarrollador = new Desarrollador("Ana", 2, 4000, "PHP", "Senior");

// Asignar bono al gerente
$gerente->asignarBono(1000);

// Agregar empleados a la empresa
$empresa->agregarEmpleado($gerente);
$empresa->agregarEmpleado($desarrollador);

// Listar empleados
echo "Empleados:<br>";
$empresa->listarEmpleados();
echo "<br>"; // Salto de línea adicional

// Calcular la nómina total
echo "Nómina total: " . $empresa->calcularNomina() . "<br><br>";

// Evaluar desempeño de empleados
echo "Evaluaciones de desempeño:<br>";
$empresa->evaluarDesempenioEmpleados();
?>

