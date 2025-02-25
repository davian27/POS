@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<div class="container">
    <h1 class="h3 mb-4 mt-4">Daftar Barang</h1>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
            Tambah Barang
        </button>

        <!-- Form Search -->
        <form action="{{ route('items.index') }}" method="GET" class="d-flex align-items-center border p-2 rounded">
            <div class="input-group">
                <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Cari barang..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Tampilkan Daftar Barang dalam Card -->
    <div class="row">
        @forelse($items as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-img-top" style="height: 200px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $item->photo) }}" class="img-fluid w-100 h-100 object-fit-cover" alt="{{ $item->name }}">
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($item->description, 100) }}</p>
                    <p class="card-text"><strong>Harga:</strong> Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    <p class="card-text"><strong>Stok:</strong> {{ $item->stock }}</p>
                    <p class="card-text"><strong>Kategori:</strong> {{ implode(', ', $item->categories->pluck('name')->toArray()) }}</p>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="#" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#showModal{{ $item->id }}">Lihat</a>
                        <a href="#" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">Edit</a>
                        <a href="#" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">Hapus</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Show -->
        <div class="modal fade" id="showModal{{ $item->id }}" tabindex="-1" aria-labelledby="showModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showModalLabel{{ $item->id }}">Detail Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @if ($item->photo)
                                <div class="col-md-4 text-center">
                                    <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" class="img-fluid rounded mb-3">
                                </div>
                            @endif
                            <div class="col-md-8">
                                <div>
                                    <p><strong>Nama:</strong> {{ $item->name }}</p>
                                    <p><strong>Harga:</strong> Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    <p><strong>Deskripsi:</strong> {{ $item->description }}</p>
                                    <p><strong>Stok:</strong> {{ $item->stock }}</p>
                                    <p class="card-text"><strong>Kategori:</strong> {{ implode(', ', $item->categories->pluck('name')->toArray()) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name{{ $item->id }}" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name{{ $item->id }}" name="name" value="{{ $item->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="sku{{ $item->id }}" class="form-label">SKU</label>
                        <input type="text" class="form-control" id="sku{{ $item->id }}" name="sku" value="{{ $item->sku }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="photo{{ $item->id }}" class="form-label">Foto</label>
                        <div class="mb-2">
                            @if ($item->photo)
                                <img src="{{ asset('storage/' . $item->photo) }}" alt="Preview Foto" class="img-thumbnail" style="width: 100px; height: 100px;">
                            @else
                                <p class="text-muted">Tidak ada foto</p>
                            @endif
                        </div>
                        <input type="file" class="form-control" id="photo{{ $item->id }}" name="photo">
                    </div>
                    <div class="mb-3">
                        <label for="stock{{ $item->id }}" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stock{{ $item->id }}" name="stock" value="{{ $item->stock }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="price{{ $item->id }}" class="form-label">Harga</label>
                        <input type="text" class="form-control" id="price{{ $item->id }}" name="price" value="{{ $item->price }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-gray-700">Kategori</label>
                        <select name="categories[]" id="categories-edit-{{ $item->id }}" class="categories px-3 py-5 border rounded js-example-basic-multiple @error('categories') border-red-500 @enderror"
                            style="width: 100% js-example-basic-multiple" multiple="multiple">
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ in_array($category->id, $item->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('categories')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description{{ $item->id }}" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description{{ $item->id }}" name="description" required>{{ $item->description }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

        <!-- Modal Hapus -->
        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Konfirmasi Hapus Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus barang <strong>{{ $item->name }}</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <div class="d-flex justify-content-center">
                <i class="bi bi-x-circle-fill text-danger" style="font-size: 100px;"></i>
            </div>
            <p>Tidak ada barang yang ditemukan</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Tambah Item -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Tambah Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="sku" class="form-label">SKU</label>
                        <input type="text" class="form-control" id="sku" name="sku" required>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stock" name="stock" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-gray-700">Kategori</label>
                        <select name="categories[]" id="categories-new"
                            class="categories px-3 py-5 border rounded js-example-basic-multiple @error('categories') border-red-500 @enderror"
                            style="width: 100%" multiple="multiple">
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('categories')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2({
        placeholder: "Pilih kategori",
        allowClear: true
    });

    // Terapkan Select2 untuk setiap modal edit yang terbuka
    $('.modal').on('shown.bs.modal', function() {
        $(this).find('.js-example-basic-multiple').select2({
            placeholder: "Pilih kategori",
            allowClear: true,
            dropdownParent: $(this)
        });
    });
});

</script>

@endsection