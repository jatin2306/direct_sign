@extends('admin.layouts.app')
@section('title', 'Transactions')

@section('content')
@php $showTransactionActions = admin_can('transactions.edit') || admin_can('transactions.delete'); @endphp
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Transactions</h4>
        @if(admin_can('transactions.create'))
        <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary">Add Transaction</a>
        @endif
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Service</th>
                    <th>Source</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Note</th>
                    <th>Date</th>
                    @if($showTransactionActions)<th>Actions</th>@endif
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $index => $transaction)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {{ $transaction->user->name ?? 'User #'.$transaction->user_id }}
                        </td>
                        <td>{{ $transaction->service ?? '-' }}</td>
                        <td>{{ $transaction->source }}</td>
                        <td>AED {{ number_format($transaction->amount,2) }}</td>
                        <td>
                            @if($transaction->status == 'Completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif($transaction->status == 'Cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td style="max-width:160px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ Str::limit($transaction->note, 50) }}</td>
                        <td>
                            {{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y, h:i a') : '-' }}
                        </td>
                        @if($showTransactionActions)
                        <td>
                            @if(admin_can('transactions.edit'))
                            <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="btn btn-sm btn-info">Edit</a>
                            @endif
                            @if(admin_can('transactions.delete'))
                            <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this transaction?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                            @endif
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr><td colspan="{{ $showTransactionActions ? 9 : 8 }}">No transactions found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
