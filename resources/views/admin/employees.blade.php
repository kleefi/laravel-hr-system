@extends('layouts.main')

@section('title','Employee List')

@section('content')
@if(session('success'))
<div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
    {{session('success')}}
</div>
@endif
<div x-data="employeeModal()" class="max-w-6xl mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Employee List</h1>
        <button @click="open = true"
            class="inline-block bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2 px-4 rounded">
            + Add Employee
        </button>
    </div>

    @if($employees->isEmpty())
    <p class="text-gray-500">No employees found.</p>
    @else
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr class="border-b">
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Photo</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Position</th>
                    <th class="px-4 py-2">Salary</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Joined</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $index => $employee)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">
                        @if($employee->photo)
                        <img src="{{ asset('storage/' . $employee->photo) }}" alt="Employee Photo"
                            class="w-10 h-10 rounded-full object-cover">
                        @else
                        <div
                            class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-sm font-bold">
                            {{ strtoupper(substr($employee->user->name, 0, 1)) }}
                        </div>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $employee->user->name }}</td>
                    <td class="px-4 py-2">{{ $employee->user->email }}</td>
                    <td class="px-4 py-2">{{ ucfirst($employee->position) }}</td>
                    <td class="px-4 py-2">{{ number_format($employee->salary?? 0, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2">
                        <span
                            class="inline-block px-2 py-1 text-xs rounded capitalize font-medium
                            {{ $employee->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($employee->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        {{ $employee->created_at->format('d-m-Y') }}
                    </td>
                    <td class="px-4 py-2 flex gap-2 items-center">
                        <button @click="editOpen = true; setEditData(
        '{{ $employee->id }}',
        '{{ $employee->user->name }}',
        '{{ $employee->user->email }}',
        '{{ $employee->position }}',
        '{{ $employee->salary }}',
        '{{ $employee->photo ? asset('storage/' . $employee->photo) : '' }}',
        '{{ $employee->status }}'
    )" class="text-blue-600 hover:underline text-sm">
                            Edit
                        </button>
                        <form method="POST" action="{{ route('admin.employees.destroy', $employee->id) }}"
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
            {{ $employees->links() }}
        </div>
    </div>
    @endif

    <!-- Modal Add Employee -->
    <div x-show="open" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50"
        style="display: none;">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Add New Employee</h2>
                <button @click="open = false"
                    class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
            </div>
            @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="POST" action="{{ route('admin.employees.store') }}" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Name</label>
                    <input name="name" type="text" required class="w-full border px-3 py-2 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input name="email" type="email" required class="w-full border px-3 py-2 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Password</label>
                    <input name="password" type="password" required class="w-full border px-3 py-2 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Position</label>
                    <input name="position" type="text" required class="w-full border px-3 py-2 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Salary</label>
                    <input name="salary" type="number" required class="w-full border px-3 py-2 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Status</label>
                    <select name="status" class="w-full border px-3 py-2 rounded">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Photo</label>
                    <input name="photo" type="file" accept="image/*" class="w-full border px-3 py-2 rounded">
                </div>
                <div class="text-right">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Employee -->
    <div x-show="editOpen" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50"
        style="display: none;">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Edit Employee</h2>
                <button @click="editOpen = false"
                    class="text-gray-500 hover:text-gray-700 text-2xl leading-none">&times;</button>
            </div>
            <form method="POST" :action="`/admin/employees/${editId}`" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium">Name</label>
                    <input name="name" x-model="editName" type="text" required class="w-full border px-3 py-2 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input name="email" x-model="editEmail" type="email" required
                        class="w-full border px-3 py-2 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Position</label>
                    <input name="position" x-model="editPosition" type="text" required
                        class="w-full border px-3 py-2 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Salary</label>
                    <input name="salary" x-model="editSalary" type="number" required
                        class="w-full border px-3 py-2 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Status</label>
                    <select name="status" x-model="editStatus" class="w-full border px-3 py-2 rounded">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Photo (optional)</label>
                    <input name="photo" type="file" accept="image/*" class="w-full border px-3 py-2 rounded">
                    <div x-show="editPhoto" class="mt-2">
                        <label class="block text-sm font-medium mb-1">Current Photo</label>
                        <img :src="editPhoto" alt="Current Photo" class="w-20 h-20 rounded object-cover border">
                    </div>
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
    function employeeModal() {
        return {
            open: false,
            editOpen: false,
            editId: null,
            editName: '',
            editEmail: '',
            editPosition: '',
            editSalary: '',
            editStatus: 'active',
            editPhoto: '',

            setEditData(id, name, email, position, salary, photo, status) {
                this.editId = id;
                this.editName = name;
                this.editEmail = email;
                this.editPosition = position;
                this.editSalary = salary;
                this.editStatus = status;
                this.editPhoto = photo;
            }
        }
    }
</script>
@endsection