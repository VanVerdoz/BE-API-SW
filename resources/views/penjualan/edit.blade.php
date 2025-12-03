@extends('layouts.app')

@section('title', 'Edit Transaksi Penjualan')

@push('styles')
<style>
    .form-container {
        background: var(--surface);
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--shadow-sm);
        max-width: 720px;
        border: 1px solid var(--border);
        color: var(--text);
    }
    .page-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 20px;
        color: var(--text);
    }
    .form-group { margin-bottom: 16px; }
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 6px;
        color: var(--text);
    }
    .form-control, .form-select {
        width: 100%;
        padding: 10px 12px;
        border-radius: 10px;
        border: 1px solid var(--border);
        font-size: 14px;
        background: var(--surface);
        color: var(--text);
    }
    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #ff6b35;
        box-shadow: 0 0 0 2px rgba(255,107,53,0.15);
    }
    .form-text {
        font-size: 12px;
        color: var(--muted);
    }
    .form-actions {
        margin-top: 20px;
        display: flex;
        gap: 10px;
    }
    .btn {
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 14px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }
    .btn-primary {
        background: linear-gradient(135deg,#ff6b35,#f7931e);
        color: #fff;
    }
    .btn-secondary {
        background: #6c757d;
        color: #fff;
    }
</style>
@endpush

@section('content')
<h2 class="page-title">Edit Transaksi Penjualan</h2>

<div class="form-container">
    <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Cabang</label>
            <select name="cabang_id" class="form-select" required>
                <option value="">-- Pilih Cabang --</option>
                @foreach($cabang as $cb)
                    <option value="{{ $cb->id }}" {{ old('cabang_id', $penjualan->cabang_id) == $cb->id ? 'selected' : '' }}>
                        {{ $cb->nama_cabang ?? 'Cabang '.$cb->id }}
                    </option>
                @endforeach
            </select>
            @error('cabang_id')
                <div class="form-text" style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Tanggal Transaksi</label>
            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', \Carbon\Carbon::parse($penjualan->tanggal)->format('Y-m-d')) }}" required>
            @error('tanggal')
                <div class="form-text" style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-select" required>
                <option value="">-- Pilih Metode --</option>
                @php $metode = old('metode_pembayaran', $penjualan->metode_pembayaran); @endphp
                <option value="tunai" {{ $metode=='tunai' ? 'selected' : '' }}>Tunai</option>
                <option value="transfer" {{ $metode=='transfer' ? 'selected' : '' }}>Transfer</option>
                <option value="qris" {{ $metode=='qris' ? 'selected' : '' }}>QRIS</option>
            </select>
            @error('metode_pembayaran')
                <div class="form-text" style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Total Pembayaran (Rp)</label>
            <input type="number" name="total" class="form-control" value="{{ old('total', $penjualan->total) }}" min="0" step="100" required>
            @error('total')
                <div class="form-text" style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Keterangan (opsional)</label>
            <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $penjualan->keterangan) }}</textarea>
            @error('keterangan')
                <div class="form-text" style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Update Transaksi
            </button>
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
