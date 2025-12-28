# Sir Isaac Newton School Management Platform - API Documentation

## Base URL
```
http://your-domain.com/api/v1
```

## Authentication

### Login
```http
POST /api/v1/auth/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password",
  "user_type": "user" // Options: user, parent, driver, teacher
}
```

**Response:**
```json
{
  "token": "1|xxxxxxxxxxxxx",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "type": "user"
  }
}
```

### Get Authenticated User
```http
GET /api/v1/auth/me
Authorization: Bearer {token}
```

### Logout
```http
POST /api/v1/auth/logout
Authorization: Bearer {token}
```

---

## Public Website API

### School Information
```http
GET /api/v1/website/school-info
```

### Programs
```http
GET /api/v1/website/programs
```

### Announcements
```http
GET /api/v1/website/announcements?limit=10
```

### Contact
```http
GET /api/v1/website/contact
```

---

## School Information (Admin)

### Get School Info
```http
GET /api/v1/school
Authorization: Bearer {token}
```

### Update School Info
```http
PUT /api/v1/school
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Sir Isaac Newton School",
  "motto": "Creating World Changers.",
  "vision": "...",
  "mission": "..."
}
```

---

## Academics

### Get Classes
```http
GET /api/v1/academics/classes?academic_year=2024/2025&level=grade_1
Authorization: Bearer {token}
```

### Get Subjects
```http
GET /api/v1/academics/subjects?type=core
Authorization: Bearer {token}
```

### Get Timetables
```http
GET /api/v1/academics/timetables?class_id=1&academic_year=2024/2025
Authorization: Bearer {token}
```

### Mark Attendance
```http
POST /api/v1/academics/attendance/mark
Authorization: Bearer {token}
Content-Type: application/json

{
  "student_id": 1,
  "course_id": 1,
  "attendance_date": "2024-01-15",
  "status": "present", // Options: present, absent, late, excused
  "notes": "Optional notes"
}
```

### Get Results
```http
GET /api/v1/academics/results?student_id=1&academic_year=2024/2025
Authorization: Bearer {token}
```

### Store Result
```http
POST /api/v1/academics/results
Authorization: Bearer {token}
Content-Type: application/json

{
  "student_id": 1,
  "course_id": 1,
  "academic_year": "2024/2025",
  "term": "Term 1",
  "exam_type": "Mid-term",
  "marks": 85,
  "grade": "A"
}
```

---

## Students

### List Students
```http
GET /api/v1/students?status=active&class_id=1&per_page=15
Authorization: Bearer {token}
```

### Get Student
```http
GET /api/v1/students/{id}
Authorization: Bearer {token}
```

### Create Student
```http
POST /api/v1/students
Authorization: Bearer {token}
Content-Type: application/json

{
  "student_number": "STU001",
  "first_name": "John",
  "last_name": "Doe",
  "email": "john@example.com",
  "level_of_education": "grade_1"
}
```

### Update Student
```http
PUT /api/v1/students/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "first_name": "Jane",
  "phone": "+254700000000"
}
```

### Get Student Attendance
```http
GET /api/v1/students/{id}/attendance?date_from=2024-01-01&date_to=2024-01-31
Authorization: Bearer {token}
```

### Get Student Results
```http
GET /api/v1/students/{id}/results?academic_year=2024/2025
Authorization: Bearer {token}
```

---

## Transportation

### List Routes
```http
GET /api/v1/transport/routes?status=active
Authorization: Bearer {token}
```

### Get Route Details
```http
GET /api/v1/transport/routes/{id}
Authorization: Bearer {token}
```

### Create Route
```http
POST /api/v1/transport/routes
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Route A - Westlands",
  "code": "RT-A",
  "vehicle_id": 1,
  "driver_id": 1,
  "type": "both", // Options: morning, afternoon, both
  "morning_pickup_time": "06:30",
  "morning_dropoff_time": "08:00",
  "afternoon_pickup_time": "15:00",
  "afternoon_dropoff_time": "16:30"
}
```

### Assign Students to Route
```http
POST /api/v1/transport/routes/{id}/assign-students
Authorization: Bearer {token}
Content-Type: application/json

{
  "student_ids": [1, 2, 3],
  "pickup_stop_id": 1,
  "dropoff_stop_id": 2,
  "service_type": "both"
}
```

### Driver: Get My Routes
```http
GET /api/v1/transport/driver/my-routes
Authorization: Bearer {token}
```

