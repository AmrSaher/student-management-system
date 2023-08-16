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
                    <ol class="breadcrumb float-sm-right">
                        <li>
                            <a href="{{ route('scanner') }}" class="btn btn-success">Scan again</a>
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
            <!-- Default box -->
            <div class="card card-solid">
                <div class="card-body">
                    @if(!$student->isExist)
                        <div class="alert alert-danger" role="alert">
                            Absent
                        </div>
                    @endif
                    @if(!$student->isPaid())
                        <div class="alert alert-danger" role="alert">
                            The monthly subscription fee was not paid
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="col-12">
                                <img class="product-image" src="{{ asset('storage/' . str_replace('public', '', $student->image_path)) }}" alt="student image">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <h3 class="my-3">{{ $student->name }}</h3>
                            <p>{{ $student->grade->name }}</p>
                            <p>{{ $student->appointment->days }} - {{ $student->appointment->clock }} - <strong>{{ $student->grade->mrs }} L.E</strong></p>

                            <hr>
                            <p>
                                <strong>Phone Number : </strong>
                                {{ $student->phone_number }}
                            </p>
                            <p>
                                <strong>Parents Phone Number : </strong>
                                {{ $student->parents_phone_number }}
                            </p>
                            <p>
                                <strong>Address : </strong>
                                {{ $student->address }}
                            </p>

                            <div class="mt-4">
                                <a href="{{ route('students.edit', ['student' => $student->id]) }}" class="btn btn-primary" style="margin-right: 10px;">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                <form action="{{ route('students.destroy', ['student' => $student->id]) }}" method="post" id="delete-student-form" style="display: none">
                                    @csrf
                                    @method('delete')
                                </form>
                                <a href="#" class="btn btn-danger" onclick="if (confirm('Are you sure ?')) document.getElementById('delete-student-form').submit()" style="margin-right: 10px;">
                                    <i class="fas fa-trash-alt"></i>
                                </a>

                                @if(!$student->isPaid())
                                    <form action="{{ route('students.subscribe', ['student' => $student->id]) }}" method="post" id="subscribe-student-form" style="display: none">
                                        @csrf
                                    </form>
                                    <a href="#" onclick="if (confirm('Are you sure ?')) document.getElementById('subscribe-student-form').submit()" class="btn btn-success">
                                        <i class="far fa-credit-card"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection
