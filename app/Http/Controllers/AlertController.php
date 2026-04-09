<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\AlertSetting;
use App\Models\InventoryItem;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    // Show all alerts
    public function index()
    {
        $alerts = Alert::with('inventoryItem')
            ->orderBy('is_read', 'asc')
            ->orderBy('severity', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $settings = AlertSetting::getSettings();

        return view('alerts.index', compact('alerts', 'settings'));
    }

    // Show shortage alerts
    public function shortage()
    {
        $alerts = Alert::ofType('shortage')
            ->with('inventoryItem')
            ->orderBy('severity', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $criticalCount = Alert::ofType('shortage')->bySeverity('critical')->count();
        $highCount = Alert::ofType('shortage')->bySeverity('high')->count();
        $mediumCount = Alert::ofType('shortage')->bySeverity('medium')->count();

        return view('alerts.shortage', compact('alerts', 'criticalCount', 'highCount', 'mediumCount'));
    }

    // Show expiry alerts
    public function expiry()
    {
        $alerts = Alert::ofType('expiry')
            ->with('inventoryItem')
            ->orderBy('severity', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $expiredCount = InventoryItem::expired()->count();
        $expiringCount = InventoryItem::expiring(30)->count();
        $warningCount = InventoryItem::expiring(60)->count() - $expiringCount;

        return view('alerts.expiry', compact('alerts', 'expiredCount', 'expiringCount', 'warningCount'));
    }

    // Update alert settings
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'low_stock_threshold_days' => 'required|integer|min:1|max:100',
            'expiry_warning_days' => 'required|integer|min:1|max:365',
            'email_notifications' => 'boolean',
            'system_notifications' => 'boolean',
        ]);

        $settings = AlertSetting::getSettings();
        $settings->update($validated);

        // Regenerate alerts based on new settings
        $this->regenerateAlerts();

        return back()->with('success', 'Alert settings updated successfully!');
    }

    // Helper method to regenerate alerts
    private function regenerateAlerts()
    {
        $settings = AlertSetting::getSettings();

        // Clear existing unread alerts
        Alert::where('is_read', false)->delete();

        // Generate shortage alerts
        $lowStockItems = InventoryItem::lowStock()->get();
        foreach ($lowStockItems as $item) {
            $severity = $this->calculateShortageSerity($item);
            Alert::create([
                'inventory_item_id' => $item->id,
                'alert_type' => 'shortage',
                'message' => "Low stock alert: {$item->item_name} has only {$item->quantity} {$item->unit_of_measure} remaining (Minimum: {$item->minimum_stock_level})",
                'severity' => $severity,
            ]);
        }

        // Generate expiry alerts
        $expiringItems = InventoryItem::expiring($settings->expiry_warning_days)->get();
        foreach ($expiringItems as $item) {
            $daysUntilExpiry = now()->diffInDays($item->expiry_date);
            $severity = $this->calculateExpirySerity($daysUntilExpiry);
            
            Alert::create([
                'inventory_item_id' => $item->id,
                'alert_type' => 'expiry',
                'message' => "Expiry warning: {$item->item_name} (Batch: {$item->batch_number}) will expire in {$daysUntilExpiry} days on {$item->expiry_date->format('d M Y')}",
                'severity' => $severity,
            ]);
        }

        // Generate expired alerts
        $expiredItems = InventoryItem::expired()->get();
        foreach ($expiredItems as $item) {
            Alert::create([
                'inventory_item_id' => $item->id,
                'alert_type' => 'expired',
                'message' => "EXPIRED: {$item->item_name} (Batch: {$item->batch_number}) expired on {$item->expiry_date->format('d M Y')}",
                'severity' => 'critical',
            ]);
        }
    }

    // Calculate shortage severity
    private function calculateShortageSerity($item)
    {
        $percentage = ($item->quantity / $item->minimum_stock_level) * 100;
        
        if ($percentage <= 25) {
            return 'critical';
        } elseif ($percentage <= 50) {
            return 'high';
        } elseif ($percentage <= 75) {
            return 'medium';
        } else {
            return 'low';
        }
    }

    // Calculate expiry severity
    private function calculateExpirySerity($daysUntilExpiry)
    {
        if ($daysUntilExpiry <= 7) {
            return 'critical';
        } elseif ($daysUntilExpiry <= 14) {
            return 'high';
        } elseif ($daysUntilExpiry <= 21) {
            return 'medium';
        } else {
            return 'low';
        }
    }
}
