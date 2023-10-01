document.addEventListener("DOMContentLoaded", function() {

    var editCells = document.querySelectorAll(".clickable-row");
    editCells.forEach(function(cell) {
        cell.addEventListener("dblclick", function() {
            redirectToEditPage(cell);
        });
    });
});

function redirectToEditPage(cell) {
    var userId = cell.getAttribute("data-user-id");
    window.location.href = "/users/edit/" + userId;
}
