@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Scanner</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
                        <li class="breadcrumb-item active">Scanner</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div id="reader" style="width: 90%; margin: auto;"></div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('extra-css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js" integrity="sha512-k/KAe4Yff9EUdYI5/IAHlwUswqeipP+Cp5qnrsUjTPCgl51La2/JhyyjNciztD7mWNKLSXci48m7cctATKfLlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('extra-js')
    <script>
        const scanner = new Html5QrcodeScanner('reader', {
            qrbox: {
                width: 500,
                height: 300,
            },
            fps: 10,
            formatsToSupport: [
                Html5QrcodeSupportedFormats.CODE_128
            ]
        })

        async function fetchData(result) {
            await fetch('/api/students/' + result)
                .then(response => response.text())
                .then(data => {
                    location.href = 'students/' + data
                })
                .catch(err => {
                    console.log(err)
                })
        }

        scanner.render(success, error)

        async function success(result) {
            fetchData(result)
            scanner.clear()
        }
        function error(err) {
            console.error(err)
        }
    </script>
@endsection
