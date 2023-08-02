@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit appointment</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('appointments.index') }}">Appointments</a></li>
                        <li class="breadcrumb-item active">Edit appointment</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('appointments.update', ['appointment' => $appointment->id]) }}" method="post">
                @csrf
                @method('put')

                <div class="card-body">
                    <div class="form-group">
                        <label for="days">Days</label>
                        <select class="form-control" id="days" required name="days">
                            <option value="">Select appointment grade</option>
                            <option value="Sat/Mon/Wed" {{ $appointment->days == 'Sat/Mon/Wed' ? 'selected' : '' }}>Sat/Mon/Wed</option>
                            <option value="Sun/Tue/Thu" {{ $appointment->days == 'Sun/Tue/Thu' ? 'selected' : '' }}>Sun/Tue/Thu</option>
                        </select>
                        @error('days')
                            <span class="w-100 text-red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="clock">Clock</label>
                        <input type="time" class="form-control" id="clock" value="{{ $appointment->clock }}" placeholder="Enter appointment clock" required name="clock">
                        @error('clock')
                            <span class="w-100 text-red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="grade">Grade</label>
                        <select class="form-control" id="grade" required name="grade">
                            <option value="">Select student grade</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->id }}" {{ $appointment->grade_id == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                            @endforeach
                        </select>
                        @error('grade')
                            <span class="w-100 text-red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div><!--/. container-fluid -->
    </section>
@endsection
