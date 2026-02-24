<?php
header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);
$id = $data['id'];
$jsonPath = __DIR__ . '/tareas.json';
$content = file_get_contents($jsonPath);
$tareas = json_decode($content, true) ?: [];
$new = [];
$deleted = false;

// Validaciones básicas
if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'error' => 'ID no proporcionado']);
    exit;
}

if (!file_exists($jsonPath)) {
    echo json_encode(['success' => false, 'error' => 'Archivo no encontrado']);
    exit;
}

// Eliminar la tarea con el ID proporcionado
foreach ($tareas as $t) {
    if ($t['id'] == $id) {
        $deleted = true;
        continue;
    }
    $new[] = $t;
}

// Guardar el nuevo array sin la tarea eliminada
if ($deleted) {
    file_put_contents($jsonPath, json_encode($new, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Tarea no encontrada']);
}
?>