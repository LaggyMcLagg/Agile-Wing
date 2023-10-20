@section('scripts')

@endsection

@section('styles')
<!-- SARA OU INES DPS METAM ISTO NO FICHEIRO CSS
está aplicada à legenda de disponibilidades -->
<style>
    .legend-color-box {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 1px solid #333;
    }
</style>
@endsection

<h3>Disponibilidades PROF CRUD</h3>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

