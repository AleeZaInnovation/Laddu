<div class="row product-container grid-style">
    @foreach($productDetails as $item )
    <div class="product-item col-lg-4 col-md-6 col-sm-6">
        <div class="item">
                    <?php
                    $product_image_path = 'front/images/product_image/small/'.$item['product_image'];
                    ?>
                <div class="image-container">
                    <a class="item-img-wrapper-link" href="{{url('product/'.$item['id'])}}">
                        @if(!empty($item['product_image']) && file_exists($product_image_path))
                        <img class="image-fluid" src="{{ asset ($product_image_path) }}" alt="Product" >
                        @else
                        <img class="image-fluid" src="{{ asset ('front/images/product_image/medium/no_image.png')}}" alt="Product" >
                        @endif
                    </a>
                    <div class="item-action-behaviors">
                        <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look
                        </a>
                        <a class="item-mail" href="javascript:void(0)">Mail</a>
                        <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                        <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                    </div>
                </div>
            <div class="item-content">
                <div class="what-product-is">
                    <ul class="bread-crumb">
                        <li class="has-separator">
                            <a href="shop-v1-root-category.html">{{$item['product_code']}}</a>
                        </li>
                        <li class="has-separator" >
                            <a href="listing.html">{{$item['product_color']}}</a>
                        </li >
                        <li >
                            <a href="listing.html">{{$item['brand']['name']}}</a>
                        </li>
                    </ul>
                    <h6 class="item-title">
                        <a href="single-product.html">{{$item['product_name']}}</a>
                    </h6>
                    <div class="item-description">
                        <p>{{$item['description']}}
                        </p>
                    </div>
                    <!-- <div class="item-stars">
                        <div class='star' title="4.5 out of 5 - based on 23 Reviews">
                            <span style='width:67px'></span>
                        </div>
                        <span>(23)</span>
                    </div> -->
                </div>
                    <?php $getDiscountPrice = App\Models\Product::getDiscountPrice($item['id']);
                    ?>
                    @if($getDiscountPrice>0)
                    <div class="price-template">
                        <div class="item-new-price">
                        Tk{{$getDiscountPrice}}
                        </div>
                        <div class="item-old-price">
                        Tk{{($item['product_price'])}}
                        </div>
                    </div>
                    @else
                    <div class="price-template">
                        <div class="item-new-price">
                        Tk{{($item['product_price'])}}
                        </div>                                            
                    </div>
                    @endif
                </div>
                <?php $isProductsNew = App\Models\Product::isProductsNew($item['id']);  ?>
                @if($isProductsNew == "Yes")
                    <div class="tag new">
                        <span>NEW</span>
                    </div>
                @endif
        </div>
    </div>
    @endforeach
</div>
@if(isset($_GET['sort']))
    <div>{{$productDetails->appends(['sort'=>$_GET['sort']])->links()}}</div>
@else
    <div>{{$productDetails->links()}}</div>
@endif
<!-- Row-of-Product-Container /- -->
<div>&nbsp;&nbsp;</div>