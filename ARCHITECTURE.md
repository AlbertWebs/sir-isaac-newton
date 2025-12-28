# School Management Platform Architecture
## Motto: "Creating World Changers"

## System Overview

A comprehensive, modular School Management Platform designed for a Kenyan curriculum school supporting:
- **Early Years**: Daycare, Playgroup, PP1, PP2
- **Primary**: Grade 1 - Grade 6
- **Languages**: French & German
- **Special Programs**: Coding & Robotics

## Architecture Principles

1. **Modular Design**: Each module is independent and can be scaled separately
2. **API-First**: REST API backend serves multiple frontend applications
3. **Role-Based Access Control**: Granular permissions for all user types
4. **Scalable**: Designed to handle growth and future multi-school support
5. **Production-Ready**: Security, logging, and monitoring built-in

## Technology Stack

### Backend
- **Framework**: Laravel 12 (PHP 8.2+)
- **API**: REST API (GraphQL optional for future)
- **Authentication**: JWT (JSON Web Tokens)
- **Database**: MySQL/PostgreSQL (SQLite for development)
- **Queue**: Laravel Queue for background jobs (notifications, SMS)
- **Cache**: Redis (optional, for performance)

### Frontend Applications
- **Admin Dashboard**: Laravel Blade + Tailwind CSS + Alpine.js (existing)
- **Parent Portal**: React (SPA)
- **Teacher Portal**: React (SPA) or Laravel Blade (existing)
- **Driver Tool**: React PWA (Progressive Web App)
- **Student Portal**: Laravel Blade (existing, can be upgraded to React)

### Infrastructure
- **Web Server**: Nginx/Apache
- **File Storage**: Local/S3-compatible storage
- **Notifications**: Push notifications (Firebase Cloud Messaging)
- **SMS**: SMS Gateway integration (existing)
- **Email**: SMTP (existing)

## System Modules

### 1. School Information Module
- School profile management
- Vision, mission, motto
- Facilities management
- Programs offered
- Public API endpoints for website

### 2. Academics Module
- Class/Grade management (Daycare → Grade 6)
- Subject management (Kenyan curriculum)
- Language programs (French, German)
- Coding & Robotics programs
- Teacher assignment
- Timetable management
- Attendance tracking
- Exams & results
- Reports generation

### 3. Student Management Module
- Student profiles
- Parent linkage
- Class assignment
- Medical information
- Pickup/drop-off authorization
- Academic history

### 4. Transportation Module (Core Feature)
- Vehicle management
- Driver management
- Route creation & optimization
- Student-to-route assignment
- Live trip session tracking
- Pickup/drop-off status
- Automatic notifications:
  - Bus approaching
  - Student picked
  - Student dropped

### 5. Extracurricular Activities Module
- Clubs & sports management
- Student participation tracking
- Schedule management

### 6. Announcements & Notifications Module
- School-wide announcements
- Class-based announcements
- Transport alerts
- Push notifications
- SMS fallback

### 7. User Management Module
- User accounts
- Role & permission management
- Authentication & authorization
- Audit logs

## User Roles & Permissions

### 1. Admin (Super Admin)
- Full system access
- User management
- System configuration
- All reports and analytics
- Transport management
- Website content management

### 2. Teachers
- Class management
- Attendance marking
- Results entry
- Subject management
- Announcements (class-level)
- Student progress tracking

### 3. Parents
- View child's profile
- View attendance
- View transport status
- Receive notifications
- View announcements
- View timetable & activities
- View results & reports

### 4. Students (Read-Only)
- View own profile
- View own attendance
- View own results
- View announcements
- View timetable

### 5. Transport Drivers
- View assigned routes
- Student checklist
- Mark pickup/drop-off status
- Trigger notifications

### 6. Transport Manager
- Route management
- Driver assignment
- Vehicle management
- Transport reports
- Route optimization

### 7. Website (Public API)
- Read-only access to:
  - School information
  - Programs
  - Announcements (public)
  - Contact information

## API Structure

### Base URL
```
/api/v1
```

### Authentication
```
POST /api/v1/auth/login
POST /api/v1/auth/logout
POST /api/v1/auth/refresh
```

### Endpoint Groups
- `/api/v1/school` - School information
- `/api/v1/academics` - Academic operations
- `/api/v1/students` - Student management
- `/api/v1/transport` - Transportation
- `/api/v1/extracurricular` - Clubs & activities
- `/api/v1/announcements` - Announcements
- `/api/v1/notifications` - Notifications
- `/api/v1/website` - Public website API

## Database Design Overview

### Core Tables
- `users` - System users (Admin, Teachers, etc.)
- `students` - Student profiles
- `parents` - Parent profiles
- `teachers` - Teacher profiles
- `classes` - Class/Grade definitions
- `subjects` - Subject catalog
- `timetables` - Class schedules
- `attendances` - Attendance records
- `exams` - Exam definitions
- `student_results` - Exam results