### Driver: Get Trip Students
```http
GET /api/v1/transport/driver/trip/{tripId}/students
Authorization: Bearer {token}
```

### Driver: Mark Pickup/Dropoff
```http
POST /api/v1/transport/driver/pickup/{logId}
Authorization: Bearer {token}
Content-Type: application/json

{
  "status": "picked", // Options: picked, dropped, missed
  "latitude": -1.2921,
  "longitude": 36.8219,
  "notes": "Student picked up on time"
}
```

### Get Student Transport Status
```http
GET /api/v1/transport/status/{studentId}
Authorization: Bearer {token}
```

### List Vehicles
```http
GET /api/v1/transport/vehicles
Authorization: Bearer {token}
```

### Create Vehicle
```http
POST /api/v1/transport/vehicles
Authorization: Bearer {token}
Content-Type: application/json

{
  "registration_number": "KCA 123A",
  "make": "Toyota",
  "model": "Hiace",
  "capacity": 14,
  "vehicle_type": "bus"
}
```

### List Drivers
```http
GET /api/v1/transport/drivers
Authorization: Bearer {token}
```

### Create Driver
```http
POST /api/v1/transport/drivers
Authorization: Bearer {token}
Content-Type: application/json

{
  "driver_number": "DRV001",
  "first_name": "John",
  "last_name": "Driver",
  "phone": "+254700000000",
  "license_number": "LIC123456",
  "license_expiry": "2025-12-31"
}
```

---

## Extracurricular

### List Clubs
```http
GET /api/v1/extracurricular/clubs?status=active&type=sports
Authorization: Bearer {token}
```

### Get Club Details
```http
GET /api/v1/extracurricular/clubs/{id}
Authorization: Bearer {token}
```

### Create Club
```http
POST /api/v1/extracurricular/clubs
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Football Club",
  "code": "FC",
  "type": "sports",
  "teacher_id": 1,
  "max_members": 20
}
```

### Get Club Members
```http
GET /api/v1/extracurricular/clubs/{id}/members?academic_year=2024/2025
Authorization: Bearer {token}
```

### Add Member to Club
```http
POST /api/v1/extracurricular/clubs/{id}/members
Authorization: Bearer {token}
Content-Type: application/json

{
  "student_id": 1,
  "academic_year": "2024/2025",
  "role": "member" // Options: member, leader, assistant_leader
}
```

---

## Announcements

### List Announcements
```http
GET /api/v1/announcements?target_audience=all&class_id=1
Authorization: Bearer {token}
```

### Get Announcement
```http
GET /api/v1/announcements/{id}
Authorization: Bearer {token}
```

### Create Announcement
```http
POST /api/v1/announcements
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "School Holiday",
  "message": "School will be closed on...",
  "target_audience": "all", // Options: all, students, parents, teachers
  "target_classes": [1, 2],
  "priority": "high" // Options: low, medium, high
}
```

### Update Announcement
```http
PUT /api/v1/announcements/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Updated Title",
  "status": "active"
}
```

### Delete Announcement
```http
DELETE /api/v1/announcements/{id}
Authorization: Bearer {token}
```

---

## Notifications

### List Notifications
```http
GET /api/v1/notifications?status=sent
Authorization: Bearer {token}
```

### Get Unread Notifications
```http
GET /api/v1/notifications/unread
Authorization: Bearer {token}
```

### Mark as Read
```http
POST /api/v1/notifications/{id}/read
Authorization: Bearer {token}
```

### Mark All as Read
```http
POST /api/v1/notifications/read-all
Authorization: Bearer {token}
```

---

## Error Responses

### Validation Error (422)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

### Unauthorized (401)
```json
{
  "message": "Unauthenticated."
}
```

### Not Found (404)
```json
{
  "message": "Resource not found."
}
```

### Forbidden (403)
```json
{
  "message": "This action is unauthorized."
}
```

---

## Rate Limiting

API endpoints are rate-limited. Default limits:
- 60 requests per minute for authenticated users
- 30 requests per minute for unauthenticated users

---

## Notes

1. All dates should be in `Y-m-d` format (e.g., "2024-01-15")
2. All times should be in `H:i` format (e.g., "14:30")
3. Pagination defaults to 15 items per page
4. Use `per_page` query parameter to change pagination size
5. All JSON responses use camelCase for consistency
6. Authentication token expires after 24 hours (configurable)

