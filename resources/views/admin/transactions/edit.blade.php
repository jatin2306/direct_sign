@extends('admin.layouts.app')
@section('title', 'Edit Transaction')
@section('content')
<div class="card">
    <div class="card-header">
        <h4>Edit Transaction</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mb-3">
            <div class="col-md-4">
    <label for="user_id" class="form-label">User *</label>
    <select class="form-control" id="user_id" name="user_id" required>
        <option value="">Select User</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}"
                {{ old('user_id', isset($transaction) ? $transaction->user_id : null) == $user->id ? 'selected' : '' }}>
                {{ $user->name }} ({{ $user->email }})
            </option>
        @endforeach
    </select>
</div>

                <div class="col-md-4">
                    <label for="service" class="form-label">Service</label>
                    <input type="text" class="form-control" id="service" name="service" value="{{ old('service', $transaction->service) }}">
                </div>
                <div class="col-md-4">
                    <label for="source" class="form-label">Source *</label>
                    <input type="text" class="form-control" id="source" name="source" value="{{ old('source', $transaction->source) }}" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="amount" class="form-label">Amount (AED) *</label>
                    <input type="number" class="form-control" id="amount" name="amount" min="0" step="0.01" value="{{ old('amount', $transaction->amount) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Status *</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Pending" {{ old('status', $transaction->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ old('status', $transaction->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ old('status', $transaction->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="transaction_date" class="form-label">Transaction Date</label>
                    <input type="datetime-local" class="form-control" id="transaction_date" name="transaction_date"
                        value="{{ old('transaction_date', $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d\TH:i') : '') }}">
                </div>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea class="form-control" id="note" name="note" rows="2">{{ old('note', $transaction->note) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Transaction</button>
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
@endsection
