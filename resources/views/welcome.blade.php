<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Manajemen Mesin Sidik Jari</title>
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
              <div class="md-col-12">
                <hr>
                <div class="alert alert-warning" role="alert">
                  <h4 class="alert-heading"><strong>Perhatian!</strong></h4>
                  <p>Sebelum menggunakan Manajemen Mesin Sidik Jari, pastikan pengaturan <b>Alamat IP Mesin Sidik Jari</b> dan <b>Alamat Server</b> yang digunakan untuk Absensi!</p>
                  <hr>
                  <p class="mb-0">Silakan melakukan Konfigurasi terlebih dahulu sebelum menggunakan!</p>
                </div>
                <hr>

                <a href="/konfigurasi">
                  <div class="links btn btn-default">
                    Konfigurasi <i class="fa fa-gears"></i>
                  </div>
                </a>

              </div>
            </div>
        </div>
    </body>
</html>
