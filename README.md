# Sir Isaac Newton School Management Platform

**Motto:** "Creating World Changers."

A comprehensive, modern School Management Platform designed for Kenyan curriculum schools, supporting early years through primary education with integrated transportation, academics, and communication systems.

## 🎓 School Information

- **Name:** Sir Isaac Newton School
- **Levels:** Daycare, Playgroup, PP1, PP2, Grade 1-6
- **Languages:** French & German
- **Special Programs:** Coding & Robotics

## ✨ Key Features

### 🏫 Academic Management
- **Multi-level Support:** Daycare through Grade 6
- **Class Management:** Organize students by class and academic year
- **Subject Management:** Core subjects, languages, and special programs
- **Timetable System:** Complete scheduling for all classes
- **Attendance Tracking:** Real-time attendance marking and reporting
- **Exams & Results:** Comprehensive exam and result management

### 🚌 Transportation System (Core Feature)
- **Route Management:** Create and optimize bus routes
- **Vehicle & Driver Management:** Complete fleet management
- **Student Assignment:** Assign students to routes with pickup/dropoff stops
- **Driver Checklist:** Mobile-friendly interface for drivers
- **Real-time Tracking:** Pickup/dropoff status tracking
- **Automatic Notifications:** Parents receive instant updates:
  - "Bus is approaching"
  - "Student picked"
  - "Student dropped"

### 👥 User Management
- **7 User Roles:**
  - Admin (Super Admin)
  - Teachers
  - Parents
  - Students (read-only)
  - Transport Drivers
  - Transport Manager
  - Website (public API)
- **Granular Permissions:** 80+ permissions across all modules
- **Role-Based Access Control:** Secure, permission-based access

### 📱 Multiple Portals
- **Admin Dashboard:** Full system management (Laravel Blade)
- **Parent Portal:** React SPA (to be implemented)
- **Teacher Portal:** React SPA (to be implemented)
- **Driver Tool:** React PWA for mobile pickup management (to be implemented)
- **Student Portal:** Existing Laravel Blade portal

### 📢 Communication
- **Announcements:** School-wide and class-based announcements
- **Notifications:** Push notifications, SMS fallback ready
- **Multi-channel:** In-app, SMS, and email support

### 🎯 Extracurricular Activities
- **Clubs Management:** Sports, academic, arts, cultural clubs
- **Membership Tracking:** Student participation management
- **Schedules:** Club meeting schedules

### 🌐 Website Integration
- **Public API:** Frontend-agnostic website API endpoints
- **School Information:** Dynamic content management
- **Programs:** Public program listings
- **Announcements:** Public announcement feed

## 🛠 Technology Stack

### Backend
- **Framework:** Laravel 12 (PHP 8.2+)
- **API:** REST API with Laravel Sanctum authentication
- **Database:** MySQL/PostgreSQL (SQLite for development)
- **Queue System:** Laravel Queue for background jobs

### Frontend (To Be Implemented)
- **Admin Dashboard:** Laravel Blade + Tailwind CSS + Alpine.js
- **Parent Portal:** React (SPA)
- **Teacher Portal:** React (SPA)
- **Driver Tool:** React PWA

## 📋 Installation

See [QUICK_START.md](QUICK_START.md) for detailed installation instructions.

### Quick Setup

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Build assets
npm run build

# Start server
php artisan serve
```

## 📚 Documentation

- **[ARCHITECTURE.md](ARCHITECTURE.md)** - System architecture and design
- **[API_DOCUMENTATION.md](API_DOCUMENTATION.md)** - Complete API reference
- **[IMPLEMENTATION_SUMMARY.md](IMPLEMENTATION_SUMMARY.md)** - Implementation status and features
- **[QUICK_START.md](QUICK_START.md)** - Quick start guide

## 🔌 API Endpoints

### Base URL
```
/api/v1
```

### Key Endpoints

**Authentication:**
- `POST /auth/login` - Multi-user type authentication
- `GET /auth/me` - Get authenticated user
- `POST /auth/logout` - Logout

**Transportation:**
- `GET /transport/routes` - List routes
- `POST /transport/routes` - Create route
- `POST /transport/routes/{id}/assign-students` - Assign students
- `GET /transport/driver/my-routes` - Driver's routes
- `POST /transport/driver/pickup/{id}` - Mark pickup/dropoff

**Academics:**
- `GET /academics/classes` - List classes
- `GET /academics/timetables` - Get timetables
- `POST /academics/attendance/mark` - Mark attendance
- `GET /academics/results` - View results

**Students:**
- `GET /students` - List students
- `GET /students/{id}` - Student details
- `GET /students/{id}/attendance` - Student attendance

**Public Website:**
- `GET /website/school-info` - School information
- `GET /website/programs` - Programs offered
- `GET /website/announcements` - Public announcements

See [API_DOCUMENTATION.md](API_DOCUMENTATION.md) for complete API reference.

## 🔐 Security Features

- **Laravel Sanctum** token-based authentication
- **Role-Based Access Control** (RBAC)
- **Permission Middleware** for granular access
- **Input Validation** on all endpoints
- **SQL Injection Prevention** via Eloquent ORM
- **XSS Protection** built-in
- **Audit Logging** for critical actions

## 📊 Database Schema

The system includes 23+ database tables covering:
- Users, Roles, Permissions
- Students, Parents, Teachers
- Classes, Subjects, Timetables
- Vehicles, Drivers, Routes
- Transportation tracking
- Extracurricular activities
- Announcements & Notifications
- School information

## 🚀 Current Status

### ✅ Completed
- Backend API (REST endpoints)
- Database schema (23+ migrations)
- Authentication system (Sanctum)
- Role & permission system
- Transportation core features
- Academic operations
- Notification service
- Website public API

### 🚧 In Progress / Pending
- React frontend applications
- GPS live tracking integration
- SMS gateway integration
- Push notification setup
- QR code scanning
- Analytics dashboard

## 🎯 System Capabilities

The platform supports:

1. **Multi-level Education**
   - Early Years: Daycare, Playgroup, PP1, PP2
   - Primary: Grade 1-6

2. **Language Programs**
   - French
   - German

3. **Special Programs**
   - Coding
   - Robotics

4. **Transportation**
   - Complete route management
   - Real-time student tracking
   - Automatic parent notifications

5. **Academic Operations**
   - Class & subject management
   - Attendance tracking
   - Exams & results

6. **Communication**
   - Multi-channel notifications
   - Announcements system

## 📝 Default Credentials

After seeding:
- **Super Admin:** `admin@sirisaacnewton.edu` / `password`
- Check seeders for additional test accounts

**⚠️ Change default passwords immediately in production!**

## 🤝 Contributing

This is a comprehensive school management system. When contributing:

1. Follow Laravel coding standards
2. Write tests for new features
3. Update documentation
4. Follow the existing architecture patterns

## 📄 License

MIT License

## 📞 Support

For issues or questions:
- Review documentation files
- Check API documentation
- Review implementation summary

---

**School Name:** Sir Isaac Newton School  
**Motto:** "Creating World Changers."

Built with ❤️ for modern education management.
