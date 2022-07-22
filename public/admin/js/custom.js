$(document).ready(function(){
    $('#item').DataTable();
    $(".nav-item").removeClass("active");
    $(".nav-link").removeClass("active");
    //Check Admin Password is wrong or right
    $("#current_password").keyup(function(){
        var current_password = $("#current_password").val();
        //alert(current_password);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : '/admin/check-admin-password',
            data :{current_password:current_password},
            success : function(resp){
                //alert(resp);
                if(resp == "false"){
                    $("#check_password").html("<font color='red'>Current Password is Incorrect !</font>");
                } else if(resp == "true"){
                    $("#check_password").html("<font color='green'>Current Password is Correct !</font>");
                }
            },
            error : function(){
                alert('Error');
            }
        });
    });
    // Update Admin Status
    $(document).on("click",".updateAdminStatus", function(){
        var status = $(this).children("i").attr("status");
        var item_id = $(this).attr("item_id");
        //alert(status);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : '/admin/update-admin-status',
            data : { status:status,item_id:item_id},
            success : function(resp){
                //alert(resp);
                if(resp['status']==0){
                    $("#item-"+item_id).html("<i style='font-size:25px;'class='mdi mdi-bookmark-outline' status='Inactive'>");
                }else if(resp['status']==1){
                        $("#item-"+item_id).html("<i style='font-size:25px;'class='mdi mdi-bookmark-check' status='Active'>");
                }               
            },
            error : function(){
                alert('Error');
            }
        });
    });
    // Update Section Status
    $(document).on("click",".updateSectionStatus", function(){
        var status = $(this).children("i").attr("status");
        var item_id = $(this).attr("item_id");
        //alert(status);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : '/admin/update-section-status',
            data : { status:status,item_id:item_id},
            success : function(resp){
                //alert(resp);
                if(resp['status']==0){
                    $("#item-"+item_id).html("<i style='font-size:25px;'class='mdi mdi-bookmark-outline' status='Inactive'>");
                }else if(resp['status']==1){
                        $("#item-"+item_id).html("<i style='font-size:25px;'class='mdi mdi-bookmark-check' status='Active'>");
                }               
            },
            error : function(){
                alert('Error');
            }
        });
    });

    //delete confirm
    $(".confirmDelete").click(function(){
        var module = $(this).attr('module');
        var moduleid = $(this).attr('moduleid');
        //alert(module);
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )

            window.location = "/admin/delete-"+module+"/"+moduleid;
            }
          })          
    });
    
    // Update Brand Status
    $(document).on("click",".updateBrandStatus", function(){
        var status = $(this).children("i").attr("status");
        var item_id = $(this).attr("item_id");
        //alert(status);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : '/admin/update-brand-status',
            data : { status:status,item_id:item_id},
            success : function(resp){
                //alert(resp);
                if(resp['status']==0){
                    $("#item-"+item_id).html("<i style='font-size:25px;'class='mdi mdi-bookmark-outline' status='Inactive'>");
                }else if(resp['status']==1){
                        $("#item-"+item_id).html("<i style='font-size:25px;'class='mdi mdi-bookmark-check' status='Active'>");
                }               
            },
            error : function(){
                alert('Error');
            }
        });
    });
    // Update Category Status
    $(document).on("click",".updateCategoryStatus", function(){
        var status = $(this).children("i").attr("status");
        var item_id = $(this).attr("item_id");
        //alert(status);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : '/admin/update-category-status',
            data : { status:status,item_id:item_id},
            success : function(resp){
                //alert(resp);
                if(resp['status']==0){
                    $("#item-"+item_id).html("<i style='font-size:25px;'class='mdi mdi-bookmark-outline' status='Inactive'>");
                }else if(resp['status']==1){
                        $("#item-"+item_id).html("<i style='font-size:25px;'class='mdi mdi-bookmark-check' status='Active'>");
                }               
            },
            error : function(){
                alert('Error');
            }
        });
    });

    // Update product Status
    $(document).on("click",".updateProductStatus", function(){
        var status = $(this).children("i").attr("status");
        var item_id = $(this).attr("item_id");
        //alert(status);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'post',
            url : '/admin/update-product-status',
            data : { status:status,item_id:item_id},
            success : function(resp){
                //alert(resp);
                if(resp['status']==0){
                    $("#item-"+item_id).html("<i style='font-size:25px;'class='mdi mdi-bookmark-outline' status='Inactive'>");
                }else if(resp['status']==1){
                        $("#item-"+item_id).html("<i style='font-size:25px;'class='mdi mdi-bookmark-check' status='Active'>");
                }               
            },
            error : function(){
                alert('Error');
            }
        });
    });

    $('#section_id').change(function(){
        var section_id = $(this).val();
        //alert(section_id);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'get',
            url : '/admin/append-categories-level',
            data : { section_id:section_id},
            success : function(resp){
                //alert(resp);
                $('#appendCategoriesLevel').html(resp);             
            },
            error : function(){
                alert('Error');
            }
        });
    });
    // Add & Remove Product Attributes
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style="height: 10px;"></div><input type="text" name="size[]" placeholder = "Size"  style="width: 120px;"/> <input type="text" name="sku[]" placeholder = "Sku"  style="width: 120px;"/> <input type="text" name="price[]" placeholder = "Price"  style="width: 120px;"/> <input type="text" name="stock[]" placeholder = "Stock"  style="width: 120px;"/> <a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });

});

