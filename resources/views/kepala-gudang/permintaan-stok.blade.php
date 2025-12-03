@extends('layouts.app')

@section('title', 'Permintaan Stok – Pilih Cabang')

@push('styles')
<style>
    .page-title { font-size: 24px; font-weight: 600; margin-bottom: 14px; color: var(--text); }
    .branch-section { background: var(--surface); border-radius: 16px; box-shadow: var(--shadow-sm); margin-bottom: 18px; border: 1px solid var(--border); color: var(--text); }
    .branch-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid var(--border); }
    .branch-title { font-size: 16px; font-weight: 600; color: var(--text); }
    .req-table { width: 100%; border-collapse: collapse; }
    .req-table th, .req-table td { padding: 12px 16px; border-bottom: 1px solid var(--border); font-size: 14px; color: var(--text); }
    .req-table th { background: var(--table-head); color: var(--text); text-align: left; }
    .btn-small { padding: 8px 10px; font-size: 12px; border-radius: 8px; }
    .status-badge { display:inline-block; padding:6px 10px; border-radius:10px; font-size:12px; }
    .status-pending { background: var(--surface); color: #f59e0b; border:1px solid #f59e0b; }
    .status-disetujui { background: var(--surface); color: #10b981; border:1px solid #10b981; }
    .req-actions { display: flex; gap: 8px; flex-wrap: wrap; }

    @media (max-width: 768px) {
        .page-title { font-size: 20px; }
        .branch-header { padding: 12px 14px; }
        .branch-title { font-size: 15px; }
        .req-actions { flex-direction: column; }
        .req-actions .btn { width: 100%; justify-content: center; }
    }
    @media (max-width: 640px) {
        .req-table thead { display: none; }
        .req-table { border: 0; }
        .req-table, .req-table tbody { display: block; width: 100%; }
        .req-table tr { display: block; margin-bottom: 12px; border: 1px solid var(--border); border-radius: 12px; background: var(--surface); box-shadow: var(--shadow-sm); padding: 8px; }
        .req-table td { display: inline-block; margin: 0 4px 8px; white-space: normal; padding: 8px 10px; border-bottom: 0; vertical-align: top; }
        .req-table td[data-label="Raider"] { display: none; }
        .req-table td[data-label="No"],
        .req-table td[data-label="Produk"],
        .req-table td[data-label="Jumlah"] { width: calc(33.33% - 8px); }
        .req-table td[data-label="Tanggal"],
        .req-table td[data-label="Status"],
        .req-table td[data-label="Aksi"] { width: calc(33.33% - 8px); }
        .req-actions { flex-direction: column; }
        .req-actions .btn { width: 100%; justify-content: center; }
        .req-table td[data-label="Aksi"] { display: block; width: 100%; }
        .req-table td::before { content: attr(data-label); display: block; font-weight: 600; color: var(--muted); margin-bottom: 4px; }
    }
</style>
@endpush

@section('content')
<h2 class="page-title">Permintaan Stok – Pilih Cabang</h2>

<div class="branch-section">
    <div class="branch-header">
        <div class="branch-title">Daftar Cabang</div>
    </div>
    <div style="padding:12px 16px;">
        <table class="req-table">
            <thead>
                <tr>
                    <th>Cabang</th>
                    <th>Alamat</th>
                    <th>Rider dengan Permintaan</th>
                    <th>Permintaan Pending</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cabangList as $row)
                    @php $cb = $row['cabang']; @endphp
                    <tr>
                        <td data-label="Cabang">{{ $cb->nama_cabang ?? '-' }}</td>
                        <td data-label="Alamat">{{ $cb->alamat ?? '-' }}</td>
                        <td data-label="Rider">{{ $row['riders'] }}</td>
                        <td data-label="Pending">{{ $row['pending'] }}</td>
                        <td data-label="Aksi">
                            <div class="req-actions">
                                <a href="{{ route('kepala.permintaan-stok.cabang', $cb->id) }}" class="btn btn-primary btn-small">
                                    <i class="fas fa-users"></i> Lihat Detail Rider
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">Belum ada permintaan stok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
