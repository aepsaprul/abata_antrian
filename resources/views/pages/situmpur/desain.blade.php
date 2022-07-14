@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
			<h3 class="text-center">DESAINER {{ Auth::user()->name }}</h3>
			<p style="text-align: center;">
                @if (Auth::user()->roles == "admin")
                    <a href="#" class="btn btn-danger">Komputer OFF</a>
                @else
                    @if ($antrian_user->status == "off")
                        <a href="{{ url('situmpur/page_desain/' . Auth::user()->master_karyawan_id . '/on') }}" class="btn btn-danger">Komputer OFF</a>
                    @else
                        <a href="{{ url('situmpur/page_desain/' . Auth::user()->master_karyawan_id . '/off') }}" class="btn btn-success">Komputer ON</a>
                    @endif
                @endif
			</p>
			<p style="text-align: center;">
				<span class="stopwatch h3">00:00:00</span>
			</p>
			<hr>
			<div class="row">
				<div class="col-12">
						<div class="layer-1">
							<div class="row data-nomor">
							</div>
						</div>
						<!-- /.card-body -->
					<!-- /.card -->
				</div>
				<div class="col-2">
					<div class="row cs-desain">

					</div>
				</div>
			</div>
        </div>
    </section>
</div>

@endsection

@section('script')
{{-- <script src="https://js.pusher.com/7.1/pusher.min.js"></script> --}}
<script>
    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    // dev
    // var pusher = new Pusher('07d3c75f0970790e45c6', {
    //     cluster: 'ap1'
    // });

    // prod
    // var pusher = new Pusher('2f72f827ef95c4adf968', {
    //     cluster: 'ap1'
    // });

    var customer_desain = pusher.subscribe('customer-desain');
    customer_desain.bind('customer-desain-event', function(data) {
        if (data.customer_filter_id == 1) {
            var title_filter = "File Siap";
        } else {
            var title_filter = "Desain / Edit";
        }
        var queryNomorAntrian = "" +
            '<div class="col-3">' +
                '<div class="card">' +
                    '<div class="card-header">' +
                        '<h6 class="text-uppercase text-center">antrian</h6>' +
                    '</div>' +
                    '<div class="card-body text-center">' +
                        '<span class="text-uppercase font-weight-bold" style="font-size: 50px;">' + data.nomor_antrian + '</span><br>' +
                        '<span class="text-uppercase">' + data.nama + '</span><br>' +
                        '<span class="text-uppercase">' + title_filter + '</span>' +
                        '<br><span class="text-uppercase text-danger">-</span>' +
                    '</div>' +
                    '<div class="card-footer">' +
                        '<div class="d-flex justify-content-center">' +
                            '<a href="page_desain/' + data.nomor_antrian + '/panggil" class="btn btn-primary" style="width: 50px;" title="Panggil"><i class="fas fa-phone"></i></a>' +
                        '</div>'
                    '</div>' +
                '</div>' +
            '</div>';

        $('.data-nomor').append(queryNomorAntrian);

        if (Notification.permission === "granted") {
            showNotification();
        } else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(permission => {
                if (permission === "granted") {
                    showNotification();
                }
            });
        }

        function showNotification() {
            const notification = new Notification("Ada pengunjung baru", {
                body: "Buka halaman desain"
            });

            notification.onclick = (e) => {
                window.location.href = "";
            }
        }

        console.log(Notification.permission);
    });

</script>

