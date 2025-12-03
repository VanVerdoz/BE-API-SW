@extends('layouts.app')

@section('title', 'Tambah Pengguna')

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
        color: #333;
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
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        max-width: 600px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
    }

    .form-label .required {
        color: #ff6b35;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s;
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
    <h2 class="page-title">Tambah Pengguna Baru</h2>
    <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Kembali
    </a>
</div>

<div class="form-container">
    <form action="{{ route('pengguna.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">
                Nama Lengkap <span class="required">*</span>
            </label>
            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') error @enderror" 
                   value="{{ old('nama_lengkap') }}" required>
            @error('nama_lengkap')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                Username <span class="required">*</span>
            </label>
            <input type="text" name="username" class="form-control @error('username') error @enderror" 
                   value="{{ old('username') }}" required>
            @error('username')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                Password <span class="required">*</span>
            </label>
            <input type="password" name="password" class="form-control @error('password') error @enderror" required>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                Role <span class="required">*</span>
            </label>
            <select name="role" class="form-control @error('role') error @enderror" required>
                <option value="">Pilih Role</option>
                <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="kepala_gudang" {{ old('role') == 'kepala_gudang' ? 'selected' : '' }}>Kepala Gudang</option>
                <option value="raider" {{ old('role') == 'raider' ? 'selected' : '' }}>Raider</option>
            </select>
            @error('role')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                Status <span class="required">*</span>
            </label>
            <select name="status" class="form-control @error('status') error @enderror" required>
                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
            @error('status')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Simpan
            </button>
            <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

