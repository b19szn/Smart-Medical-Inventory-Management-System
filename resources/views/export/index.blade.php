@extends('layouts.app')

@section('title', 'Export Data - Smart Medical Inventory')
@section('page-title', 'Export Data Center')

@section('content')
<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-file-export"></i> Inventory Data Export Center
        </h3>
    </div>

    <div class="card-body">
        <p style="color: var(--text-secondary); margin-bottom: 2rem;">
            Export your inventory data in various formats for reporting, analysis, or backup purposes.
        </p>

        <!-- Export Options -->
        <div class="grid-2">
            <!-- Full Inventory Export -->
            <div class="card" style="border: 2px solid var(--border-color);">
                <div class="card-header" style="background: var(--bg-secondary);">
                    <h4 style="margin: 0; font-size: 1.125rem;">
                        <i class="fas fa-boxes"></i> Full Inventory
                    </h4>
                </div>
                <div class="card-body">
                    <p style="font-size: 0.875rem; color: var(--text-secondary);">
                        Export complete inventory with all items and details
                    </p>
                    <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                        <form action="{{ route('export.pdf') }}" method="POST" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="type" value="inventory">
                            <button type="submit" class="btn btn-danger" style="width: 100%;">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                        </form>
                        <form action="{{ route('export.csv') }}" method="POST" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="type" value="inventory">
                            <button type="submit" class="btn btn-success" style="width: 100%;">
                                <i class="fas fa-file-csv"></i> CSV
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Low Stock Items -->
            <div class="card" style="border: 2px solid var(--warning-color);">
                <div class="card-header" style="background: #fef3c7;">
                    <h4 style="margin: 0; font-size: 1.125rem; color: #92400e;">
                        <i class="fas fa-exclamation-triangle"></i> Low Stock Items
                    </h4>
                </div>
                <div class="card-body">
                    <p style="font-size: 0.875rem; color: var(--text-secondary);">
                        Export items below minimum stock level
                    </p>
                    <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                        <form action="{{ route('export.pdf') }}" method="POST" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="type" value="low_stock">
                            <button type="submit" class="btn btn-danger" style="width: 100%;">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                        </form>
                        <form action="{{ route('export.csv') }}" method="POST" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="type" value="low_stock">
                            <button type="submit" class="btn btn-success" style="width: 100%;">
                                <i class="fas fa-file-csv"></i> CSV
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Expiring Items -->
            <div class="card" style="border: 2px solid var(--warning-color);">
                <div class="card-header" style="background: #fef3c7;">
                    <h4 style="margin: 0; font-size: 1.125rem; color: #92400e;">
                        <i class="fas fa-calendar-times"></i> Expiring Items
                    </h4>
                </div>
                <div class="card-body">
                    <p style="font-size: 0.875rem; color: var(--text-secondary);">
                        Export items expiring within 30 days
                    </p>
                    <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                        <form action="{{ route('export.pdf') }}" method="POST" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="type" value="expiring">
                            <button type="submit" class="btn btn-danger" style="width: 100%;">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                        </form>
                        <form action="{{ route('export.csv') }}" method="POST" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="type" value="expiring">
                            <button type="submit" class="btn btn-success" style="width: 100%;">
                                <i class="fas fa-file-csv"></i> CSV
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Expired Items -->
            <div class="card" style="border: 2px solid var(--danger-color);">
                <div class="card-header" style="background: #fee2e2;">
                    <h4 style="margin: 0; font-size: 1.125rem; color: #991b1b;">
                        <i class="fas fa-ban"></i> Expired Items
                    </h4>
                </div>
                <div class="card-body">
                    <p style="font-size: 0.875rem; color: var(--text-secondary);">
                        Export items that have already expired
                    </p>
                    <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                        <form action="{{ route('export.pdf') }}" method="POST" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="type" value="expired">
                            <button type="submit" class="btn btn-danger" style="width: 100%;">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                        </form>
                        <form action="{{ route('export.csv') }}" method="POST" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="type" value="expired">
                            <button type="submit" class="btn btn-success" style="width: 100%;">
                                <i class="fas fa-file-csv"></i> CSV
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Stock Transactions -->
            <div class="card" style="border: 2px solid var(--info-color);">
                <div class="card-header" style="background: #cffafe;">
                    <h4 style="margin: 0; font-size: 1.125rem; color: #164e63;">
                        <i class="fas fa-history"></i> Stock Transactions
                    </h4>
                </div>
                <div class="card-body">
                    <p style="font-size: 0.875rem; color: var(--text-secondary);">
                        Export all stock movement history
                    </p>
                    <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                        <form action="{{ route('export.pdf') }}" method="POST" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="type" value="transactions">
                            <button type="submit" class="btn btn-danger" style="width: 100%;">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                        </form>
                        <form action="{{ route('export.csv') }}" method="POST" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="type" value="transactions">
                            <button type="submit" class="btn btn-success" style="width: 100%;">
                                <i class="fas fa-file-csv"></i> CSV
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Transfer History -->
            <div class="card" style="border: 2px solid var(--primary-color);">
                <div class="card-header" style="background: #dbeafe;">
                    <h4 style="margin: 0; font-size: 1.125rem; color: #1e40af;">
                        <i class="fas fa-exchange-alt"></i> Transfer History
                    </h4>
                </div>
                <div class="card-body">
                    <p style="font-size: 0.875rem; color: var(--text-secondary);">
                        Export stock transfer records
                    </p>
                    <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                        <form action="{{ route('export.pdf') }}" method="POST" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="type" value="transfers">
                            <button type="submit" class="btn btn-danger" style="width: 100%;">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                        </form>
                        <form action="{{ route('export.csv') }}" method="POST" style="flex: 1;">
                            @csrf
                            <input type="hidden" name="type" value="transfers">
                            <button type="submit" class="btn btn-success" style="width: 100%;">
                                <i class="fas fa-file-csv"></i> CSV
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Information -->
        <div class="card mt-4" style="background: var(--bg-secondary); border: none;">
            <div class="card-body">
                <h4 style="margin-bottom: 1rem;">
                    <i class="fas fa-info-circle"></i> Export Information
                </h4>
                <ul style="color: var(--text-secondary); font-size: 0.875rem; line-height: 1.8;">
                    <li><strong>PDF Format:</strong> Best for printing and official reports</li>
                    <li><strong>CSV Format:</strong> Best for data analysis in Excel or other spreadsheet applications</li>
                    <li><strong>Excel Format:</strong> Formatted spreadsheet with formulas and styling</li>
                    <li>All exports include timestamp and are generated in real-time</li>
                    <li>Exported data reflects the current state of your inventory</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
