<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('user')->paginate(10);
        return view('admin.employees', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'position' => 'required|string|max:100',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'password' => 'required|min:6',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);
        // Proses upload foto jika ada
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('employee_photos', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);
        $user->assignRole('employee');
        $user->employee()->create([
            'position' => $validated['position'],
            'status' => $validated['status'],
            'salary' => $validated['salary'],
            'photo' => $photoPath,
        ]);

        return back()->with('success', 'Employee created successfully!');
    }
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->user_id,
            'position' => 'required|string|max:100',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $employee->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Cek jika ada file foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
                Storage::disk('public')->delete($employee->photo);
            }

            // Simpan foto baru
            $photoPath = $request->file('photo')->store('employee_photos', 'public');
            $employee->photo = $photoPath;
        }

        $employee->update([
            'position' => $validated['position'],
            'salary' => $validated['salary'],
            'status' => $validated['status'],
            'photo' => $employee->photo
        ]);

        return back()->with('success', 'Employee updated successfully!');
    }

    public function destroy(Employee $employee)
    {
        $employee->user()->delete();
        $employee->delete();
        if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
            Storage::disk('public')->delete($employee->photo);
        }

        return back()->with('success', 'Employee deleted successfully.');
    }
}
