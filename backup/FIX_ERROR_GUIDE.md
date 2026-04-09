# 🔧 Fixing "Class Illuminate\Foundation\Application not found" Error

## ❌ Error You're Seeing:
```
Fatal error: Uncaught Error: Class "Illuminate\Foundation\Application" not found
in C:\xampp\htdocs\smartmedicalinventory\bootstrap\app.php:7
```

## 🎯 Root Cause:
This error occurs because **Laravel dependencies are not installed**. The `vendor` folder (which contains all Laravel framework files) is missing.

---

## ✅ **SOLUTION: Install Composer and Dependencies**

### **Step 1: Install Composer**

1. **Download Composer for Windows:**
   - Visit: https://getcomposer.org/Composer-Setup.exe
   - Download and run the installer
   - Follow the installation wizard
   - It will automatically detect your PHP installation from XAMPP

2. **Verify Installation:**
   - Open Command Prompt
   - Type: `composer --version`
   - You should see the Composer version

### **Step 2: Install Laravel Dependencies**

1. **Open Command Prompt as Administrator**

2. **Navigate to your project:**
   ```bash
   cd c:\xampp\htdocs\smartmedicalinventory
   ```

3. **Install dependencies:**
   ```bash
   composer install
   ```

4. **Wait for installation** (this may take 2-5 minutes)

5. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

### **Step 3: Verify Installation**

After installation, you should see:
- ✅ A `vendor` folder in your project directory
- ✅ The folder should be about 50-80 MB in size
- ✅ Contains Laravel framework files

---

## 🚀 **Alternative: Quick Setup (If Composer Installation Fails)**

If you're having trouble installing Composer, here's a manual workaround:

### **Download Composer.phar (Portable Version)**

1. **Download composer.phar:**
   - Visit: https://getcomposer.org/download/
   - Download `composer.phar` file
   - Save it to: `c:\xampp\htdocs\smartmedicalinventory\`

2. **Run Composer:**
   ```bash
   cd c:\xampp\htdocs\smartmedicalinventory
   php composer.phar install
   ```

---

## 📋 **After Installing Dependencies**

Once Composer finishes installing, do the following:

### 1. **Copy .env file:**
```bash
copy .env.example .env
```

### 2. **Generate Application Key:**
```bash
php artisan key:generate
```

### 3. **Setup Database:**
- Open phpMyAdmin: http://localhost/phpmyadmin
- Create database: `medical`
- Import file: `database/schema.sql`

### 4. **Access Application:**
- Open browser: http://localhost/smartmedicalinventory/public
- You should see the welcome page!

---

## 🐛 **Troubleshooting**

### Issue: "composer: command not found"
**Solution:** 
- Restart Command Prompt after installing Composer
- Or use full path: `C:\ProgramData\ComposerSetup\bin\composer install`

### Issue: "Your requirements could not be resolved"
**Solution:**
- Make sure you have PHP 8.1 or higher
- Check PHP version: `php -v`
- Update XAMPP if needed

### Issue: Installation is very slow
**Solution:**
- This is normal - Laravel has many dependencies
- Wait patiently (can take 5-10 minutes on slow connections)

### Issue: "proc_open() has been disabled"
**Solution:**
- Open: `c:\xampp\php\php.ini`
- Find: `disable_functions`
- Remove `proc_open` from the list
- Restart Apache

---

## 📝 **Why This Happens**

Laravel is a PHP framework that uses **Composer** (PHP package manager) to manage its dependencies. The project files I created include:
- ✅ Application code (Controllers, Models, Views)
- ✅ Configuration files
- ✅ Routes and migrations
- ❌ Laravel framework files (these need to be installed via Composer)

The `composer.json` file tells Composer which packages to install, but you need to run `composer install` to actually download them.

---

## ✅ **Expected Result After Fix**

After running `composer install`, your project structure will look like:

```
smartmedicalinventory/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── vendor/          ← This folder will be created (50-80 MB)
│   ├── laravel/
│   ├── symfony/
│   └── ... (many packages)
├── .env
├── composer.json
└── composer.lock    ← This file will be created
```

---

## 🎯 **Quick Command Summary**

```bash
# 1. Navigate to project
cd c:\xampp\htdocs\smartmedicalinventory

# 2. Install dependencies
composer install

# 3. Copy environment file
copy .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Done! Open in browser
# http://localhost/smartmedicalinventory/public
```

---

## 📞 **Need More Help?**

If you're still having issues:

1. **Check PHP Version:**
   ```bash
   php -v
   ```
   Should be 8.1 or higher

2. **Check if Composer is installed:**
   ```bash
   composer --version
   ```

3. **Make sure XAMPP Apache and MySQL are running**

4. **Check error logs:**
   - `c:\xampp\apache\logs\error.log`

---

**Once you run `composer install`, the error will be fixed and your application will work perfectly!** 🎉
