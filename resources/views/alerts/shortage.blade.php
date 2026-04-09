@extends('layouts.app')

@section('title', 'Shortage Alerts - Smart Medical Inventory')
@section('page-title', 'Shortage Alerts')

@section('content')
<div class="page-header">
    <h2>Shortage Alerts</h2>
    <p>Items with low stock levels</p>
</div>

<div class="alert-stats">
    <div class="stat-card critical">
        <i class="fas fa-exclamation-circle"></i>
        <div class="stat-info">
            <h3>{{ $criticalCount }}</h3>
            <p>Critical</p>
        </div>
    </div>
    <div class="stat-card high">
        <i class="fas fa-exclamation-triangle"></i>
        <div class="stat-info">
            <h3>{{ $highCount }}</h3>
            <p>High Priority</p>
        </div>
    </div>
    <div class="stat-card medium">
        <i class="fas fa-info-circle"></i>
        <div class="stat-info">
            <h3>{{ $mediumCount }}</h3>
            <p>Medium Priority</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Shortage Alerts</h3>
    </div>
    <div class="card-body">
        @if($alerts->count() > 0)
        <div class="alerts-list">
            @foreach($alerts as $alert)
            <div class="alert-item severity-{{ $alert->severity }}">
                <div class="alert-icon">
                    @if($alert->severity === 'critical')
                        <i class="fas fa-exclamation-circle"></i>
                    @elseif($alert->severity === 'high')
                        <i class="fas fa-exclamation-triangle"></i>
                    @else
                        <i class="fas fa-info-circle"></i>
                    @endif
                </div>
                <div class="alert-content">
                    <h4>{{ $alert->inventoryItem->name }}</h4>
                    <p>{{ $alert->message }}</p>
                    <div class="alert-meta">
                        <span><i class="fas fa-box"></i> Current Stock: {{ $alert->inventoryItem->quantity }} {{ $alert->inventoryItem->unit }}</span>
                        <span><i class="fas fa-layer-group"></i> Reorder Level: {{ $alert->inventoryItem->reorder_level }}</span>
                        <span><i class="fas fa-clock"></i> {{ $alert->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="alert-actions">
                    <a href="{{ route('stock.add.form') }}?item={{ $alert->inventoryItem->id }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add Stock
                    </a>
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
            <h3>No Shortage Alerts</h3>
            <p>All items are adequately stocked!</p>
        </div>
        @endif
    </div>
</div>
@endsection
