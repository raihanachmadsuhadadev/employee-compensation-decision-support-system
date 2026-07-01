@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-show fs-3"></i>
                        </span>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1">Detail Realisasi KPI Umum</h3>
                        <p class="text-muted mb-0">
                            {{ $real->user->full_name }} - {{ $real->user->division?->name ?? '-' }} -
                            {{ $bulanList[$real->bulan] ?? $real->bulan }} {{ $real->tahun }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('realisasi-kpi-umum.index', ['bulan' => $real->bulan, 'tahun' => $real->tahun, 'division_id' => request('division_id')]) }}"
                    class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>

        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                @if ($real->status === 'stale')
                    <div class="alert alert-secondary">
                        Realisasi ini <strong>tidak valid</strong> karena terjadi perubahan data KPI.
                        Mohon leader melakukan <strong>Input Ulang</strong> untuk periode ini.
                    </div>
                @endif
                <div class="row g-3">
                    <div class="col-md-6">
                        <span class="text-muted small d-block mb-1">Status</span>
                        @if ($real->status === 'approved')
                            <span class="badge bg-label-success">Approved</span>
                        @elseif($real->status === 'submitted')
                            <span class="badge bg-label-warning">Menunggu</span>
                        @else
                            <span class="badge bg-label-danger">Rejected</span>
                            @if ($real->hr_note)
                                <small class="text-danger d-block">Alasan: {{ $real->hr_note }}</small>
                            @endif
                        @endif
                    </div>
                    <div class="col-md-6">
                        <span class="text-muted small d-block mb-1">Skor Total</span>
                        <span class="badge bg-label-primary fs-6">
                            {{ rtrim(rtrim(number_format(round($real->total_score, 2), 2, '.', ''), '0'), '.') }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded">
            <div class="card-body p-0">
                <div class="table-responsive" style="overflow-y:auto; max-height:65vh;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama KPI</th>
                                <th>Tipe</th>
                                <th>Satuan</th>
                                <th class="text-end">TARGET</th>
                                <th class="text-end">REALISASI</th>
                                <th class="text-end">SKOR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($real->items as $it)
                                <tr>
                                    <td class="fw-semibold">{{ $it->kpi?->nama ?? '-' }}</td>
                                    <td><span class="badge bg-label-secondary text-capitalize">{{ $it->tipe }}</span></td>
                                    <td>{{ $it->satuan ?? '-' }}</td>
                                    <td class="text-end">
                                        {{ rtrim(rtrim(number_format($it->target, 2, '.', ''), '0'), '.') }}
                                    </td>
                                    <td class="text-end">
                                        {{ rtrim(rtrim(number_format($it->realisasi, 2, '.', ''), '0'), '.') }}
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-label-primary">
                                            {{ rtrim(rtrim(number_format(round($it->score, 2), 2, '.', ''), '0'), '.') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($me->role === 'hr' && $real->status === 'submitted')
                    <div class="d-flex justify-content-end border-top p-3 gap-2">
                        <form method="POST" action="{{ route('realisasi-kpi-umum.approve', $real->id) }}"
                            class="js-approve">
                            @csrf
                            <button type="submit" class="btn btn-success"><i class="bx bx-check me-1"></i> ACC</button>
                        </form>

                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="bx bx-x me-1"></i> Tolak
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Reject --}}
    @if ($me->role === 'hr' && $real->status === 'submitted')
        <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" method="POST" action="{{ route('realisasi-kpi-umum.reject', $real->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tolak Realisasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Keterangan</label>
                        <textarea name="hr_note" class="form-control" rows="4" required placeholder="Alasan penolakan..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
        });

        // Konfirmasi ACC
        document.querySelector('form.js-approve')?.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'ACC realisasi ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, ACC',
                cancelButtonText: 'Batal'
            }).then(res => {
                if (res.isConfirmed) e.target.submit();
            });
        });

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: @json(session('success'))
            });
        @endif
        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: @json(session('error'))
            });
        @endif
        function rejectReal() {
            Swal.fire({
                title: 'Alasan Penolakan',
                input: 'textarea',
                inputPlaceholder: 'Tuliskan alasan...',
                showCancelButton: true,
                confirmButtonText: 'Tolak',
                cancelButtonText: 'Batal'
            }).then(res => {
                if (res.isConfirmed && res.value) {
                    document.getElementById('hr_note').value = res.value;
                    document.getElementById('rejectForm').submit();
                } else if (res.isConfirmed) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Alasan wajib diisi',
                        timer: 1800,
                        showConfirmButton: false
                    });
                }
            });
        }
    </script>
@endpush
