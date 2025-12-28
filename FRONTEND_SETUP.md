# Frontend Applications Setup Guide

This guide will help you set up and run the React frontend applications for the Sir Isaac Newton School Management Platform.

## Applications

1. **Driver Tool** (Port 3001) - PWA for transport drivers
2. **Parent Portal** (Port 3002) - SPA for parents
3. **Teacher Portal** (Port 3003) - SPA for teachers

## Prerequisites

- Node.js 18+ and npm
- Backend API running on `http://localhost:8000`

## Setup Instructions

### 1. Driver Tool

```bash
cd frontend/driver-tool
npm install
npm run dev
```

Access at: `http://localhost:3001`

### 2. Parent Portal

```bash
cd frontend/parent-portal
npm install
npm run dev
```

Access at: `http://localhost:3002`

### 3. Teacher Portal

```bash
cd frontend/teacher-portal
npm install
npm run dev
```

Access at: `http://localhost:3003`

## Environment Variables

Create a `.env` file in each application directory:

```env
VITE_API_BASE_URL=http://localhost:8000/api/v1
```

For production, update to your production API URL.

## Building for Production

Each application can be built for production:

```bash
npm run build
```

The built files will be in the `dist` directory.

## Features

### Driver Tool
- ✅ Login/Logout
- ✅ View assigned routes
- ✅ View route details with stops
- ✅ Student checklist for trips
- ✅ Mark pickup/dropoff status
- ✅ GPS location tracking
- ✅ PWA support (installable)

### Parent Portal
- ✅ Login/Logout
- ✅ View children list
- ✅ Student details (overview, attendance, results, transport)
- ✅ View announcements
- ✅ View notifications
- ✅ Transport status tracking

### Teacher Portal
- ✅ Login/Logout
- ✅ Class management
- ✅ Attendance marking
- ✅ Results entry
- ✅ Announcements
- ✅ Student progress tracking

## API Integration

All applications connect to the backend API at `/api/v1`. Make sure:

1. Backend is running on port 8000
2. CORS is configured in Laravel
3. Sanctum authentication is working

## Troubleshooting

### CORS Issues
If you encounter CORS errors, ensure `config/sanctum.php` has:
```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 'localhost,localhost:3001,localhost:3002,localhost:3003')),
```

### Authentication Issues
- Check that tokens are being stored in localStorage
- Verify API base URL is correct
- Ensure backend API is accessible

### Build Issues
- Clear node_modules and reinstall: `rm -rf node_modules && npm install`
- Check Node.js version: `node --version` (should be 18+)

## Development Notes

- All apps use React 18 with React Router v6
- Tailwind CSS for styling (via CDN or can be configured)
- Axios for API calls
- Lucide React for icons

## Next Steps

1. Complete Teacher Portal implementation
2. Add more features to each portal
3. Implement real-time updates (WebSockets)
4. Add offline support for Driver Tool
5. Implement push notifications

