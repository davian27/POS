@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="h3 mb-4 text-gray-800">Daftar Transaksi</h1>

    <!-- Tombol Tambah Transaksi -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal" onclick="resetForm()">
            Tambah Transaksi
        </button>
    </div>

    <!-- Tabel Transaksi -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Transaksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Admin</th>
                            <th>Deskripsi</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Cetak Struk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td class="text-center">{{ $transaction->id }}</td>
                            <td class="text-center">{{ $transaction->admin->name }}</td>
                            <td class="text-center">{{ $transaction->description ?? 'Tidak ada deskripsi'}}</td>
                            <td class="text-center">Rp{{ number_format($transaction->total, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ $transaction->status == 'pending' ? 'warning text-dark' : ($transaction->status == 'success' ? 'success' : 'danger') }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td class="text-center">{{ $transaction->transaction_date }}</td>
                            <td class="text-center">
                                @if ($transaction->status === 'success')
                                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#transactionModalShow{{ $transaction->id }}">
                                    Cetak Receipt
                                </button>
                                @else
                                    <span class="badge bg-danger">Cetak Receipt Tidak Tersedia</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#transactionModalShow{{ $transaction->id }}">Detail</button>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTransactionModal{{ $transaction->id }}">Edit</button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteTransactionModal{{ $transaction->id }}">Hapus</button>
                            </td>
                        </tr>

                        <!-- Modal Edit Transaksi -->
                        <div class="modal fade" id="editTransactionModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="editTransactionModalLabel{{ $transaction->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('transactions-kasir.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editTransactionModalLabel{{ $transaction->id }}">Edit Transaksi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Pilih Pengguna -->
                                            <div class="form-group">
                                                <label for="user_id">Pengguna</label>
                                                <select name="user_id" id="user_id" class="form-control">
                                                    @foreach($admins as $admin)
                                                    <option value="{{ $admin->id }}" {{ $admin->id == $transaction->user_id ? 'selected' : '' }}>{{ $admin->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Deskripsi -->
                                            <div class="form-group">
                                                <label for="description">Deskripsi</label>
                                                <textarea name="description" id="description" class="form-control">{{ $transaction->description }}</textarea>
                                            </div>

                                            <!-- Tanggal Transaksi -->
                                            <div class="form-group">
                                                <label for="transaction_date">Tanggal Transaksi</label>
                                                <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{ $transaction->transaction_date }}">
                                            </div>

                                            <!-- Pilih Item dan Kuantitas -->
                                            <div class="form-group">
                                                <label for="items">Pilih Item</label>
                                                <div id="edit-items-container-{{ $transaction->id }}">
                                                    @foreach($transaction->items as $transactionItem)
                                                    <div class="d-flex mb-2">
                                                        <select name="items[]" class="form-control mr-2">
                                                            @foreach($items as $item)
                                                            <option value="{{ $item->id }}" {{ $item->id == $transactionItem->id ? 'selected' : '' }}>
                                                                {{ $item->name }} - Rp{{ number_format($item->price, 0, ',', '.') }} - (Stok: {{ $item->stock }})
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="number" name="quantities[]" class="form-control w-25" placeholder="Qty" min="1" value="{{ $transactionItem->pivot->quantity }}">
                                                        <button type="button" class="btn btn-danger ml-2 remove-item">-</button>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <button type="button" class="btn btn-success mt-2 add-item-edit" data-transaction-id="{{ $transaction->id }}">Tambah Item</button>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Update Transaksi</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Hapus Transaksi -->
                        <div class="modal fade" id="deleteTransactionModal{{ $transaction->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('transactions-kasir.destroy', $transaction->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Hapus Transaksi #{{ $transaction->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus transaksi ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($transactions as $transaction)
<div class="modal fade" id="transactionModalShow{{ $transaction->id }}" tabindex="-1" aria-labelledby="transactionModalLabel{{ $transaction->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="transactionModalLabel{{ $transaction->id }}">Detail Struk Belanja</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 text-center">
                          <img src="{{ $transaction->photo ? asset('storage/' . $customer->photo) : asset('assets/Logo.webp') }}" alt="Transaction Photo"class="card-img-top pt-3" alt="Foto Barang" style=" object-fit: contain;">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-4">
                            <h6 class="fw-bold">User:</h6>
                            <p>{{ $transaction->admin->name }}</p>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold">Status:</h6>
                            <p class="badge bg-{{ $transaction->status == 'completed' ? 'success' : 'success' }} text-white">
                                {{ ucfirst($transaction->status) }}
                            </p>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold">Description:</h6>
                            <p>{{ $transaction->description }}</p>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold">Total:</h6>
                            <p class="text-success fw-bold">Rp. {{ number_format($transaction->total, 2) }}</p>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold">Date:</h6>
                            <p>{{ $transaction->created_at->format('Y-m-d H:i') }}</p>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold">Items Purchased:</h6>
                            <ul class="list-group">
                                @foreach ($transaction->items as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $item->name }}</span>
                                    <span class="badge bg-primary rounded-pill">Quantity: {{ $item->pivot->quantity }}</span>
                                    <span class="text-muted">Rp. {{ number_format($item->price, 2) }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Tambah Transaksi -->
<div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('transactions-kasir.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTransactionModalLabel">Tambah Transaksi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- Pilih Pengguna -->
                    <div class="form-group">
                        <label>Admin</label>
                        <p class="form-control-plaintext">{{ $transaction->admin->name }}</p>
                        <input type="hidden" name="user_id" value="{{ $transaction->user_id }}">
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>

                    <!-- Tanggal Transaksi -->
                    <div class="form-group">
                        <label for="transaction_date">Tanggal Transaksi</label>
                        <input type="date" name="transaction_date" id="transaction_date" class="form-control" min="{{now()->format('Y-m-d')}}" max="{{now()->format('Y-m-d')}}">
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" name="status" id="status" class="form-control" value="success" readonly>
                    </div>

                    <!-- Pilih Item dan Kuantitas -->
                    <div class="form-group">
                        <label for="items">Pilih Item</label>
                        <div id="items-container">
                            <div class="d-flex mb-2">
                                <select name="items[]" class="form-control mr-2">
                                    @foreach($items as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }} - Rp{{ number_format($item->price, 0, ',', '.') }} - (Stok: {{ $item->stock }})
                                    </option>
                                    @endforeach

                                </select>
                                <input type="number" name="quantities[]" class="form-control w-25" placeholder="Qty" value="1">
                                <button type="button" class="btn btn-success ml-2 add-item">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateAvailableItems(container) {
            let selectedItems = Array.from(container.querySelectorAll('select[name="items[]"]'))
                .map(select => select.value);

            container.querySelectorAll('select[name="items[]"]').forEach(select => {
                let currentValue = select.value;
                select.querySelectorAll('option').forEach(option => {
                    option.hidden = selectedItems.includes(option.value) && option.value !== currentValue;
                });
            });
        }

        // Menambah item pada modal tambah transaksi
        document.querySelector('.add-item').addEventListener('click', function() {
            let container = document.getElementById('items-container');
            let newItem = document.createElement('div');
            newItem.classList.add('d-flex', 'mb-2');

            newItem.innerHTML = `
            <select name="items[]" class="form-control me-2">
                <option value="" selected disabled>Pilih Item</option>
                @foreach($items as $item)
                <option value="{{ $item->id }}">{{ $item->name }} - Rp{{ number_format($item->price, 0, ',', '.') }} - (Stok: {{ $item->stock }})</option>
                @endforeach
            </select>
            <input type="number" name="quantities[]" class="form-control w-25 me-2" placeholder="Qty" value="1" min="1">
            <button type="button" class="btn btn-danger remove-item">-</button>
            `;

            container.appendChild(newItem);
            updateAvailableItems(container);
        });

        // Menghapus item dalam modal tambah transaksi
        document.getElementById('items-container').addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-item')) {
                event.target.parentElement.remove();
                updateAvailableItems(document.getElementById('items-container'));
            }
        });

        // Menambah item pada modal edit transaksi
        document.querySelectorAll('.add-item-edit').forEach(function(button) {
            button.addEventListener('click', function() {
                let transactionId = this.getAttribute('data-transaction-id');
                let container = document.getElementById('edit-items-container-' + transactionId);
                let newItem = document.createElement('div');
                newItem.classList.add('d-flex', 'mb-2');

                newItem.innerHTML = `
                <select name="items[]" class="form-control me-2">
                    <option value="" selected disabled>Pilih Item</option>
                    @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }} - Rp{{ number_format($item->price, 0, ',', '.') }} ({{$item->stock}})</option>
                    @endforeach
                </select>
                <input type="number" name="quantities[]" class="form-control w-25 me-2" placeholder="Qty" min="1">
                <button type="button" class="btn btn-danger remove-item">-</button>
                `;

                container.appendChild(newItem);
                updateAvailableItems(container);
            });
        });

        // Menghapus item dalam modal edit transaksi
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-item')) {
                let container = event.target.closest('#items-container, .edit-items-container');
                event.target.parentElement.remove();
                updateAvailableItems(container);
            }
        });

        // Update daftar item yang tersedia setelah perubahan pilihan
        document.addEventListener('change', function(event) {
            if (event.target.matches('select[name="items[]"]')) {
                let container = event.target.closest('#items-container, .edit-items-container');
                updateAvailableItems(container);
            }
        });
    });
</script>
@endsection