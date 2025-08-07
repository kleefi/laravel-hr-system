<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $leaves = LeaveRequest::with('employee.user')->whereIn('status', ['rejected', 'pending'])->paginate(10);
        return view('admin.approvals', compact('leaves'));
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

        return redirect()->route('admin.approvals.index')->with('success', 'Leave request updated.');
    }
    public function destroy(string $id)
    {
        $leave = LeaveRequest::findOrFail($id);
        $leave->delete();

        return redirect()->route('admin.approvals.index')
            ->with('success', 'Leave request deleted successfully.');
    }
}
