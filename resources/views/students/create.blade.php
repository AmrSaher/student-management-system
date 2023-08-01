@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create new student</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
                        <li class="breadcrumb-item active">Create new student</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Modal -->
    <div class="modal">

    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('students.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter student name" required name="name" autofocus>
                        @error('name')
                            <span class="w-100 text-red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <div style="position: relative">
                            <input type="text" class="form-control" id="slug" placeholder="Enter student slug" required name="slug">
                            <button id="scan-btn" class="btn-flat" style="border: none; background: transparent; cursor: pointer; position: absolute; top: 50%; right: 10px; transform: translateY(-50%);">
                                <i class="fas fa-barcode text-white"></i>
                            </button>
                        </div>
                        <div id="reader"></div>
                        @error('slug')
                            <span class="w-100 text-red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                            </div>
                        </div>
                        @error('image')
                            <span class="w-100 text-red">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div><!--/. container-fluid -->
    </section>
@endsection

@section('extra-css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js" integrity="sha512-k/KAe4Yff9EUdYI5/IAHlwUswqeipP+Cp5qnrsUjTPCgl51La2/JhyyjNciztD7mWNKLSXci48m7cctATKfLlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('extra-js')
    <script>
        const scanner = new Html5QrcodeScanner('reader', {
            qrbox: {
                width: 300,
                height: 200,
            },
            fps: 10,
            formatsToSupport: [
                Html5QrcodeSupportedFormats.CODE_128
            ]
        })

        document.getElementById('scan-btn').addEventListener('click', (e) => {
            e.preventDefault()

            document.getElementById('reader').style.display = 'block'

            scanner.render(success, error)

            function success(result) {
                document.getElementById('slug').value = result

                scanner.clear()
                document.getElementById('reader').style.display = 'none'
            }

            function error(err) {
                console.error(err)
            }
        })
    </script>
@endsection
