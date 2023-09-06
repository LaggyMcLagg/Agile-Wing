document.addEventListener("DOMContentLoaded", function() {
    // Client-side sorting
    var table = document.getElementById("sortable-table");
    var headers = table.querySelectorAll("th[data-column-index]");
    var rows = table.querySelectorAll("tbody tr");
    headers.forEach(function(header) {
        header.addEventListener("click", function() {
            sortTableByColumn(table, headers, rows, header);
        });
    });
    // Live search
    var searchInput = document.getElementById("search-input");
    searchInput.addEventListener("keyup", function() {
        filterRowsBySearchInput(searchInput, rows);
    });
    // Clickable rows
    var editCells = document.querySelectorAll(".clickable-row");
    editCells.forEach(function(cell) {
        cell.addEventListener("dblclick", function() {
            redirectToEditPage(cell);
        });
    });
});
function sortTableByColumn(table, headers, rows, clickedHeader) {
    var columnIndex = parseInt(clickedHeader.getAttribute("data-column-index"));
    var sortDirection = clickedHeader.classList.contains("sorted-asc") ? "desc" : "asc";
    rows = Array.from(rows);
    rows.sort(function(a, b) {
        var aValue = a.children[columnIndex].textContent;
        var bValue = b.children[columnIndex].textContent;
        if (sortDirection === "asc") {
            return aValue.localeCompare(bValue);
        } else {
            return bValue.localeCompare(aValue);
        }
    });
    rows.forEach(function(row) {
        table.querySelector("tbody").appendChild(row);
    });
    headers.forEach(function(header) {
        header.classList.remove("sorted-asc", "sorted-desc");
    });
    clickedHeader.classList.add(sortDirection === "asc" ? "sorted-asc" : "sorted-desc");
}
function filterRowsBySearchInput(searchInput, rows) {
    var searchText = searchInput.value.toLowerCase();
    rows.forEach(function(row) {
        var rowText = row.textContent.toLowerCase();
        if (rowText.includes(searchText)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}
function redirectToEditPage(cell) 
{
    var userId = cell.getAttribute("data-user-id");
    window.location.href = "/users/" + userId + "/edit";
}
