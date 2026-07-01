@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bx bx-git-branch me-1"></i>Input Distribusi Target KPI Divisi - {{ $kpi->nama }} ({{ $bulanList[$kpi->bulan] }} {{ $kpi->tahun }})
                </h5>
                <a href="{{ route('distribusi-kpi-divisi.index', ['bulan' => $kpi->bulan, 'tahun' => $kpi->tahun, 'division_id' => $kpi->division_id]) }}"
                    class="btn btn-sm btn-outline-secondary"><i class="bx bx-arrow-back me-1"></i>Kembali</a>
            </div>

            <div class="card-body">
                @if ($distribution->status === 'approved')
                    <div class="alert alert-info">
                        Distribusi saat ini <strong>approved</strong>. Menyimpan perubahan akan <strong>mengajukan
                            revisi</strong> (status menjadi
                        <em>submitted</em>) dan realisasi terkait akan ditandai <em>stale</em>.
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('distribusi-kpi-divisi.store') }}">
                    @csrf
                    <input type="hidden" name="kpi_id" value="{{ $kpi->id }}">

                    <div class="small text-muted mb-3">
                        Target KPI: <strong>{{ rtrim(rtrim(number_format($kpi->target, 2, '.', ''), '0'), '.') }}
                            {{ $kpi->satuan }}</strong>
                    </div>

                    <div class="table-responsive" style="max-height:65vh; overflow:auto;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Karyawan</th>
                                    <th class="text-end" style="width:220px;">Target</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $sum = 0; @endphp
                                @foreach ($employees as $emp)
                                    @php
                                        $v = (float) ($existing[$emp->id] ?? 0);
                                        $sum += $v;
                                    @endphp
                                    <tr>
                                        <td class="fw-semibold">{{ $emp->full_name }}</td>
                                        <td>
                                            <input type="number" step="0.01" name="alloc[{{ $emp->id }}]"
                                                class="form-control alloc text-end" value="{{ $v }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-top mt-3 pt-3">
                        <div class="small text-muted">
                            Total alokasi: <span
                                id="sum">{{ rtrim(rtrim(number_format($sum, 2, '.', ''), '0'), '.') }}</span>
                            / {{ rtrim(rtrim(number_format($kpi->target, 2, '.', ''), '0'), '.') }}
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Ajukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function recalc() {
            let s = 0;
            document.querySelectorAll('.alloc').forEach(i => s += parseFloat(i.value || 0));
            document.getElementById('sum').textContent = (Math.round(s * 100) / 100).toString();
        }
        document.querySelectorAll('.alloc').forEach(i => i.addEventListener('input', recalc));
    </script>
@endpush
