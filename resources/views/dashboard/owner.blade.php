@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @php
            $periodeText = ($bulanList[$bulan] ?? $bulan) . ' ' . $tahun;
            $summary = $ownerSummary ?? [];
            $kpiUmumStatus = $summary['kpiUmumStatus'] ?? [];
            $distributionStatus = $summary['kpiDivisiDistributionStatus'] ?? [];
            $peerAssessment = $summary['peerAssessment'] ?? ['total' => 0, 'submitted' => 0];
            $statCards = [
                [
                    'label' => 'Total Karyawan',
                    'value' => $summary['totalKaryawan'] ?? 0,
                    'icon' => 'bx-group',
                    'tone' => 'primary',
                ],
                [
                    'label' => 'Total Divisi',
                    'value' => $summary['totalDivisi'] ?? 0,
                    'icon' => 'bx-building-house',
                    'tone' => 'info',
                ],
                [
                    'label' => 'KPI Umum',
                    'value' => $summary['totalKpiUmum'] ?? 0,
                    'icon' => 'bx-data',
                    'tone' => 'success',
                ],
                [
                    'label' => 'KPI Divisi',
                    'value' => $summary['totalKpiDivisi'] ?? 0,
                    'icon' => 'bx-bar-chart-alt',
                    'tone' => 'warning',
                ],
            ];
            $insights = [
                [
                    'label' => 'Leaderboard',
                    'text' => 'Lihat ranking performa karyawan dan divisi.',
                    'route' => route('leaderboard.bulanan.index', ['bulan' => $bulan, 'tahun' => $tahun]),
                    'icon' => 'bx-trophy',
                ],
                [
                    'label' => 'Rekomendasi Bonus',
                    'text' => 'Buka hasil rekomendasi bonus periode aktif.',
                    'route' => route('bonus.rekomendasi.index', ['bulan' => $bulan, 'tahun' => $tahun]),
                    'icon' => 'bx-gift',
                ],
                [
                    'label' => 'Kenaikan Gaji',
                    'text' => 'Tinjau rekomendasi kenaikan gaji tahunan.',
                    'route' => route('salary.raise.index', ['tahun' => $tahun]),
                    'icon' => 'bx-money',
                ],
            ];
        @endphp

        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex flex-column flex-lg-row justify-content-between gap-3">
                        <div>
                            <div class="text-muted small mb-1">Dashboard Owner</div>
                            <h4 class="mb-1">Ringkasan Performa Perusahaan</h4>
                            <p class="mb-0 text-muted">
                                Pantau performa karyawan, divisi, dan kesiapan data SPK pada periode aktif.
                            </p>
                        </div>
                        <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-2">
                            <select name="bulan" class="form-select form-select-sm w-auto">
                                @foreach ($bulanList as $num => $label)
                                    <option value="{{ $num }}" {{ (int) $bulan === (int) $num ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" name="tahun" value="{{ $tahun }}"
                                class="form-control form-control-sm w-auto" style="width:90px" min="2000" max="2100">
                            <button class="btn btn-sm btn-primary">
                                <i class="bx bx-filter me-1"></i> Filter
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @foreach ($statCards as $card)
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center gap-3">
                            <span class="avatar-initial rounded bg-label-{{ $card['tone'] }} p-3">
                                <i class="bx {{ $card['icon'] }} fs-4"></i>
                            </span>
                            <div>
                                <div class="text-muted small">{{ $card['label'] }}</div>
                                <h4 class="mb-0">{{ number_format($card['value']) }}</h4>
                                <small class="text-muted">{{ $periodeText }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12 col-xl-8">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="card-title mb-1"><i class="bx bx-trophy me-1"></i>Top 5 Karyawan Global</h6>
                            <small class="text-muted">Periode {{ $periodeText }}</small>
                        </div>
                        <a href="{{ route('leaderboard.bulanan.index', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-right-arrow-alt me-1"></i> Detail
                        </a>
                    </div>
                    <div class="card-body pb-2">
                        <div class="table-responsive">
                            <table class="table-sm mb-0 table align-middle">
                                <thead>
                                    <tr class="text-muted text-uppercase small">
                                        <th style="width:56px;">Rank</th>
                                        <th>Nama</th>
                                        <th>Divisi</th>
                                        <th class="text-end" style="width:90px;">Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($topGlobal as $row)
                                        <tr>
                                            <td class="fw-semibold">{{ $row['rank'] }}</td>
                                            <td class="fw-semibold">{{ $row['name'] }}</td>
                                            <td>{{ $row['division'] }}</td>
                                            <td class="text-end">{{ number_format($row['score'], 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-muted py-4 text-center">
                                                Belum ada data pada periode ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="card-title mb-0"><i class="bx bx-check-shield me-1"></i>Status Data Periode</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">KPI umum approved</span>
                            <span class="fw-semibold text-success">{{ number_format($kpiUmumStatus['approved'] ?? 0) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Distribusi approved</span>
                            <span class="fw-semibold text-success">{{ number_format($distributionStatus['approved'] ?? 0) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Peer submitted</span>
                            <span class="fw-semibold text-success">{{ number_format($peerAssessment['submitted'] ?? 0) }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Peer total</span>
                            <span class="fw-semibold">{{ number_format($peerAssessment['total'] ?? 0) }}</span>
                        </div>
                    </div>
                    <div class="card-footer small text-muted">Periode: {{ $periodeText }}</div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12 col-xl-7">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h6 class="card-title mb-1"><i class="bx bx-building-house me-1"></i>Top 5 Divisi</h6>
                            <small class="text-muted">Berdasarkan rata-rata KPI divisi</small>
                        </div>
                        <a href="{{ route('leaderboard.divisi-kpi.index', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                            class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-right-arrow-alt me-1"></i> Detail
                        </a>
                    </div>
                    <div class="card-body pb-2">
                        <div class="table-responsive">
                            <table class="table-sm mb-0 table align-middle">
                                <thead>
                                    <tr class="text-muted text-uppercase small">
                                        <th style="width:56px;">Rank</th>
                                        <th>Divisi</th>
                                        <th class="text-end" style="width:90px;">Avg</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($topDivisi as $row)
                                        <tr>
                                            <td class="fw-semibold">{{ $row['rank'] }}</td>
                                            <td class="fw-semibold">{{ $row['division'] }}</td>
                                            <td class="text-end">{{ number_format($row['score'], 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted py-4 text-center">
                                                Belum ada data pada periode ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-5">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="card-title mb-0"><i class="bx bx-line-chart me-1"></i>Portfolio Insight</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach ($insights as $insight)
                                <div class="col-12">
                                    <a href="{{ $insight['route'] }}"
                                        class="d-flex align-items-center gap-3 rounded border p-3 text-body">
                                        <span class="avatar-initial rounded bg-label-primary p-2">
                                            <i class="bx {{ $insight['icon'] }} fs-4"></i>
                                        </span>
                                        <span class="flex-grow-1">
                                            <span class="d-block fw-semibold">{{ $insight['label'] }}</span>
                                            <span class="d-block small text-muted">{{ $insight['text'] }}</span>
                                        </span>
                                        <i class="bx bx-chevron-right fs-4 text-muted"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
