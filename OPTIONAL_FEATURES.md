# Optional Features - Design & Implementation Guide

This document outlines the optional features for the Sir Isaac Newton School Management Platform.

## 1. GPS Live Bus Tracking 🗺️

### Design
- Real-time location tracking using GPS coordinates
- Integration with Google Maps or Mapbox
- Live route visualization
- Estimated arrival time calculations

### Implementation Plan

#### Backend
1. **New Endpoint:** `POST /api/v1/transport/trips/{id}/location`
   - Accept GPS coordinates from driver app
   - Store in `trip_sessions` table (already has latitude/longitude fields)
   - Update location every 30 seconds

2. **New Endpoint:** `GET /api/v1/transport/trips/{id}/location`
   - Return current bus location
   - Calculate distance to next stop
   - Estimate arrival time

3. **WebSocket/Broadcasting:**
   - Use Laravel Broadcasting with Pusher/Redis
   - Real-time location updates to parents
   - Push notifications when bus is approaching

#### Frontend
1. **Driver Tool:**
   - Background geolocation tracking
   - Automatic location updates
   - Map view of current route

2. **Parent Portal:**
   - Live map showing bus location
   - Estimated arrival time
   - Push notification: "Bus is 5 minutes away"

### Database Changes
- Already have `latitude` and `longitude` in `trip_sessions` and `pickup_logs`
- Add `location_history` table for tracking:
  ```sql
  CREATE TABLE location_history (
    id BIGINT PRIMARY KEY,
    trip_session_id BIGINT,
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),
    recorded_at TIMESTAMP,
    INDEX(trip_session_id, recorded_at)
  );
  ```

### Technologies
- **Backend:** Laravel Broadcasting, Redis/Pusher
- **Frontend:** Google Maps API or Mapbox
- **Mobile:** React Native Geolocation API

---

## 2. SMS Fallback Notifications 📱

### Design
- Automatic SMS when push notification fails
- SMS for critical alerts (emergency, transport delays)
- Configurable SMS templates
- Integration with existing SMS service

### Implementation Plan

#### Backend
1. **Update NotificationService:**
   ```php
   public function sendNotification($notifiable, $title, $message, $data = [], $channel = 'push', $type = 'general') {
       $notification = Notification::create([...]);
       
       // Try push first
       try {
           $this->sendPushNotification(...);
       } catch (\Exception $e) {
           // Fallback to SMS
           if ($notifiable->phone) {
               $this->sendSms($notifiable->phone, $message);
           }
       }
       
       return $notification;
   }
   ```

2. **SMS Templates:**
   - Transport: "Bus has picked up {student_name} from {stop_name}"
   - Emergency: "URGENT: {message}"
   - Attendance: "{student_name} was {status} today"

3. **Configuration:**
   - Enable/disable SMS fallback per notification type
   - Rate limiting to prevent spam
   - Cost tracking

### Integration
- Use existing `SmsService` in `app/Services/SmsService.php`
- Configure SMS provider in `.env`
- Add SMS credits/budget tracking

---

## 3. Student QR Scan for Pickup 🔲

### Design
- Generate unique QR code for each student
- Driver scans QR code to verify identity
- Automatic pickup confirmation
- Prevents unauthorized pickups

### Implementation Plan

#### Backend
1. **QR Code Generation:**
   - Endpoint: `GET /api/v1/students/{id}/qr-code`
   - Generate QR containing: `student_id`, `timestamp`, `signature`
   - Store QR code image in storage

2. **QR Verification:**
   - Endpoint: `POST /api/v1/transport/verify-qr`
   - Validate QR code signature
   - Check if student is assigned to route
   - Create pickup log automatically

3. **Security:**
   - Time-based tokens (expire after 1 hour)
   - Cryptographic signature verification
   - Rate limiting on verification attempts

#### Frontend
1. **Parent Portal:**
   - Display student QR code
   - Download/print QR code
   - Regenerate QR code option

2. **Driver Tool:**
   - QR scanner component
   - Camera access for scanning
   - Automatic pickup confirmation on scan

### Database Changes
- Add `qr_code` and `qr_code_expires_at` to `students` table
- Add `qr_verification_logs` table for audit

