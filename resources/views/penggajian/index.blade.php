@extends('layouts.app')

@role ('supervisor-payroll')
@php $pageTitle = 'Approval Penggajian Pegawai'; @endphp
@else
@php $pageTitle = 'Daftar Penggajian Pegawai'; @endphp
@endrole

@section('title', $pageTitle)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ $pageTitle }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if (count($errors) > 0)
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Validation Error</h4>
                        <div class="alert-body">
                            <ul class="pl-1 m-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script>
    function confirmDelete() {
        let text = "Apakah Anda yakin akan menghapus penggajian ini?";
        if (window.confirm(text) == true) {
            document.getElementById('delete-penggajian').submit()
        } else {
            return false;
        }
    }
</script>

{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush