@if ($errors->first())
<script>
    toastr.error('{{ $errors->first() }}');
</script>
@endif

@if (Session::has('message'))
<script>
    toastr.success("{{ Session::get('message') }}");
</script>
@endif
@if (Session::has('error'))
<script>
    toastr.error("{{ Session::get('error') }}");
</script>
@endif