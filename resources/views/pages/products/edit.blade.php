@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Ubah Produk</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="form-group">
                                <label for="nameInput">Nama Produk</label>
                                <input type="text" class="form-control" id="nameInput" name="name"
                                    placeholder="Masukkan nama" value="{{ $product->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="cateogryInput">Kategori</label>
                                <select class="form-control" name="category_id" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nameInput">Deskripsi</label>
                                <textarea class="form-control" rows="3" name="description"
                                    placeholder="Masukkan deskripsi produk"
                                    required>{{ $product->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="photoInput">Gambar</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="photoInput" name="photo">
                                        <label class="custom-file-label" for="photoInput">Pilih Gambar</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label for="weightInput">Stok</label>
                                        <input id="stockInput" type="number" name="stock" min="1" class="form-control"
                                            value="{{ $product->stock }}" required>
                                    </div>

                                    <div class="form-group col-3">
                                        <label for="weightInput">Berat (gram)</label>
                                        <input id="weightInput" type="number" name="weight" min="1" class="form-control"
                                            value="{{ $product->weight }}" required>
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="totaltInput">Harga</label>
                                        <input id="totaltInput" type="number" name="total" min="0" class="form-control"
                                            value="{{ $product->total }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
                <!--/.col (left) -->

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    @endsection
