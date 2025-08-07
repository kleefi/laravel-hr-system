<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Mail\LeaveRequestConfirmationToEmployee;
use App\Mail\LeaveRequestSubmittedToAdmin;
use App\Models\EmailLog;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LeaveController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            abort(403, 'Employee data not found.');
        }

        // Ambil semua cuti milik employee tersebut
        $leaves = LeaveRequest::where('employee_id', $employee->id)
            ->latest()
            ->paginate(10);
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

        // Simpan pengajuan cuti
        $leave = LeaveRequest::create([
            'employee_id' => $employee->id,
            'start_date'  => $validated['start_date'],
            'end_date'    => $validated['end_date'],
            'reason'      => $validated['reason'],
            'status'      => 'pending',
        ]);

        // === KIRIM EMAIL KE ADMIN ===
        $adminEmails = User::role('admin')->pluck('email')->toArray();
        try {
            $adminMailable = new LeaveRequestSubmittedToAdmin($leave);
            Mail::to($adminEmails)->send($adminMailable);

            foreach ($adminEmails as $adminEmail) {
                EmailLog::create([
                    'recipient_email' => $adminEmail,
                    'subject'         => $adminMailable->envelope()->subject ?? 'Leave Request Submitted',
                    'body'            => $adminMailable->render(),
                    'status'          => 'sent',
                ]);
            }
        } catch (\Exception $e) {
            foreach ($adminEmails as $adminEmail) {
                EmailLog::create([
                    'recipient_email' => $adminEmail,
                    'subject'         => 'Leave Request Submitted',
                    'body'            => 'Failed to send to admin: ' . $e->getMessage(),
                    'status'          => 'failed',
                ]);
            }
        }

        // === KIRIM EMAIL KE EMPLOYEE (PENGAJU) ===
        try {
            $employeeMailable = new LeaveRequestConfirmationToEmployee($leave);
            Mail::to($request->user()->email)->send($employeeMailable);

            EmailLog::create([
                'recipient_email' => $request->user()->email,
                'subject'         => $employeeMailable->envelope()->subject ?? 'Leave Request Confirmation',
                'body'            => $employeeMailable->render(),
                'status'          => 'sent',
            ]);
        } catch (\Exception $e) {
            EmailLog::create([
                'recipient_email' => $request->user()->email,
                'subject'         => 'Leave Request Confirmation',
                'body'            => 'Failed to send to employee: ' . $e->getMessage(),
                'status'          => 'failed',
            ]);
        }

        return redirect()
            ->route('employee.apply-leave.index')
            ->with('success', 'Leave request submitted successfully.');
    }
}
