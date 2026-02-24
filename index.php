<?php

$tareas = [];
$jsonPath = __DIR__ . '/tareas.json';

if (file_exists($jsonPath)) {
    $content = file_get_contents($jsonPath);
    $tareas = json_decode($content, true) ?: [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="style.css">
    <title>Gitflow - PPS</title>
</head>

<body class="text-slate-200 font-sans antialiased h-screen flex flex-col overflow-hidden">
    
    <header class="pt-10 pb-6 text-center shrink-0">
        <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-widest text-blue-400 uppercase bg-blue-900/30 border border-blue-500/30 rounded-full">
            Workflow Manager
        </div>
        <h1 class="text-4xl font-extrabold tracking-tight text-white">
            Lista de <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-500">Tareas</span>
        </h1>
    </header>

    <main class="flex-1 overflow-y-auto custom-scroll max-w-2xl mx-auto w-full px-6">
        <div class="space-y-4 pb-10">
            <?php if (count($tareas) > 0): ?>
                <?php foreach ($tareas as $t): ?>
                    <div class="group relative p-5 bg-slate-900/50 border border-slate-800 rounded-2xl hover:border-blue-500/50 hover:bg-slate-800/50 transition-all duration-300 shadow-xl backdrop-blur-sm flex items-center justify-between">
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
        </div>
    </main>

    <footer class="shrink-0 py-6 border-t border-slate-900 bg-black/20 backdrop-blur-md text-center">
        <p class="text-[10px] font-mono text-slate-600 tracking-tighter">
            PROYECTO PPS <span class="mx-2 text-slate-800">•</span> Antonio Arcediano - Antonio Nogues - Iván Téllez <span class="mx-2 text-slate-800">•</span> v.0.0.1
        </p>
    </footer>
</body>
</html>