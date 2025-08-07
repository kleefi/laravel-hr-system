<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Exports\LeaveRequestExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function index()
    {
        $leaves = LeaveRequest::with('employee.user')->whereIn('status', ['rejected', 'pending', 'approved'])->paginate(10);
        return view('admin.export', compact('leaves'));
    }
    public function export(Request $request)
    {
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return Excel::download(
            new LeaveRequestExport($status, $startDate, $endDate),
            'leave_requests.xlsx'
        );
    }
}
