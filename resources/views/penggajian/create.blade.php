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

                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">Panduan</h4>
                        <div class="alert-body">
                            <ol class="pl-1 m-0">
                                <li><strong>Periode Penggajian:</strong> pilih periode 'Januari 2021.'</li>
                                <li><strong>Data Pegawai:</strong> pilih pegawai 'Kawaca Sihombing.'</li>
                                <li><strong>Klik tombol 'Hitung.'</strong></li>
                                <li><strong>Terakhir, klik tombol 'Buat.'</strong></li>
                            </ol>
                        </div>
                    </div>

                    {{ html()->form('POST', route('penggajian.store'))->class('row g-3')->open() }}
                    {{ html()->hidden('no_ref', fake()->numerify('#########')) }}
                    <!-- Periode penggajian -->
                    <div><strong>Periode Penggajian</strong></div>
                    <div class="col-md-4">
                        <label for="bulan_periode" class="form-label">Bulan</label>
                        <select id="bulan_periode" name="bulan_periode" class="form-select" required>
                            <option value="" selected>Pilih...</option>
                            <option value="01">Januari</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="tahun_periode" class="form-label">Bulan</label>
                        <select id="tahun_periode" name="tahun_periode" class="form-select" required>
                            <option value="" selected>Pilih...</option>
                            <option value="2021">2021</option>
                        </select>
                    </div>

                    <!-- Detail Pegawai -->
                    <div><strong>Data Pegawai</strong></div>
                    <div class="col-md-12">
                        <label for="pegawai" class="form-label">Pegawai</label>
                        <select id="pegawai" name="pegawai_id" onchange="getPegawaiId()" class="form-select" required>
                            <option value="" selected>Pilih...</option>
                            @foreach ($data['pegawai'] as $peg)
                            <option value="{{ $peg->id }}">{{ $peg->no_pegawai }} &ndash; {{
                                $peg->nama }} ({{ $peg->departemen->nama }} - {{ $peg->posisi->nama }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="no_pegawai" class="form-label">No. Pegawai</label>
                        <input type="text" disabled class="form-control" id="no_pegawai">
                    </div>
                    <div class="col-md-8">
                        <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                        <input type="text" disabled class="form-control" id="nama_pegawai">
                    </div>
                    <div class="col-md-5">
                        <label for="departemen" class="form-label">Departemen</label>
                        <input type="text" disabled class="form-control" id="departemen">
                    </div>
                    <div class="col-md-7">
                        <label for="posisi" class="form-label">Posisi</label>
                        <input type="text" disabled class="form-control" id="posisi">
                    </div>
                    <hr class="mb-0">

                    <!-- Penambah Gaji -->
                    <div><strong>Penambah Gaji</strong></div>
                    <div class="col-md-6">
                        <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="gaji_pokok" readonly class="form-control gaji_pokok">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="jumlah_tunjangan_tetap" class="form-label">Tunjangan Tetap</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control jumlah_tunjangan_tetap"
                                name="jumlah_tunjangan_tetap" readonly class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="jumlah_insentif" class="form-label">Jumlah Insentif</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="jumlah_insentif" readonly class="form-control"
                                id="jumlah_insentif">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="status_pegawai" class="form-label">Status Pegawai</label>
                        <input type="text" class="form-control" disabled class="form-control" id="status_pegawai">
                    </div>
                    <div class="col-md-4">
                        <label for="masa_kerja" class="form-label">Masa Kerja (tahun)</label>
                        <input type="number" class="form-control" disabled class="form-control" id="masa_kerja">
                    </div>
                    <div class="col-md-6">
                        <label for="lembur" class="form-label">Jumlah Lembur</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="jumlah_lembur" readonly class="form-control"
                                id="jumlah_lembur">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="lama_lembur" class="form-label">Lama Lembur (jam)</label>
                        <input type="number" name="lama_lembur" class="form-control" readonly class="form-control"
                            id="lama_lembur">
                    </div>
                    <hr class="mb-0">

                    <!-- Potongan Gaji -->
                    <div><strong>Potongan Gaji</strong></div>
                    <div class="col-md-4">
                        <label for="jumlah_nwnp" class="form-label">Jumlah NWNP</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="jumlah_nwnp" readonly class="form-control" id="jumlah_nwnp">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="kehadiran" class="form-label">Hadir</label>
                        <input type="number" name="kehadiran" readonly class="form-control" id="kehadiran">
                    </div>
                    <div class="col-md-2">
                        <label for="alpha" class="form-label">Alpha</label>
                        <input type="number" name="alpha" readonly class="form-control" id="alpha">
                    </div>
                    <div class="col-md-2">
                        <label for="izin" class="form-label">Izin</label>
                        <input type="number" name="izin" readonly class="form-control" id="izin">
                    </div>
                    <div class="col-md-2">
                        <label for="cuti" class="form-label">Cuti</label>
                        <input type="number" name="cuti" readonly class="form-control" id="cuti">
                    </div>
                    <div class="col-md-6">
                        <label for="bpjs" class="form-label">BPJS (3%)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="bpjs" readonly class="form-control"
                                id="bpjs">
                        </div>
                    </div>
                    <hr class="mb-0">

                    <!-- Total Gaji -->
                    <div><strong>Total Gaji</strong></div>
                    <p><em>Total gaji perbulan = Gaji pokok + Tunjangan tetap + Tunjangan tidak tetap + Upah lembur -
                            Potongan NWNP - Potongan BPJS</em></p>
                    <div class="col-md-6">
                        <label for="komponen_penambah_gaji" class="form-label">Komponen Penambah Gaji</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="jumlah_penambah_gaji" readonly class="form-control"
                                id="komponen_penambah_gaji">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="komponen_pengurang_gaji" class="form-label">Komponen Pengurang Gaji</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="jumlah_potongan_gaji" class="form-control" readonly
                                id="komponen_pengurang_gaji">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="total_gaji" class="form-label">Total Gaji</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="total_gaji" readonly id="total_gaji">
                        </div>
                    </div>

                    <div class=" col-sm-12">
                        Dibuat oleh: <em>{{ auth()->user()->name }}</em>
                    </div>
                    <div class=" col-sm-4">
                        <a onclick="hitungPenggajian()" class="btn btn-success">Hitung</a>
                    </div>
                    <hr class="mb-0">

                    <div class=" col-sm-8">
                        <button type="submit" class="btn btn-primary">Buat</button>
                        <input type="reset" value="Reset" class="btn btn-danger">
                        <a href="{{ route('penggajian.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                    {{ html()->form()->close() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    function getPegawaiId() {
        let id = $('#pegawai option:selected').val();

        $.ajax({
            type: 'GET',
            url: "{{ route('data-pegawai') }}",
            data: {
                id: id
            },
            success: function (data) {
                $('#no_pegawai').val(data.no_pegawai);
                $('#nama_pegawai').val(data.nama);
                $('#departemen').val(data.departemen.nama);
                $('#posisi').val(data.posisi.nama);
                $('.gaji_pokok').val(data.gaji_pokok);
                $('.jumlah_tunjangan_tetap').val(data.tunjangan_tetap);
                $('#status_pegawai').val(data.status_pegawai);
                $('#masa_kerja').val(data.masa_kerja_tahun);
            },
            error: function (data) {
                console.log("err" + data);
            }
        });
    }

    function hitungPenggajian() {
        let id = $('#pegawai option:selected').val();
        let periode = $('#tahun_periode option:selected').val() + '-' + $('#bulan_periode option:selected').val();

        $.ajax({
            type: 'GET',
            url: "{{ route('data-penggajian') }}",
            data: {
                id: id,
                periode: periode,
            },
            success: function (data) {
                $('#jumlah_insentif').val(data.insentif);
                $('#lama_lembur').val(data.lembur.jam_lembur);
                $('#jumlah_lembur').val(data.lembur.jumlah_lembur);
                $('#kehadiran').val(data.kehadiran.jumlah_hadir);
                $('#alpha').val(data.kehadiran.jumlah_alpha);
                $('#izin').val(data.kehadiran.jumlah_izin);
                $('#cuti').val(data.kehadiran.jumlah_cuti);
                $('#jumlah_nwnp').val(data.nwnp);
                $('#bpjs').val(data.bpjs);
                $('#komponen_penambah_gaji').val(data.penambah_gaji);
                $('#komponen_pengurang_gaji').val(data.pengurang_gaji);
                $('#total_gaji').val(data.total_gaji);
            },
            error: function (xhr, status, error) {
    console.error('AJAX Error:', error);
    console.error('Status:', status);
    console.error('Response:', xhr.responseText);
}

        });
    }
</script>
@endpush