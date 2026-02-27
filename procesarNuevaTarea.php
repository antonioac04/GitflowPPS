<?php
function ProcesarNuevaTarea(string &$jsonPath, array &$tareas): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['tarea'])) {
        $nuevoTitulo = trim($_POST['tarea']);

        $nuevoId = !empty($tareas) ? max(array_column($tareas, 'id')) + 1 : 1;

        $nuevaTarea = [
            'id' => $nuevoId,
            'titulo' => $nuevoTitulo
        ];

        $tareas[] = $nuevaTarea;

        file_put_contents($jsonPath, json_encode($tareas, JSON_PRETTY_PRINT));

        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

?>