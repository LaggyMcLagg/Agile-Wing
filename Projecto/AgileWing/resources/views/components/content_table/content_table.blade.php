@section('scripts')
<script src="{{ asset('js/content_table.js')}}"></script>
@endsection

<div class="table-responsive">
  <form class="form-inline my-2 my-lg-0">
    <input id="search-input" class="form-control mr-sm-2" type="search" placeholder="Pesquisa" aria-label="Search">
    <button class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
</form>

  <table class="table table-bordered" id="sortable-table">
    <thead>
        <tr>
            @foreach($columns as $index => $column)
            <th scope="col" data-column-index="{{$index}}">{{$column}}</th>
            @endforeach
            @if($useCheckbox)
            <th scope="col">Selected</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $index => $row)
        @if(isset($objectIds))
        <tr class="clickable-row" data-user-id="{{$objectIds[$index]}}">
        @endif
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
            @if($useCheckbox)
            <td>
                @if(isset($pedagogicalGroupUser) && isset($pedagogicalGroupUser[$row[0]]))
        <input type="checkbox" {{ $pedagogicalGroupUser[$row[2]] ? 'checked' : '' }}>
                @endif
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
  </table>
</div>