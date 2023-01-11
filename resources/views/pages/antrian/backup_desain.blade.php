@extends('layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="d-flex justify-content-between">
        <h4 class="text-center text-uppercase">DESAIN {{ Auth::user()->name }}</h4>
        <p style="text-align: center;">
            {{-- <span class="stopwatch h3">00:00:00</span> --}}
        </p>
        <p style="text-align: center;">
          @if (Auth::user()->roles == "admin")
            <a href="#" class="btn btn-danger btn-sm">Komputer OFF</a>
          @else
            @if ($antrian_user->status == "off")
              <a href="{{ url('antrian/page_desain/' . Auth::user()->master_karyawan_id . '/status/on') }}" class="btn btn-danger">Komputer OFF</a>
            @else
              <a href="{{ url('antrian/page_desain/' . Auth::user()->master_karyawan_id . '/status/off') }}" class="btn btn-success">Komputer ON</a>
            @endif
          @endif
        </p>
      </div>
    </div>
  </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            {{-- cabang id --}}
            <input type="hidden" name="cabang_id" id="cabang_id"
                @if (Auth::user()->master_karyawan_id == 0)
                    value="1"
                @else
                    value="{{ Auth::user()->karyawan->master_cabang_id }}"
                @endif
            >
            @if (Auth::user()->karyawan)
              @if (Auth::user()->karyawan->master_cabang_id == 5)
                {{-- cs to desain --}}
                <div class="row">
                    <div class="col-12">
                        <div class="layer-1">
                            <div class="row data-cs">
                            </div>
                        </div>
                    </div>
                </div>
                <hr>                  
              @endif
            @endif
            {{-- desain page --}}
			<div class="row">
				<div class="col-12">
                    <div class="layer-1">
                        <div class="row data-nomor">
                        </div>
                    </div>
				</div>
			</div>
        </div>
    </section>
</div>

@endsection

@section('script')

<script>
    let user_cabang_id = $('#cabang_id').val();
    let user_karyawan_id = {!! Auth::user()->master_karyawan_id !!};

    var customer_desain = pusher.subscribe('customer-desain');
    customer_desain.bind('customer-desain-event', function(data) {
        if (user_cabang_id == data.cabang_id) {

            if (Notification.permission === "granted") {
                showNotification();
            } else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        showNotification();
                    }
                });
            }

            window.location.reload(1);
        }

        function showNotification() {
            const notification = new Notification("Ada pengunjung baru", {
                body: "Buka halaman desain"
            });

            notification.onclick = (e) => {
                window.location.href = "";
            }
        }

    });

    // desain ke display ketika klik panggil
    var desain_panggil = pusher.subscribe('desain-panggil');
    desain_panggil.bind('desain-panggil-event', function(data) {
        window.location.reload(1);
    });

    // update ketika desainer klik selesai
    var desain_selesai = pusher.subscribe('desain-selesai');
    desain_selesai.bind('desain-selesai-event', function(data) {
        if (user_cabang_id == data.cabang_id) {
            window.location.reload(1);
        }
    });

    // cs to desain
    var cs_to_desain = pusher.subscribe('cs-to-desain');
    cs_to_desain.bind('cs-to-desain-event', function(data) {
        if (user_cabang_id == data.cabang_id) {
            window.location.reload(1);
        }
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
				url: "{{ URL::route('antrian_desain.nomor') }}",
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
                                            '<span class="text-uppercase font-weight-bold" style="font-size: 50px;">';
                                                if (value.cabang_id == 5) {
                                                    val_nomor_antrian += 'D';
                                                }
                                                val_nomor_antrian += value.nomor_antrian + '</span><br>' +
                                            '<span class="text-uppercase">' + value.nama_customer + '</span><br>' +
                                            '<span class="text-uppercase">' + title_filter + '</span>';
                                            if (value.status == 1 || value.status == 2) {
                                                if (value.karyawan == null) {
                                                    val_nomor_antrian += '<br><span class="text-uppercase text-danger">admin</span>';
                                                } else {
                                                    val_nomor_antrian += '<br><span class="text-uppercase text-danger font-weight-bold">' + value.karyawan.nama_panggilan + '</span>';
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
                                                    if (user_karyawan_id == value.karyawan.id) {
                                                        val_nomor_antrian += '' +
                                                            '<div class="d-flex justify-content-center">' +
                                                                '<a href="page_desain/' + value.nomor_antrian + '/panggil" class="btn btn-primary" style="width: 50px;" title="Panggil"><i class="fas fa-phone"></i></a>' +
                                                            '</div>';
                                                    }
                                                } else {
                                                    if (user_karyawan_id == value.karyawan.id) {
                                                        val_nomor_antrian += '' +
                                                            '<div class="d-flex justify-content-between">' +
                                                                '<a href="page_desain/' + value.nomor_antrian + '/panggil" class="btn btn-primary" style="width: 50px;" title="Panggil"><i class="fas fa-phone"></i></a>' +
                                                                '<a href="page_desain/' + value.nomor_antrian + '/mulai" class="btn btn-success" style="width: 50px;" title="Mulai"><i class="fas fa-play"></i></a>' +
                                                                '<a href="page_desain/' + value.nomor_antrian + '/batal" class="btn btn-danger" style="width: 50px;" title="Batal"><i class="fas fa-times"></i></a>' +
                                                            '</div>';
                                                    }
                                                }
                                            }
                                            if (value.status == 2) {
                                                if (user_karyawan_id == value.karyawan.id) {
                                                    val_nomor_antrian += '' +
                                                        '<div class="d-flex justify-content-center">' +
                                                            '<a href="page_desain/' + value.nomor_antrian + '/selesai" class="btn btn-success" style="width: 50px;" title="Selesai"><i class="fas fa-check"></i></a>' +
                                                        '</div>';
                                                }
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

        nomorAntrianCs();
        function nomorAntrianCs(timestamp) {
			$('.data-nomor').empty();
			$.ajax({
				url: "{{ URL::route('antrian_cs_to_desain.nomor') }}",
				type: 'GET',
				success: function(response) {
					$.each(response.data, function(i, value) {
						let val_nomor_antrian = '' +
                                '<div class="col-3">' +
                                    '<div class="card">' +
                                        '<div class="card-header">' +
                                            '<h6 class="text-uppercase text-center">antrian</h6>' +
                                        '</div>' +
                                        '<div class="card-body text-center">' +
                                            '<span class="text-uppercase font-weight-bold" style="font-size: 50px;">C' + value.nomor_antrian + '</span><br>' +
                                            '<span class="text-uppercase">' + value.nama_customer + '</span>';
                                            if (value.status == 1 || value.status == 2) {
                                                if (value.karyawan == null) {
                                                    val_nomor_antrian += '<br><span class="text-uppercase text-danger">admin</span>';
                                                } else {
                                                    val_nomor_antrian += '<br><span class="text-uppercase text-danger font-weight-bold">' + value.karyawan.nama_panggilan + '</span>';
                                                }
											} else {
                                                val_nomor_antrian += '<br><span class="text-uppercase text-danger">-</span>';
                                            }
                                        val_nomor_antrian += '</div>' +
                                        '<div class="card-footer">';
                                            if (value.status == 0) {
                                                val_nomor_antrian += '' +
                                                    '<div class="d-flex justify-content-center">' +
                                                        '<a href="page_cs_to_desain/' + value.nomor_antrian + '/panggil" class="btn btn-primary" style="width: 50px;" title="Panggil"><i class="fas fa-phone"></i></a>' +
                                                    '</div>';
                                            }
                                            if (value.status == 1) {
                                                if (value.customer_filter_id == 2) {
                                                    if (user_karyawan_id == value.karyawan.id) {
                                                        val_nomor_antrian += '' +
                                                            '<div class="d-flex justify-content-center">' +
                                                                '<a href="page_cs_to_desain/' + value.nomor_antrian + '/panggil" class="btn btn-primary" style="width: 50px;" title="Panggil"><i class="fas fa-phone"></i></a>' +
                                                            '</div>';
                                                    }
                                                } else {
                                                    if (user_karyawan_id == value.karyawan.id) {
                                                        val_nomor_antrian += '' +
                                                            '<div class="d-flex justify-content-between">' +
                                                                '<a href="page_cs_to_desain/' + value.nomor_antrian + '/panggil" class="btn btn-primary" style="width: 50px;" title="Panggil"><i class="fas fa-phone"></i></a>' +
                                                                '<a href="page_cs_to_desain/' + value.nomor_antrian + '/mulai" class="btn btn-success" style="width: 50px;" title="Mulai"><i class="fas fa-play"></i></a>' +
                                                                '<a href="page_cs_to_desain/' + value.nomor_antrian + '/batal" class="btn btn-danger" style="width: 50px;" title="Batal"><i class="fas fa-times"></i></a>' +
                                                            '</div>';
                                                    }
                                                }
                                            }
                                            if (value.status == 2) {
                                                if (user_karyawan_id == value.karyawan.id) {
                                                    val_nomor_antrian += '' +
                                                        '<div class="d-flex justify-content-center">' +
                                                            '<a href="page_cs_to_desain/' + value.nomor_antrian + '/selesai" class="btn btn-success" style="width: 50px;" title="Selesai"><i class="fas fa-check"></i></a>' +
                                                        '</div>';
                                                }
                                            }
                                            val_nomor_antrian += '' +
                                        '</div>' +
                                    '</div>' +
                                '</div>';
                        $('.data-cs').append(val_nomor_antrian);
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
