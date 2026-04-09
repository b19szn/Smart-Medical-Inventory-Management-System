<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\InventoryItem;
use App\Models\AlertSetting;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default alert settings
        AlertSetting::create([
            'low_stock_threshold_days' => 10,
            'expiry_warning_days' => 30,
            'email_notifications' => true,
            'system_notifications' => true,
        ]);

        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@smartmedical.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'phone' => '+880 1700-000000',
            'hospital_name' => 'System Administration',
            'department' => 'IT',
            'is_active' => true,
        ]);

        // Create Hospital Admin
        User::create([
            'name' => 'Hospital Admin',
            'email' => 'hospital@smartmedical.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+880 1700-000001',
            'hospital_name' => 'Dhaka Medical College Hospital',
            'department' => 'Administration',
            'is_active' => true,
        ]);

        // Create Staff User
        User::create([
            'name' => 'Staff Member',
            'email' => 'staff@smartmedical.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'phone' => '+880 1700-000002',
            'hospital_name' => 'Dhaka Medical College Hospital',
            'department' => 'Pharmacy',
            'is_active' => true,
        ]);

        // Create Supplier
        User::create([
            'name' => 'Medical Supplier',
            'email' => 'supplier@smartmedical.com',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'phone' => '+880 1700-000003',
            'hospital_name' => 'MediSupply Bangladesh',
            'department' => 'Sales',
            'is_active' => true,
        ]);

        // Create sample inventory items
        $items = [
            [
                'item_name' => 'Paracetamol 500mg',
                'item_code' => 'MED-001',
                'description' => 'Pain relief and fever reducer',
                'category' => 'Medicines',
                'unit_of_measure' => 'tablets',
                'quantity' => 5000,
                'minimum_stock_level' => 1000,
                'unit_price' => 0.50,
                'supplier_name' => 'MediSupply Bangladesh',
                'batch_number' => 'BATCH-2024-001',
                'manufacturing_date' => now()->subMonths(2),
                'expiry_date' => now()->addMonths(22),
                'storage_location' => 'Pharmacy - Shelf A1',
                'is_critical' => false,
            ],
            [
                'item_name' => 'Surgical Gloves (Latex)',
                'item_code' => 'SUP-001',
                'description' => 'Sterile latex surgical gloves, size M',
                'category' => 'Surgical Supplies',
                'unit_of_measure' => 'pairs',
                'quantity' => 200,
                'minimum_stock_level' => 500,
                'unit_price' => 15.00,
                'supplier_name' => 'MediSupply Bangladesh',
                'batch_number' => 'BATCH-2024-002',
                'manufacturing_date' => now()->subMonth(),
                'expiry_date' => now()->addYears(2),
                'storage_location' => 'Surgery - Cabinet B2',
                'is_critical' => true,
            ],
            [
                'item_name' => 'Insulin Injection 100IU',
                'item_code' => 'MED-002',
                'description' => 'Insulin for diabetes management',
                'category' => 'Medicines',
                'unit_of_measure' => 'vials',
                'quantity' => 50,
                'minimum_stock_level' => 100,
                'unit_price' => 250.00,
                'supplier_name' => 'MediSupply Bangladesh',
                'batch_number' => 'BATCH-2024-003',
                'manufacturing_date' => now()->subMonths(3),
                'expiry_date' => now()->addMonths(9),
                'storage_location' => 'Pharmacy - Refrigerator R1',
                'is_critical' => true,
            ],
            [
                'item_name' => 'Oxygen Cylinder (Large)',
                'item_code' => 'EQP-001',
                'description' => 'Medical oxygen cylinder for patient care',
                'category' => 'Equipment',
                'unit_of_measure' => 'cylinders',
                'quantity' => 15,
                'minimum_stock_level' => 20,
                'unit_price' => 5000.00,
                'supplier_name' => 'MediSupply Bangladesh',
                'batch_number' => 'BATCH-2024-004',
                'manufacturing_date' => now()->subMonths(6),
                'expiry_date' => now()->addYears(5),
                'storage_location' => 'ICU - Storage Room',
                'is_critical' => true,
            ],
            [
                'item_name' => 'Disposable Syringes 5ml',
                'item_code' => 'SUP-002',
                'description' => 'Sterile disposable syringes with needle',
                'category' => 'Surgical Supplies',
                'unit_of_measure' => 'pieces',
                'quantity' => 3000,
                'minimum_stock_level' => 2000,
                'unit_price' => 5.00,
                'supplier_name' => 'MediSupply Bangladesh',
                'batch_number' => 'BATCH-2024-005',
                'manufacturing_date' => now()->subMonth(),
                'expiry_date' => now()->addYears(3),
                'storage_location' => 'Pharmacy - Shelf C3',
                'is_critical' => false,
            ],
            [
                'item_name' => 'Antibacterial Hand Sanitizer',
                'item_code' => 'HYG-001',
                'description' => '70% alcohol-based hand sanitizer',
                'category' => 'Hygiene',
                'unit_of_measure' => 'bottles',
                'quantity' => 100,
                'minimum_stock_level' => 200,
                'unit_price' => 120.00,
                'supplier_name' => 'MediSupply Bangladesh',
                'batch_number' => 'BATCH-2024-006',
                'manufacturing_date' => now()->subWeeks(2),
                'expiry_date' => now()->addMonths(18),
                'storage_location' => 'General Storage - Shelf D1',
                'is_critical' => false,
            ],
            [
                'item_name' => 'IV Fluid (Normal Saline 500ml)',
                'item_code' => 'MED-003',
                'description' => 'Intravenous fluid for hydration',
                'category' => 'Medicines',
                'unit_of_measure' => 'bottles',
                'quantity' => 800,
                'minimum_stock_level' => 1000,
                'unit_price' => 45.00,
                'supplier_name' => 'MediSupply Bangladesh',
                'batch_number' => 'BATCH-2024-007',
                'manufacturing_date' => now()->subMonths(4),
                'expiry_date' => now()->addMonths(20),
                'storage_location' => 'Emergency - Cabinet E1',
                'is_critical' => true,
            ],
            [
                'item_name' => 'Surgical Mask (3-ply)',
                'item_code' => 'PPE-001',
                'description' => 'Disposable 3-ply surgical face mask',
                'category' => 'PPE',
                'unit_of_measure' => 'pieces',
                'quantity' => 5000,
                'minimum_stock_level' => 3000,
                'unit_price' => 3.00,
                'supplier_name' => 'MediSupply Bangladesh',
                'batch_number' => 'BATCH-2024-008',
                'manufacturing_date' => now()->subWeeks(3),
                'expiry_date' => now()->addYears(2),
                'storage_location' => 'PPE Storage - Shelf F1',
                'is_critical' => false,
            ],
        ];

        foreach ($items as $item) {
            InventoryItem::create($item);
        }
    }
}
