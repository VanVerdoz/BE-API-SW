# ✅ Deployment Checklist - Dashboard Sidewalk.Go

## Pre-Deployment Checklist

### 1. Environment Setup
- [ ] `.env` file configured correctly
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `APP_URL` set to production URL
- [ ] Database credentials correct
- [ ] Session driver configured (database/redis recommended)

### 2. Database
- [ ] Database created
- [ ] Migrations run successfully: `php artisan migrate`
- [ ] Seeders run (if needed): `php artisan db:seed`
- [ ] Test data created for each role
- [ ] Database backup created

### 3. Dependencies
- [ ] Composer dependencies installed: `composer install --optimize-autoloader --no-dev`
- [ ] NPM dependencies installed (if using): `npm install`
- [ ] Assets compiled: `npm run build`

### 4. Security
- [ ] Application key generated: `php artisan key:generate`
- [ ] CSRF protection enabled
- [ ] HTTPS configured (SSL certificate)
- [ ] Secure session cookies: `SESSION_SECURE_COOKIE=true`
- [ ] HTTP only cookies: `SESSION_HTTP_ONLY=true`
- [ ] Strong passwords for all users
- [ ] File permissions set correctly (755 for directories, 644 for files)
- [ ] Storage and bootstrap/cache writable

### 5. Performance
- [ ] Config cached: `php artisan config:cache`
- [ ] Routes cached: `php artisan route:cache`
- [ ] Views cached: `php artisan view:cache`
- [ ] Optimize autoloader: `composer dump-autoload --optimize`
- [ ] Enable OPcache in PHP
- [ ] Database indexes created
- [ ] Query optimization done

### 6. Testing
- [ ] All features tested manually
- [ ] Login/Logout working
- [ ] Dashboard displays correctly
- [ ] All CRUD operations working
- [ ] Role-based access control working
- [ ] Charts rendering correctly
- [ ] Forms validation working
- [ ] Error handling working
- [ ] Responsive design tested on multiple devices
- [ ] Cross-browser testing done (Chrome, Firefox, Safari)

### 7. Monitoring & Logging
- [ ] Error logging configured
- [ ] Log rotation setup
- [ ] Monitoring tools installed (optional)
- [ ] Backup strategy in place

## Deployment Steps

### Step 1: Prepare Server
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install php8.2 php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl nginx mysql-server -y
```

### Step 2: Clone & Setup Project
```bash
# Clone repository
git clone <repository-url> /var/www/sidewalk-dashboard
cd /var/www/sidewalk-dashboard

# Install dependencies
composer install --optimize-autoloader --no-dev

# Set permissions
sudo chown -R www-data:www-data /var/www/sidewalk-dashboard
sudo chmod -R 755 /var/www/sidewalk-dashboard
sudo chmod -R 775 /var/www/sidewalk-dashboard/storage
sudo chmod -R 775 /var/www/sidewalk-dashboard/bootstrap/cache
```

### Step 3: Configure Environment
```bash
# Copy environment file
cp .env.example .env

# Edit .env file
nano .env

# Generate application key
php artisan key:generate
```

### Step 4: Database Setup
```bash
# Create database
mysql -u root -p
CREATE DATABASE sidewalk_db;
CREATE USER 'sidewalk_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON sidewalk_db.* TO 'sidewalk_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Run migrations
php artisan migrate --force
```

### Step 5: Optimize Application
```bash
# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

### Step 6: Configure Web Server (Nginx)
```nginx
# /etc/nginx/sites-available/sidewalk-dashboard

server {
    listen 80;
    server_name your-domain.com;
    root /var/www/sidewalk-dashboard/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/sidewalk-dashboard /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### Step 7: SSL Certificate (Let's Encrypt)
```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx -y

# Get certificate
sudo certbot --nginx -d your-domain.com

# Auto-renewal
sudo certbot renew --dry-run
```

## Post-Deployment Checklist

### 1. Verification
- [ ] Website accessible via domain
- [ ] HTTPS working
- [ ] Login page loads correctly
- [ ] Dashboard loads after login
- [ ] All menu items accessible
- [ ] Charts rendering
- [ ] CRUD operations working
- [ ] No console errors
- [ ] No PHP errors in logs

### 2. Performance Check
- [ ] Page load time < 3 seconds
- [ ] Images optimized
- [ ] CSS/JS minified
- [ ] Caching working
- [ ] Database queries optimized

### 3. Security Check
- [ ] HTTPS enforced
- [ ] Security headers set
- [ ] File permissions correct
- [ ] Debug mode off
- [ ] Error messages don't expose sensitive info
- [ ] SQL injection protection working
- [ ] XSS protection working
- [ ] CSRF protection working

### 4. Backup
- [ ] Database backup automated
- [ ] File backup automated
- [ ] Backup restoration tested
- [ ] Backup stored off-site

### 5. Documentation
- [ ] User manual provided
- [ ] Admin documentation available
- [ ] API documentation (if applicable)
- [ ] Deployment notes documented

## Rollback Plan

If deployment fails:

1. **Restore Database**
```bash
mysql -u sidewalk_user -p sidewalk_db < backup.sql
```

2. **Restore Files**
```bash
cp -r /backup/sidewalk-dashboard /var/www/
```

3. **Clear Caches**
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

4. **Restart Services**
```bash
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
```

## Maintenance Mode

Enable maintenance mode during updates:
```bash
# Enable
php artisan down --message="Sedang maintenance, akan kembali sebentar lagi"

# Disable
php artisan up
```

## Support Contacts

- **Developer**: [Your Contact]
- **Server Admin**: [Admin Contact]
- **Emergency**: [Emergency Contact]

---

**Last Updated**: [Date]
**Deployed By**: [Name]
**Version**: 1.0.0

