@if(isset($paginator) && method_exists($paginator, 'links'))
    <div class="mt-4 d-flex justify-content-end">
        {{ $paginator->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
@endif
