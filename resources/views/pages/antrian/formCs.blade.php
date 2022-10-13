@extends('layouts.app')

@section('style')

@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="mt-5">
                        <center>
                            <img src="{{ asset('public/assets/logo-bg-blue.png') }}" alt="">
                        </center>
                        <form role="form" action="{{ route('antrian.customer.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="customer_filter_id" name="customer_filter_id" value="{{ $customer_filter_id }}">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="nomor_antrian" name="nomor_antrian" value="@if (is_null($nomors)){{ 0 + 1 }}@else{{ $nomors->nomor_antrian + 1 }}@endif">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="sisa_antrian" name="sisa_antrian" value="{{ $count_nomor_all - $count_nomor_panggil }}">
                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control" id="telepon" name="telepon" maxlength="13" autocomplete="off" required placeholder="Masukkan nomor telepon">
                                    <div class="telepon">
                                        <ul class="telepon-data">
                                            {{-- data  --}}
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nama" name="nama_customer" required placeholder="Masukkan nama">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Cetak</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var btnVal = $('#customer_filter_id').val();

        $("#telepon").on("keyup", function() {
            $('.telepon .telepon-data').empty();
            var value = $(this).val();
            if (value.length >= 10) {
                $.ajax({
                    url: "{{ URL::route('antrian_customer.search') }}",
                    type: 'POST',
                    data: {
                        value: value
                    },
                    success: function(response) {
                        $.each(response.customers, function (i, value) {
                            var data_customers = "<li><button class=\"btn-data-customer\" data-value=\"" + value.telepon + "-" + value.nama_customer + "\">" + value.telepon + " | " + value.nama_customer + "</button></li>";
                            $('.telepon .telepon-data').append(data_customers);
                        });
                        $('.telepon .telepon-data').css('display', 'block');
                    }
                });
            }
        });

        $('.telepon').on('click', '.btn-data-customer', function (e) {
            e.preventDefault();
            var a = $(this).attr('data-value');
            var b = a.split("-");
            $("#telepon").val(b[0]);
            $("#nama").val(b[1]);
            $('.telepon .telepon-data').css('display', 'none');
        });
    });
</script>
@endsection
