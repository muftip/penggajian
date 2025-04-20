<div class="btn-group" role="group" aria-label="Action button">
    <a href="{{ route('pegawai.edit',$pegawai->id) }}" class="edit btn btn-warning btn-sm">
        <i class="bi bi-pencil-square fs-5"></i></a>
    {{ html()->form('DELETE', route('pegawai.destroy',$pegawai->id))->id('delete-pegawai')
    ->class(['delete', 'btn', 'btn-danger', 'btn-sm'])->open() }}
    <i onclick="confirmDelete()" class="bi bi-trash fs-5"></i>
    {{ html()->form()->close() }}
</div>