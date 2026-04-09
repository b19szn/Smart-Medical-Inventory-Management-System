@extends('layouts.app')

@section('title', 'Expiry Alerts - Smart Medical Inventory')
@section('page-title', 'Expiry Alerts')

@section('content')
<div class="page-header">
    <h2>Expiry Alerts</h2>
    <p>Items approaching or past expiration date</p>
</div>

<div class="alert-stats">
    <div class="stat-card critical">
        <i class="fas fa-calendar-times"></i>
        <div class="stat-info">
            <h3>{{ $expiredCount }}</h3>
            <p>Expired</p>
        </div>
    </div>
    <div class="stat-card high">
        <i class="fas fa-calendar-exclamation"></i>
        <div class="stat-info">
            <h3>{{ $expiringCount }}</h3>
            <p>Expiring Soon</p>
        </div>
    </div>
    <div class="stat-card medium">
        <i class="fas fa-calendar-check"></i>
        <div class="stat-info">
            <h3>{{ $warningCount }}</h3>
            <p>Warning</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Expiry Alerts</h3>
    </div>
    <div class="card-body">
        @if($alerts->count() > 0)
        <div class="alerts-list">
            @foreach($alerts as $alert)
            <div class="alert-item severity-{{ $alert->severity }}">
                <div class="alert-icon">
                    @if($alert->severity === 'critical')
                        <i class="fas fa-calendar-times"></i>
                    @elseif($alert->severity === 'high')
                        <i class="fas fa-calendar-exclamation"></i>
                    @else
                        <i class="fas fa-calendar-check"></i>
                    @endif
                </div>
                <div class="alert-content">
                    <h4>{{ $alert->inventoryItem->name }}</h4>
                    <p>{{ $alert->message }}</p>
                    <div class="alert-meta">
                        <span><i class="fas fa-calendar"></i> Expiry Date: {{ $alert->inventoryItem->expiry_date ? $alert->inventoryItem->expiry_date->format('M d, Y') : 'N/A' }}</span>
                        <span><i class="fas fa-box"></i> Quantity: {{ $alert->inventoryItem->quantity }} {{ $alert->inventoryItem->unit }}</span>
                        <span><i class="fas fa-clock"></i> {{ $alert->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="alert-actions">
                    @if($alert->inventoryItem->expiry_date && $alert->inventoryItem->expiry_date->isPast())
                        <span class="badge badge-danger">Expired</span>
                    @else
                        <span class="badge badge-warning">
                            Expires in {{ $alert->inventoryItem->expiry_date->diffForHumans() }}
                        </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="pagination-wrapper">
            {{ $alerts->links() }}
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-check-circle"></i>
            <h3>No Expiry Alerts</h3>
            <p>No items are expiring soon!</p>
        </div>
        @endif
    </div>
</div>
@endsection
