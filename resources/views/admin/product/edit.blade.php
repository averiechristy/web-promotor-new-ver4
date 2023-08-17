@extends('layouts.admin.app')

@section('content')

  
                <!-- Begin Page Content -->
             

                <div class="container">
                        <div class="row">
                            <div class="col-8 offset-2">
                                <div class="card mt-3">
                                    <div class="card-header">
                                        Edit product
                                    </div>
                                    <div class="card-body">
                                       <form action="/updateproduct/{{$data->id}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group mb-4">
                                                <label for="" class="form-label">Kode Role</label>

                                              
                                                <select name = "role_id" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" style="border-color: #01004C; margin-left: 5px; width: 30%; border-radius: 5px;" required>
                                                    <option selected>{{ $data->Role->jenis_role }}</option>
                                                    @foreach ($role as $item)
                                                    <option value="{{ $item->id }}" {{ $data->role_id == $item->id ? 'selected':''}}> {{ $item->kode_role }} - {{$item->jenis_role}}</option>
                                                @endforeach
                                                  </select>
                                                <!-- @if ($errors->has('name'))
                                                    <p class="text-danger">{{$errors->first('name')}}</p>
                                                @endif -->
                                            </div>
        

                                            <div class="row g-3 align-items-center " style="margin-bottom: 20px;">
                                                <div class="col-auto">
                                                  <label for="inputPassword6" class="col-form-label">Nama Produk</label>
                                                </div>
                                                <div class="col-auto">
                                                  <input name ="nama_produk" type="text" style="border-color: #01004C;" id="" class="form-control" aria-describedby="passwordHelpInline" value="{{ $data->nama_produk }}" required>
                                                </div>
                                                <div class="col-auto">
                                                    <label for="inputPassword6" class="col-form-label">Poin</label>
                                                  </div>
                                                <div class="col-auto">
                                                    <input name="poin_produk" type="text" style="border-color: #01004C;"  id="" class="form-control" aria-describedby="passwordHelpInline" value="{{ $data->poin_produk }}" required>

                                                </div>
                                              </div>
                                              <form>
                                                <div class="form-group">
                                                  <label for="exampleFormControlFile1">Upload Gambar Produk</label>
                                                  <input  name="gambar_produk" type="file" class="form-control-file" value="{{ $data->gambar_produk }}">
                                                </div>
                                                <div class="form-group">
                                                    <img src="{{asset('img/'.$data->gambar_produk)}}" height="10%" width="50%" alt="" srcset="">
                                                    </div>
                                              
                                    
                                            <div class="form-group mb-4">
                                                <label for="" class="form-label">Deskripsi Product</label>
                                                <textarea name="deskripsi_produk" type="text" class="form-control {{$errors->has('code') ? 'is-invalid' : ''}}"  style="border-color: #01004C;"  required > {{ $data->deskripsi_produk }} </textarea>
                                                <!-- @if ($errors->has('code'))
                                                    <p class="text-danger">{{$errors->first('code')}}</p>
                                                @endif -->
                                            </div>

                                            <div class="form-group mb-4">
                                                <button type="submit" class="btn " style="background-color: #01004C; color: white;">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
          
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

@endsection