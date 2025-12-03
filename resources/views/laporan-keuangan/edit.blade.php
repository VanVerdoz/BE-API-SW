@extends('layouts.app')

@section('title', 'Edit Laporan Keuangan')

@push('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        color: var(--text);
        font-weight: 600;
    }

    .btn {
        padding: 12px 25px;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .form-container {
        background: var(--surface);
        padding: 30px;
        border-radius: 20px;
        box-shadow: var(--shadow-sm);
        max-width: 600px;
        border: 1px solid var(--border);
        color: var(--text);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: var(--text);
        margin-bottom: 8px;
    }

    .form-label .required {
        color: #ff6b35;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid var(--border);
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s;
        background: var(--surface);
        color: var(--text);
    }

    .form-control:focus {
        outline: none;
        border-color: #ff6b35;
        box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
    }

    .form-control.error {
        border-color: #f44336;
    }

    .error-message {
        color: #f44336;
        font-size: 12px;
        margin-top: 5px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }

    select.form-control {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h2 class="page-title">Edit Laporan Keuangan</h2>
    <a href="{{ route('laporan-keuangan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="form-container">
    <form action="{{ route('laporan-keuangan.update', $laporan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">
                Cabang <span class="required">*</span>
            </label>
            <select name="cabang_id" class="form-control @error('cabang_id') error @enderror" required>
                <option value="">Pilih Cabang</option>
                @foreach($cabang as $item)
                <option value="{{ $item->id }}" {{ old('cabang_id', $laporan->cabang_id) == $item->id ? 'selected' : '' }}>
                    {{ $item->nama_cabang }}
                </option>
                @endforeach
            </select>
            @error('cabang_id')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                Periode Awal <span class="required">*</span>
            </label>
            <input type="date" name="periode_awal" class="form-control @error('periode_awal') error @enderror" 
                   value="{{ old('periode_awal', $laporan->periode_awal) }}" required>
            @error('periode_awal')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                Periode Akhir <span class="required">*</span>
            </label>
            <input type="date" name="periode_akhir" class="form-control @error('periode_akhir') error @enderror"
                   value="{{ old('periode_akhir', $laporan->periode_akhir) }}" required>
            @error('periode_akhir')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                Total Pendapatan <span class="required">*</span>
            </label>
            <input type="number" name="total_pendapatan" class="form-control @error('total_pendapatan') error @enderror"
                   value="{{ old('total_pendapatan', $laporan->total_pendapatan) }}" step="0.01" required>
            @error('total_pendapatan')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Update
            </button>
            <a href="{{ route('laporan-keuangan.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
