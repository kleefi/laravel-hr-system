<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LeaveHistory;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $employee = $user->employee;

        // Pastikan employee terhubung
        if (!$employee) {
            abort(403, 'Employee data not found.');
        }

        // Ambil semua cuti milik employee tersebut
        $leaves = LeaveRequest::where('employee_id', $employee->id)
            ->latest()
            ->get();
        $leaves = LeaveRequest::paginate(10);
        return view('employee.my-leave', compact('leaves'));
    }
    public function formLeave()
    {
        return view('employee.apply-leave');
    }
    public function storeLeave(Request $request)
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
            'reason'     => ['required', 'string', 'max:1000'],
        ]);
        $employee = $request->user()->employee;

        if (!$employee) {
            return back()->withErrors(['message' => 'Employee data not found for this user.']);
        }
        LeaveRequest::create([
            'employee_id' => $employee->id,
            'start_date'  => $validated['start_date'],
            'end_date'    => $validated['end_date'],
            'reason'      => $validated['reason'],
            'status'      => 'pending', // default
        ]);

        return redirect()
            ->route('employee.apply-leave.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
