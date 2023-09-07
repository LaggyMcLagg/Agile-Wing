@section('styles')
<link href="{{ asset('css/style.css')}}" rel="stylesheet">
@endsection
<button type="" class="btn {{ $class }}"  data-toggle="modal" data-target="#{{ $modalId }}"> {{$slot}}</button>
