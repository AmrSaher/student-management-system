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
                        <li class="breadcrumb-item">
                            <button class="btn btn-success" id="scan-btn">Scan Again</button>
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
            <p id="message"></p>
            <div id="reader"></div>
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('extra-css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js" integrity="sha512-k/KAe4Yff9EUdYI5/IAHlwUswqeipP+Cp5qnrsUjTPCgl51La2/JhyyjNciztD7mWNKLSXci48m7cctATKfLlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@section('extra-js')
    <script>
        const message = document.getElementById('message')
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

        async function recordStudent(result) {
            await fetch(`/api/work/scan/${result}/{{ $appointment->id }}`, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    message.innerHTML = data.message
                    message.className = data.message == 'Success' ? 'text-success' : 'text-danger'
                })
                .catch(err => {
                    console.log(err.message)
                })
        }

        function start() {
            document.getElementById('reader').style.display = 'block'
            message.style.display = 'none'

            scanner.render(success, error)

            async function success(result) {
                recordStudent(result)

                scanner.clear()
                document.getElementById('reader').style.display = 'none'
                message.style.display = 'block'
            }

            function error(err) {
                console.error(err)
            }
        }
        start()

        document.getElementById('scan-btn').addEventListener('click', start)
    </script>
@endsection
