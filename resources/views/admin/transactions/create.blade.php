@extends('admin.layouts.app')
@section('title', 'Create Transaction')
@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h4 class="page-title">Add New Transaction</h4>
    <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Back to List</a>
</div>
<form action="{{ route('admin.transactions.store') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-body">
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
                    <input type="text" class="form-control" id="service" name="service" value="{{ old('service') }}">
                </div>
                <div class="col-md-4">
                    <label for="source" class="form-label">Source *</label>
                    <input type="text" class="form-control" id="source" name="source" value="{{ old('source') }}" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="amount" class="form-label">Amount (AED) *</label>
                    <input type="number" class="form-control" id="amount" name="amount" min="0" step="0.01" value="{{ old('amount') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Status *</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="transaction_date" class="form-label">Transaction Date</label>
                    <input type="datetime-local" class="form-control" id="transaction_date" name="transaction_date" value="{{ old('transaction_date') }}">
                </div>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea class="form-control" id="note" name="note" rows="2">{{ old('note') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Transaction</button>
        </div>
    </div>
</form>
@endsection
