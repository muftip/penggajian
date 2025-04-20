@extends('layouts.app')

@section('title', $pageTitle)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $pageTitle }}</div>

                <div class="card-body">
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

                    {{ html()->form('PUT', route('pegawai.update', $data['pegawai']->id))->class('row g-3')->open() }}
                    {{ html()->hidden('id', $data['pegawai']->id) }}
                    <div class="col-md-5">
                        <label for="no_pegawai" class="form-label">No. Pegawai</label>
                        <input type="number" name="no_pegawai" required class="form-control" id="no_pegawai"
                            placeholder="00608484939"
                            value="{{ old('no_pegawai') ? old('no_pegawai') : $data['pegawai']->no_pegawai }}">
                    </div>
                    <div class="col-md-7">
                        <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" required class="form-control" id="namaLengkap"
                            placeholder="Kasusra Sitorus"
                            value="{{ old('nama') ? old('nama') : $data['pegawai']->nama }}">
                    </div>
                    <div class="col-md-4">
                        <label for="tempatLahir" class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" required class="form-control" id="tempatLahir"
                            placeholder="Binjai"
                            value="{{ old('tempat_lahir') ? old('tempat_lahir') : $data['pegawai']->tempat_lahir }}">
                    </div>
                    <div class="col-md-4">
                        <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" required class="form-control" id="tanggalLahir"
                            value="{{ old('tanggal_lahir') ? old('tanggal_lahir') : $data['pegawai']->tanggal_lahir }}">
                    </div>
                    <div class="col-md-4">
                        <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                        <div class="form-control">
                            @if ((old('jenis_kelamin') OR $data['pegawai']->jenis_kelamin) == 'L')
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" checked name="jenis_kelamin" id="laki"
                                    value="L">
                                <label class="form-check-label" for="laki">Laki-Laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan"
                                    value="P">
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                            @else
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="L">
                                <label class="form-check-label" for="laki">Laki-Laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" checked name="jenis_kelamin" id="perempuan"
                                    value="P">
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="departemen" class="form-label">Departemen</label>
                        <select id="departemen" name="departemen_id" class="form-select" required>
                            <option value="" selected>Pilih...</option>
                            @foreach ($data['departemen'] as $dep)
                            @if ((old('departemen_id') ? old('departemen_id') : $data['pegawai']->departemen_id) ==
                            $dep->id)
                            <option value="{{ $dep->id }}" selected> {{ $dep->nama }}</option>
                            @else
                            <option value="{{ $dep->id }}"> {{ $dep->nama }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="posisi" class="form-label">Posisi</label>
                        <select id="posisi" name="posisi_id" onchange="getPosisi()" class="form-select" required>
                            <option value="" selected>Pilih...</option>
                            @foreach ($data['posisi'] as $pos)
                            @if ((old('posisi_id') ? old('posisi_id') : $data['pegawai']->posisi_id) == $pos->id)
                            <option value="{{ $pos->id }}" selected> {{ $pos->nama }}</option>
                            @else
                            <option value="{{ $pos->id }}"> {{ $pos->nama }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="statusPegawai" class="form-label">Status Pegawai</label>
                        <select id="statusPegawai" name="status_pegawai" class="form-select" required>
                            @if ((old('status_pegawai') ? old('status_pegawai') : $data['pegawai']->status_pegawai) ==
                            'tetap')
                            <option value="tetap" selected>Tetap</option>
                            @elseif ((old('status_pegawai') ? old('status_pegawai') : $data['pegawai']->status_pegawai)
                            == 'kontrak')
                            <option value="kontrak" selected>Kontrak</option>
                            @elseif ((old('status_pegawai') ? old('status_pegawai') : $data['pegawai']->status_pegawai)
                            == 'HL')
                            <option value="HL" selected>Harian Lepas</option>
                            @else
                            <option value="" selected>Pilih...</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="masaKerja" class="form-label">Masa Kerja (tahun)</label>
                        <input type="number" class="form-control money2" id="masaKerja" aria-describedby="gajiPokok"
                            name="masa_kerja_tahun"
                            value="{{ old('masa_kerja_tahun') ? old('masa_kerja_tahun') : $data['pegawai']->masa_kerja_tahun }}"
                            required>
                    </div>
                    <div class="col-md-5">
                        <label for="gajiPokok" class="form-label">Gaji Pokok</label>
                        <div class="input-group">
                            <span class="input-group-text" id="rupiahGaji">Rp </span>
                            <input type="number" class="form-control money2" id="gajiPokok" aria-describedby="gajiPokok"
                                name="gaji_pokok"
                                value="{{ old('gaji_pokok') ? old('gaji_pokok') : $data['pegawai']->gaji_pokok }}"
                                required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label for="tunjanganTetap" class="form-label">Tunjangan Tetap</label>
                        <div class="input-group">
                            <span class="input-group-text" id="rupiahTunjangan">Rp </span>
                            <input type="number" class="form-control money2" id="tunjanganTetap"
                                aria-describedby="tunjanganTetap" name="tunjangan_tetap"
                                value="{{ old('tunjangan_tetap') ? old('tunjangan_tetap') : $data['pegawai']->tunjangan_tetap }}"
                                required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                    {{ html()->form()->close() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection