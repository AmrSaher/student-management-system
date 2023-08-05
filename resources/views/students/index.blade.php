@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Students</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right align-items-center">
                        <li>
                            <a href="{{ route('students.create') }}" class="btn btn-success">Create new student</a>
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <table id="students-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Parents Phone Number</th>
                        <th>Address</th>
                        <th>Grade</th>
                        <th>Appointment</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>
                                <img src="{{ asset('storage/' . str_replace('public', '', $student->image_path)) }}" alt="student image" style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->phone_number }}</td>
                            <td>{{ $student->parents_phone_number }}</td>
                            <td>{{ $student->address }}</td>
                            <td>{{ $student->grade->name }}</td>
                            <td>{{ $student->appointment->days }} - {{ $student->appointment->clock }}</td>
                            <td>{{ $student->slug }}</td>
                            <td style="display: flex; flex-wrap: wrap; gap: 10px;">
                                <a href="{{ route('students.show', ['student' => $student->id]) }}" class="btn btn-success">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('students.edit', ['student' => $student->id]) }}" class="btn btn-primary">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('students.destroy', ['student' => $student->id]) }}" method="post" id="delete-student-form-{{ $student->id }}" style="display: none">
                                    @csrf
                                    @method('delete')
                                </form>
                                <a href="#" class="btn btn-danger" onclick="if (confirm('Are you sure ?')) document.getElementById('delete-student-form-{{ $student->id }}').submit()">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('extra-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('extra-js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        let table = new DataTable('#students-table')
    </script>
@endsection
