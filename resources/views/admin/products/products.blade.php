@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Products</h4>
                        
                        <!-- <p class="card-description">
                            Add class <code>.table-bordered</code>
                        </p> -->
                        <a style="max-width: 150px; float: right; display: inline-block;
                        "href="{{ url('admin/add-edit-product')}}" class="btn btn-primary btn-block"> Add Product</a>
                        @if(Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success :</strong> {{Session::get('success_message')}}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                        @endif
                        <div class="table-responsive pt-3">
                            <table id="item" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Product Name
                                        </th>
                                        <th>
                                            Product Color
                                        </th>
                                        <th>
                                            Product Image
                                        </th>
                                        <th>
                                            Product Code
                                        </th>
                                        <th>
                                            Category
                                        </th>
                                        <th>
                                            Section
                                        </th>
                                        <th>
                                            Added By
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $item)
                                        
                                    <tr>
                                        <td>
                                            {{ $item['id']}}
                                        </td>
                                        <td>
                                            {{ $item['product_name']}}
                                        </td>
                                        <td>
                                            {{ $item['product_color']}}
                                        </td>
                                        <td>
                                            @if(!empty($item['product_image']))
                                            <img style="width: 120px; height: 120px;" src="{{ asset ('front/images/product_image/small/'.$item['product_image']) }}" >
                                            @else
                                            <img style="width: 120px; height: 120px;" src="{{ asset ('front/images/product_image/medium/no_image.png')}}" >
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item['product_code']}}
                                        </td>
                                        <td>
                                            {{ $item['category']['category_name']}}
                                        </td>
                                        <td>
                                            {{ $item['section']['name']}}
                                        </td>
                                        <td>
                                            @if($item['admin_type']=='vendor')
                                                <a href="{{ url ('admin/view-vendor-details/'.$item['admin_id'])}}">
                                                    {{ ucfirst( $item['admin_type'])}}</a>
                                            @else
                                                {{ ucfirst( $item['admin_type'])}}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item['status']==1)
                                            <a class="updateProductStatus" id="item-{{ $item['id']}}" item_id="{{ $item['id']}}"
                                            href="javascript:void(0)"><i style="font-size:25px;" 
                                            class="mdi mdi-bookmark-check" status="Active"></i></a> 
                                            @else
                                            <a class="updateProductStatus" id="item-{{ $item['id']}}" item_id="{{ $item['id']}}"
                                            href="javascript:void(0)"><i style="font-size:25px;"
                                             class="mdi mdi-bookmark-outline" status="Inctive"></i>
                                            @endif
                                        </td>
                                            
                                        <td>
                                            <a title="Edit Product" href="{{ url('admin/add-edit-product/'.$item['id'] )}}">
                                            <i style="font-size:25px;" class="mdi mdi-pencil-box"></i></a>
                                            <a title="Add Attributes" href="{{ url('admin/add-attributes/'.$item['id'] )}}">
                                            <i style="font-size:25px;" class="mdi mdi-plus-box"></i></a>
                                            <a title="Add Multiple Images" href="{{ url('admin/add-images/'.$item['id'] )}}">
                                            <i style="font-size:25px;" class="mdi mdi-library-plus"></i></a>
                                            <!--  -->
                                            <a title="Delete" class="confirmDelete" href="javascript:void(0)" module="product" moduleid="{{ $item['id']}}">
                                            <i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a>
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
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
        </div>
    </footer>
    <!-- partial -->
</div>
@endsection