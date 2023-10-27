document.addEventListener("DOMContentLoaded", function() {

    var table = document.getElementById("sortable-table");
    var rows = table.querySelectorAll("tbody tr");
    // Live search
    var searchInput = document.getElementById("search-input");
    searchInput.addEventListener("keyup", function() {
        filterRowsBySearchInput(searchInput, rows);
    });
});

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
