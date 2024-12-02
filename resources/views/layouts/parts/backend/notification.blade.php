@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Dashmix.helpers('jq-notify', {
            type: 'success',
            icon: 'fa fa-check me-1',
            message: '{{ session('success') }}'
        });
    });
</script>
@endif

@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Dashmix.helpers('jq-notify', {
            type: 'danger',
            icon: 'fa fa-times me-1',
            message: '{{ session('error') }}'
        });
    });
</script>
@endif