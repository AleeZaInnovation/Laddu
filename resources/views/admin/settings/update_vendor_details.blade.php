
@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Update Vendor Details</h3>
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
        @if($slug=="personal")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update  Personal Information</h4>
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
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/personal') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label >Vendor Username/Email</label>
                      <input  class="form-control" value="{{Auth::guard('admin')->user()->email}}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="name">Name </label>
                      <input type="text" class="form-control" value="{{Auth::guard('admin')->user()->name}}" id="name" name="name" placeholder="Enter vendor name" required="">
                    </div>
                    <div class="form-group">
                      <label for="address">Address </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['address']}}" id="address" name="address" placeholder="Enter vendor address" required="">
                    </div>
                    <div class="form-group">
                      <label for="city">City </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['city']}}" id="city" name="city" placeholder="Enter vendor city" required="">
                    </div>
                    <div class="form-group">
                      <label for="state">State </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['state']}}" id="state" name="state" placeholder="Enter vendor state" required="">
                    </div>
                    <div class="form-group">
                      <label for="country">Country </label>
                      <select class="form-control" name="country" id="country" style="color: #495057;">
                            <option value=""> Select Country </option>
                            @foreach($countires as $country)
                            <option value="{{$country['country_name']}}" @if($country['country_name']==$vendorDetails['country']) selected @endif>
                            {{$country['country_name']}}
                            </option>
                            @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="pincode">Pincode </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['pincode']}}" id="pincode" name="pincode" placeholder="Enter vendor pincode" required="">
                    </div>
                    <div class="form-group">
                      <label for="mobile">Mobile </label>
                      <input type="text" class="form-control" value="{{Auth::guard('admin')->user()->mobile}}" id="mobile" name="mobile" placeholder="Enter 11 digit mobile number"  required="" maxlength="11" minlength="11">
                    </div>
                    <div class="form-group">
                      <label for="image">Image </label>
                      <input type="file" class="form-control" id="image" name="image" >
                      @if(!empty(Auth::guard('admin')->user()->image))
                      <a target="_blank" href="{{ url ('admin/images/photos/'.Auth::guard('admin')->user()->image) }}">View Image</a>
                      <input type="hidden"  name="current_vendor_image" value ="{{Auth::guard('admin')->user()->image}}">
                      @endif
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
        </div>
        @elseif($slug=="business")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update  Business Information</h4>
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
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/business') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label >Vendor Username/Email</label>
                      <input  class="form-control" value="{{Auth::guard('admin')->user()->email}}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="shop_name">Shop Name </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['shop_name']}}" id="shop_name" name="shop_name" placeholder="Enter vendor Shop Name" required="">
                    </div>
                    <div class="form-group">
                      <label for="shop_address">Shop Address </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['shop_address']}}" id="shop_address" name="shop_address" placeholder="Enter vendor Shop Address" required="">
                    </div>
                    <div class="form-group">
                      <label for="account_number">Shop City </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['shop_city']}}" id="shop_city" name="shop_city" placeholder="Enter vendor Shop City" required="">
                    </div>
                    <div class="form-group">
                      <label for="shop_state">Shop State </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['shop_state']}}" id="shop_state" name="shop_state" placeholder="Enter vendor Shop State" required="">
                    </div>
                    <div class="form-group">
                      <label for="shop_country">Shop Country </label>
                      <select class="form-control" name="shop_country" id="shop_country" style="color: #495057;">
                            <option value=""> Select Country </option>
                            @foreach($countires as $country)
                            <option value="{{$country['country_name']}}" @if($country['country_name']==$vendorDetails['shop_country']) selected @endif>
                            {{$country['country_name']}}
                            </option>
                            @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="shop_pincode">Shop Pincode </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['shop_pincode']}}" id="shop_pincode" name="shop_pincode" placeholder="Enter vendor Shop Pincode" required="">
                    </div>
                    <div class="form-group">
                      <label for="shop_mobile">Shop Mobile </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['shop_mobile']}}" id="shop_mobile" name="shop_mobile" placeholder="Enter 11 digit shop mobile number"  required="" maxlength="11" minlength="11">
                    </div>
                    <div class="form-group">
                      <label for="shop_website">Shop Website </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['shop_website']}}" id="shop_website" name="shop_website" placeholder="Enter  shop website "  required="" >
                    </div>
                    <div class="form-group">
                      <label for="shop_email">Shop Email </label>
                      <input type="email" class="form-control" value="{{$vendorDetails['shop_email']}}" id="shop_email" name="shop_email" placeholder="Enter  shop email "  required="" >
                    </div>                    
                    <div class="form-group">
                      <label for="business_license_number">Business License Number </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['business_license_number']}}" id="business_license_number" name="business_license_number" placeholder="Enter  business license number"  required="" >
                    </div>
                    <div class="form-group">
                      <label for="gst_number">GST Number </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['gst_number']}}" id="gst_number" name="gst_number" placeholder="Enter  gst number"  required="" >
                    </div>
                    <div class="form-group">
                      <label for="pan_number">PAN Number </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['pan_number']}}" id="pan_number" name="pan_number" placeholder="Enter  pan number"  required="" >
                    </div>
                    <div class="form-group">
                      <label for="address_proof">Address Proof </label>
                      <select class="form-control" name="address_proof" id="address_proof" value="{{$vendorDetails['address_proof']}}">
                        <option value="Passport" @if($vendorDetails['address_proof'] == "Passport") selected @endif> Passport</option>
                        <option value="NID" @if($vendorDetails['address_proof'] == "NID") selected @endif> NID</option>
                        <option value="Voting Card" @if($vendorDetails['address_proof'] == "Voting Card") selected @endif>Voting Card</option>
                        <option value="Driving License" @if($vendorDetails['address_proof'] == "Driving License") selected @endif>Driving License</option>
                        <option value="Others Card" @if($vendorDetails['address_proof'] == "Others Card") selected @endif>Others Card</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="address_proof_image">Address Proof Image </label>
                      <input type="file" class="form-control" id="address_proof_image" name="address_proof_image" >
                      @if(!empty($vendorDetails['address_proof_image']))
                      <a target="_blank" href="{{ url ('admin/images/proofs/'.$vendorDetails['address_proof_image']) }}">View Image</a>
                      <input type="hidden"  name="current_proof_image" value ="{{$vendorDetails['address_proof_image']}}">
                      @endif
                    </div>                    
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
        </div>
        @elseif($slug=="bank")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update  Bank Information</h4>
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
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/bank') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label >Vendor Username/Email</label>
                      <input  class="form-control" value="{{Auth::guard('admin')->user()->email}}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="account_holder_name">Account Holder Name </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['account_holder_name']}}" id="account_holder_name" name="account_holder_name" placeholder="Enter account holder name" required="">
                    </div>
                    <div class="form-group">
                      <label for="bank_name">Bank Name </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['bank_name']}}" id="bank_name" name="bank_name" placeholder="Enter vendor bank name" required="">
                    </div>
                    <div class="form-group">
                      <label for="account_number">Account Number </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['account_number']}}" id="account_number" name="account_number" placeholder="Enter vendor account number" required="">
                    </div>
                    <div class="form-group">
                      <label for="bank_ifsc_code">Bank Ifsc Code </label>
                      <input type="text" class="form-control" value="{{$vendorDetails['bank_ifsc_code']}}" id="bank_ifsc_code" name="bank_ifsc_code" placeholder="Enter vendor bank ifsc code" required="">
                    </div>                  
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
        </div>
        @endif
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection