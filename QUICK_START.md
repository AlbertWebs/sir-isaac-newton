# Quick Start Guide - Sir Isaac Newton School Management Platform

## Prerequisites

- PHP 8.2+
- Composer
- Node.js & npm
- MySQL/PostgreSQL (or SQLite for development)
- Laravel 12

## Installation Steps

### 1. Install Dependencies

```bash
composer install
npm install
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sir_isaac_newton
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 3. Run Migrations

```bash
php artisan migrate
```

### 4. Seed Database

```bash
php artisan db:seed
```

This will seed:
- Roles and Permissions
- School Information (Sir Isaac Newton School)
- Default users (if configured)

### 5. Build Frontend Assets

```bash
npm run build
```

### 6. Start Development Server

```bash
php artisan serve
```

API will be available at: `http://localhost:8000/api/v1`

---

## Default Credentials

After seeding, default accounts may include:

### Super Admin
- Email: `admin@sirisaacnewton.edu`
- Password: `password` (change immediately!)

### Test Accounts
Check `database/seeders/TestAccountsSeeder.php` for test credentials.

---

## API Testing

### Using cURL

```bash
# Login
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@sirisaacnewton.edu",
    "password": "password",
    "user_type": "user"
  }'

# Use token in subsequent requests
curl http://localhost:8000/api/v1/school \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Using Postman

1. Import the API collection (create from `API_DOCUMENTATION.md`)
2. Set base URL: `http://localhost:8000/api/v1`
3. Login to get token
4. Set token in Authorization header for protected routes

---

## Key Features to Test

### 1. School Information
```bash
GET /api/v1/website/school-info
```

### 2. Transportation
```bash
# Create a route
POST /api/v1/transport/routes

# Assign students
POST /api/v1/transport/routes/{id}/assign-students

# Driver view
GET /api/v1/transport/driver/my-routes
```

### 3. Academics
```bash
# Get classes
GET /api/v1/academics/classes

# Mark attendance
POST /api/v1/academics/attendance/mark
```

### 4. Students
```bash
# List students
GET /api/v1/students

# Get student details
GET /api/v1/students/{id}
```

---

## Development Workflow

### Running Tests
```bash
php artisan test
```

### Code Formatting
```bash
./vendor/bin/pint
```

### Database Refresh
```bash
php artisan migrate:fresh --seed
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

---

## Next Steps

1. **Configure SMS Service**
   - Update `config/sms.php`
   - Add SMS provider credentials

2. **Set Up Push Notifications**
   - Configure Firebase Cloud Messaging
   - Update notification service

3. **Frontend Development**
   - Set up React projects
   - Connect to API endpoints
   - Implement authentication

4. **Production Deployment**
   - Set up production database
   - Configure environment variables
   - Set up SSL certificates
   - Configure queue workers

---

## Troubleshooting

### Migration Errors
```bash
php artisan migrate:fresh
php artisan db:seed
```

### Permission Errors
Ensure storage and cache directories are writable:
```bash
chmod -R 775 storage bootstrap/cache
```

### API Authentication Issues
- Check token is being sent correctly
- Verify token hasn't expired
- Ensure user has required permissions

---

## Support

For issues or questions:
1. Check `ARCHITECTURE.md` for system design
2. Review `API_DOCUMENTATION.md` for endpoint details
3. Check `IMPLEMENTATION_SUMMARY.md` for feature status

---

**School Name:** Sir Isaac Newton School  
**Motto:** "Creating World Changers."