### Technologies
- **Backend:** Simple QrCode library (simplesoftwareio/simple-qrcode)
- **Frontend:** react-qr-scanner or html5-qrcode

---

## 4. Emergency Broadcast Alerts 🚨

### Design
- School-wide emergency notifications
- Multi-channel delivery (push, SMS, email)
- Priority override for all notifications
- Acknowledgment tracking

### Implementation Plan

#### Backend
1. **New Endpoint:** `POST /api/v1/emergency/broadcast`
   - Requires admin permission
   - Sends to all users immediately
   - Bypasses normal notification queue

2. **Emergency Types:**
   - School closure
   - Weather alert
   - Security alert
   - Medical emergency

3. **Delivery Channels:**
   - Push notification (highest priority)
   - SMS (if phone available)
   - Email (backup)
   - In-app notification

#### Frontend
1. **Admin Dashboard:**
   - Emergency broadcast form
   - Template selection
   - Preview before sending

2. **All Portals:**
   - Emergency alert banner
   - Cannot be dismissed easily
   - Requires acknowledgment

### Database Changes
- Add `emergency_broadcasts` table
- Add `emergency_acknowledgments` table
- Track delivery status

---

## 5. Analytics Dashboard 📊

### Design
- Visual analytics for school operations
- Attendance trends
- Transport efficiency metrics
- Academic performance insights
- Custom date range filtering

### Implementation Plan

#### Backend
1. **New Endpoint:** `GET /api/v1/analytics/dashboard`
   - Aggregate data from multiple sources
   - Calculate key metrics
   - Return formatted statistics

2. **Metrics:**
   - Attendance rate by class/student
   - Transport on-time performance
   - Average exam scores
   - Student enrollment trends
   - Route efficiency

3. **Caching:**
   - Cache analytics for performance
   - Refresh every 15 minutes
   - Real-time option available

#### Frontend
1. **Admin Dashboard:**
   - Charts and graphs (Chart.js or Recharts)
   - Interactive filters
   - Export to PDF/Excel

2. **Visualizations:**
   - Line charts for trends
   - Bar charts for comparisons
   - Pie charts for distributions
   - Heatmaps for patterns

### Technologies
- **Backend:** Laravel aggregation queries
- **Frontend:** Chart.js, Recharts, or D3.js
- **Caching:** Redis

---

## 6. Multi-School Support 🏫

### Design
- Support multiple schools in one installation
- School-specific data isolation
- Centralized admin management
- School switching for users

### Implementation Plan

#### Database Changes
1. **Add `school_id` to all relevant tables:**
   - users, students, teachers, classes
   - routes, vehicles, drivers
   - announcements, notifications
   - All other school-specific data

2. **New `schools` table:**
   ```sql
   CREATE TABLE schools (
     id BIGINT PRIMARY KEY,
     name VARCHAR(255),
     code VARCHAR(50) UNIQUE,
     settings JSON,
     status ENUM('active', 'inactive'),
     created_at TIMESTAMP,
     updated_at TIMESTAMP
   );
   ```

#### Backend
1. **Middleware:** `EnsureSchoolContext`
   - Set school context from request
   - Filter queries by school_id
   - Validate school access

2. **Scoping:**
   - All models scoped by school_id
   - Global scope applied automatically
   - Admin can access all schools

#### Frontend
1. **School Selector:**
   - Dropdown in header
   - Switch between schools
   - Remember selection

2. **Multi-tenancy:**
   - Separate data per school
   - School-specific branding
   - Independent configurations

---

## Implementation Priority

### Phase 1 (High Priority)
1. ✅ SMS Fallback Notifications
2. ✅ Emergency Broadcast Alerts
3. ✅ Analytics Dashboard (Basic)

### Phase 2 (Medium Priority)
4. GPS Live Bus Tracking
5. Student QR Scan for Pickup

### Phase 3 (Future)
6. Multi-School Support

---

## Notes

- All features are designed to be optional and can be enabled/disabled
- Features can be implemented incrementally
- Each feature maintains backward compatibility
- Security and privacy are prioritized in all designs

---

**Status:** Designed and ready for implementation ✅

