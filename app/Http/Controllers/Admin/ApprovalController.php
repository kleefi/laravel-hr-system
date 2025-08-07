<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Mail\LeaveRequestStatusUpdated;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailLog;

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
        // Kirim email notifikasi ke pengaju
        $employeeEmail = $leave->employee->user->email ?? null;
        if ($employeeEmail) {
            try {
                // Buat mailable
                $mailable = new LeaveRequestStatusUpdated($leave);

                // Kirim email
                Mail::to($employeeEmail)->send($mailable);

                // Simpan log email berhasil
                EmailLog::create([
                    'recipient_email' => $employeeEmail,
                    'subject' => $mailable->envelope()->subject ?? 'Leave Request Status Updated',
                    'body' => $mailable->render(),
                    'status' => 'sent',
                ]);
            } catch (\Exception $e) {
                // Simpan log email gagal
                EmailLog::create([
                    'recipient_email' => $employeeEmail,
                    'subject' => 'Leave Request Status Updated',
                    'body' => 'Failed to send email: ' . $e->getMessage(),
                    'status' => 'failed',
                ]);
            }
        }
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
