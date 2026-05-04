@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Tambah User Baru</h5>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="Masukkan nama lengkap">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="Masukkan email">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Masukkan password">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">No. HP</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone') }}" placeholder="Masukkan nomor HP">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat</label>
                <textarea name="address" class="form-control" rows="2"
                          placeholder="Masukkan alamat">{{ old('address') }}</textarea>
            </div>

            <!-- Hobi Section -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Daftar Hobi</label>
                <div id="hobbies-container">
                    <div class="input-group mb-2">
                        <input type="text" name="hobbies[]" class="form-control" placeholder="Masukkan hobi">
                        <button type="button" class="btn btn-success btn-add-hobby">
                            +
                        </button>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Tambah
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('click', function(e) {
    // Tambah field hobi
    if (e.target.closest('.btn-add-hobby')) {
        const container = document.getElementById('hobbies-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" name="hobbies[]" class="form-control" placeholder="Hobi">
            <button type="button" class="btn btn-danger btn-remove-hobby">
                -
            </button>
        `;
        container.appendChild(div);
    }
    // Hapus field hobi
    if (e.target.closest('.btn-remove-hobby')) {
        e.target.closest('.input-group').remove();
    }
});
</script>
@endsection