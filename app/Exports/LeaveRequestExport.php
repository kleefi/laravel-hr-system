<?php

namespace App\Exports;

use App\Models\LeaveRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class LeaveRequestExport implements FromCollection, WithHeadings
{
    protected $status;
    protected $startDate;
    protected $endDate;

    public function __construct($status = null, $startDate = null, $endDate = null)
    {
        $this->status = $status;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = LeaveRequest::with('employee.user');

        if ($this->status) {
            $query->whereIn('status', (array)$this->status);
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('start_date', [$this->startDate, $this->endDate]);
        }

        return $query->get()->map(function ($leave) {
            return [
                'Name'        => $leave->employee->user->name ?? '-',
                'Start Date'  => $leave->start_date,
                'End Date'    => $leave->end_date,
                'Total Days'  => $this->calculateWorkdays($leave->start_date, $leave->end_date),
                'Approved By' => $leave->approvedBy?->name ?? '-',
                'Status'      => ucfirst($leave->status),
                'Reason'      => $leave->reason,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Start Date',
            'End Date',
            'Total Days',
            'Approved By',
            'Status',
            'Reason'
        ];
    }

    private function calculateWorkdays($start, $end)
    {
        $period = \Carbon\CarbonPeriod::create($start, $end);
        return collect($period)->filter(fn($date) => !$date->isWeekend())->count();
    }
}
