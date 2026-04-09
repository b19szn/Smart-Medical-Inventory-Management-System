# Smart Medical Inventory System

A comprehensive Laravel-based inventory management system designed for healthcare facilities to track medical supplies, manage stock levels, and generate alerts for shortages and expiring items.

## 🚀 Quick Start

### Prerequisites
- XAMPP (Apache + MySQL + PHP 8.x)
- Composer

### Installation

1. **Start XAMPP Services**
   - Start Apache
   - Start MySQL (Port 3307)

2. **Access Application**
   ```
   http://localhost/smartmedicalinventory/public
   ```

3. **Default Login Credentials**
   - **Email:** admin@smartmedical.com
   - **Password:** password

## 📊 Features

### 1. Dashboard & Visualization
- Real-time inventory statistics
- Stock by category charts
- Alert notifications
- Critical stock items
- Quick action buttons

### 2. Inventory Management
- Add, edit, delete inventory items
- Search and filter capabilities
- Detailed item information
- Category-based organization

### 3. Stock Control
- **Add Stock:** Increase inventory quantities
- **Consume Stock:** Record usage/consumption
- **Transfer Stock:** Move items between locations
- **Transfer History:** View all stock movements

### 4. Alerts System
- **Shortage Alerts:** Low stock warnings
- **Expiry Alerts:** Expiration notifications
- **Customizable Thresholds:** Set alert levels
- **Severity Levels:** Critical, High, Medium, Low

### 5. User Management (Admin Only)
- Create and manage users
- Role-based access control
- User activation/deactivation
- Roles: Super Admin, Admin, Staff, Supplier

### 6. Export Center
- PDF Export
- Excel Export
- CSV Export
- Customizable date ranges

## 🔐 User Roles

| Role | Permissions |
|------|-------------|
| Super Admin | Full system access |
| Admin | Manage users, inventory, and reports |
| Staff | View and update inventory |
| Supplier | Limited access to relevant items |

## 🗄️ Database Configuration

- **Database Name:** medical
- **Host:** 127.0.0.1
- **Port:** 3307
- **Username:** root
- **Password:** (empty)

## 📁 Project Structure

```
smartmedicalinventory/
├── app/                    # Application logic
│   ├── Http/
│   │   ├── Controllers/   # Request handlers
│   │   └── Middleware/    # Request filters
│   ├── Models/            # Database models
│   └── Providers/         # Service providers
├── config/                # Configuration files
├── database/
│   ├── migrations/        # Database migrations
│   └── schema.sql         # Database schema
├── public/                # Public assets
│   ├── css/
│   ├── js/
│   └── index.php          # Entry point
├── resources/
│   └── views/             # Blade templates
├── routes/
│   └── web.php            # Web routes
├── storage/               # Generated files
├── backup/                # Documentation & guides
├── .env                   # Environment config
└── composer.json          # Dependencies
```

## 🛠️ Maintenance

### Clear Cache
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

### Update Dependencies
```bash
composer update
```

## 📖 Documentation

All setup guides, troubleshooting documentation, and implementation details have been moved to the `backup/` folder for reference.

## 🔧 Troubleshooting

### Database Connection Error
- Ensure MySQL is running on port 3307
- Check `.env` file has correct database settings

### Page Not Found
- Access via: `http://localhost/smartmedicalinventory/public`
- Ensure Apache is running

### CSS/JS Not Loading
- Clear browser cache (Ctrl + F5)
- Check files exist in `/public/css` and `/public/js`

## 📞 Support

For detailed setup instructions and troubleshooting guides, see the `backup/` folder.

## 🎨 Technology Stack

- **Framework:** Laravel 9.52
- **PHP:** 8.x
- **Database:** MySQL
- **Server:** Apache (XAMPP)
- **Frontend:** Blade Templates, Custom CSS, Vanilla JavaScript

## 📄 License

MIT License

---

**Version:** 1.0.0  
**Last Updated:** December 10, 2025

Built with ❤️ for Healthcare Professionals
