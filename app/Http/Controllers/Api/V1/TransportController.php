<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\RouteStop;
use App\Models\RouteAssignment;
use App\Models\TripSession;
use App\Models\PickupLog;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Student;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransportController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Get all routes
     */
    public function routes(Request $request)
    {
        $query = Route::with(['vehicle', 'driver', 'stops']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->get());
    }

    /**
     * Get route details
     */
    public function showRoute($id)
    {
        $route = Route::with(['vehicle', 'driver', 'stops', 'students'])
            ->findOrFail($id);

        return response()->json($route);
    }

    /**
     * Create route
     */
    public function createRoute(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|unique:routes,code',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'type' => 'required|in:morning,afternoon,both',
            'morning_pickup_time' => 'nullable|date_format:H:i',
            'morning_dropoff_time' => 'nullable|date_format:H:i',
            'afternoon_pickup_time' => 'nullable|date_format:H:i',
            'afternoon_dropoff_time' => 'nullable|date_format:H:i',
        ]);

        $route = Route::create($request->all());

        return response()->json($route, 201);
    }

    /**
     * Update route
     */
    public function updateRoute(Request $request, $id)
    {
        $route = Route::findOrFail($id);

        $request->validate([
            'code' => 'sometimes|unique:routes,code,' . $id,
        ]);

        $route->update($request->all());

        return response()->json($route);
    }

    /**
     * Delete route
     */
    public function deleteRoute($id)
    {
        $route = Route::findOrFail($id);
        $route->delete();

        return response()->json(['message' => 'Route deleted successfully']);
    }

    /**
     * Assign students to route
     */
    public function assignStudents(Request $request, $id)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'pickup_stop_id' => 'nullable|exists:route_stops,id',
            'dropoff_stop_id' => 'nullable|exists:route_stops,id',
            'service_type' => 'required|in:morning,afternoon,both',
        ]);

        $route = Route::findOrFail($id);

        DB::transaction(function () use ($route, $request) {
            foreach ($request->student_ids as $studentId) {
                // Deactivate existing assignments
                RouteAssignment::where('student_id', $studentId)
                    ->where('status', 'active')
                    ->update(['status' => 'cancelled']);

                // Create new assignment
                RouteAssignment::create([
                    'route_id' => $route->id,
                    'student_id' => $studentId,
                    'pickup_stop_id' => $request->pickup_stop_id,
                    'dropoff_stop_id' => $request->dropoff_stop_id,
                    'service_type' => $request->service_type,
                    'status' => 'active',
                ]);

                // Update student transport flag
                Student::where('id', $studentId)->update(['uses_transport' => true]);
            }
        });

        return response()->json(['message' => 'Students assigned successfully']);
    }

    /**
     * Get driver's assigned routes
     */
    public function myRoutes(Request $request)
    {
        $driver = Driver::where('user_id', $request->user()->id)->first();

        if (!$driver) {
            return response()->json(['error' => 'Driver not found'], 404);
        }

        $routes = Route::with(['vehicle', 'stops', 'students'])
            ->where('driver_id', $driver->id)
            ->where('status', 'active')
            ->get();

        return response()->json($routes);
    }

    /**
     * Get students for a trip session
     */
    public function tripStudents($tripId, Request $request)
    {
        $trip = TripSession::with(['route', 'route.students'])
            ->findOrFail($tripId);

        $students = $trip->route->students()
            ->wherePivot('status', 'active')
            ->get();

        // Get pickup logs for this trip
        $pickupLogs = PickupLog::where('trip_session_id', $tripId)
            ->with('student')
            ->get()
            ->keyBy('student_id');

        $studentsWithStatus = $students->map(function ($student) use ($pickupLogs, $trip) {
            $log = $pickupLogs->get($student->id);
            return [
                'id' => $student->id,
                'name' => $student->full_name,
                'student_number' => $student->student_number,
                'pickup_status' => $log ? $log->status : 'pending',
                'pickup_log_id' => $log ? $log->id : null,
            ];
        });

        return response()->json([
            'trip' => $trip,
            'students' => $studentsWithStatus,
        ]);
    }

    /**
     * Mark pickup/dropoff status
     */
    public function markPickup(Request $request, $logId)
    {
        $log = PickupLog::with(['student', 'tripSession', 'routeStop'])->findOrFail($logId);

        $request->validate([
            'status' => 'required|in:picked,dropped,missed',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        $log->update([
            'status' => $request->status,
            'actual_time' => now(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'notes' => $request->notes,
        ]);

        // Send notification to parents
        $this->sendPickupNotification($log);

        return response()->json($log);
    }

    /**
     * Get student transport status
     */
    public function studentStatus($studentId)
    {
        $assignment = RouteAssignment::with(['route', 'route.vehicle', 'route.driver', 'pickupStop', 'dropoffStop'])
            ->where('student_id', $studentId)
            ->where('status', 'active')
            ->first();

        if (!$assignment) {
            return response()->json(['message' => 'No active transport assignment'], 404);
        }

        // Get today's trip sessions
        $todayTrips = TripSession::where('route_id', $assignment->route_id)
            ->where('trip_date', today())
            ->get();

        // Get today's pickup logs
        $todayLogs = PickupLog::where('student_id', $studentId)
            ->whereIn('trip_session_id', $todayTrips->pluck('id'))
            ->get();

        return response()->json([
            'assignment' => $assignment,
            'today_trips' => $todayTrips,
            'today_logs' => $todayLogs,
        ]);
    }

    /**
     * Get vehicles
     */
    public function vehicles()
    {
        return response()->json(Vehicle::all());
    }

    /**
     * Create vehicle
     */
    public function createVehicle(Request $request)
    {
        $request->validate([
            'registration_number' => 'required|unique:vehicles,registration_number',
            'make' => 'required|string',
            'model' => 'required|string',
            'capacity' => 'required|integer|min:1',
        ]);

        $vehicle = Vehicle::create($request->all());

        return response()->json($vehicle, 201);
    }

    /**
     * Get drivers
     */
    public function drivers()
    {
        return response()->json(Driver::all());
    }

    /**
     * Create driver
     */
    public function createDriver(Request $request)
    {
        $request->validate([
            'driver_number' => 'required|unique:drivers,driver_number',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|unique:drivers,phone',
            'license_number' => 'required|unique:drivers,license_number',
            'license_expiry' => 'required|date',
        ]);

        $driver = Driver::create($request->all());

        return response()->json($driver, 201);
    }

    /**
     * Send pickup notification to parents
     */
    protected function sendPickupNotification(PickupLog $log)
    {
        $student = $log->student;
        $parents = $student->parents()->wherePivot('emergency_contact', true)->get();

        $message = match($log->status) {
            'picked' => "Bus has picked up {$student->full_name} from {$log->routeStop->name}",
            'dropped' => "Bus has dropped off {$student->full_name} at {$log->routeStop->name}",
            default => "Transport update for {$student->full_name}",
        };

        foreach ($parents as $parent) {
            $this->notificationService->sendNotification(
                $parent,
                'Transport Update',
                $message,
                ['type' => 'transport', 'pickup_log_id' => $log->id]
            );
        }
    }
}

