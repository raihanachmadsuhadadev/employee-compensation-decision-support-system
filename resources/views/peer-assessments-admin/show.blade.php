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
                        <h3 class="fw-bold mb-1">Detail Peer Assessment</h3>
                        <p class="text-muted mb-0">
                            {{ $user->full_name }} - {{ $user->division?->name ?? '-' }} -
                            {{ $bulanList[$bulan] ?? $bulan }} {{ $tahun }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('peer.admin.index', ['bulan' => $bulan, 'tahun' => $tahun, 'division_id' => request('division_id')]) }}"
                    class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>

        </div>

        <div class="card border-0 shadow-sm rounded">
            <div class="card-body p-0">
                @if ($assessments->isEmpty())
                    <div class="text-muted py-5 text-center">
                        <i class="bx bx-user-check d-block mb-2 fs-3"></i>
                        Belum ada penilaian yang masuk.
                    </div>
                @else
                    <div class="border-bottom p-3">
                        <h6 class="fw-semibold mb-1">Nilai per Penilai</h6>
                        <p class="text-muted mb-0">Rekap skor setiap penilai untuk karyawan terpilih.</p>
                    </div>
                    <div class="table-responsive" style="white-space:nowrap;">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:220px">Penilai</th>
                                    @foreach ($columns as $c)
                                        <th class="text-center">{{ $c['label'] }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assessments as $a)
                                    @php $row = $itemsMatrix[$a->id] ?? []; @endphp
                                    <tr>
                                        <td>{{ $a->assessor?->full_name ?? '#' . $a->assessor_id }}</td>
                                        @foreach ($columns as $c)
                                            @php $sc = $row[$c['key']] ?? null; @endphp
                                            <td class="text-center">{{ $sc !== null ? $sc : '-' }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="border-top border-bottom p-3">
                        <h6 class="fw-semibold mb-1">Rata-rata per Aspek</h6>
                        <p class="text-muted mb-0">Ringkasan nilai rata-rata yang digunakan pada proses penilaian.</p>
                    </div>
                    <div class="table-responsive" style="white-space:nowrap;">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    @foreach ($columns as $c)
                                        <th class="text-center">{{ $c['label'] }}</th>
                                    @endforeach
                                    <th class="text-center">Rata-rata Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($columns as $c)
                                        @php $val = $avgPerKey[$c['key']] ?? null; @endphp
                                        <td class="text-center">
                                            {{ $val !== null ? rtrim(rtrim(number_format($val, 2, '.', ''), '0'), '.') : '-' }}
                                        </td>
                                    @endforeach
                                    <td class="text-center">
                                        {{ $avgTotal !== null ? rtrim(rtrim(number_format($avgTotal, 2, '.', ''), '0'), '.') : '-' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
