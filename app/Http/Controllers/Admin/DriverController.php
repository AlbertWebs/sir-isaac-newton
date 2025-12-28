<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        // Check permission
        if (!auth()->user()->hasPermission('drivers.view')) {
            abort(403, 'Unauthorized access');
        }

        $query = Driver::query();
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('driver_number', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('license_number', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        $drivers = $query->with('user')->latest()->paginate(20)->withQueryString();
        $searchTerm = $request->get('search', '');
        $statusFilter = $request->get('status', '');

        return view('admin.drivers.index', compact('drivers', 'searchTerm', 'statusFilter'));
    }

    public function create()
    {
        if (!auth()->user()->hasPermission('drivers.create')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.drivers.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasPermission('drivers.create')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:drivers,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:drivers,phone'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'license_number' => ['required', 'string', 'max:255', 'unique:drivers,license_number'],
            'license_class' => ['required', 'string', 'max:10'],
            'license_expiry' => ['required', 'date'],
            'address' => ['nullable', 'string'],
            'status' => ['required', 'in:active,suspended,inactive'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);

        // Auto-capitalize names
        $validated['first_name'] = ucwords(strtolower(trim($validated['first_name'])));
        $validated['middle_name'] = $validated['middle_name'] ? ucwords(strtolower(trim($validated['middle_name']))) : null;
        $validated['last_name'] = ucwords(strtolower(trim($validated['last_name'])));
        $validated['address'] = $validated['address'] ? ucwords(strtolower(trim($validated['address']))) : null;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('driver-photos', 'public');
            $validated['photo'] = $photoPath;
        }

        // Generate driver number if not provided
        if (empty($validated['driver_number'])) {
            $validated['driver_number'] = 'DRV-' . strtoupper(Str::random(8));
        }

        // Set default password
        $validated['password'] = Hash::make($validated['driver_number']);

        $driver = Driver::create($validated);

        // Create user account for driver if email is provided
        if ($validated['email']) {
            $driverRole = Role::where('slug', 'transport-driver')->first();
            if ($driverRole) {
                $user = User::create([
                    'name' => $driver->full_name,
                    'email' => $validated['email'],
                    'password' => $validated['password'],
                    'role_id' => $driverRole->id,
                ]);
                $driver->update(['user_id' => $user->id]);
            }
        }

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver created successfully!');
    }

    public function show(Driver $driver)
    {
        if (!auth()->user()->hasPermission('drivers.view')) {
            abort(403, 'Unauthorized access');
        }

        $driver->load('routes', 'tripSessions');
        return view('admin.drivers.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        if (!auth()->user()->hasPermission('drivers.edit')) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        if (!auth()->user()->hasPermission('drivers.edit')) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:drivers,email,' . $driver->id],
            'phone' => ['required', 'string', 'max:20', 'unique:drivers,phone,' . $driver->id],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'license_number' => ['required', 'string', 'max:255', 'unique:drivers,license_number,' . $driver->id],
            'license_class' => ['required', 'string', 'max:10'],
            'license_expiry' => ['required', 'date'],
            'address' => ['nullable', 'string'],
            'status' => ['required', 'in:active,suspended,inactive'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);

        // Auto-capitalize names
        $validated['first_name'] = ucwords(strtolower(trim($validated['first_name'])));
        $validated['middle_name'] = $validated['middle_name'] ? ucwords(strtolower(trim($validated['middle_name']))) : null;
        $validated['last_name'] = ucwords(strtolower(trim($validated['last_name'])));
        $validated['address'] = $validated['address'] ? ucwords(strtolower(trim($validated['address']))) : null;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($driver->photo && \Storage::disk('public')->exists($driver->photo)) {
                \Storage::disk('public')->delete($driver->photo);
            }
            $photoPath = $request->file('photo')->store('driver-photos', 'public');
            $validated['photo'] = $photoPath;
        }

        $driver->update($validated);

        // Update user account if exists
        if ($driver->user && $validated['email']) {
            $driver->user->update([
                'name' => $driver->full_name,
                'email' => $validated['email'],
            ]);
        }

        return redirect()->route('admin.drivers.show', $driver->id)
            ->with('success', 'Driver updated successfully!');
    }

    public function destroy(Driver $driver)
    {
        if (!auth()->user()->hasPermission('drivers.delete')) {
            abort(403, 'Unauthorized access');
        }

        // Delete photo if exists
        if ($driver->photo && \Storage::disk('public')->exists($driver->photo)) {
            \Storage::disk('public')->delete($driver->photo);
        }

        // Delete associated user if exists
        if ($driver->user) {
            $driver->user->delete();
        }

        $driver->delete();

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver deleted successfully!');
    }
}

