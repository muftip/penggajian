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

                    @unlessrole ('supervisor-payroll')
                    <div class=" col-sm-8 mb-3">
                        <a href="{{ route('generate-pdf', $data['penggajian']->id ) }}" target="_blank"
                            rel="noopener noreferrer" class="btn btn-warning">View as
                            PDF</a>
                        <a href="{{ route('cetak-pdf',  $data['penggajian']->id) }}" target="_blank"
                            rel="noopener noreferrer" class="btn btn-secondary">Export as
                            PDF</a>
                    </div>
                    @endrole

                    @role ('supervisor-payroll')
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">Approval Penggajian</h4>
                        <div class="alert-body">
                            <ol class="pl-1 m-0">
                                <li><strong>Cek data:</strong> periksa seluruh data penggajian.</li>
                                <li><strong>Status:</strong> ubah status penggajian antara 'draf', 'disetuji', atau
                                    'dibatalkan'</li>
                                <li><strong>Klik tombol 'Ubah Status.'</strong></li>
                            </ol>
                        </div>
                    </div>
                    @endrole

                    @role ('supervisor-payroll')
                    {{ html()->form('PATCH', route('penggajian.update', $data['penggajian']->id))->class('row
                    g-3')->open() }}
                    {{ html()->hidden('approver', auth()->user()->id) }}
                    @else
                    {{ html()->form()->class('row g-3')->open() }}
                    @endrole
                    <!-- Periode penggajian -->
                    <div><strong>Periode Penggajian</strong></div>
                    <div class="col-md-4">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" readonly class="form-control"
                            value="{{ $data['penggajian']->tanggal_mulai }}">
                    </div>
                    <div class="col-md-4">
                        <label for="tanggal_hingga" class="form-label">Tanggal Hingga</label>
                        <input type="date" readonly class="form-control"
                            value="{{ $data['penggajian']->tanggal_hingga }}">
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="tanggal_hingga" class="form-label text-danger fw-bold fst-italic">Status
                            Penggajian</label>
                        @role('supervisor-payroll')
                        <select id="agama" name="status" class="form-select" required>
                            <option value="" selected>Pilih...</option>
                            @if ($data['penggajian']->status == 'draf')
                            <option value="draf" selected>draf</option>
                            <option value="disetujui">disetujui</option>
                            <option value="dibatalkan">dibatalkan</option>
                            @elseif ($data['penggajian']->status == 'disetujui')
                            <option value="draf">draf</option>
                            <option value="disetujui" selected>disetujui</option>
                            <option value="dibatalkan">dibatalkan</option>
                            @elseif ($data['penggajian']->status == 'dibatalkan')
                            <option value="draf">draf</option>
                            <option value="disetujui">disetujui</option>
                            <option value="dibatalkan" selected>dibatalkan</option>
                            @else
                            <option value="draf">draf</option>
                            <option value="disetujui">disetujui</option>
                            <option value="dibatalkan">dibatalkan</option>
                            @endif
                        </select>
                        @else
                        <input type="text" readonly class="form-control" value="{{ $data['penggajian']->status }}">
                        @endrole
                        </select>
                    </div>

                    <!-- Detail Pegawai -->
                    <div><strong>Data Pegawai</strong></div>
                    <div class="col-md-12">
                        <label for="pegawai" class="form-label">Pegawai</label>
                        <input type="text" readonly class="form-control"
                            value="{{ $data['pegawai']->no_pegawai }} -- {{ $data['pegawai']->nama }} ({{ $data['pegawai']->departemen->nama }} - {{ $data['pegawai']->posisi->nama }})">
                    </div>
                    <div class="col-md-4">
                        <label for="no_pegawai" class="form-label">No. Pegawai</label>
                        <input type="text" readonly class="form-control" value="{{ $data['pegawai']->no_pegawai }}">
                    </div>
                    <div class="col-md-8">
                        <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                        <input type="text" readonly class="form-control" value="{{ $data['pegawai']->nama }}">
                    </div>
                    <div class="col-md-5">
                        <label for="departemen" class="form-label">Departemen</label>
                        <input type="text" readonly class="form-control"
                            value="{{ $data['pegawai']->departemen->nama }}">
                    </div>
                    <div class="col-md-7">
                        <label for="posisi" class="form-label">Posisi</label>
                        <input type="text" readonly class="form-control" value="{{ $data['pegawai']->posisi->nama }}">
                    </div>
                    <hr class="mb-0">

                    <!-- Penambah Gaji -->
                    <div><strong>Penambah Gaji</strong></div>
                    <div class="col-md-6">
                        <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="gaji_pokok" readonly class="form-control gaji_pokok"
                                value="{{ $data['pegawai']->gaji_pokok }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="jumlah_tunjangan_tetap" class="form-label">Tunjangan Tetap</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control jumlah_tunjangan_tetap"
                                name="jumlah_tunjangan_tetap" readonly class="form-control"
                                value="{{ $data['pegawai']->tunjangan_tetap }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="jumlah_insentif" class="form-label">Jumlah Insentif</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="jumlah_insentif" readonly class="form-control"
                                value="{{ $data['penggajian']->jumlah_insentif }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="status_pegawai" class="form-label">Status Pegawai</label>
                        <input type="text" class="form-control" readonly class="form-control"
                            value="{{ $data['pegawai']->status_pegawai }}">
                    </div>
                    <div class="col-md-4">
                        <label for="masa_kerja" class="form-label">Masa Kerja (tahun)</label>
                        <input type="number" class="form-control" readonly class="form-control"
                            value="{{ $data['pegawai']->masa_kerja_tahun }}">
                    </div>
                    <div class="col-md-6">
                        <label for="lembur" class="form-label">Jumlah Lembur</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="jumlah_lembur" readonly class="form-control"
                                value="{{ $data['penggajian']->jumlah_lembur }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="lama_lembur" class="form-label">Lama Lembur (jam)</label>
                        <input type="number" class="form-control" readonly class="form-control"
                            value="{{ $data['penggajian']->lama_lembur }}">
                    </div>
                    <hr class="mb-0">

                    <!-- Potongan Gaji -->
                    <div><strong>Potongan Gaji</strong></div>
                    <div class="col-md-4">
                        <label for="jumlah_nwnp" class="form-label">Jumlah NWNP</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="jumlah_nwnp" readonly class="form-control"
                                value="{{ $data['penggajian']->jumlah_potongan_nwnp }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="kehadiran" class="form-label">Hadir</label>
                        <input type="number" name="kehadiran" readonly class="form-control"
                            value="{{ $data['penggajian']->kehadiran }}">
                    </div>
                    <div class="col-md-2">
                        <label for="alpha" class="form-label">Alpha</label>
                        <input type="number" name="alpha" readonly class="form-control"
                            value="{{ $data['penggajian']->alpha }}">
                    </div>
                    <div class="col-md-2">
                        <label for="izin" class="form-label">Absen</label>
                        <input type="number" name="izin" readonly class="form-control"
                            value="{{ $data['penggajian']->absen }}">
                    </div>
                    <div class="col-md-2">
                        <label for="cuti" class="form-label">Cuti</label>
                        <input type="number" name="cuti" readonly class="form-control"
                            value="{{ $data['penggajian']->cuti }}">
                    </div>
                    <div class="col-md-6">
                        <label for="bpjs" class="form-label">BPJS (3%)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="bpjs" readonly class="form-control"
                                value="{{ $data['penggajian']->jumlah_potongan_bpjs }}">
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
                            <input type="number" readonly class="form-control"
                                value="{{ $data['penggajian']->jumlah_penambah_gaji }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="komponen_pengurang_gaji" class="form-label">Komponen Pengurang Gaji</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" readonly
                                value="{{ $data['penggajian']->jumlah_potongan_gaji }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="total_gaji" class="form-label">Total Gaji</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="total_gaji" readonly
                                value="{{ $data['penggajian']->total_gaji }}">
                        </div>
                    </div>
                    <hr class="mb-0">

                    <!-- Persetujuan -->
                    <div><strong>Persetujuan Penggajian</strong></div>
                    <div class="col-md-12">
                        <ul class="pl-1 m-0">
                            <li><strong>Dibuat oleh: </strong> {{ $data['penggajian']->dibuatOleh->name }}</li>
                            <li><strong>Disetujui oleh: </strong>{{ $data['penggajian']->disetujuiOleh->name ?? '-' }}
                            </li>
                            <li><strong>Dibatalkan oleh: </strong> {{ $data['penggajian']->dibatalkanOleh->name ?? '-'
                                }}
                            </li>
                            <li><strong>Dibuat pada: </strong>
                                {{ date('Y-m-d H:i:s T',strtotime($data['penggajian']->created_at)) ?? '-' }}
                            </li>
                            <li><strong>Diperbarui pada: </strong>
                                {{ date('Y-m-d H:i:s T',strtotime($data['penggajian']->updated_at)) ?? '-' }}
                            </li>
                        </ul>
                    </div>
                    <hr class="mb-0">

                    <div class=" col-sm-8">
                        @role ('supervisor-payroll')
                        <button type="submit" class="btn btn-success">Ubah Status</button>
                        @endrole
                        <a href="{{ route('penggajian.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                    {{ html()->form()->close() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection