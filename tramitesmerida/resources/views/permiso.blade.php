@extends('layout.Layout')

@section('body')
aaaaaaaa
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "language": {
                url: "plugins/DataTables/language/Spanish.json",
                "search":			"Filtrar resultados:",
            },
            searching: true,
            ordering: true,
            paging: true,
            bLengthChange: false,
        });
    });
</script>
@endsection