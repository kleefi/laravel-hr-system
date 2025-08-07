@extends('layouts.main')
@section('title','Notifications')
@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Email Notifications Log</h1>

    @if($logs->isEmpty())
    <p class="text-gray-500">No email notifications sent yet.</p>
    @else
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">To</th>
                    <th class="px-4 py-2">Subject</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Sent At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $index => $log)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $log->recipient_email }}</td>
                    <td class="px-4 py-2">{{ $log->subject }}</td>
                    <td class="px-4 py-2">{{ ucfirst($log->status) }}</td>
                    <td class="px-4 py-2">{{ $log->created_at->format('d-m-Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
    @endif
</div>
@endsection