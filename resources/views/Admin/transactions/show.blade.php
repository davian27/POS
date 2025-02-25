@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="h3 mb-4 text-gray-800">Daftar Transaksi</h1>

    @if($transactions->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Akun</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->admin->name ?? '-' }}</td>
                        <td>{{ $transaction->transaction_date }}</td>
                        <td>Rp{{ number_format($transaction->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $transaction->status == 'success' ? 'success' : ($transaction->status == 'pending' ? 'warning text-dark' : 'danger') }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteTransactionModal{{ $transaction->id }}">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted">Tidak ada transaksi.</p>
    @endif
</div>
@endsection
