@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="h3 mb-4 text-gray-800">Riwayat Transaksi per Akun</h1>

    @foreach($admins as $admin)
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="m-0">{{ $admin->name }}</h5>
        </div>
        <div class="card-body">
            @if($admin->transactions->count() > 0)
                <div class="row">
                    @foreach($admin->transactions as $transaction)
                    <div class="col-md-4 mb-3">
                        <div class="card border-left-{{ $transaction->status == 'success' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }} shadow h-100">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="fw-bold">ID: {{ $transaction->id }}</h6>
                                    <p class="mb-1"><strong>Deskripsi:</strong> {{ $transaction->description ?? 'Tidak ada deskripsi' }}</p>
                                    <p class="mb-1"><strong>Total:</strong> <span class="fw-bold text-success">Rp{{ number_format($transaction->total, 0, ',', '.') }}</span></p>
                                    <p class="mb-1"><strong>Tanggal:</strong> {{ $transaction->transaction_date }}</p>
                                    <p><strong>Status:</strong> <span class="badge bg-{{ $transaction->status == 'success' ? 'success' : ($transaction->status == 'pending' ? 'warning text-dark' : 'danger') }}">{{ ucfirst($transaction->status) }}</span></p>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#transactionModalShow{{ $transaction->id }}">Detail</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Detail Transaksi -->
                    <div class="modal fade" id="transactionModalShow{{ $transaction->id }}" tabindex="-1" aria-labelledby="transactionModalLabel{{ $transaction->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title" id="transactionModalLabel{{ $transaction->id }}">Detail Transaksi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr><th>ID</th><td>{{ $transaction->id }}</td></tr>
                                            <tr><th>Deskripsi</th><td>{{ $transaction->description ?? 'Tidak ada deskripsi' }}</td></tr>
                                            <tr><th>Total</th><td>Rp{{ number_format($transaction->total, 0, ',', '.') }}</td></tr>
                                            <tr><th>Tanggal</th><td>{{ $transaction->transaction_date }}</td></tr>
                                            <tr><th>Status</th><td><span class="badge bg-{{ $transaction->status == 'success' ? 'success' : ($transaction->status == 'pending' ? 'warning text-dark' : 'danger') }}">{{ ucfirst($transaction->status) }}</span></td></tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <h6 class="fw-bold mt-5">Barang yang Dibeli:</h6>
                                    <table class="table table-striped mt-2">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Harga Satuan</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transaction->items as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->pivot->quantity }}</td>
                                                <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                                <td>Rp{{ number_format($item->price * $item->pivot->quantity, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Tidak ada transaksi untuk akun ini.</p>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection