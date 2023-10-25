document.addEventListener('DOMContentLoaded', function() {
    const deleteSelectedRoute = sessionStorage.getItem('deleteSelectedRoute');
    const publishSelectedRoute = sessionStorage.getItem('publishSelectedRoute');
    const selectAllCheckbox = document.getElementById('selectAll');
    const availabilityCheckboxes = document.querySelectorAll('.availability-checkbox');
    const deleteBtn = document.getElementById('deleteBtn');
    const publishBtn = document.getElementById('publishBtn');

    // Select/Deselect all functionality
    selectAllCheckbox.addEventListener('change', function() {
        availabilityCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });

    // Delete functionality
    deleteBtn.addEventListener('click', function() {

        if (!window.confirm("Tem a certeza que quer apagar estes registos?")) {
            return;
        }

        const selectedIds = [...availabilityCheckboxes].filter(checkbox => checkbox.checked).map(checkbox => checkbox.value);
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = selectedIds;
        document.getElementById('bulkActionForm').appendChild(input);
        console.log(selectedIds);
        
        document.getElementById('bulkActionForm').action = deleteSelectedRoute;
        document.getElementById('bulkActionForm').submit();
    });

    // Publish functionality
    publishBtn.addEventListener('click', function() {

        if (!window.confirm("Tem a certeza que quer publicar estes registos? Futuras edições só através de pedido a/c do planemaneto.")) {
            return;
        }

        const selectedIds = [...availabilityCheckboxes].filter(checkbox => checkbox.checked).map(checkbox => checkbox.value);

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = selectedIds;
        document.getElementById('bulkActionForm').appendChild(input);
        console.log(selectedIds);
        
        document.getElementById('bulkActionForm').action = publishSelectedRoute;
        document.getElementById('bulkActionForm').submit();
    });
});