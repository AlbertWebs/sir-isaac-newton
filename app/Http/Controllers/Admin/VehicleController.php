<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermission('transport.view')) {
            abort(403, 'Unauthorized access');
        }

        $query = Vehicle::query();

        // Search
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('registration_number', 'like', "%{$searchTerm}%")
                  ->orWhere('make', 'like', "%{$searchTerm}%")
                  ->orWhere('model', 'like', "%{$searchTerm}%")
                  ->orWhere('insurance_number', 'like', "%{$searchTerm}%")
                  ->orWhere('notes', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by vehicle type
        if ($request->filled('vehicle_type')) {
            $query->where('vehicle_type', $request->get('vehicle_type'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        $vehicles = $query->latest()->paginate(20)->withQueryString();
        $searchTerm = $request->get('search', '');
        $typeFilter = $request->get('vehicle_type', '');
        $statusFilter = $request->get('status', '');

        return view('admin.vehicles.index', compact('vehicles', 'searchTerm', 'typeFilter', 'statusFilter'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('transport.create')) {
            abort(403, 'Unauthorized access');
        }

        $vehicleTypes = ['bus', 'van', 'car', 'minibus', 'other'];

        return view('admin.vehicles.create', compact('vehicleTypes'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasPermission('transport.create')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'registration_number' => ['required', 'string', 'max:50', 'unique:vehicles,registration_number'],
            'make' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'color' => ['nullable', 'string', 'max:50'],
            'capacity' => ['required', 'integer', 'min:1'],
            'vehicle_type' => ['required', 'in:bus,van,car,minibus,other'],
            'insurance_number' => ['nullable', 'string', 'max:100'],
            'insurance_expiry' => ['nullable', 'date'],
            'inspection_expiry' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive,maintenance'],
            'notes' => ['nullable', 'string'],
        ]);

        Vehicle::create($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehicle created successfully!');
    }

    public function show(Vehicle $vehicle)
    {
        if (!auth()->user()->hasPermission('transport.view')) {
            abort(403, 'Unauthorized access');
        }

        $vehicle->load('routes');
        $routeCount = $vehicle->routes()->count();

        return view('admin.vehicles.show', compact('vehicle', 'routeCount'));
    }

    public function edit(Vehicle $vehicle)
    {
        if (!auth()->user()->hasPermission('transport.edit')) {
            abort(403, 'Unauthorized access');
        }

        $vehicleTypes = ['bus', 'van', 'car', 'minibus', 'other'];

        return view('admin.vehicles.edit', compact('vehicle', 'vehicleTypes'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        if (!auth()->user()->hasPermission('transport.edit')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'registration_number' => ['required', 'string', 'max:50', 'unique:vehicles,registration_number,' . $vehicle->id],
            'make' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'color' => ['nullable', 'string', 'max:50'],
            'capacity' => ['required', 'integer', 'min:1'],
            'vehicle_type' => ['required', 'in:bus,van,car,minibus,other'],
            'insurance_number' => ['nullable', 'string', 'max:100'],
            'insurance_expiry' => ['nullable', 'date'],
            'inspection_expiry' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive,maintenance'],
            'notes' => ['nullable', 'string'],
        ]);

        $vehicle->update($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehicle updated successfully!');
    }

    public function destroy(Vehicle $vehicle)
    {
        if (!auth()->user()->hasPermission('transport.delete')) {
            abort(403, 'Unauthorized access');
        }

        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehicle deleted successfully!');
    }
}

