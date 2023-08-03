@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Work</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('appointments.index') }}">Appointments</a></li>
                        <li class="breadcrumb-item active">Work</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- ./card-header -->
                        <div class="card-body p-0">
                            <table class="table table-hover">
                                <tbody>
                                    @foreach($grades as $grade)
                                        <tr data-widget="expandable-table" aria-expanded="false">
                                            <td>
                                                <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                                                {{ $grade->name }}
                                            </td>
                                        </tr>
                                        <tr class="expandable-body">
                                            <td>
                                                <div class="p-0">
                                                    <table class="table table-hover">
                                                        <tbody>
                                                            <?php
                                                                $gradeAppointments = array_filter(
                                                                    array_values((array)$appointments)[0],
                                                                    fn($val) => $val->grade_id == $grade->id
                                                                );
                                                            ?>
                                                            @foreach($gradeAppointments as $appointment)
                                                                <tr data-widget="expandable-table" aria-expanded="false">
                                                                    <td>
                                                                        <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                                                                        {{ $appointment->days }} - {{ $appointment->clock }}
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <a href="{{ route('work.start', ['appointment' => $appointment->id]) }}">Start</a>
                                                                    </td>
                                                                </tr>
                                                                <tr class="expandable-body d-none">
                                                                    <td>
                                                                        <div class="p-0" style="display: none;">
                                                                            <table class="table table-hover">
                                                                                <tbody>
                                                                                    @foreach($appointment->students as $student)
                                                                                        <tr>
                                                                                            <td>{{ $student->name }} - {{ $student->slug }}</td>
                                                                                            <td></td>
                                                                                            <td class="text-right {{ $student->isExist ? 'text-success' : 'text-danger' }}">{{ $student->isExist ? 'Existing' : 'Absent' }}</td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection
