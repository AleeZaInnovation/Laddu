
@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Product</h3>
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
                  <h4 class="card-title">{{$title}}</h4>
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
                  <form class="forms-sample" @if(empty($product['id'])) action="{{ url('admin/add-edit-product') }}" @else action="{{ url('admin/add-edit-product/'.$product['id']) }}" @endif method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="category_id">Select Category </label>
                      <select class="form-control" name="category_id" id="category_id" style="color: #495057;">
                            <option value=""> Select </option>
                            @foreach($categories as $section)
                              <optgroup label="{{$section['name']}}"></optgroup>
                                @foreach($section['categories'] as $category)
                                    <option  @if(!empty($product['category_id']==$category['id'])) selected="" @endif value="{{$category['id']}}">
                                      &nbsp;&nbsp;&nbsp;***&nbsp;
                                    {{$category['category_name']}}
                                    </option>
                                    @foreach($category['subcategories'] as $subcategories)
                                    <option @if(!empty($product['category_id']==$subcategories['id'])) selected="" @endif  value="{{$subcategories['id']}}">
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;
                                    {{$subcategories['category_name']}}
                                    </option>
                                    @endforeach
                                @endforeach
                            @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="brand_id">Select Brand </label>
                      <select class="form-control" name="brand_id" id="brand_id" style="color: #495057;">
                            <option value="" > Select </option>
                            @foreach($brands as $item)
                            <option value="{{$item['id']}}" @if($item['id']==$product['brand_id']) selected @endif>{{$item['name']}}</option>
                            @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="product_name"> Product Name </label>
                      <input type="text" class="form-control" @if(!empty($product['product_name'])) value="{{ $product['product_name'] }}" 
                      @else value="{{old('product_name')}}" @endif id="product_name" name="product_name" placeholder="Enter product name" >
                    </div> 
                    <div class="form-group">
                      <label for="product_code"> Product Code </label>
                      <input type="text" class="form-control" @if(!empty($product['product_code'])) value="{{ $product['product_code'] }}" 
                      @else value="{{old('product_code')}}" @endif id="product_code" name="product_code" placeholder="Enter product code" >
                    </div>
                    <div class="form-group">
                      <label for="product_color"> Product Color </label>
                      <input type="text" class="form-control" @if(!empty($product['product_color'])) value="{{ $product['product_color'] }}" 
                      @else value="{{old('product_color')}}" @endif id="product_color" name="product_color" placeholder="Enter product color" >
                    </div>
                    <div class="form-group">
                      <label for="product_price"> Product Price </label>
                      <input type="text" class="form-control" @if(!empty($product['product_price'])) value="{{ $product['product_price'] }}" 
                      @else value="{{old('product_price')}}" @endif id="product_price" name="product_price" placeholder="Enter product price" >
                    </div> 
                    <div class="form-group">
                      <label for="product_discount"> Product Discount (%) </label>
                      <input type="text" class="form-control" @if(!empty($product['product_discount'])) value="{{ $product['product_discount'] }}" 
                      @else value="{{old('product_discount')}}" @endif id="product_discount" name="product_discount" placeholder="Enter product discount" >
                    </div>
                    <div class="form-group">
                      <label for="product_weight"> Product Weight </label>
                      <input type="text" class="form-control" @if(!empty($product['product_weight'])) value="{{ $product['product_weight'] }}" 
                      @else value="{{old('product_weight')}}" @endif id="product_weight" name="product_weight" placeholder="Enter product weight" >
                    </div>
                    <div class="form-group">
                      <label for="image">Product Image (Recommended Size : 1000x1000)</label>
                      <input type="file" class="form-control" id="image" name="image" >
                      @if(!empty($product['product_image']))
                      <a target="_blank" href="{{ url ('front/images/product_image/large/'.$product['product_image'])}}" >View Image</a>
                      &nbsp;|&nbsp;<a class="confirmDelete" href="javascript:void(0)" module="product-image" 
                      moduleid="{{ $product['id']}}"> Delete Image </a>
                      <input type="hidden"  name="current_product_image" value ="{{$product['product_image']}}">
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="product_video">Product Video (Recommended Size : Less Then 2MB) </label>
                      <input type="file" class="form-control" id="product_video" name="product_video" >
                      @if(!empty($product['product_video']))
                      <a target="_blank" href="{{ url ('front/videos/product_video/'.$product['product_video']) }}">View Video</a>
                      &nbsp;|&nbsp;<a class="confirmDelete" href="javascript:void(0)" module="product-video" 
                      moduleid="{{ $product['id']}}"> Delete Video </a>
                      <input type="hidden"  name="current_product_video" value ="{{$product['product_video']}}">
                      @endif
                    </div>                    
                    <div class="form-group">
                      <label for="description"> Product Description </label>
                      <textarea row="3" class="form-control" @if(!empty($product['description'])) value="{{ $product['description'] }}" 
                      @else value="{{old('description')}}" @endif id="description" name="description" 
                      placeholder="Enter product description" >{{ $product['description'] }}
                      </textarea>
                    </div>
                    <div class="form-group">
                      <label for="meta_title">Meta Tilte </label>
                      <input type="text" class="form-control" @if(!empty($product['meta_title'])) value="{{ $product['meta_title'] }}" 
                      @else value="{{old('meta_title')}}" @endif id="meta_title" name="meta_title" placeholder="Enter meta tilte" >
                    </div>
                    <div class="form-group">
                      <label for="meta_description">Meta Description </label>
                      <input type="text" class="form-control" @if(!empty($product['meta_description'])) value="{{ $product['meta_description'] }}" 
                      @else value="{{old('meta_description')}}" @endif id="meta_description" name="meta_description" placeholder="Enter meta description" >
                    </div>
                    <div class="form-group">
                      <label for="meta_keywords">Meta Keywords </label>
                      <input type="text" class="form-control" @if(!empty($product['meta_keywords'])) value="{{ $product['meta_keywords'] }}" 
                      @else value="{{old('meta_keywords')}}" @endif id="meta_keywords" name="meta_keywords" placeholder="Enter meta keywords" >
                    </div>
                    <div class="form-group">
                      <label for="is_featured">Featured Item </label>
                      <input type="checkbox" name="is_featured" id="is_featured" value="Yes" 
                      @if(!empty($product['is_featured']) && $product['is_featured'] == "Yes") checked="" @endif> 
                    </div>                   
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
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