document.addEventListener("DOMContentLoaded", function() 
{
  var searchInput = document.getElementById("search-input");

  searchInput.addEventListener("keyup", function() {
    var searchText = searchInput.value.toLowerCase();
    var rows = document.querySelectorAll("tbody tr");

    rows.forEach(function(row) 
    {
      var rowText = row.textContent.toLowerCase();
      if (rowText.includes(searchText)) 
      {
        row.style.display = "";
      } 
      else 
      {
        row.style.display = "none";
      }
    });
  });
});


