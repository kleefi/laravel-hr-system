@extends('layouts.main')
@section('title', 'My Leave')

@section('content')
<div class=" mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">My Leave Requests</h1>
        <a href="{{ route('employee.apply-leave.index') }}"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded">
            + Apply for Leave
        </a>
    </div>

    @if($leaves->isEmpty())
    <p class="text-gray-500">You have not submitted any leave requests yet.</p>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr class="border-b">
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Start Date</th>
                    <th class="px-4 py-2">End Date</th>
                    <th class="px-4 py-2">Total Days</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Reason</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaves as $index => $leave)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
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
                    <td class="px-4 py-2">
                        <span class="@if($leave->status == 'approved') text-green-600
                                             @elseif($leave->status == 'rejected') text-red-600
                                             @else text-yellow-600 @endif font-semibold">
                            {{ ucfirst($leave->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ $leave->reason }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="my-2">
            {{ $leaves->links() }}
        </div>
    </div>
    @endif
</div>
@endsection