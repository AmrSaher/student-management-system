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
            <a href="#" class="btn btn-success w-auto" id="subscribe-btn">
                <i class="far fa-credit-card"></i>
            </a>
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
        const message = document.getElementById('message')
        const subscribeBtn = document.getElementById('subscribe-btn')
        const scanBtn = document.getElementById('scan-btn')
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

        let studentID
        async function recordStudent(result) {
            await fetch(`/api/work/scan/${result}/{{ $appointment->id }}`, {
                    method: 'POST'
                })
                .then(res => res.json())
                .then(res => {
                    let isPaid = res.isPaid
                    message.innerHTML = res.message
                    message.className = 'text-' + res.messageColor
                    subscribeBtn.style.display = isPaid ? 'none' : 'block'
                    studentID = res.studentID
                })
                .catch(err => {
                    console.log(err.message)
                })
        }

        async function subscribe() {
            if (confirm('Are you sure ?') && studentID) {
                await fetch('/api/students/subscribe/' + studentID, {
                        method: 'POST'
                    })
                    .then(res => res.json())
                    .then(res => {
                        alert('Subscribed')
                    })
                    .catch(err => {
                        console.log(err.message)
                    })
            }
        }

        function start() {
            document.getElementById('reader').style.display = 'block'
            message.style.display = 'none'
            subscribeBtn.style.display = 'none'

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

        scanBtn.addEventListener('click', start)
        subscribeBtn.addEventListener('click', subscribe)
    </script>
@endsection
