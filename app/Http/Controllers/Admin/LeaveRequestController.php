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
        $leaves = LeaveRequest::with('employee.user')->where('status', 'approved')->paginate(10);
        return view('admin.leave-requests', compact('leaves'));
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
}
