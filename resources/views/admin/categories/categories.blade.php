@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Categories</h4>
                        
                        <!-- <p class="card-description">
                            Add class <code>.table-bordered</code>
                        </p> -->
                        <a style="max-width: 150px; float: right; display: inline-block;
                        "href="{{ url('admin/add-edit-category')}}" class="btn btn-primary btn-block"> Add Category</a>
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
                                            Name
                                        </th>
                                        <th>
                                            Parent Category
                                        </th>
                                        <th>
                                            Section
                                        </th>
                                        <th>
                                            URL
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
                                    @foreach($categories as $item)
                                        @if(isset($item['parentcategory']['category_name']) &&!empty
                                        ($item['parentcategory']['category_name']))
                                            @php $parent_category = $item['parentcategory']['category_name']; @endphp
                                        @else
                                            @php $parent_category = "Root"; @endphp
                                        @endif
                                    <tr>
                                        <td>
                                            {{ $item['id']}}
                                        </td>
                                        <td>
                                            {{ $item['category_name']}}
                                        </td>
                                        <td>
                                            {{ $parent_category}}
                                        </td>
                                        <td>
                                            {{ $item['section']['name']}}
                                        </td>
                                        <td>
                                            {{ $item['url']}}
                                        </td>
                                        <td>
                                            @if ($item['status']==1)
                                            <a class="updateCategoryStatus" id="item-{{ $item['id']}}" item_id="{{ $item['id']}}"
                                            href="javascript:void(0)"><i style="font-size:25px;" 
                                            class="mdi mdi-bookmark-check" status="Active"></i></a> 
                                            @else
                                            <a class="updateCategoryStatus" id="item-{{ $item['id']}}" item_id="{{ $item['id']}}"
                                            href="javascript:void(0)"><i style="font-size:25px;"
                                             class="mdi mdi-bookmark-outline" status="Inctive"></i>
                                            @endif
                                        </td>
                                            
                                        <td>
                                            <a href="{{ url('admin/add-edit-category/'.$item['id'] )}}">
                                            <i style="font-size:25px;" class="mdi mdi-pencil-box"></i></a>
                                            <?php /* <a title="section" class="confirmDelete" href="{{ url('admin/delete-section/'.$item['id'] )}}">
                                            <i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a> */ ?>
                                            <a class="confirmDelete" href="javascript:void(0)" module="category" moduleid="{{ $item['id']}}">
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