@extends('layouts.app')

@section('links')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Transaksi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID User</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $order->user_id }}</td>
                                    <td>{{ strtoupper($order->status) }}</td>
                                    <td>{{ $order->total }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bukti Pembayaran</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <img class="img-thumbnail" style="max-width:75%"
                            src="{{ $order->payment != null ? url('storage', $order->payment->photo) : '' }}" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Produk</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID Produk</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->detailOrder as $detail)
                                    <tr>
                                        <td>{{ $detail->product->id }}</td>
                                        <td>{{ $detail->product->name }}</td>
                                        <td>{{ $detail->product->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Pengiriman</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if ($order->shipping)
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Alamat</th>
                                        <th>Kurir</th>
                                        <th>Biaya Ongkir</th>
                                        <th>No Resi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $street = $order->shipping->address->street;
                                    $district = $order->shipping->address->district;
                                    $postalCode = $order->shipping->address->postal_code;
                                    $province = $order->shipping->address->province->province;
                                    $city = $order->shipping->address->city->city_name;
                                    ?>
                                    <tr>
                                        <td>
                                            {{ $street . ', ' . $city . ', ' . $district . ' ' . $province . ' ' . $postalCode }}
                                        </td>
                                        <td>{{ strtoupper($order->shipping->courier) }}</td>
                                        <td>{{ $order->shipping->shipping_cost }}</td>
                                        <td>{{ $order->shipping->resi }}</td>
                                        <td>
                                            <a href="{{ route('orders.edit', $order->id) }}"
                                                class="btn btn-primary btn-sm">Ubah Resi</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <th>Pengiriman</th>
                                    <th style="width: 25%">Ubah Status</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Barang Diambil Sendiri</td>
                                        <td class="row">

                                            <form class="col mb-2" action="{{ route('order', $order->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')

                                                <input type="submit" name="status" class="btn btn-primary btn-sm"
                                                    value="Sudah Dibayar" />
                                            </form>
                                            <form class="col" action="{{ route('order', $order->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')

                                                <input type="submit" name="status" class="btn btn-primary btn-sm"
                                                    value="Sudah Diambil" />
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <!-- DataTables  & Plugins -->
    <script src="{{ url('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ url('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ url('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ url('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
