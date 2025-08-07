<h2>Leave Request Confirmation</h2>
<p>Hi {{ $leave->employee->user->name }},</p>
<p>Your leave request has been submitted.</p>
<p><strong>Start:</strong> {{ $leave->start_date }}</p>
<p><strong>End:</strong> {{ $leave->end_date }}</p>
<p><strong>Reason:</strong> {{ $leave->reason }}</p>
<p>Status: <strong>{{ ucfirst($leave->status) }}</strong></p>
<p>Thank you.</p>