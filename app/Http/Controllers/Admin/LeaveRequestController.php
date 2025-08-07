<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $leaves = LeaveRequest::with('employee.user')->paginate(10);
        return view('admin.leave-requests', compact('leaves'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $leave = LeaveRequest::findOrFail($id);

        $leave->status = $request->status;

        if ($request->status !== 'pending') {
            $leave->approved_by = auth()->id();
            $leave->approved_at = now();
        } else {
            $leave->approved_by = null;
            $leave->approved_at = null;
        }

        $leave->save();

        return redirect()->route('admin.leave-requests.index')->with('success', 'Leave request updated.');
    }


    public function destroy(string $id)
    {
        $leave = LeaveRequest::findOrFail($id);
        $leave->delete();

        return redirect()->route('admin.leave-requests.index')
            ->with('success', 'Leave request deleted successfully.');
    }
}