<script>
	$(document).ready(function() {
		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        nomorAntrian();

		function nomorAntrian(timestamp) {
			$('.data-nomor').empty();
			$.ajax({
				url: "{{ URL::route('situmpur_desain.nomor') }}",
				type: 'GET',
				success: function(response) {
					$.each(response.data, function(i, value) {

						if (value.customer_filter_id == 1) {
							var title_filter = "Siap Cetak";
						} else if (value.customer_filter_id == 4) {
							var title_filter = "Desain";
						} else if (value.customer_filter_id == 5) {
							var title_filter = "Edit";
						} else {
							var title_filter = "<a href=\"page_desain/" + value.nomor_antrian + "/jenis/desain\">Desain</a> / <a href=\"page_desain/" + value.nomor_antrian + "/jenis/edit\">Edit</a>";
						}

						let val_nomor_antrian = '' +
                                '<div class="col-3">' +
                                    '<div class="card">' +
                                        '<div class="card-header">' +
                                            '<h6 class="text-uppercase text-center">antrian</h6>' +
                                        '</div>' +
                                        '<div class="card-body text-center">' +
                                            '<span class="text-uppercase font-weight-bold" style="font-size: 50px;">' + value.nomor_antrian + '</span><br>' +
                                            '<span class="text-uppercase">' + value.nama_customer + '</span><br>' +
                                            '<span class="text-uppercase">' + title_filter + '</span>';
                                            if (value.status == 2) {
                                                if (value.karyawan == null) {
                                                    val_nomor_antrian += '<br><span class="text-uppercase text-danger">admin</span>';
                                                } else {
                                                    val_nomor_antrian += '<br><span class="text-uppercase text-danger">' + value.karyawan.nama_panggilan + '</span>';
                                                }
											} else {
                                                val_nomor_antrian += '<br><span class="text-uppercase text-danger">-</span>';
                                            }
                                        val_nomor_antrian += '</div>' +
                                        '<div class="card-footer">';
                                            if (value.status == 0) {
                                                val_nomor_antrian += '' +
                                                    '<div class="d-flex justify-content-center">' +
                                                        '<a href="page_desain/' + value.nomor_antrian + '/panggil" class="btn btn-primary" style="width: 50px;" title="Panggil"><i class="fas fa-phone"></i></a>' +
                                                    '</div>';
                                            }
                                            if (value.status == 1) {
                                                if (value.customer_filter_id == 2) {
                                                    val_nomor_antrian += '' +
                                                        '<div class="d-flex justify-content-center">' +
                                                            '<a href="page_desain/' + value.nomor_antrian + '/panggil" class="btn btn-primary" style="width: 50px;" title="Panggil"><i class="fas fa-phone"></i></a>' +
                                                        '</div>';
                                                } else {
                                                    val_nomor_antrian += '' +
                                                        '<div class="d-flex justify-content-between">' +
                                                            '<a href="page_desain/' + value.nomor_antrian + '/panggil" class="btn btn-primary" style="width: 50px;" title="Panggil"><i class="fas fa-phone"></i></a>' +
                                                            '<a href="page_desain/' + value.nomor_antrian + '/mulai" class="btn btn-success" style="width: 50px;" title="Mulai"><i class="fas fa-play"></i></a>' +
                                                            '<a href="page_desain/' + value.nomor_antrian + '/batal" class="btn btn-danger" style="width: 50px;" title="Batal"><i class="fas fa-times"></i></a>' +
                                                        '</div>';
                                                }
                                            }
                                            if (value.status == 2) {
                                                start();
                                                val_nomor_antrian += '' +
                                                    '<div class="d-flex justify-content-center">' +
                                                        '<a href="page_desain/' + value.nomor_antrian + '/selesai" class="btn btn-success" style="width: 50px;" title="Selesai"><i class="fas fa-check"></i></a>' +
                                                    '</div>';
                                            }
                                            val_nomor_antrian += '' +
                                        '</div>' +
                                    '</div>' +
                                '</div>';
                        $('.data-nomor').append(val_nomor_antrian);
					});
				}
			});
		}

		var ms = 0, s = 0, m = 0;
		var timer;

		var stopwatchEl = document.querySelector('.stopwatch');

		function start() {
			if(!timer) {
				timer = setInterval(run, 1000);
			}
		}

		function run() {
			stopwatchEl.textContent = getTimer();
			ms++;

			if (ms == 60) {
				ms = 0;
				s++;
			}
			if (s == 60) {
				s = 0;
				m++;
			}
		}

		function getTimer() {
			return (m < 10 ? "0" + m : m) + ":" + (s < 10 ? "0" + s : s) + ":" + (ms <10 ? "0" + ms : ms);
		}
	});
</script>
@endsection
