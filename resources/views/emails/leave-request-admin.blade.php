<h2>New Leave Request Submitted</h2>
<p>Employee: {{ $leave->employee->user->name }}</p>
<p><strong>Start Date:</strong> {{ $leave->start_date }}</p>
<p><strong>End Date:</strong> {{ $leave->end_date }}</p>
<p><strong>Reason:</strong> {{ $leave->reason }}</p>
<p>Status: <strong>{{ ucfirst($leave->status)</strong> }}</p>