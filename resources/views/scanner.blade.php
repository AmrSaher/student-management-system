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
                        <li>
                            <a href="#" class="btn btn-success" id="scan-btn">Scan again</a>
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
            <div id="reader"></div>
            <!-- Default box -->
            <div class="card card-solid">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="col-12">
                                <img class="product-image" id="student-image" alt="student image">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <h3 class="my-3" id="student-title">----</h3>
                            <p id="student-grade">----</p>
                            <p id="student-appointment">----</p>

                            <hr>

                            <div class="mt-4">
                                <a id="edit-link" class="btn btn-primary" style="margin-right: 10px;">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                <form method="post" style="display: none" id="delete-student-form">@csrf @method('delete')</form>
                                <a href="#" class="btn btn-danger" onclick="if (confirm('Are you sure ?')) document.getElementById('delete-student-form').submit()">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
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
                .then(response => response.json())
                .then(data => {
                    const title = document.querySelector('#student-title')
                    const image = document.querySelector('#student-image')
                    const grade = document.querySelector('#student-grade')
                    const appointment = document.querySelector('#student-appointment')
                    const editLink = document.querySelector('#edit-link')
                    const deleteForm = document.querySelector('#delete-student-form')

                    title.innerHTML = data.student.name
                    grade.innerHTML = data.grade
                    image.src = `/storage/${data.student.image_path.replace('public', '')}`
                    editLink.href = `/students/${data.student.id}/edit`
                    deleteForm.action = `/students/${data.student.id}`
                    appointment.innerHTML = data.appointment
                })
                .catch(err => {
                    console.log(err)
                })
        }

        function start() {
            document.getElementById('reader').style.display = 'block'
            document.querySelector('.card').style.display = 'none'

            scanner.render(success, error)

            async function success(result) {
                fetchData(result)

                scanner.clear()
                document.getElementById('reader').style.display = 'none'
                document.querySelector('.card').style.display = 'block'
            }

            function error(err) {
                console.error(err)
            }
        }
        start()

        document.getElementById('scan-btn').addEventListener('click', start)
    </script>
@endsection
