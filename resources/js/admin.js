$(document).ready(function(){
	  $('select[name="da_type_lic"]').on('change', function() {
	      $('.product').empty();
	      var option = $(this).val();
          var requestUrl = baseUrl +'logistics/get_product/'+option;
          products(requestUrl);
	  });
});

function products(requestUrl = '') {
        $.ajax({
            url: requestUrl,
            type: "GET",
            dataType: "json",
            success:function(response) {
                if(response.success) {
                     toastr.success('Products listed successfully.');
                     var data = response.success;
                        $('.lic-product').empty();
                        $('.lic-product').append('<option value="">Select Product</option>');
                        $.each(data, function(key, value) {
                            $('.lic-product').append('<option value="'+ value.id +'">'+ value.product +'</option>');
                        });
                } else if(response.error == 'true'){
                    toastr.error('No product found.');
                    $('.lic-product').append('<option value="">Select product</option>');
               
                }
            }
         });
   }

  