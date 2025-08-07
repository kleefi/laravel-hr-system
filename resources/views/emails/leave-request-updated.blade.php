<h2>Hello {{ $leave->employee->user->name }},</h2>

<p>Your leave request has been <strong>{{ ucfirst($leave->status) }}</strong>.</p>

<p><strong>Start Date:</strong> {{ $leave->start_date }}</p>
<p><strong>End Date:</strong> {{ $leave->end_date }}</p>
<p><strong>Reason:</strong> {{ $leave->reason }}</p>

@if($leave->status !== 'pending')
<p><strong>Approved/Rejected By:</strong> {{ $leave->approvedBy->name ?? 'Admin' }}</p>
<p><strong>On:</strong> {{ $leave->approved_at }}</p>
@endif

<p>Thank you.</p>