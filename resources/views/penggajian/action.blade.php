<div class="btn-group" role="group" aria-label="Action button">
    <a href="{{ route('penggajian.show',$penggajian->id) }}" class="show btn btn-warning btn-sm">
        <i class="bi bi-eye fs-5"></i></a>
    @can('penggajian-delete')
    {{ html()->form('DELETE', route('penggajian.destroy',$penggajian->id))->id('delete-penggajian')
    ->class(['delete', 'btn', 'btn-dark', 'btn-sm'])->open() }}
    <i onclick="confirmDelete()" class="bi bi-trash fs-5"></i>
    {{ html()->form()->close() }}
    @endcan
</div>