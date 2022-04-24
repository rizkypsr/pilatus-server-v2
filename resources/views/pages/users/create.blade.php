@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah User</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            <div class="form-group">
                                <label for="nameInput">Nama User</label>
                                <input type="text" class="form-control" id="nameInput" name="name"
                                    placeholder="Masukkan nama" required>
                            </div>
                            <div class="form-group">
                                <label for="emailInput">Alamat Email</label>
                                <input type="email" class="form-control" id="emailInput" name="email"
                                    placeholder="Masukkan email" required>
                            </div>
                            <div class="form-group">
                                <label for="passwordInput">Password</label>
                                <input type="password" class="form-control" id="passwordInput" name="password"
                                    placeholder="Masukkan password" required>
                            </div>
                            <div class="form-group">
                                <label for="genderInput">Jenis Kelamin</label>
                                <select id="genderInput" class="form-control" name="gender" required>
                                    <option value="PRIA">Pria</option>
                                    <option value="WANITA">Wanita</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="rolesInput">Roles</label>
                                <select id="rolesInput" class="form-control" name="roles" required>
                                    <option value="ADMIN">Admin</option>
                                    <option value="USER">User</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="phoneInput">Nomor Hp</label>
                                <input type="telp" class="form-control" id="phoneInput" name="phone"
                                    placeholder="Masukkan nomor hp" required>
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
