document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('confirmModal');
    let selectedId = null;

    // Al hacer clic en el botón de eliminar, se muestra el modal de confirmación y se almacena el ID de 
    // la tarea a eliminar.
    document.querySelectorAll('button[title="Eliminar"]').forEach(btn => {
        btn.addEventListener('click', () => {
            const container = btn.closest('[data-id]');
            if (!container) return;
            selectedId = container.getAttribute('data-id');
            modal.classList.remove('hidden');
        });
    });

    document.getElementById('cancelBtn').addEventListener('click', () => {
        modal.classList.add('hidden');
        selectedId = null;
    });

    // Al confirmar el eliminar la tarea, se envía una solicitud POST a delete.php 
    // con el ID de la tarea a eliminar.
    document.getElementById('confirmBtn').addEventListener('click', () => {
        if (!selectedId) return;
        fetch('delete.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: parseInt(selectedId) })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const taskEl = document.querySelector('[data-id="' + selectedId + '"]');
                    if (taskEl) taskEl.remove();
                } else {
                    console.error('Error al eliminar la tarea');
                }
                modal.classList.add('hidden');
                selectedId = null;
            })
            .catch(err => {
                console.error(err);
                modal.classList.add('hidden');
                selectedId = null;
            });
    });
});
