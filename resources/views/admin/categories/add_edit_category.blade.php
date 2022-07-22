
@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Setting</h3>
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
                  <form class="forms-sample" @if(empty($category['id'])) action="{{ url('admin/add-edit-category') }}" @else action="{{ url('admin/add-edit-category/'.$category['id']) }}" @endif method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="category_name">Category Name </label>
                      <input type="text" class="form-control" @if(!empty($category['category_name'])) value="{{ $category['category_name'] }}" 
                      @else value="{{old('category_name')}}" @endif id="category_name" name="category_name" placeholder="Enter category name" >
                    </div>
                    <div class="form-group">
                      <label for="section_id">Select Section </label>
                      <select class="form-control" name="section_id" id="section_id" style="color: #495057;">
                            <option value=""> Select </option>
                            @foreach($section as $item)
                            <option value="{{$item['id']}}" @if($item['id']==$category['section_id']) selected @endif>
                            {{$item['name']}}
                            </option>
                            @endforeach
                      </select>
                    </div>
                    <div id="appendCategoriesLevel">
                      @include('admin.categories.append_categories_level')
                    </div>
                    <div class="form-group">
                      <label for="image">Image </label>
                      <input type="file" class="form-control" id="image" name="image" >
                      @if(!empty($category['category_image']))
                      <a target="_blank" href="{{ url ('front/images/category_image/'.$category['category_image']) }}">View Image</a>
                      &nbsp;|&nbsp;<a class="confirmDelete" href="javascript:void(0)" module="category-image" 
                      moduleid="{{ $category['id']}}"> Delete Image </a>
                      <input type="hidden"  name="current_category_image" value ="{{$category['category_image']}}">
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="category_discount">Category Discount </label>
                      <input type="text" class="form-control" @if(!empty($category['category_discount'])) value="{{ $category['category_discount'] }}" 
                      @else value="{{old('category_discount')}}" @endif id="category_discount" name="category_discount" placeholder="Enter category discount" >
                    </div>
                    <div class="form-group">
                      <label for="description">Category Description </label>
                      <textarea row="3" class="form-control"  id="description" name="description" 
                      placeholder="Enter category description" >{{ $category['description'] }}
                      </textarea>
                    </div>
                    <div class="form-group">
                      <label for="url">Category URL </label>
                      <input type="text" class="form-control" @if(!empty($category['url'])) value="{{ $category['url'] }}" 
                      @else value="{{old('url')}}" @endif id="url" name="url" placeholder="Enter category url" >
                    </div>
                    <div class="form-group">
                      <label for="meta_title">Meta Tilte </label>
                      <input type="text" class="form-control" @if(!empty($category['meta_title'])) value="{{ $category['meta_title'] }}" 
                      @else value="{{old('meta_title')}}" @endif id="meta_title" name="meta_title" placeholder="Enter meta tilte" >
                    </div>
                    <div class="form-group">
                      <label for="meta_description">Meta Description </label>
                      <input type="text" class="form-control" @if(!empty($category['meta_description'])) value="{{ $category['meta_description'] }}" 
                      @else value="{{old('meta_description')}}" @endif id="meta_description" name="meta_description" placeholder="Enter meta description" >
                    </div>
                    <div class="form-group">
                      <label for="meta_keywords">Meta Keywords </label>
                      <input type="text" class="form-control" @if(!empty($category['meta_keywords'])) value="{{ $category['meta_keywords'] }}" 
                      @else value="{{old('meta_keywords')}}" @endif id="meta_keywords" name="meta_keywords" placeholder="Enter meta keywords" >
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