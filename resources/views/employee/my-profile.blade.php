@extends('layouts.main')

@section('title','My Profile')

@section('content')
<div class="mx-auto p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">My Profile</h1>

    @php
    $user = auth()->user();
    $employee = $user->employee;
    @endphp

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex items-center space-x-4 mb-6">
            <div
                class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-3xl font-bold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
                <p class="text-gray-600">{{ $user->email }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <div>
                <p class="font-semibold">Position:</p>
                <p>{{ ucfirst($employee?->position ?? '-') }}</p>
            </div>
            <div>
                <p class="font-semibold">Status:</p>
                @if($employee)
                <span
                    class="inline-block px-2 py-1 text-sm rounded capitalize 
                        {{ $employee->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ ucfirst($employee->status) }}
                </span>
                @else
                <p>-</p>
                @endif
            </div>
            <div>
                <p class="font-semibold">Salary:</p>
                <p>Rp{{ number_format($employee?->salary ?? 0, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="font-semibold">Joined at:</p>
                <p>{{ $user->created_at->format('d-m-Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection