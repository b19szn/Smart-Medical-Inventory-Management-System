@extends('layouts.app')

@section('title', 'Transfer History - Smart Medical Inventory')
@section('page-title', 'Transfer History')

@section('content')
<div class="page-header">
    <h2>Stock Transfer History</h2>
    <p>View all stock transfers between locations</p>
</div>

<div class="card">
    <div class="card-header">
        <h3>All Transfers</h3>
        <div class="card-actions">
            <a href="{{ route('stock.transfer.form') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Transfer
            </a>
        </div>
    </div>
    <div class="card-body">
        @if($transfers->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Item</th>
                        <th>From Location</th>
                        <th>To Location</th>
                        <th>Quantity</th>
                        <th>Transferred By</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transfers as $transfer)
                    <tr>
                        <td>{{ $transfer->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            <strong>{{ $transfer->inventoryItem->name }}</strong><br>
                            <small class="text-muted">{{ $transfer->inventoryItem->sku }}</small>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $transfer->from_location }}</span>
                        </td>
                        <td>
                            <span class="badge badge-success">{{ $transfer->to_location }}</span>
                        </td>
                        <td>
                            <strong>{{ $transfer->quantity }}</strong> {{ $transfer->inventoryItem->unit }}
                        </td>
                        <td>{{ $transfer->user->name }}</td>
                        <td>{{ $transfer->notes ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="pagination-wrapper">
            {{ $transfers->links() }}
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-exchange-alt"></i>
            <h3>No Transfers Yet</h3>
            <p>No stock transfers have been recorded.</p>
            <a href="{{ route('stock.transfer.form') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create First Transfer
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
