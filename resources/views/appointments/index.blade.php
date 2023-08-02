@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Appointments</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right align-items-center">
                        <li>
                            <a href="{{ route('appointments.create') }}" class="btn btn-success">Create new appointment</a>
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
            <table id="appointments-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Days</th>
                    <th>Clock</th>
                    <th>Grade</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->days }}</td>
                        <td>{{ $appointment->clock }}</td>
                        <td>{{ $appointment->grade->name }}</td>
                        <td style="display: flex; flex-wrap: wrap; gap: 10px;">
                            <a href="{{ route('appointments.edit', ['appointment' => $appointment->id]) }}" class="btn btn-primary">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('appointments.destroy', ['appointment' => $appointment->id]) }}" method="post" id="delete-appointment-form-{{ $appointment->id }}" style="display: none">
                                @csrf
                                @method('delete')
                            </form>
                            <a href="#" class="btn btn-danger" onclick="if (confirm('Are you sure ?')) document.getElementById('delete-appointment-form-{{ $appointment->id }}').submit()">
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
        let table = new DataTable('#appointments-table')
    </script>
@endsection
