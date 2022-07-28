
@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Product Images</h3>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add Product Images</h4>
                  @if(Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Error :</strong> {{Session::get('error_message')}}.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @endif
                  @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success :</strong> {{Session::get('success_message')}}.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @endif
                  @if ($errors->any())
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                  @endif
                  <form class="forms-sample"  action="{{ url('admin/add-images/'.$product['id']) }}"  method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="product_name"> Product Name </label>
                      &nbsp; {{ $product['product_name']}}
                    </div> 
                    <div class="form-group">
                      <label for="product_code"> Product Code </label>
                      &nbsp; {{ $product['product_code']}}
                    </div>
                    <div class="form-group">
                      <label for="product_color"> Product Color </label>
                      &nbsp; {{ $product['product_color']}}
                    </div>
                    <div class="form-group">
                      <label for="product_price"> Product Price </label>
                      &nbsp; {{ $product['product_price']}}
                    </div> 
                    <div class="form-group">
                        @if(!empty($product['product_image']))
                        <img style="width: 120px; height: 120px;" src="{{ asset ('front/images/product_image/small/'.$product['product_image']) }}" >
                        @else
                        <img style="width: 120px; height: 120px;" src="{{ asset ('front/images/product_image/medium/no_image.png')}}" >
                        @endif
                    </div>
                    <div>
                        <div class="field_wrapper">
                              <div>
                                  <input type="file" name="images[]" multiple="" id="images">
                              </div>
                          </div>
                    </div> 
                    <br><br>                
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-warning">Cancel</button>
                  </form>
                  <br><br><h4 class="card-title">Product Images</h4>                  
                    <table id="item" class="table table-bordered">
                      <thead>
                          <tr>
                              <th>
                                  ID
                              </th>
                              <th>
                                  Image
                              </th>
                              <th>
                                  Actions
                              </th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($product['images'] as $item)                              
                          <tr>
                              <td>
                                  {{ $item['id']}}
                              </td>
                              <td>
                              <img style="width: 120px; height: 120px;" src="{{ asset ('front/images/product_image/small/'.$item['image']) }}" >
                              </td>
                              <td>
                                  @if ($item['status']==1)
                                  <a class="updateImageStatus" id="item-{{ $item['id']}}" item_id="{{ $item['id']}}"
                                  href="javascript:void(0)"><i style="font-size:25px;" 
                                  class="mdi mdi-bookmark-check" status="Active"></i></a> 
                                  @else
                                  <a class="updateImageStatus" id="item-{{ $item['id']}}" item_id="{{ $item['id']}}"
                                  href="javascript:void(0)"><i style="font-size:25px;"
                                    class="mdi mdi-bookmark-outline" status="Inctive"></i>
                                  @endif
                              </td>
                          </tr>
                          @endforeach
                      </tbody>
                    </table>                 
                </div>
              </div>
            </div>                
        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection