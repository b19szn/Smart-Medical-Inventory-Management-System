@extends('layouts.app')

@section('title', 'Alerts - Smart Medical Inventory')
@section('page-title', 'All Alerts')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-bell"></i> System Alerts
        </h3>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('alerts.shortage') }}" class="btn btn-sm btn-warning">
                <i class="fas fa-exclamation-triangle"></i> Shortage
            </a>
            <a href="{{ route('alerts.expiry') }}" class="btn btn-sm btn-danger">
                <i class="fas fa-calendar-times"></i> Expiry
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- Alert Settings -->
        <div class="card mb-4" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
            <div class="card-header" style="background: transparent;">
                <h4 style="margin: 0; font-size: 1rem;">
                    <i class="fas fa-cog"></i> Alert Settings
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('alerts.settings.update') }}" method="POST">
                    @csrf
                    <div class="grid-2">
                        <div class="form-group">
                            <label for="low_stock_threshold_days" class="form-label">Low Stock Threshold (Days)</label>
                            <input type="number" 
                                   name="low_stock_threshold_days" 
                                   id="low_stock_threshold_days" 
                                   class="form-control" 
                                   value="{{ $settings->low_stock_threshold_days }}" 
                                   min="1" 
                                   max="100">
                        </div>

                        <div class="form-group">
                            <label for="expiry_warning_days" class="form-label">Expiry Warning (Days Before)</label>
                            <input type="number" 
                                   name="expiry_warning_days" 
                                   id="expiry_warning_days" 
                                   class="form-control" 
                                   value="{{ $settings->expiry_warning_days }}" 
                                   min="1" 
                                   max="365">
                        </div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label style="display: flex; align-items: center; gap: 0.5rem;">
                                <input type="checkbox" 
                                       name="email_notifications" 
                                       value="1" 
                                       {{ $settings->email_notifications ? 'checked' : '' }}>
                                <span>Enable Email Notifications</span>
                            </label>
                        </div>

                        <div class="form-group">
                            <label style="display: flex; align-items: center; gap: 0.5rem;">
                                <input type="checkbox" 
                                       name="system_notifications" 
                                       value="1" 
                                       {{ $settings->system_notifications ? 'checked' : '' }}>
                                <span>Enable System Notifications</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Settings
                    </button>
                </form>
            </div>
        </div>

        <!-- Alerts List -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Severity</th>
                        <th>Type</th>
                        <th>Item</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alerts as $alert)
                    <tr style="{{ $alert->is_read ? 'opacity: 0.6;' : '' }}">
                        <td>
                            <span class="badge badge-{{ 
                                $alert->severity === 'critical' ? 'danger' : 
                                ($alert->severity === 'high' ? 'warning' : 
                                ($alert->severity === 'medium' ? 'info' : 'primary')) 
                            }}">
                                {{ ucfirst($alert->severity) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ 
                                $alert->alert_type === 'shortage' ? 'warning' : 'danger' 
                            }}">
                                {{ ucfirst($alert->alert_type) }}
                            </span>
                        </td>
                        <td>
                            <strong>{{ $alert->inventoryItem->item_name ?? 'N/A' }}</strong>
                            <br>
                            <small style="color: var(--text-light);">
                                {{ $alert->inventoryItem->item_code ?? '' }}
                            </small>
                        </td>
                        <td>{{ $alert->message }}</td>
                        <td>{{ $alert->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            @if($alert->is_read)
                                <span class="badge badge-success">Read</span>
                            @else
                                <span class="badge badge-warning">Unread</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-light);">
                            <i class="fas fa-check-circle" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                            No alerts at this time. Your inventory is in good condition!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($alerts->hasPages())
        <div class="pagination">
            {{ $alerts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