### Transportation Tables
- `vehicles` - Vehicle information
- `drivers` - Driver profiles
- `routes` - Route definitions
- `route_stops` - Route stop points
- `route_assignments` - Student-to-route assignments
- `trip_sessions` - Active trip tracking
- `pickup_logs` - Pickup/drop-off history

### Other Tables
- `clubs` - Extracurricular clubs
- `club_memberships` - Student club participation
- `announcements` - Announcements
- `notifications` - Notification queue
- `audit_logs` - System audit trail

## Frontend Applications

### 1. Admin Dashboard (Laravel Blade)
- Full system management
- Located at: `/admin/*`
- Uses existing Laravel Blade templates

### 2. Parent Portal (React SPA)
- Standalone React application
- API-driven
- Responsive design
- Push notifications support

### 3. Teacher Portal (React SPA or Laravel Blade)
- Class management interface
- Attendance & results entry
- Communication tools

### 4. Driver Tool (React PWA)
- Progressive Web App
- Offline capability
- Mobile-optimized
- Route & checklist interface

### 5. Student Portal (Laravel Blade - existing)
- Student self-service
- Can be upgraded to React later

## Security Features

1. **JWT Authentication**: Secure token-based auth
2. **Role-Based Access Control**: Granular permissions
3. **API Rate Limiting**: Prevent abuse
4. **CORS Configuration**: Secure cross-origin requests
5. **Input Validation**: All inputs validated
6. **SQL Injection Prevention**: Eloquent ORM
7. **XSS Protection**: Output escaping
8. **Audit Logging**: Track all critical actions
9. **Secure File Uploads**: Validation & storage
10. **Password Hashing**: Bcrypt/Argon2

## Scalability Considerations

1. **Database Indexing**: Optimized queries
2. **Caching Strategy**: Redis for frequently accessed data
3. **Queue System**: Background job processing
4. **CDN Integration**: Static asset delivery
5. **Load Balancing**: Multiple server support
6. **Multi-School Support**: School ID isolation (future)

## Future Enhancements

1. **GPS Live Tracking**: Real-time bus location
2. **QR Code Pickup**: Scan-based verification
3. **SMS Fallback**: Notification redundancy
4. **Analytics Dashboard**: Data insights
5. **Mobile Apps**: Native iOS/Android
6. **GraphQL API**: Alternative to REST
7. **Multi-Language Support**: i18n
8. **Advanced Reporting**: Custom reports builder

## Deployment Architecture

```
┌─────────────┐
│   Nginx     │
│  (Reverse   │
│   Proxy)    │
└──────┬──────┘
       │
       ├─────────────┐
       │             │
┌──────▼──────┐ ┌────▼──────┐
│   Laravel   │ │   React   │
│   Backend   │ │  Frontend │
│   (API)     │ │   Apps    │
└──────┬──────┘ └───────────┘
       │
┌──────▼──────┐
│  Database   │
│ (MySQL/PG)  │
└─────────────┘
```

## Development Workflow

1. **Backend First**: Implement API endpoints
2. **Database Migrations**: Schema design
3. **Models & Relationships**: Eloquent models
4. **Controllers & Services**: Business logic
5. **API Testing**: Postman/API tests
6. **Frontend Development**: React applications
7. **Integration Testing**: End-to-end tests
8. **Deployment**: Staging → Production

## Project Structure

```
sir-isaac-newton/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── V1/
│   │   │   │   │   ├── AuthController.php
│   │   │   │   │   ├── SchoolController.php
│   │   │   │   │   ├── AcademicsController.php
│   │   │   │   │   ├── TransportController.php
│   │   │   │   │   └── ...
│   │   │   │   └── WebsiteController.php (public)
│   │   │   └── ...
│   │   └── Middleware/
│   │       ├── ApiAuth.php
│   │       └── RoleCheck.php
│   ├── Models/
│   │   ├── Student.php
│   │   ├── Parent.php
│   │   ├── Teacher.php
│   │   ├── Route.php
│   │   ├── Vehicle.php
│   │   └── ...
│   ├── Services/
│   │   ├── TransportService.php
│   │   ├── NotificationService.php
│   │   └── ...
│   └── Jobs/
│       ├── SendPushNotification.php
│       └── SendSmsNotification.php
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   ├── api.php (API routes)
│   └── web.php (Web routes)
├── frontend/
│   ├── parent-portal/ (React)
│   ├── teacher-portal/ (React)
│   └── driver-tool/ (React PWA)
└── public/
    └── api/ (API documentation)
```

## Next Steps

1. ✅ Architecture defined
2. ⏭️ User roles & permissions implementation
3. ⏭️ Database schema design & migrations
4. ⏭️ API endpoint implementation
5. ⏭️ Frontend applications development
6. ⏭️ Integration & testing
7. ⏭️ Deployment preparation

