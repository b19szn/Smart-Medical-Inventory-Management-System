# Quick Setup Guide - Smart Medical Inventory System

## 🚀 Quick Start (5 Minutes)

### Option 1: Using phpMyAdmin (Recommended for XAMPP users)

1. **Start XAMPP**
   - Open XAMPP Control Panel
   - Start Apache and MySQL

2. **Create Database**
   - Open browser: `http://localhost/phpmyadmin`
   - Click "New" in left sidebar
   - Database name: `medical`
   - Collation: `utf8mb4_unicode_ci`
   - Click "Create"

3. **Import Database Schema**
   - Select the `medical` database
   - Click "Import" tab
   - Choose file: `database/schema.sql`
   - Click "Go"
   - ✅ Database is now ready!

4. **Configure Environment**
   - Navigate to project folder
   - Copy `.env.example` to `.env`
   - Open `.env` and verify:
     ```
     DB_DATABASE=medical
     DB_USERNAME=root
     DB_PASSWORD=
     ```

5. **Access Application**
   - Open browser: `http://localhost/smartmedicalinventory/public`
   - You should see the welcome page!

### Option 2: Using Command Line (If Composer is installed)

```bash
# Navigate to project directory
cd c:\xampp\htdocs\smartmedicalinventory

# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate

# Run migrations and seeders
php artisan migrate --seed

# Access the application
# Open: http://localhost/smartmedicalinventory/public
```

## 🔑 Login Credentials

After setup, use these credentials to login:

### Super Admin (Full Access)
- Email: `admin@smartmedical.com`
- Password: `password`

### Hospital Admin
- Email: `hospital@smartmedical.com`
- Password: `password`

### Staff Member
- Email: `staff@smartmedical.com`
- Password: `password`

### Supplier
- Email: `supplier@smartmedical.com`
- Password: `password`

## 📋 First Steps After Login

1. **Explore the Dashboard**
   - View inventory statistics
   - Check active alerts
   - See critical stock items

2. **Add Your First Item**
   - Click "Inventory" in sidebar
   - Click "Add New Item"
   - Fill in the details
   - Save

3. **Try Stock Operations**
   - Add Stock: Increase inventory quantity
   - Consume Stock: Record usage
   - Transfer Stock: Move items between locations

4. **Check Alerts**
   - Navigate to "Alerts" section
   - View shortage and expiry warnings
   - Customize alert settings

5. **Export Data**
   - Go to "Export Data" section
   - Choose export type (PDF/CSV)
   - Download your reports

## ⚙️ Configuration

### Database Connection
Edit `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=medical
DB_USERNAME=root
DB_PASSWORD=your_password_if_any
```

### Application URL
```
APP_URL=http://localhost/smartmedicalinventory/public
```

## 🐛 Common Issues & Solutions

### Issue 1: "Page not found" or blank page
**Solution:**
- Make sure you're accessing: `http://localhost/smartmedicalinventory/public`
- Check if Apache is running in XAMPP
- Verify `.htaccess` file exists in `public` folder

### Issue 2: Database connection error
**Solution:**
- Verify MySQL is running in XAMPP
- Check database name in `.env` matches the created database
- Ensure database credentials are correct

### Issue 3: CSS/JS not loading
**Solution:**
- Clear browser cache (Ctrl + F5)
- Check if files exist in `public/css` and `public/js`
- Verify file permissions

### Issue 4: "Class not found" errors
**Solution:**
- If you have Composer: Run `composer dump-autoload`
- Otherwise, ensure all files are properly uploaded

### Issue 5: Routes not working
**Solution:**
- Enable `mod_rewrite` in Apache
- Check `.htaccess` file in `public` folder
- Restart Apache server

## 📱 Testing the Application

### Test Stock Control (Feature 1)
1. Login as Admin or Staff
2. Go to "Add Stock"
3. Select an item and add quantity
4. Check inventory - quantity should increase
5. Try "Consume Stock" and "Transfer Stock"

### Test Alerts (Feature 2)
1. Go to "Alerts" section
2. You should see alerts for low stock items
3. Try changing alert settings
4. Check "Shortage Alerts" and "Expiry Alerts"

### Test User Management (Feature 3)
1. Login as Super Admin
2. Go to "User Management"
3. Create a new user
4. Assign role and permissions
5. Try editing and deleting users

### Test Dashboard (Feature 4)
1. View dashboard statistics
2. Check charts and visualizations
3. Review recent alerts and transactions
4. Click on critical stock items

### Test Export (Feature 5)
1. Go to "Export Data"
2. Try exporting full inventory as CSV
3. Try exporting low stock items as PDF
4. Verify downloaded files

## 🔒 Security Notes

- **Change default passwords** after first login
- Default password for all users is: `password`
- Use strong passwords in production
- Keep `.env` file secure (never commit to Git)

## 📊 Sample Data

The system comes with:
- 4 default users (different roles)
- 8 sample inventory items
- Various categories (Medicines, Surgical Supplies, PPE, etc.)
- Some items are intentionally low stock to demonstrate alerts

## 🎯 Next Steps

1. **Customize for your hospital:**
   - Add your actual inventory items
   - Set appropriate minimum stock levels
   - Configure alert thresholds

2. **Create user accounts:**
   - Add staff members
   - Assign appropriate roles
   - Set up departments

3. **Start tracking:**
   - Record daily stock movements
   - Monitor alerts regularly
   - Generate reports as needed

## 📞 Need Help?

- Check the main `README.md` for detailed documentation
- Review Laravel documentation: https://laravel.com/docs
- Check error logs in `storage/logs/laravel.log`

## ✅ Verification Checklist

- [ ] XAMPP Apache and MySQL running
- [ ] Database created and imported
- [ ] `.env` file configured
- [ ] Can access welcome page
- [ ] Can login with default credentials
- [ ] Dashboard loads correctly
- [ ] Can add/edit inventory items
- [ ] Stock operations working
- [ ] Alerts displaying
- [ ] Export functionality working

---

**Congratulations! Your Smart Medical Inventory System is ready to use! 🎉**
