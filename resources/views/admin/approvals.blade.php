@extends('layouts.main')
@section('title','Approvals')
@section('content')
@if(session('success'))
<div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
    {{session('success')}}
</div>
@endif
<div x-data="leaveRequestModal()" class="mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Approvals</h1>
    </div>

    @if($leaves->isEmpty())
    <p class="text-gray-500">You have not submitted any leave requests yet.</p>
    @else
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr class="border-b">
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Start Date</th>
                    <th class="px-4 py-2">End Date</th>
                    <th class="px-4 py-2">Total Days</th>
                    <th class="px-4 py-2">Approvaed By</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Reason</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaves as $index => $leave)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $leave->employee->user->name ??'-'}}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($leave->start_date)->format('d-m-Y') }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($leave->end_date)->format('d-m-Y') }}</td>
                    <td class="px-4 py-2">
                        @php
                        $period = Carbon\CarbonPeriod::create($leave->start_date, $leave->end_date);
                        $workdays = collect($period)->filter(function ($date) {
                        return !$date->isWeekend();
                        })->count();
                        @endphp
                        {{ $workdays }} day(s)
                    </td>
                    <td>{{ $leave->approvedBy?->name ?? '-' }}</td>

                    <td class="px-4 py-2">
                        <span class="@if($leave->status == 'approved') text-green-600
                                             @elseif($leave->status == 'rejected') text-red-600
                                             @else text-yellow-600 @endif font-semibold">
                            {{ ucfirst($leave->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ $leave->reason }}</td>
                    <td class="px-4 py-2 flex gap-2 items-center">
                        <button @click="setEditData('{{ $leave->id }}', '{{ $leave->status }}')"
                            class="text-blue-600 hover:underline text-sm">
                            Edit
                        </button>
                        <form method="POST" action="{{ route('admin.approvals.destroy', $leave->id) }}"
                            onsubmit="return confirm('Are you sure you want to delete this employee?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="my-4">
            {{ $leaves->links() }}
        </div>
    </div>
    @endif

    <!-- Modal Edit Employee -->
    <div x-show="editOpen" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50"
        style="display: none;">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Edit Employee</h2>
                <button @click="editOpen = false"
                    class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
            </div>
            <form method="POST" :action="`/admin/approvals/${editId}`" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium">Leave Status</label>
                    <select name="status" required class="w-full border px-3 py-2 rounded">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="text-right">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function leaveRequestModal() {
        return {
            editOpen: false,
            editId: null,
            editStatus: '',

            setEditData(id, status) {
                this.editId = id;
                this.editStatus = status;
                this.editOpen = true;
            }
        }
    }
</script>
@endsection