<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermission('transport.view')) {
            abort(403, 'Unauthorized access');
        }

        $query = Route::with(['vehicle', 'driver']);

        // Search
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('code', 'like', "%{$searchTerm}%")
                  ->orWhere('notes', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->get('type'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        $routes = $query->latest()->paginate(20)->withQueryString();
        $searchTerm = $request->get('search', '');
        $typeFilter = $request->get('type', '');
        $statusFilter = $request->get('status', '');

        return view('admin.routes.index', compact('routes', 'searchTerm', 'typeFilter', 'statusFilter'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('transport.create')) {
            abort(403, 'Unauthorized access');
        }

        $vehicles = Vehicle::where('status', 'active')->orderBy('registration_number')->get();
        $drivers = Driver::where('status', 'active')->orderBy('first_name')->get();
        $routeTypes = ['morning', 'afternoon', 'both'];

        return view('admin.routes.create', compact('vehicles', 'drivers', 'routeTypes'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasPermission('transport.create')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:routes,code'],
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'type' => ['required', 'in:morning,afternoon,both'],
            'morning_pickup_time' => ['required', 'date_format:H:i'],
            'morning_dropoff_time' => ['required', 'date_format:H:i'],
            'afternoon_pickup_time' => ['required', 'date_format:H:i'],
            'afternoon_dropoff_time' => ['required', 'date_format:H:i'],
            'estimated_distance_km' => ['nullable', 'numeric', 'min:0'],
            'estimated_duration_minutes' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
            'notes' => ['nullable', 'string'],
        ]);

        Route::create($validated);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route created successfully!');
    }

    public function show(Route $route)
    {
        if (!auth()->user()->hasPermission('transport.view')) {
            abort(403, 'Unauthorized access');
        }

        $route->load(['vehicle', 'driver', 'stops', 'students']);
        $studentCount = $route->students()->wherePivot('status', 'active')->count();

        return view('admin.routes.show', compact('route', 'studentCount'));
    }

    public function edit(Route $route)
    {
        if (!auth()->user()->hasPermission('transport.edit')) {
            abort(403, 'Unauthorized access');
        }

        $vehicles = Vehicle::where('status', 'active')->orderBy('registration_number')->get();
        $drivers = Driver::where('status', 'active')->orderBy('first_name')->get();
        $routeTypes = ['morning', 'afternoon', 'both'];

        return view('admin.routes.edit', compact('route', 'vehicles', 'drivers', 'routeTypes'));
    }

    public function update(Request $request, Route $route)
    {
        if (!auth()->user()->hasPermission('transport.edit')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:routes,code,' . $route->id],
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
            'driver_id' => ['nullable', 'exists:drivers,id'],
            'type' => ['required', 'in:morning,afternoon,both'],
            'morning_pickup_time' => ['required', 'date_format:H:i'],
            'morning_dropoff_time' => ['required', 'date_format:H:i'],
            'afternoon_pickup_time' => ['required', 'date_format:H:i'],
            'afternoon_dropoff_time' => ['required', 'date_format:H:i'],
            'estimated_distance_km' => ['nullable', 'numeric', 'min:0'],
            'estimated_duration_minutes' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
            'notes' => ['nullable', 'string'],
        ]);

        $route->update($validated);

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route updated successfully!');
    }

    public function destroy(Route $route)
    {
        if (!auth()->user()->hasPermission('transport.delete')) {
            abort(403, 'Unauthorized access');
        }

        $route->delete();

        return redirect()->route('admin.routes.index')
            ->with('success', 'Route deleted successfully!');
    }
}

