# Complete Setup Guide - Sir Isaac Newton School Management Platform

This comprehensive guide will help you set up the entire system from scratch.

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- MySQL/PostgreSQL (or SQLite for development)
- Git

## Step 1: Backend Setup

### 1.1 Install PHP Dependencies

```bash
composer install
```

### 1.2 Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

### 1.3 Configure Database

Edit `.env` file:

**For SQLite (Development):**
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

**For MySQL/PostgreSQL (Production):**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sir_isaac_newton
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 1.4 Run Migrations

```bash
php artisan migrate
```

### 1.5 Seed Database

```bash
php artisan db:seed
```

This will create:
- Roles and permissions
- School information (Sir Isaac Newton School)
- Default admin user
- Test accounts

### 1.6 Configure Sanctum (CORS)

The CORS configuration is already set up. If you need to add more domains, edit `config/sanctum.php`:

```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 'localhost,localhost:3001,localhost:3002,localhost:3003')),
```

### 1.7 Start Backend Server

```bash
php artisan serve
```

Backend will run on: `http://localhost:8000`

---

## Step 2: Frontend Setup

### 2.1 Driver Tool

```bash
cd frontend/driver-tool
npm install

# Create .env file
echo "VITE_API_BASE_URL=http://localhost:8000/api/v1" > .env

# Start development server
npm run dev
```

Access at: `http://localhost:3001`

### 2.2 Parent Portal

```bash
cd frontend/parent-portal
npm install

# Create .env file
echo "VITE_API_BASE_URL=http://localhost:8000/api/v1" > .env

# Start development server
npm run dev
```

Access at: `http://localhost:3002`

### 2.3 Teacher Portal

```bash
cd frontend/teacher-portal
npm install

# Create .env file
echo "VITE_API_BASE_URL=http://localhost:8000/api/v1" > .env

# Start development server
npm run dev
```

Access at: `http://localhost:3003`

---

## Step 3: Verify Installation

### 3.1 Test Backend API

```bash
# Test public endpoint
curl http://localhost:8000/api/v1/website/school-info

# Should return school information
```

### 3.2 Test Authentication

```bash
# Login test
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@sirisaacnewton.edu",
    "password": "password",
    "user_type": "user"
  }'
```

### 3.3 Test Frontend Apps

1. Open each frontend app in browser
2. Try logging in with test credentials
3. Verify API connectivity

---

## Step 4: Default Credentials

After seeding, you can login with:

### Admin
- Email: `admin@sirisaacnewton.edu`
- Password: `password`
- **⚠️ Change immediately in production!**

### Test Accounts
Check `database/seeders/TestAccountsSeeder.php` for additional test accounts.

---

## Step 5: Production Deployment

### 5.1 Backend

1. **Set Environment:**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Optimize:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Set Permissions:**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

4. **Configure Web Server:**
   - Nginx/Apache configuration
   - SSL certificates
   - Domain setup

### 5.2 Frontend

1. **Build for Production:**
   ```bash
   cd frontend/driver-tool && npm run build
   cd ../parent-portal && npm run build
   cd ../teacher-portal && npm run build
   ```

2. **Deploy Built Files:**
   - Upload `dist/` folders to web server
   - Configure reverse proxy
   - Set up CDN if needed

### 5.3 Database

1. **Backup:**
   ```bash
   php artisan backup:run
   ```

2. **Migration:**
   ```bash
   php artisan migrate --force
   ```

---

## Step 6: Optional Features Setup

### 6.1 SMS Notifications

1. Configure SMS provider in `.env`:
   ```env
   SMS_PROVIDER=africas_talking
   AFRICAS_TALKING_API_KEY=your_key
   AFRICAS_TALKING_USERNAME=your_username
   ```

2. Test SMS:
   ```bash
   php artisan tinker
   >>> app(\App\Services\SmsService::class)->send('+254700000000', 'Test message');
   ```

### 6.2 Push Notifications

1. Set up Firebase Cloud Messaging
2. Add credentials to `.env`:
   ```env
   FCM_SERVER_KEY=your_server_key
   FCM_SENDER_ID=your_sender_id
   ```

### 6.3 GPS Tracking

1. Enable in `.env`:
   ```env
   ENABLE_GPS_TRACKING=true
   ```

2. Configure Google Maps API key in frontend apps

---

## Step 7: Troubleshooting

### CORS Issues

If you see CORS errors:

1. Check `config/sanctum.php` includes your frontend domain
2. Verify `config/cors.php` has correct origins
3. Clear config cache: `php artisan config:clear`

### Authentication Issues

1. Check token is being sent in headers
2. Verify Sanctum is configured correctly
3. Check token hasn't expired

### Database Issues

1. Verify database connection in `.env`
2. Check migrations ran successfully: `php artisan migrate:status`
3. Ensure database user has proper permissions

### Frontend Build Issues

1. Clear node_modules: `rm -rf node_modules && npm install`
2. Check Node.js version: `node --version` (should be 18+)
3. Clear npm cache: `npm cache clean --force`

---

## Step 8: Maintenance

### Regular Tasks

1. **Backup Database:**
   ```bash
   php artisan backup:run
   ```

2. **Clear Cache:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   ```

3. **Update Dependencies:**
   ```bash
   composer update
   npm update
   ```

### Monitoring

1. Check logs: `storage/logs/laravel.log`
2. Monitor API performance
3. Track error rates
4. Review audit logs

---

## Step 9: Security Checklist

- [ ] Change default passwords
- [ ] Set `APP_DEBUG=false` in production
- [ ] Configure SSL/HTTPS
- [ ] Set up firewall rules
- [ ] Enable rate limiting
- [ ] Configure backup schedule
- [ ] Set up monitoring
- [ ] Review file permissions
- [ ] Enable 2FA (if implemented)
- [ ] Regular security updates

---

## Support & Documentation

- **Architecture:** See `ARCHITECTURE.md`
- **API Documentation:** See `API_DOCUMENTATION.md`
- **Frontend Setup:** See `FRONTEND_SETUP.md`
- **Optional Features:** See `OPTIONAL_FEATURES.md`

---

## Quick Commands Reference

```bash
# Backend
php artisan serve                    # Start server
php artisan migrate                  # Run migrations
php artisan db:seed                 # Seed database
php artisan migrate:fresh --seed    # Reset database
php artisan cache:clear              # Clear cache

# Frontend (in each app directory)
npm install                          # Install dependencies
npm run dev                          # Development server
npm run build                        # Production build

# Testing
php artisan test                     # Run tests
```

---

**System Status:** ✅ Ready for Production

All components are configured and ready to use!

