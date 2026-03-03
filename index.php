<?php

$tareas = [];
$jsonPath = __DIR__ . '/tareas.json';

if (file_exists($jsonPath)) {
    $content = file_get_contents($jsonPath);
    $tareas = json_decode($content, true) ?: [];
}

include_once 'procesarNuevaTarea.php';
ProcesarNuevaTarea($jsonPath, $tareas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="shortcut icon" href="https://icons8.com/icon/63262/checkmark" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>Gitflow - PPS</title>
</head>

<body class="text-slate-200 font-sans antialiased h-screen flex flex-col overflow-hidden">
    
    <header class="pt-10 pb-6 text-center shrink-0">
        <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-widest text-blue-400 uppercase bg-blue-900/30 border border-blue-500/30 rounded-full">
            Lista de tareas
        </div>
        <h1 class="text-4xl font-extrabold tracking-tight text-white">
            Flow<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-500">Stack</span>
        </h1>
    </header>

    <main class="flex-1 overflow-y-auto custom-scroll max-w-2xl mx-auto w-full px-6">
        <div class="space-y-4 pb-4">
            <?php if (count($tareas) > 0): ?>
                <?php foreach ($tareas as $t): ?>
                    <div data-id="<?php echo $t['id']; ?>" class="group relative p-5 bg-slate-900/50 border border-slate-800 rounded-2xl hover:border-blue-500/50 hover:bg-slate-800/50 transition-all duration-300 shadow-xl backdrop-blur-sm flex items-center justify-between">
                        <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-blue-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-mono text-slate-500 uppercase tracking-widest mb-1">Tarea nº: #<?php echo $t['id']; ?></span>
                            <h2 class="text-lg font-semibold text-slate-100 group-hover:text-blue-400 transition-colors">
                                <?php echo htmlspecialchars($t['titulo'], ENT_QUOTES, 'UTF-8'); ?>
                            </h2>
                        </div>
                        <div class="flex gap-2">
                             <button class="p-2 text-slate-500 hover:text-red-400 hover:bg-red-400/10 rounded-lg transition-colors" title="Eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                             </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-20 border-2 border-dashed border-slate-800 rounded-3xl">
                    <p class="text-slate-600 italic">No hay tareas pendientes en el backlog.</p>
                </div>
            <?php endif; ?>
             <div class="space-y-4 pb-10">
                <h1>¿Desea agregar alguna tarea?</h1>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" class="flex gap-2 items-center mt-4">
                    <input type="text" placeholder="Depurar código" name="tarea" required class="px-3 py-2 rounded-lg text-white placeholder-white flex-1 border border-white bg-slate-800 focus:border-blue-400 focus:outline-none">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">Añadir tarea</button>
                </form>
            </div>
        </div>
    </main>

    </main>

    <footer class="shrink-0 py-6 mt-4 border-t border-slate-900 bg-black/20 backdrop-blur-md text-center">
        <p class="text-[10px] font-mono text-slate-600 tracking-tighter">
            PROYECTO PPS <span class="mx-2 text-slate-800">•</span> Antonio Arcediano - Antonio Nogues - Iván Téllez <span class="mx-2 text-slate-800">•</span> v.0.0.1
        </p>
    </footer>

    <!-- Modal de confirmación -->
    <div id="confirmModal" class="fixed inset-0 z-50 flex items-center justify-center hidden backdrop-blur-md bg-black/60 transition-all duration-300">
    
    <div class="relative bg-slate-900/90 border border-slate-700 p-8 rounded-3xl max-w-sm w-full shadow-2xl transform transition-all">
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-blue-500/10 blur-3xl rounded-full"></div>
        <div class="relative flex flex-col items-center text-center space-y-5">
            <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            </div>
            <div class="space-y-2">
                <h3 class="text-xl font-bold text-white tracking-tight">¿Confirmar eliminación?</h3>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Esta acción es permanente. La tarea se eliminará de manera <span class="text-blue-400 font-mono">definitiva</span>.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full pt-2">
                <button id="cancelBtn" class="flex-1 px-4 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-medium rounded-xl transition-all border border-slate-700 hover:border-slate-600 active:scale-95">
                    Cancelar
                </button>
                <button id="confirmBtn" class="flex-1 px-4 py-3 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-400 text-white font-bold rounded-xl shadow-lg shadow-red-900/20 transition-all active:scale-95">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

    <script src="delete-tarea.js"></script>
</body>
</html>