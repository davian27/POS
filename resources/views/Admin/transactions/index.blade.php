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
                            <div class="card-body">
                                <h6 class="fw-bold">ID: {{ $transaction->id }}</h6>
                                <p class="mb-1">Deskripsi: {{ $transaction->description ?? 'Tidak ada deskripsi' }}</p>
                                <p class="mb-1">Total: <span class="fw-bold text-success">Rp{{ number_format($transaction->total, 0, ',', '.') }}</span></p>
                                <p class="mb-1">Tanggal: {{ $transaction->transaction_date }}</p>
                                <p>Status: <span class="badge bg-{{ $transaction->status == 'success' ? 'success' : ($transaction->status == 'pending' ? 'warning text-dark' : 'danger') }}">
                                    {{ ucfirst($transaction->status) }}</span>
                                </p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#transactionModalShow{{ $transaction->id }}">Detail</button>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteTransactionModal{{ $transaction->id }}">Hapus</button>
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
