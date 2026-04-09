<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'low_stock_threshold_days',
        'expiry_warning_days',
        'email_notifications',
        'system_notifications',
    ];

    protected $casts = [
        'email_notifications' => 'boolean',
        'system_notifications' => 'boolean',
    ];

    public static function getSettings()
    {
        return self::first() ?? self::create([
            'low_stock_threshold_days' => 10,
            'expiry_warning_days' => 30,
            'email_notifications' => true,
            'system_notifications' => true,
        ]);
    }
}
