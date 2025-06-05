@extends('layouts.adminNav')

@section('content')
    <h1>Create Department</h1>
    <form action="{{ route('admin.storeDepartment') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="college_id">College</label>
            <select name="college_id" id="college_id" class="form-control" required>
                @foreach ($colleges as $college)
                    <option value="{{ $college->college_id }}">{{ $college->college_description}}</option>
                @endforeach
        </select>       
    </div>
        <div class="mb-3">
            <label for="department_code">Code</label>
            <input name="department_code" id="department_code" class="form-control" required></input>
        </div>

        <div class="mb-3">
            <label for="department_name">Name</label>
            <input name="department_name" id="department_name" class="form-control" required></input>
        </div>

        <div class="mb-3">
            <label for="department_status">Status</label>
            <select name="department_status" id="department_status" class="form-control" required>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
            </select>        </div>
        <button type="submit" class="btn btn-primary">Create Department</button>
    </form>
    @endsection