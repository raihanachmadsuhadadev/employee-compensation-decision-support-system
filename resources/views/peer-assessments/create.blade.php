@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="bx bx-user-check fs-3"></i>
                        </span>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1">Input Peer Assessment</h3>
                        <p class="text-muted mb-0">Berikan penilaian untuk rekan satu divisi sesuai aspek yang tersedia.</p>
                    </div>
                </div>
                <a href="{{ route('peer.index', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                    class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <span class="text-muted small">Karyawan Dinilai</span>
                        <h5 class="fw-semibold mb-0">{{ $assessee->full_name }}</h5>
                    </div>
                    <div class="col-md-4">
                        <span class="text-muted small">Divisi</span>
                        <h5 class="fw-semibold mb-0">{{ $assessee->division?->name ?? '-' }}</h5>
                    </div>
                    <div class="col-md-4">
                        <span class="text-muted small">Periode</span>
                        <h5 class="fw-semibold mb-0">{{ $bulanList[$bulan] }} {{ $tahun }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded">
            <div class="card-body p-0">
                <form method="POST" action="{{ route('peer.store') }}">
                    @csrf
                    <input type="hidden" name="assessee_id" value="{{ $assessee->id }}">
                    <input type="hidden" name="bulan" value="{{ $bulan }}">
                    <input type="hidden" name="tahun" value="{{ $tahun }}">

                    <div class="table-responsive" style="white-space:nowrap;max-height:65vh;overflow:auto;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="min-width:320px;">Aspek</th>
                                    <th style="width:240px;">Skor (1-10)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aspeks as $a)
                                    <tr>
                                        <td class="fw-semibold">{{ $a->nama }}</td>
                                        <td>
                                            <select name="score[{{ $a->id }}]" class="form-select" required>
                                                <option value="" selected disabled>Pilih skor</option>
                                                @foreach ($scale as $val => $label)
                                                    <option value="{{ $val }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end border-top p-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i> Kirim Penilaian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
