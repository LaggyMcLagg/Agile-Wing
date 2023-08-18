<div class="table-responsive">
  <form class="form-inline my-2 my-lg-0">
    <input id="search-input" class="form-control mr-sm-2" type="search" placeholder="Pesquisa" aria-label="Search">
    <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
  </form>

  <table class="table table-bordered">
    <thead>
      <tr>
        @foreach($columns as $column)
        <th scope="col">{{ $column }}</th>
        @endforeach
      </tr>
    </thead>
  
    <tbody>
        @foreach($rows as $index => $row)
        <tr class="clickable-row" data-user-id="{{$objectIds[$index]}}">
          @foreach($row as $cell)
          <td>
            @if(is_array($cell))
            <ul>
              @foreach($cell as $item)
              <li>{{ $item }}</li>
              @endforeach
            </ul>
            @else
            {{ $cell }}
            @endif
          </td>
          @endforeach
        </tr>
        @endforeach
    </tbody>
  </table>
</div>

<script>
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


var editCells = document.querySelectorAll(".clickable-row");
    editCells.forEach(function(cell) {
      cell.addEventListener("dblclick", function() {
        var userId = cell.getAttribute("data-user-id");
        window.location.href = "/formadores/" + userId + "/edit";
      });
    });
  });
</script>