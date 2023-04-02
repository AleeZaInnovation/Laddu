<?php
use App\Models\ProductsFilter;

$productFilters = ProductsFilter::productFilters();

?>
<script>
    $(document).ready(function(){
        // Filter for sort
        $('#sort').on("change",function(){
            //this.form.submit();
            var color = get_filter('color');
            var size = get_filter('size');
            var price = get_filter('price');
            var brand = get_filter('brand');
            var sort = $("#sort").val();
            var url = $("#url").val();
            @foreach($productFilters as $filters)
                var {{$filters['filter_column']}} = get_filter('{{$filters['filter_column']}}');
            @endforeach
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:url,
                method:"POST",
                data: {
                        @foreach($productFilters as $filters)
                        {{$filters['filter_column']}}:{{$filters['filter_column']}},
                        @endforeach
                        sort:sort,url:url,size:size,color:color,price:price,brand:brand},
                success: function(data){
                    $('.filter-products').html(data);
                },
                error: function(){
                    alert("Error");
                }
            });
        });
        // Filter for Size
        $('.size').on("change",function(){
            //this.form.submit();
            var color = get_filter('color');
            var size = get_filter('size');
            var price = get_filter('price');
            var brand = get_filter('brand');
            var sort = $("#sort").val();
            var url = $("#url").val();
            @foreach($productFilters as $filters)
                var {{$filters['filter_column']}} = get_filter('{{$filters['filter_column']}}');
            @endforeach
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:url,
                method:"POST",
                data: {
                        @foreach($productFilters as $filters)
                        {{$filters['filter_column']}}:{{$filters['filter_column']}},
                        @endforeach
                        sort:sort,url:url,size:size,color:color,price:price,brand:brand},
                success: function(data){
                    $('.filter-products').html(data);
                },
                error: function(){
                    alert("Error");
                }
            });
        });

        // Filter for Color
        $('.color').on("change",function(){
            //this.form.submit();
            var color = get_filter('color');
            var size = get_filter('size');
            var price = get_filter('price');
            var brand = get_filter('brand');
            var sort = $("#sort").val();
            var url = $("#url").val();
            @foreach($productFilters as $filters)
                var {{$filters['filter_column']}} = get_filter('{{$filters['filter_column']}}');
            @endforeach
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:url,
                method:"POST",
                data: {
                        @foreach($productFilters as $filters)
                        {{$filters['filter_column']}}:{{$filters['filter_column']}},
                        @endforeach
                        sort:sort,url:url,size:size,color:color,price:price,brand:brand},
                success: function(data){
                    $('.filter-products').html(data);
                },
                error: function(){
                    alert("Error");
                }
            });
        });

        // Filter for Price
        $('.price').on("change",function(){
            //this.form.submit();
            var price = get_filter('price');
            var color = get_filter('color');
            var size = get_filter('size');
            var brand = get_filter('brand');
            var sort = $("#sort").val();
            var url = $("#url").val();
            @foreach($productFilters as $filters)
                var {{$filters['filter_column']}} = get_filter('{{$filters['filter_column']}}');
            @endforeach
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:url,
                method:"POST",
                data: {
                        @foreach($productFilters as $filters)
                        {{$filters['filter_column']}}:{{$filters['filter_column']}},
                        @endforeach
                        sort:sort,url:url,size:size,color:color,price:price,brand:brand},
                success: function(data){
                    $('.filter-products').html(data);
                },
                error: function(){
                    alert("Error");
                }
            });
        });

        // Filter for Brand
        $('.brand').on("change",function(){
            //this.form.submit();
            var brand = get_filter('brand');
            var color = get_filter('color');
            var size = get_filter('size');
            var price = get_filter('price');
            var sort = $("#sort").val();
            var url = $("#url").val();
            @foreach($productFilters as $filters)
                var {{$filters['filter_column']}} = get_filter('{{$filters['filter_column']}}');
            @endforeach
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:url,
                method:"POST",
                data: {
                        @foreach($productFilters as $filters)
                        {{$filters['filter_column']}}:{{$filters['filter_column']}},
                        @endforeach
                        sort:sort,url:url,size:size,color:color,price:price,brand:brand},
                success: function(data){
                    $('.filter-products').html(data);
                },
                error: function(){
                    alert("Error");
                }
            });
        });

        //Filter for Daynamic
        @foreach($productFilters as $filter)
            $('.{{$filter['filter_column']}}').on('click',function(){
                var sort = $("#sort option:selected").val();
                var url = $("#url").val();
                var color = get_filter('color');
                var size = get_filter('size');
                var price = get_filter('price');
                var brand = get_filter('brand');
                @foreach($productFilters as $filters)
                    var {{$filters['filter_column']}} = get_filter('{{$filters['filter_column']}}');
                @endforeach
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:url,
                    method:"POST",
                    data: {
                        @foreach($productFilters as $filters)
                        {{$filters['filter_column']}}:{{$filters['filter_column']}},
                        @endforeach
                        sort:sort,url:url,size:size,color:color,price:price,brand:brand},
                    success: function(data){
                        $('.filter-products').html(data);
                    },
                    error: function(){
                        alert("Error");
                    }
                });
            });
        @endforeach
    });
</script>