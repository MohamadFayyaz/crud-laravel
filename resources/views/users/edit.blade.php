@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Edit User: {{ $user->name }}</h5>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Password Baru <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password baru">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">No. HP</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone', $user->phone) }}" placeholder="Masukkan nomor HP">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Masukkan alamat">{{ old('address', $user->address) }}</textarea>
            </div>

            <!-- Hobi Section -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Daftar Hobi</label>
                <div id="hobbies-container">
                    @forelse($user->hobbies as $hobby)
                    <div class="input-group mb-2">
                        <input type="text" name="hobbies[]" class="form-control" value="{{ $hobby->name }}">
                        <button type="button" class="btn btn-danger btn-remove-hobby">
                            -
                        </button>
                    </div>
                    @empty
                    <div class="input-group mb-2">
                        <input type="text" name="hobbies[]" class="form-control" placeholder="Masukkan hobi">
                        <button type="button" class="btn btn-success btn-add-hobby">
                            +
                        </button>
                    </div>
                    @endforelse
                </div>
                <button type="button" class="btn btn-sm btn-outline-success btn-add-hobby">
                    + Tambah Hobi
                </button>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    Simpan
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
    if (e.target.closest('.btn-remove-hobby')) {
        e.target.closest('.input-group').remove();
    }
});
</script>
@endsection