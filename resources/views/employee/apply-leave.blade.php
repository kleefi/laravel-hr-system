@extends('layouts.main')

@section('title', 'Apply Leave')

@section('content')
<div class="mx-auto p-6">
    <div class="grid grid-cols-1 md:grid-cols-[60%_40%] gap-6">
        <div class="w-full bg-white p-6 rounded-md shadow border border-gray-200">
            <h1 class="text-2xl font-semibold mb-6 text-gray-800">Apply for Leave</h1>

            @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('employee.apply-leave.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-indigo-200">
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-indigo-200">
                </div>

                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                    <textarea name="reason" id="reason" rows="4"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring focus:ring-indigo-200">{{ old('reason') }}</textarea>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 transition">
                        Submit Leave Request
                    </button>
                </div>
            </form>
        </div>

        <div
            class="hidden md:block w-full bg-gray-50 p-6 rounded-md shadow border border-gray-200 text-sm text-gray-700">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Information</h2>

            @php
            $user = auth()->user();
            $employee = $user->employee;
            @endphp

            <div class="space-y-3 text-gray-700">
                <p><span class="font-medium">Name :</span> {{ $user->name }}</p>
                <p><span class="font-medium">Email :</span> {{ $user->email }}</p>

                @if($employee)
                <p><span class="font-medium">Position :</span> {{ ucfirst($employee->position) }}</p>
                <p><span class="font-medium">Status :</span>
                    <span
                        class="inline-block px-2 py-1 text-sm rounded 
                            {{ $employee->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($employee->status) }}
                    </span>
                </p>
                <p class="hidden"><span class="font-medium">Salary :</span> Rp{{ number_format($employee->salary, 0,
                    ',',
                    '.') }}</p>
                @else
                <p class="text-sm text-red-500">No employee data found.</p>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection