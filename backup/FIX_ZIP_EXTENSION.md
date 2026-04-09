# 🔧 Fix: Zip Extension Missing Error

## ❌ Error Message:
```
Failed to download guzzlehttp/psr7 from dist: The zip extension and unzip/7z commands are both missing, skipping.
The php.ini used by your command-line PHP is: C:\xampp\php\php.ini
```

## ✅ Solution: Enable PHP Zip Extension

### **Method 1: Edit php.ini Manually**

1. **Open php.ini:**
   - Location: `C:\xampp\php\php.ini`
   - Open with Notepad

2. **Find and edit:**
   - Search for: `;extension=zip`
   - Change to: `extension=zip` (remove the semicolon)

3. **Save the file**

4. **Restart Apache in XAMPP**

### **Method 2: Via XAMPP Control Panel**

1. Open XAMPP Control Panel
2. Click **Config** next to Apache
3. Select **PHP (php.ini)**
4. Find: `;extension=zip`
5. Change to: `extension=zip`
6. Save and close
7. Stop and Start Apache

---

## 🔍 **Verify Extension is Enabled**

Run in Command Prompt:
```bash
php -m | findstr zip
```

Expected output: `zip`

---

## 🚀 **After Enabling Zip Extension**

Run these commands:
```bash
cd c:\xampp\htdocs\smartmedicalinventory
composer install
```

Now Composer will be able to download and extract all packages successfully!

---

## 📋 **Other Extensions You Might Need**

While you're editing php.ini, make sure these extensions are also enabled (remove `;` if present):

```ini
extension=curl
extension=fileinfo
extension=gd
extension=mbstring
extension=mysqli
extension=openssl
extension=pdo_mysql
extension=zip
```

These are commonly needed for Laravel applications.

---

## ✅ **Expected Result**

After enabling zip extension and running `composer install`, you should see:
- ✅ Packages downloading successfully
- ✅ "Generating optimized autoload files" message
- ✅ A `vendor` folder created in your project
- ✅ No more zip extension errors

---

## 🎯 **Quick Command Summary**

```bash
# 1. Enable zip extension in php.ini
# 2. Restart Apache in XAMPP
# 3. Verify extension
php -m | findstr zip

# 4. Navigate to project
cd c:\xampp\htdocs\smartmedicalinventory

# 5. Install dependencies
composer install

# 6. Copy environment file
copy .env.example .env

# 7. Generate key
php artisan key:generate
```

---

**After these steps, your Laravel application will work perfectly!** 🎉
