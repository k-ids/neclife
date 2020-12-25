
<?php
 defined('BASEPATH') OR exit('No direct script access allowed');
?>

</div>
        <!-- /.container-fluid -->

    </div>
    <!-- /.content-wrapper -->

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-chevron-up"></i>
    </a>

    <!-- Bootstrap core JavaScript -->
    <script src="<?=base_url()?>resources/vendor/jquery/jquery.min.js"></script>

    <script src="<?=base_url()?>resources/vendor/tether/tether.min.js"></script>
    <script src="<?=base_url()?>resources/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="<?=base_url()?>resources/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?=base_url()?>resources/vendor/chart.js/Chart.min.js"></script>
    <script src="<?=base_url()?>resources/vendor/datatables/jquery.dataTables.js"></script>
    <script src="<?=base_url()?>resources/vendor/datatables/dataTables.bootstrap4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    
    <!-- Custom scripts for this template -->
    <script src="<?=base_url()?>resources/js/sb-admin.min.js"></script>
    <script src="<?=base_url()?>resources/js/admin.js"></script>
    <script src="<?=base_url()?>resources/js/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="<?=base_url()?>resources/js/html2canvas.min.js"></script>
    <script src="<?=base_url()?>resources/js/html2pdf.bundle.min.js"></script>
    <script src="<?=base_url()?>resources/js/sb-admin-inhouse.js"></script>
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" type="text/css"/>
    
     <script>

      function closeModal(id) {
            $('#'+id).hide('hide');
      }

      $(document).ready(function() {
          $('#example-optionClass').multiselect({
            includeSelectAllOption: true, // add select all option as usual
            optionClass: function(element) {
              var value = $(element).val();
              if (value%2 == 0) {
                return 'odd'; // reversed
              }
              else {
                return 'even'; // reversed
              }
            }
          });
        });

        CKEDITOR.replace( 'address' );
        CKEDITOR.replace( 'export_reference' );
        CKEDITOR.replace( 'shipping_marks_inv' );
        CKEDITOR.replace( 'declaration_final' );
        CKEDITOR.replace( 'gsk_info' );
        CKEDITOR.replace( 'pallet_dimensions' );

      $(document).ready(function(){
           exchangeRate();
           igstCalculation();

           $("#drop-zone").on('click', function(e){
              e.preventDefault();
              $("#upload_excel:hidden").trigger('click');
           });

           $("input[id='upload_excel']").change(function (e) {
              var fileType = this.files[0].type;
              
          /*    if(fileType != 'application/vnd.ms-excel') {
                 toastr.error('Invalid File format.');
                 $("input[id='upload_excel']").val('');
                 return false;
              } else {*/
                    var filename = $(this).val().split('\\').pop();
                    if(filename) {
                       $("#drop-zone").text(filename);
                    } else {
                       $("#drop-zone").text('Click to upload the file.');
                    }
             /* }
*/
          });
      });
      $(document).ready(function(){
        $('.check-box-invoice').click(function() {
            $('.check-box-invoice').not(this).prop('checked', false);
        });

        var id = $('.check-box-invoice:checked').attr('id');
   
        $("#gst").click(function(){
          
            $('#eunder_lut').prop('readonly', true);
            $('#exchange_rate').prop('readonly', false);
            $('#taxable_amount_inr').prop('readonly', false);
            $('#total_amount_inr').prop('readonly', false);
            $('#gst_amount_hidden').prop('readonly', true);
            $('#gst_rate_hidden').prop('readonly', true);
            return;
        });

        $("#lut").click(function(){
            $('#eunder_lut').prop('readonly', false);
            $('#exchange_rate').prop('readonly', true);
            $('#taxable_amount_inr').prop('readonly', true);
            $('#total_amount_inr').prop('readonly', true);
            $('#gst_amount_hidden').prop('readonly', true);
            $('#gst_rate_hidden').prop('readonly', true);
            return;
        });

      });
            
      </script>
   
    <script>    
    $(function() {
    // Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview) {
            
        if (input.files) {
                    
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    $($.parseHTML('<img style="height: 100px; width: 200px;">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#employee-signature').on('change', function() {
              imagesPreview(this, 'div.gallery');
          });
     });  

        $(document).ready(function(){
          $('a[data-toggle="tooltip"]').tooltip({
              animated: 'fade',
              placement: 'bottom',
              html: true
          });
        });
        
        function PrintElem(elem)
        {
            var mywindow = window.open('', 'PRINT', 'height=400,width=600');
            mywindow.document.write('<html><head><title></title>');
            mywindow.document.write('</head><body>');
           // mywindow.document.write('<h1>' + document.title  + '</h1>');
            mywindow.document.write(document.getElementById(elem).innerHTML);
            mywindow.document.write('</body></html>');
            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/
            mywindow.print();
            mywindow.close();
            return true;
        }
        
        function pdf(filename) {
           
           Swal.fire({
              icon: 'success',
              title: 'Thank you!',
              text: 'Your file is ready to download.',
              width: 600,
              padding: '3em',
              background: '#fff url(/images/trees.png)',
              backdrop: `
                rgba(0,0,123,0.4)
                url("/images/nyan-cat.gif")
                left top
                no-repeat
              `
            })
            html2pdf($('#elem')[0], {
             margin:       1,
             filename:     filename+'.pdf',
             image:        { type: 'jpeg', quality: 18 },
             html2canvas:  { dpi: 192, letterRendering: true },
             jsPDF:        { unit: 'pt', format: 'A4', orientation: 'p' }
          });

        }

      function pdf_invoice(filename) {

        Swal.fire({
            icon: 'success',
            title: 'Thank you!',
            text: 'Your file is ready to download.',
            width: 600,
            padding: '3em',
            background: '#fff url(/images/trees.png)',
            backdrop: `
              rgba(0,0,123,0.4)
              url("/images/nyan-cat.gif")
              left top
              no-repeat
            `
          })
            html2pdf($('#elem')[0], {
             margin:       1,
             filename:     filename+'.pdf',
             image:        { type: 'jpeg', quality: 18 },
             html2canvas:  { dpi: 192, letterRendering: true },
             jsPDF:        { unit: 'pt', format: [900, 2000], orientation: 'p' }
          });

        }
     </script>

     <script type="text/javascript">
      $(window).on('load',function(){
          $('#myModal').modal('show');
      });
     </script>

    <script type="text/javascript">
    <?php if ($this->session->flashdata('success')) {?>
        toastr.success("<?php echo $this->session->flashdata('success'); ?>");
    <?php } else if ($this->session->flashdata('error')) {?>
        toastr.error("<?php echo $this->session->flashdata('error'); ?>");
    <?php } else if ($this->session->flashdata('warning')) {?>
        toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
    <?php } else if ($this->session->flashdata('info')) {?>
        toastr.info("<?php echo $this->session->flashdata('info'); ?>");
    <?php } elseif ($this->session->flashdata('session-mismatch')) { ?>
      Swal.fire({
            icon: 'error',
            title: 'Unauthorised Action',
            text: 'You are not authorised to perfom this action.',
            width: 600,
            padding: '3em',
            background: '#fff url(/images/trees.png)',
            backdrop: `
              rgba(0,0,123,0.4)
              url("/images/nyan-cat.gif")
              left top
              no-repeat
            `
          })
    <?php } ?>
    </script>

    <script type="text/javascript">

    function getBuyerInfo(id, id2) {
      
        var obj = id.value ;
        if(obj) {
           var url = '<?= base_url() ?>logistics/get_buyer_info/'+obj;
           $.ajax({
                type: 'GET',
                url: url,
                success : function(response) {
                   var res = JSON.parse(response);
                   console.log('result', res);
                   if(res.status=='success') {

                       $("#address1-"+id2).text(res.result.address1);
                       $("#address2-"+id2).text(res.result.address2);
                       $("#address3-"+id2).text(res.result.address3);
                       $("#fax-tel-"+id2).text('FAX: '+res.result.fax+' TEL: '+res.result.phone);
                       $("#party-"+id2).css({'display': 'block'});

                   } else {
                     toastr.error('No result found.');
                     return false;
                   }
                },
                error: function(data) { 
                  toastr.error(data);
                }
           });

        } else {
          toster.error('something went wrong.');
          return false;
        }

    }


    function commonAjax(requestUrl = '') {
        $.ajax({
            url: requestUrl,
            type: "GET",
            dataType: "json",
            success:function(response) {

                if(response.success) {
                     //toastr.success('Department found successfully.');
                     var data = response.success;
                     $('select[name="department"]').empty();
                        var get_department = $("#db_department").val();

                        $('select[name="department"]').append('<option value="">Select department</option>');

                        $.each(data, function(key, value) {
                            if(get_department != undefined) {
                               if(get_department == value.id) {
                                  var selected = "selected";
                               } else {
                                  var selected = "";
                               }
                            }
                            $('select[name="department"]').append('<option value="'+ value.id +'" '+selected+'>'+ value.department +'</option>');
                        });
                } else if(response.error == 'true'){
                    toastr.error('No department found.');
                    $('select[name="department"]').append('<option value="">Select one</option>');
                }
            }
        });
    }

    function commonAjax1(requestUrl = '') {
        $.ajax({
            url: requestUrl,
            type: "GET",
            dataType: "json",
            success:function(response) {

                if(response.success) {
                     //toastr.success('Department found successfully.');
                     var data = response.success;
                     $('select[name="department"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="department"]').append('<option value="'+ value.id +'">'+ value.department +'</option>');
                        });
                } else if(response.error == 'true'){
                   $('select[name="department"]').empty();
                    toastr.error('No department found.');
                    $('select[name="department"]').append('<option value="">Select one</option>');
                }
            }
        });
    }
   

    $(function(){
      
        var value = $('select[name="da_type"]').val();
        if(value) {
            var parts = value.split("-");
            var requestUrl = '<?= base_url().'administrator/get_department/' ?>'+parts[0];
            commonAjax(requestUrl);
        }
     
    });

    $(document).ready(function() {

        $('select[name="da_type"]').on('change', function() {
          
            $('select[name="department"]').empty();
            var dataType_id = $(this).val();
            var arr = dataType_id.split('-');
           
            if(arr[0]) {
               var requestUrl = '<?= base_url().'administrator/get_department/' ?>'+arr[0];
               commonAjax(requestUrl);

            } else{
               // toastr.error('Request Failed.');
                $('select[name="department"]').empty();
            }
        });
    });

    /************* DA ENTRY PREPARATION *************************/

    $(document).ready(function() {

        var val = $('select[name="datype"]').val();
             callFunction(val);
          
        $('select[name="datype"]').on('change', function() {
            $(".da-table .form-control").val('');
            $('.product').empty();
            $("#add_more").removeAttr('title');
            $("#add_more").removeAttr('disabled');
            var dataType_id = $(this).val();
            var requestUrl = '<?= base_url().'logistics/get_product/'?>'+dataType_id;
            var pRequestUrl = '<?= base_url().'logistics/get_packing_type/'?>'+dataType_id;
            if(dataType_id) {
                
                 productListing(requestUrl);
                 packingTypeLisitng(pRequestUrl);
            } else{
                toastr.error('Request Failed.');
                $('.product').empty();
                var title_text = 'Please select da type above to proceed.';
                $("#add_more").attr('title', title_text);
                $("#add_more").prop('disabled', true);
            }
        });

    });

    function callFunction(val) {

            $('.product').empty();
            $("#add_more").removeAttr('title');
            $("#add_more").removeAttr('disabled');
            var dataType_id = val;
            var requestUrl = '<?= base_url().'logistics/get_product/'?>'+dataType_id;
            var pRequestUrl = '<?= base_url().'logistics/get_packing_type/'?>'+dataType_id;
            if(dataType_id) {

                 productListing(requestUrl);
                 packingTypeLisitng(pRequestUrl);
            } else{
                //toastr.error('Request Failed.');
                $('.product').empty();
                var title_text = 'Please select da type above to proceed.';
                $("#add_more").attr('title', title_text);
                $("#add_more").prop('disabled', true);
            }
    }

    function getval(sel, id) {
            var option = sel.options[sel.selectedIndex];
            var product_id = option && option.value;
            var row_index  = id;
              
            if(product_id) {

                  var requestUrl = baseUrl+'logistics/get_product_hscode/'+product_id;
                  productHsCodeListing(requestUrl, row_index);

            } else{
                toastr.error('Request Failed.');
            }
     }

    function productHsCodeListing(requestUrl = '', row_index = '') {
         $.ajax({
              url: requestUrl,
              type: "GET",
              dataType: "json",
              success:function(response) {

                  if(response.success) {
                     var data = response.success[0].hscode;
                     $("#hscode-"+row_index).val(data);
                    
                  } else if(response.error == 'true'){
                      toastr.error('No product found.');
                  }
              }
          });
     }


    function productListing(requestUrl = '') {
        $.ajax({
            url: requestUrl,
            type: "GET",
            dataType: "json",
            success:function(response) {

                if(response.success) {
                     //toastr.success('Department found successfully.');
                     var data = response.success;
                       
                        $('.product').empty();
                        $('.product').append('<option value="">Select Product</option>');
                        $.each(data, function(key, value) {

                            $('.product').append('<option value="'+ value.id +'">'+ value.product +'</option>');
                        });

                        
                } else if(response.error == 'true'){
                    toastr.error('No product found.');
                    $('.product').append('<option value="">Select product</option>');
                         var title_text = 'Please select da type above to proceed.';
                    $("#add_more").attr('title', title_text);
                    $("#add_more").prop('disabled', true);
                }
            }
         });
    }

    function packingTypeLisitng(pRequestUrl = '') {
        $.ajax({
            url: pRequestUrl,
            type: "GET",
            dataType: "json",
            success:function(response) {

                if(response.success) {
                     //toastr.success('Department found successfully.');
                     var data = response.success;
                     $('.packing_type').empty();

                        $('.packing_type').append('<option value="">Select Product</option>');
                        $.each(data, function(key, value) {
                            $('.packing_type').append('<option value="'+ value.id +'">'+ value.kindofpackages +'</option>');
                        });

                       
                } else if(response.error == 'true'){
                    toastr.error('No packing type found.');
                    $('.packing_type').append('<option value="">Select packing type</option>');
                }
            }
         });
    }
  
    $('#add_more').click(function () {

          var rowData = $('#myTable tbody tr:last td:eq(0) select').val();
           if(rowData =='' || rowData ==null || rowData =='undefined') {
              toastr.warning('Please fill the previous row first then proceed to next.');
              return false;
          }

          var increment = 1;       
          var checkid = $('#myTable tbody tr:last td:eq(1) input').attr('id');
          var arr = checkid.split('-');
          var rows = parseInt(arr[1]) + parseInt(increment);
          var html = $('#row').children('#myTable tbody tr:last').html();

          $('#myTable tbody').append('<tr>'+ html +'</tr>');
          $('#myTable tbody tr:gt(0) td:last').html('');
          $('#myTable tbody tr:gt(0) td:last').append('<input type="button" value="Delete" class="btn btn-danger" />');
          $('#myTable tbody tr:last td:eq(1)').html('');

          $('#myTable tbody tr:last td:eq(1)').append('<input type="text" name="hs_code[]" id="hscode-'+rows+'" class="form-control hscode" value="" readonly required>');
                
           $('#myTable tbody tr:last td:eq(0) select').attr('onchange', 'getval(this,'+rows+')');
           $('#myTable tbody tr:last td:eq(5) input').attr('id', 'qty-'+rows);
           $('#myTable tbody tr:last td:eq(5) input').attr('onchange', 'calculation('+rows+') ');
           $('#myTable tbody tr:last td:eq(6) input').attr('id', 'rate-'+rows);
           $('#myTable tbody tr:last td:eq(6) input').attr('onchange', 'calculation('+rows+') ');
           $('#myTable tbody tr:last td:eq(7) input').attr('id', 'amount-'+rows);
           $('#myTable tbody tr:last td:eq(8) input').attr('id', 'freight-'+rows);
           $('#myTable tbody tr:last td:eq(8) input').attr('onchange', 'calculation('+rows+') ');

           $('#myTable tbody tr:last td:eq(9) input').attr('id', 'logistics-'+rows);
           $('#myTable tbody tr:last td:eq(9) input').attr('onchange', 'calculation('+rows+') ');

           $('#myTable tbody tr:last td:eq(10) input').attr('id', 'fobrate-'+rows);

           $('#myTable tbody tr:last td:eq(11) input').attr('id', 'qty_discount-'+rows);
           $('#myTable tbody tr:last td:eq(11) input').attr('onchange', 'calculation('+rows+') ');

           $('#myTable tbody tr:last td:eq(12) input').attr('id', 'comm_per-'+rows);
           $('#myTable tbody tr:last td:eq(12) input').attr('onchange', 'calculation('+rows+') ');

           $('#myTable tbody tr:last td:eq(13) input').attr('id', 'comm_amount-'+rows);
           $('#myTable tbody tr:last td:eq(13) input').attr('onchange', 'calculation('+rows+') ');
           $('#myTable tbody tr:last td:eq(14) input').attr('id', 'net_price-'+rows);

           
           
    });

    $('#myTable').on('click', 'input[type="button"]', function () {
        $(this).closest('tr').remove();
        var last = $("#last_count").text();
        $("#last_count").text(parseInt(last)+ parseInt());
        gstCalculation();
    });
   
    function calculation_old(index) {

        var daType = $("#datype").val(); //get selected da type
        /* calculation of amount start*/
        var rate = $('#rate-'+index).val();
        var qty = $('#qty-'+index).val();
        
        if(daType != 5) {
             var amount  = ((qty) * (rate)).toFixed(2);
        } else {
             var amount  = (((qty) * (rate)) / 1000) .toFixed(2);
        }
        $('#amount-'+index).val(amount);

    
        /* calculation of fobrate start*/
        var freight = $('#freight-'+index).val();
        var logistics = $('#logistics-'+index).val();
        var f_l_sum = (+freight) + (+logistics);
        var fobrate = ( (rate) - (f_l_sum) );
        $('#fobrate-'+index).val(fobrate.toFixed(2));
        /* calculation of fobrate end*/
        
        /* calculation of net price start*/
        var qty_discount = $('#qty_discount-'+index).val();
        var comm_per = $('#comm_per-'+index).val();
        var comAmt = $('#comm_amount-'+index).val();

        if(comm_per > 0 ) {
             var commission = ((fobrate) - (qty_discount) ) * (comm_per /100);
             $('#comm_amount-'+index).val(commission.toFixed(2));
             var net_price = ((fobrate) - (qty_discount) - (commission));

        } else  {
            // var commission = ((fobrate) - (qty_discount) ) * (comm_per /100);
             /*var commission = (comAmt) / ( (fobrate) - (qty_discount) ) * 100; */
             $('#comm_amount-'+index).val('0.00');
             var net_price = ((fobrate) - (qty_discount));
        }
    
        $('#net_price-'+index).val(net_price.toFixed(2));

        gstCalculation();

        /* calculation of net price end*/

    }

    function calculation(index) {

        var daType = $("#datype").val(); //get selected da type
        /* calculation of amount start*/
        var rate = $('#rate-'+index).val();
        var qty = $('#qty-'+index).val();
        
        if(daType != 5) {
             var amount  = ((qty) * (rate)).toFixed(2);
        } else {
             var amount  = (((qty) * (rate)) / 1000) .toFixed(2);
        }
        $('#amount-'+index).val(amount);

        /* calculation of fobrate start*/
        var freight = $('#freight-'+index).val();
        var logistics = $('#logistics-'+index).val();
        var f_l_sum = (+freight) + (+logistics);
        var fobrate = ( (rate) - (f_l_sum) );
        $('#fobrate-'+index).val(fobrate.toFixed(2));
        /* calculation of fobrate end*/
        
        /* calculation of net price start*/
        var qty_discount = $('#qty_discount-'+index).val();
        var comm_per = $('#comm_per-'+index).val();
        //console.log('comm_per', comm_per);
        var comAmt = $('#comm_amount-'+index).val();

        if(comm_per != '0.00' || comm_per != '0' ) {

             var commission = ((fobrate) - (qty_discount) ) * (comm_per /100);
             $('#comm_amount-'+index).val(commission.toFixed(2));
             var net_price = ((fobrate) - (qty_discount) - (commission));

        } else  {

            // var commission = ((fobrate) - (qty_discount) ) * (comm_per /100);
            /*var commission = (comAmt) / ( (fobrate) - (qty_discount) ) * 100; */
            var comAmount = $('#comm_amount-'+index).val();

            if(comAmount != '0.00' || comAmount != '' || comAmount != '0') { 
                
                var commission = (comAmt) / ( (fobrate) - (qty_discount) ) * 100
                $('#comm_per-'+index).val(commission.toFixed(2));
               
                var net_price = (parseFloat(f_l_sum)) - (parseFloat(fobrate));

            } else {

                 $('#comm_amount-'+index).val('0.00');
                 var net_price = ((fobrate) - (qty_discount));
            }
        }
    
        $('#net_price-'+index).val(net_price.toFixed(2));

        gstCalculation();

        /* calculation of net price end*/

    }

    function reCalculation(index) {
  
        var rate = $('#re-rate-'+index).val();
        var quantity = $('#re-quantity-'+index).val();
        var amount  = ((quantity) * (rate)).toFixed(2);
        $('#re-amount-'+index).val(amount);
        var rowCount = $('.re-calculate tbody tr').length;
        var i;
        var totalAmount = 0;
      
        for(i= 0 ; i <= (rowCount - 1); i++) {
            let re_amount =  $('#re-amount-'+i).val();
            totalAmount = parseFloat(totalAmount) + parseFloat(re_amount);
        }
        var reTotalAmount = totalAmount.toFixed(2);
        $("#re-total").val(reTotalAmount);

        var _amount  = $("#re-total").val();
        var _exchange_rate = $("#exchange_rate").val();
        var taxableAmount = ( _amount * _exchange_rate ).toFixed(2);
        $("#taxable_amount_inr").val(taxableAmount);
       
        var gst_rate = $("#gst_rate_hidden").val();
        var _gst_amount = (taxableAmount * gst_rate) / 100;
        var _final_amount = parseFloat(taxableAmount) + parseFloat(_gst_amount);
        $("#gst_amount_hidden").val(_gst_amount.toFixed(2));
        $("#total_amount_inr").val(_final_amount.toFixed(2));

         var url = '<?= base_url().'commercial_invoice/total_in_words'?>';
         var data = { amount : reTotalAmount};
         $.ajax({
              type: 'POST',
              url: url,
              data: data,
              success: function(result) {
                  var response = JSON.parse(result);
                  var amountWords = response.amount_in_words+' Only';
                  $("#re-amount-words").val(amountWords);
                  return true;

            }
        });
    }
    
    function exchangeRate() {
        
        var _amount  = $("#re-total").val();
        var _exchange_rate = $("#exchange_rate").val();
        var taxableAmount = ( _amount * _exchange_rate ).toFixed(2);
        $("#taxable_amount_inr").val(taxableAmount);
        var gst_rate = $("#gst_rate_hidden").val();
        var _gst_amount = (taxableAmount * gst_rate) / 100;

        var _final_amount = parseFloat(taxableAmount) + parseFloat(_gst_amount);
        $("#gst_amount_hidden").val(_gst_amount.toFixed(2));
        $("#total_amount_inr").val(_final_amount.toFixed(2));
    }

    function igstCalculation() {

        var _amount  = $("#re-total").val();
        var _exchange_rate = $("#exchange_rate").val();
        var taxableAmount = ( _amount * _exchange_rate ).toFixed(2);
        $("#taxable_amount_inr").val(taxableAmount);

        var gst_rate = $("#gst_rate_hidden").val();
        var _gst_amount = (taxableAmount * gst_rate) / 100;

        var _final_amount = parseFloat(taxableAmount) + parseFloat(_gst_amount);
        $("#gst_amount_hidden").val(_gst_amount.toFixed(2));
        $("#total_amount_inr").val(_final_amount.toFixed(2));
    }

    function gstCalculation() {
       
        var gst_rate = $("#gst_rate").val();
        if(gst_rate != '') {
            var rowCount = $('.da-table tbody tr').length;
            var i;
            var totalAmount = 0;
            for(i= 0 ; i <= (rowCount - 1); i++) {
                let re_amount =  $('#amount-'+i).val();
                if(re_amount != ''){
                    totalAmount = parseFloat(totalAmount) + parseFloat(re_amount);
                }
            }
            console.log('totalAmount', totalAmount);
            /** GST CALCULATION **/
            var gstAmount = (totalAmount * gst_rate) / 100;
            console.log('gstAmount', gstAmount);
            $("#gst_amount").val(gstAmount.toFixed(2));
            return true;
        }
    }

    function grossWeightCalculation(index) {

          var gross_wt = $("#gross_wt-"+index).val();
          var tare_wt_corrugated = $("#tare_wt_corrugated-"+index).val();
          var multiplyby6 = gross_wt * 6;
          var gross_wt_corrugated = parseFloat(multiplyby6) + parseFloat(tare_wt_corrugated); 
          $("#gross_wt_corrugated-"+index).val(gross_wt_corrugated.toFixed(2));
          grandCalculationgsk(3);
          return true;
    }

    var totalWeightDispatched = [];
    $('#add_more-packing-list').click(function () {
            
            var rowData = $('#table-packing-list tbody tr:last td:eq(0) select').val();
            if(rowData =='' || rowData ==null || rowData =='undefined') {
              toastr.warning('Please fill the previous row first then proceed to next.');
              return false;
             }
            var checked= $('#table-packing-list tbody tr:last td:eq(0) select').attr('id');
            var arr = checked.split('-');
            var valueId =  arr[1];
           /**************** values section *************/
            var packing_type = $("#packing_type-"+valueId).val();
            var perfix = $("#perfix-"+valueId).val();
            var excise_sr_no = $("#excise_sr_no-"+valueId).val();
            var batch_no = $("#batch_no-"+valueId).val();
            var container = $("#container-"+valueId).val();
            var seal_no = $("#seal_no-"+valueId).val();
            var inner_tare_weight = $("#inner_tare_weight-"+valueId).val();
            var outer_tare_weight = $("#outer_tare_weight-"+valueId).val();
            var net_weight = $("#net_weight-"+valueId).val();
            var mgf_date = $("#mgf_date-"+valueId).val();
            var exp_date = $("#exp_date-"+valueId).val();
            var retest_date = $("#retest_date-"+valueId).val();
            var dimensions = $("#dimensions-"+valueId).val();
            var pallet_dimensions = $("#pallet_dimensions-"+valueId).val();
            var pallet_gross_weight = $("#pallet_gross_weight-"+valueId).val();
            var pallet_no = $("#pallet_no-"+valueId).val();
            var inner_tare_weight = $("#inner_tare-"+valueId).val();
            var outer_tare_weight = $("#outer_tare-"+valueId).val();
            var net_weight = $("#net_weight-"+valueId).val();
            var inner_gross_weight = $("#inner_gross_weight-"+valueId).val();
            var outer_gross_weight = $("#outer_gross_weight-"+valueId).val();

            
            totalWeightDispatched.push(net_weight);
            console.log('totalWeightDispatched' , totalWeightDispatched);
            var total = 0;
            for (var i = 0; i < totalWeightDispatched.length; i++) {
                total += totalWeightDispatched[i] << 0;
            }

            var totalQtyInListToFixed = $("#qty_in_list").val();
            $("#qauntity_dispatched").val(total.toFixed(2));
            if(parseFloat(total) > parseFloat(totalQtyInListToFixed)) {
      
                toastr.info('Quantity dispatched must be less than total quantity in list.');
                $("#add_more-packing-list").prop('disabled', true);
                var hasAttr = $("#add_more-packing-list").attr('disabled');
                if(hasAttr) {
                     $("#qauntity_dispatched").val('');
                     totalWeightDispatched = [];
                     var innerRowCount = $('#table-packing-list tbody tr').length;
                     if(innerRowCount > 0) {
                         var totalDisWt = [];
                         var loop = parseInt(innerRowCount) - parseInt(1);
                         for(var i = 0; i <= loop; i++) {
                            var netWt = $('#table-packing-list tbody tr:eq('+i+') td:eq(8) input').val();
                            totalWeightDispatched.push(netWt);
                         }
                          var total = 0;
                          for (var i = 0; i < totalWeightDispatched.length; i++) {
                              total += totalWeightDispatched[i] << 0;
                          }
                          $("#qauntity_dispatched").val(total.toFixed(2));
                  
                     }
                }
                return false;
            }  

            var increment = 1;       
            var checkid = $('#table-packing-list tbody tr:last td:eq(6) input').attr('id');
            var arr = checkid.split('-');
            var rows = parseInt(arr[1]) + parseInt(increment);
            var html = $('#table-packing-list-row').children('#table-packing-list tbody tr:last').html();
           //console.log('html', html);
           $('#table-packing-list tbody').append('<tr>'+ html +'</tr>');
           $('#table-packing-list tbody tr:gt(0) td:last').html('');
           $('#table-packing-list tbody tr:gt(0) td:last').append('<input type="button" value="Remove" class="btn btn-danger table-packing-list-del" />');

           $('#table-packing-list tbody tr:last td:eq(6) input').attr({'id' :'inner_tare-'+rows, 'value': inner_tare_weight, 'onchange' : 'tareNetCalculation('+rows+') '});
           $('#table-packing-list tbody tr:last td:eq(7) input').attr({'id' :'outer_tare-'+rows, 'value': outer_tare_weight, 'onchange' : 'tareNetCalculation('+rows+') '});
           $('#table-packing-list tbody tr:last td:eq(8) input').attr({'id' :'net_weight-'+rows, 'value' : net_weight , 'onchange' : 'tareNetCalculation1('+rows+') '});
          /********* make content dynamic ************************/
           $('#table-packing-list tbody tr:last td:eq(0) select').attr({'id': 'packing_type-'+rows});
           $('#table-packing-list tbody tr:last td:eq(0) select option[value="'+packing_type+'"]').attr("selected","selected");
           $('#table-packing-list tbody tr:last td:eq(1) input').attr({'id' : 'perfix-'+rows, 'value' : perfix});
           $('#table-packing-list tbody tr:last td:eq(2) input').attr({'id': 'excise_sr_no-'+rows, 'value': parseInt(excise_sr_no)+parseInt(1), 'onkeyup' : 'checkDigitOrNot('+rows+') '});
           $('#table-packing-list tbody tr:last td:eq(3) input').attr({'id' : 'batch_no-'+rows, 'value': batch_no});
           $('#table-packing-list tbody tr:last td:eq(4) input').attr({'id': 'container-'+rows, 'value': parseInt(container)+parseInt(1) });
           $('#table-packing-list tbody tr:last td:eq(5) input').attr({'id': 'seal_no-'+rows, 'value' : parseInt(seal_no)+parseInt(1) }); 
           $('#table-packing-list tbody tr:last td:eq(9) input').attr({'id' : 'inner_gross_weight-'+rows, 'value' : inner_gross_weight});
           $('#table-packing-list tbody tr:last td:eq(10) input').attr({'id' :'outer_gross_weight-'+rows, 'value': outer_gross_weight});
           $('#table-packing-list tbody tr:last td:eq(11) input').attr({'id' : 'mgf_date-'+rows, 'value' : mgf_date});
           $('#table-packing-list tbody tr:last td:eq(12) input').attr({'id' :'exp_date-'+rows, 'value': exp_date});
           $('#table-packing-list tbody tr:last td:eq(13) input').attr({'id' : 'retest_date-'+rows, 'value': retest_date});
           $('#table-packing-list tbody tr:last td:eq(14) input').attr({'id': 'dimensions-'+rows, 'value': dimensions});
           $('#table-packing-list tbody tr:last td:eq(15) input').attr({'id':'pallet_dimensions-'+rows, 'value': pallet_dimensions});
           $('#table-packing-list tbody tr:last td:eq(16) input').attr({'id': 'pallet_gross_weight-'+rows, 'value' : pallet_gross_weight});
           $('#table-packing-list tbody tr:last td:eq(17) input').attr({'id': 'pallet_no-'+rows, 'value': '' });

           $('#table-packing-list tbody tr:last td:eq(18) input').attr({'id': 'box_no-'+rows, 'value': '' });
           $('#table-packing-list tbody tr:last td:eq(19) input').attr({'id': 'total_no_boxes-'+rows, 'value': '' });
           $('#table-packing-list tbody tr:last td:eq(20) input').attr({'id': 'total_no_packs-'+rows, 'value': '' });

           callDateFunction();
          
         /****************** end end  **************************/
    });


    $('#add-more-gsk-packing-list').click(function () {

            var rowData = $('#table-gsk-packing-list tbody tr:last td:eq(1) input').val();
            if(rowData =='' || rowData ==null || rowData =='undefined') {
              toastr.warning('Please fill the previous row first then proceed to next.');
              return false;
             }
              //grandCalculationgsk(1);
            var checked= $('#table-gsk-packing-list tbody tr:last td:eq(0) input').attr('id');
            var arr = checked.split('-');
            var valueId =  arr[1];

            /********** find value section *********/
             
            var serial_no = $("#serial_no-"+valueId).val();
            var excise_serial_no = $("#excise_serial_no-"+valueId).val();
            var bag_no = $("#bag_no-"+valueId).val();
            var batch_no = $("#batch_no-"+valueId).val();
            var mfg_date = $("#mfg_date-"+valueId).val();
            var retest_date = $("#retest_date-"+valueId).val();
            var tare_wt = $("#tare_wt-"+valueId).val();
            var net_wt = $("#net_wt-"+valueId).val();
            var gross_wt = $("#gross_wt-"+valueId).val();
            var tare_wt_corrugated = $("#tare_wt_corrugated-"+valueId).val();
            var gross_wt_corrugated = $("#gross_wt_corrugated-"+valueId).val();
            var gross_wt_pallet = $("#gross_wt_pallet-"+valueId).val();

            
            /********** end section ***************/
            

            var increment = 1;       
            var checkid = $('#table-gsk-packing-list tbody tr:last td:eq(0) input').attr('id');
            var arr = checkid.split('-');
            var rows = parseInt(arr[1]) + parseInt(increment);
            var html = $('#table-gsk-packing-list-row').children('#table-gsk-packing-list tbody tr:last').html();
            $('#table-gsk-packing-list tbody').append('<tr>'+ html +'</tr>');

           $('#table-gsk-packing-list tbody tr:gt(0) td:last').html('');
           $('#table-gsk-packing-list tbody tr:gt(0) td:last').append('<input type="button" value="Remove" class="btn btn-danger table-gsk-packing-list-del" />');

           $('#table-gsk-packing-list tbody tr:last td:eq(0) input').attr({'id' : 'serial_no-'+rows, 'value' : parseInt(serial_no)+ parseInt(1) });
           $('#table-gsk-packing-list tbody tr:last td:eq(1) input').attr({'id' : 'excise_serial_no-'+rows, 'value' : parseInt(excise_serial_no)+ parseInt(1) });
           $('#table-gsk-packing-list tbody tr:last td:eq(2) input').attr({'id' : 'bag_no-'+rows, 'value' : bag_no });
           $('#table-gsk-packing-list tbody tr:last td:eq(3) input').attr({'id' : 'batch_no-'+rows, 'value' : batch_no });

           $('#table-gsk-packing-list tbody tr:last td:eq(4) input').attr({'id' : 'mfg_date-'+rows, 'value' : mfg_date });
           $('#table-gsk-packing-list tbody tr:last td:eq(5) input').attr({'id' : 'retest_date-'+rows, 'value' : retest_date });

           $('#table-gsk-packing-list tbody tr:last td:eq(6) input').attr({'id' : 'tare_wt-'+rows, 'value' : tare_wt , 'onchange': 'grossWtBag('+rows+')'});
           $('#table-gsk-packing-list tbody tr:last td:eq(7) input').attr({'id' : 'net_wt-'+rows, 'value' : net_wt , 'onchange': 'grossWtBag('+rows+')'});

           $('#table-gsk-packing-list tbody tr:last td:eq(8) input').attr({'id' : 'gross_wt-'+rows, 'value' : gross_wt, 'onchange': 'grossWeightCalculation('+rows+')'});

           $('#table-gsk-packing-list tbody tr:last td:eq(9) input').attr({'id' : 'tare_wt_corrugated-'+rows, 'value' : tare_wt_corrugated, 'onchange': 'grossWeightCalculation('+rows+')' });

           $('#table-gsk-packing-list tbody tr:last td:eq(10) input').attr({'id' : 'gross_wt_corrugated-'+rows, 'value' : gross_wt_corrugated });
           $('#table-gsk-packing-list tbody tr:last td:eq(11) input').attr({'id' : 'gross_wt_pallet-'+rows, 'value' : gross_wt_pallet });

           callDateFunction();
          
         /****************** end end  **************************/
    });

    $('#table-gsk-packing-list').on('click', '.table-gsk-packing-list-del', function () {
        
       // grandCalculationgsk(2);

        $(this).closest('tr').remove();
        var last = $("#last_count").text();
        $("#last_count").text(parseInt(last)+ parseInt());
          var rowCount = $('#table-gsk-packing-list tbody tr').length;
          var counter = parseInt(rowCount) - parseInt(1);
 
          for(var i = 0; i <= counter; i++) {
              var increment =  parseInt(i) + parseInt(1);
              $('#table-gsk-packing-list tbody tr:eq('+i+') td:eq(0) input').val(increment);
                      
          }
        //window.location.reload();
    });

    function grossWtBag(index) {
        var tare_wt = $("#tare_wt-"+index).val();
        var net_wt = $("#net_wt-"+index).val();
        var grossWtBag = ( parseFloat(tare_wt) + parseFloat(net_wt) ) ;
        $("#gross_wt-"+index).val(grossWtBag);
        grossWeightCalculation(index);
       // grandCalculationgsk(1);
    }
    
  
    function grandCalculationgsk() {
     
        var rowCount = $('#table-gsk-packing-list tbody tr').length;
        var totla_row = parseInt(rowCount) + parseInt(1);
        var i;
        var totalpalletNo = 0;
        var totalGrossWtCoggurated = 0;
        var totalTareCoggurated = 0;
        var totalGross = 0;
        var totalNet = 0;
        var totalTare = 0;
      
        var intialise = 0;
        var loopCounter = parseInt(rowCount) - parseInt(1);
      
        
        for(i = intialise; i <= loopCounter; i++) {
            
                var grossTare = $('#table-gsk-packing-list tbody tr:eq('+i+') td:eq(6) input').val();
                totalTare = parseFloat(totalTare) + (parseFloat(grossTare) * 6);

                var grossNet = $('#table-gsk-packing-list tbody tr:eq('+i+') td:eq(7) input').val();
                totalNet = parseFloat(totalNet) + (parseFloat(grossNet) * 6);

                var grossWt = $('#table-gsk-packing-list tbody tr:eq('+i+') td:eq(8) input').val();
                totalGross = parseFloat(totalGross) + parseFloat(grossWt);

                var tareCoggurated = $('#table-gsk-packing-list tbody tr:eq('+i+') td:eq(9) input').val();
                totalTareCoggurated = parseFloat(totalTareCoggurated) + parseFloat(tareCoggurated);

                var grossWtCoggurated = $('#table-gsk-packing-list tbody tr:eq('+i+') td:eq(10) input').val();
                totalGrossWtCoggurated = parseFloat(totalGrossWtCoggurated) + parseFloat(grossWtCoggurated);

                var palletNo = $('#table-gsk-packing-list tbody tr:eq('+i+') td:eq(11) input').val();
                var palletNo1;
                if(palletNo == '') {
                     palletNo1 = '0.00';
                } else {
                    palletNo1 = palletNo;
                } 
                totalpalletNo = parseFloat(totalpalletNo) + parseFloat(palletNo1);
          }
           
          var travel_sample1 = $("#travel_sample1").val();
          var grandTotalTare = parseFloat(totalTare) + parseFloat(travel_sample1);

          var travel_sample2 = $("#travel_sample2").val();
          var grandTotalNet = parseFloat(totalNet) + parseFloat(travel_sample2);

          var travel_sample3 = $("#travel_sample3").val();
          var grandTotalGross = parseFloat(totalGross) + parseFloat(travel_sample3);

          $("#grand_tare").val(grandTotalTare.toFixed(2));
          $("#grand_net").val(grandTotalNet.toFixed(2));
          $("#grand_gross").val(grandTotalGross.toFixed(2));
          
          $("#grand_tare_coggurated").val(totalTareCoggurated.toFixed(2));
          $("#grand_gross_pallet").val(totalpalletNo.toFixed(2));
          $("#grand_gross_coggurated").val(totalGrossWtCoggurated.toFixed(2));
        
    }

   function checkDigitOrNot(index) {
    
        var str = $('#excise_sr_no-'+index).val();
        if (/\D/g.test(str)) {
            // Filter non-digits from input value.
            str = str.replace(/\D/g, '');
            $('#excise_sr_no-'+index).val(str);
            toastr.error('only digits [0-9] allowed.');
            return;
        }
   }

    $('[id^="delete-record-"]').on('click', function () {
         var id = $(this).data('id');
         var url = $(this).data('url');
    
            const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                  confirmButton: 'btn btn-success',
                  cancelButton: 'btn btn-danger'
              },
              buttonsStyling: false
          })
          swalWithBootstrapButtons.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, delete it!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
          }).then((result) => {
              if (result.value) {
                  $.ajax({
                      type: 'POST',
                      url: url,
                      success: function(result) {
                          var response = JSON.parse(result);
                          if (response.success) {
                              Swal.fire({
                                  icon: 'success',
                                  title: 'Deleted!',
                                  text: response.success, 
                              }).then((result) => {
                                if(result.value) {
                                    window.location.reload();
                                    return true;
                                }                                  
                              });
                          } else if(response.error){
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Sorry',
                                  text: 'Not able to proecess your request',  
                              });
                          } else {

                          }
                      },
                  });
              } else if (
                  /* Read more about handling dismissals below */
                  result.dismiss === Swal.DismissReason.cancel
              ) {
                  swalWithBootstrapButtons.fire(
                      'Cancelled',
                      'Your Record is safe :)',
                      'error'
                  )
              }
          })
        
    });

    $('[id^="regenerate-invoice-"]').on('click', function () {
         var id = $(this).data('id');
         var url = $(this).data('url');
    
            const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                  confirmButton: 'btn btn-success',
                  cancelButton: 'btn btn-danger'
              },
              buttonsStyling: false
          })
          swalWithBootstrapButtons.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, regenerate it!',
              cancelButtonText: 'No, cancel!',
              reverseButtons: true
          }).then((result) => {
              if (result.value) {
                  $.ajax({
                      type: 'POST',
                      url: url,
                      success: function(result) {
                          var response = JSON.parse(result);
                          if (response.success) {
                              Swal.fire({
                                  icon: 'success',
                                  title: 'Invoice Re-open!',
                                  text: response.success, 
                              }).then((result) => {
                                  window.location.href = response.url;
                                  return true;                                
                              });
                          } else if(response.error){
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Sorry',
                                  text: 'Not able to proecess your request',  
                              });
                          } else {

                          }
                      },
                  });
              } else if (
                  /* Read more about handling dismissals below */
                  result.dismiss === Swal.DismissReason.cancel
              ) {
                  swalWithBootstrapButtons.fire(
                      'Cancelled',
                      'Your Record is safe :)',
                      'error'
                  )
              }
          })
        
    });
     
    $('#table-packing-list').on('click', '.table-packing-list-del', function () {
        $(this).closest('tr').remove();
        var last = $("#last_count").text();
        $("#last_count").text(parseInt(last)+ parseInt());
    });
    
    function checkunique(obj2, obj3) {
       var field_value = $("#value-"+obj3).val();
       var field_name = obj2;
       var id = obj3;
       var url = '<?= base_url().$this->router->fetch_class().'/check_unique'?>';
       var data = {id: id, field: field_name, value: field_value};
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(result) {
                var response = JSON.parse(result);
                 //console.log(response);
            },
        });
    }

    /*********************** END *******************************/
   

    //$(document).ready(function() {
        $('[id^="delete-user-"]').click(function() {

                  var url = $(this).data('url');
                  var remove_tr = $(this).parent('td').parent('tr').attr('id');
                  const swalWithBootstrapButtons = Swal.mixin({
                      customClass: {
                          confirmButton: 'btn btn-success',
                          cancelButton: 'btn btn-danger'
                      },
                      buttonsStyling: false
                  })
                  swalWithBootstrapButtons.fire({
                      title: 'Are you sure?',
                      text: "You won't be able to revert this!",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonText: 'Yes, delete it!',
                      cancelButtonText: 'No, cancel!',
                      reverseButtons: true
                  }).then((result) => {
                      if (result.value) {
                          $.ajax({
                              type: 'POST',
                              url: url,
                              success: function(result) {
                                  var response = JSON.parse(result);
                                  if (response.success) {
                                  
                                      Swal.fire({
                                          icon: 'success',
                                          title: 'Deleted!',
                                          text: response.success, 
                                      }).then((result) => {
                                        if(result.value) {
                                            alert('dddadad');
                                            window.location.reload();
                                            return true;
                                         }                                  
                                      });
                                  } else if(response.error){
                                      Swal.fire({
                                          icon: 'error',
                                          title: 'Sorry',
                                          text: 'Not able to proecess your request',  
                                      }).then((result) => {
                                        if(result.value) {
                                          window.location.reload();
                                        }                                  
                                      });
                                  } else {

                                  }
                              },
                          });
                      } else if (
                          /* Read more about handling dismissals below */
                          result.dismiss === Swal.DismissReason.cancel
                      ) {
                          swalWithBootstrapButtons.fire(
                              'Cancelled',
                              'Your Record is safe :)',
                              'error'
                          )
                      }
                  })
          });
   // });
    
    //$(document).ready(function() {
        $('[id^="delete-"]').click(function() {

                  var url = $(this).data('url');
                  var remove_tr = $(this).parent('td').parent('tr').attr('id');
                  const swalWithBootstrapButtons = Swal.mixin({
                      customClass: {
                          confirmButton: 'btn btn-success',
                          cancelButton: 'btn btn-danger'
                      },
                      buttonsStyling: false
                  })
                  swalWithBootstrapButtons.fire({
                      title: 'Are you sure?',
                      text: "You won't be able to revert this!",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonText: 'Yes, delete it!',
                      cancelButtonText: 'No, cancel!',
                      reverseButtons: true
                  }).then((result) => {
                      if (result.value) {
                          $.ajax({
                              type: 'POST',
                              url: url,
                              success: function(result) {
                                  var response = JSON.parse(result);
                                  if (response.success) {
                                  
                                      Swal.fire({
                                          icon: 'success',
                                          title: 'Deleted!',
                                          text: response.success, 
                                      }).then((result) => {
                                        if(result.value) {
                                           
                                            $("#"+remove_tr).remove();

                                             var rowCount = $('#table-gsk-packing-list tbody tr').length;
                                            var counter = parseInt(rowCount) - parseInt(1);
                                   
                                            for(var i = 0; i <= counter; i++) {
                                                var increment =  parseInt(i) + parseInt(1);
                                                $('#table-gsk-packing-list tbody tr:eq('+i+') td:eq(0) input').val(increment);
                                                        
                                            }
                                            Swal.fire({
                                                icon: 'info',
                                                title: 'Save Packing List',
                                                text: 'Please save the Packing list for data accuracy.',  
                                            });
                                            return true;
                                         }                                  
                                      });
                                  } else if(response.error){
                                      Swal.fire({
                                          icon: 'error',
                                          title: 'Sorry',
                                          text: 'Not able to proecess your request',  
                                      }).then((result) => {
                                        if(result.value) {
                                          window.location.reload();
                                        }                                  
                                      });
                                  } else {

                                  }
                              },
                          });
                      } else if (
                          /* Read more about handling dismissals below */
                          result.dismiss === Swal.DismissReason.cancel
                      ) {
                          swalWithBootstrapButtons.fire(
                              'Cancelled',
                              'Your Record is safe :)',
                              'error'
                          )
                      }
                  })
          });
    //});
    
    $(function() {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
         $("#from_date, #upto_date, #lc_date, #da_date, #po_date, .tentative_date, .actual_date, #cancellation_date, #expiry_date, #license_date, #packing_list_date").datepicker({ 
           format:'dd-MM-yyyy',
        });

        $("#from_date, #upto_date, #lc_date, #da_date ,#po_date, .tentative_date, .actual_date, #cancellation_date, #expiry_date, #license_date, #packing_list_date").datepicker('setDate', today);

    });

    $(function() {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
         $("#billed_date, #due_date").datepicker({ 
           format:'dd-M-yyyy',
        });

        $("#billed_date, #due_date").datepicker('setDate', today);

    });

    $(function() {
         $("#from_date_1, #upto_date_1, #lc_date_1, #da_date_1 ,#po_date_1, #packing_list_date_1, .tentative_date, .actual_date, #expiry_date-1, #license_date-1, .eo_extend_date").datepicker({ 
           format:'dd-MM-yyyy',
        });
    });
    
    $('#days').change(function() {
      var ll = $(this).val();
      var bb = $('#billed_date').val();
      var date = new Date(bb);
      date.setDate(date.getDate() + (+ll));
      
      var dd = date.getDate();
      var mm = date.getMonth() + 1;
      var yyyy = date.getFullYear();
      var someFormattedDate = dd + '-' + mm + '-' + yyyy;
      
      $('#due_date').val(someFormattedDate);
    });


    $(function() {
    //$(document).on('click', '.mfg_date, .exp_date, .retest_date', function(e)) {
         $(".mfg_date, .exp_date, .retest_date").datepicker({ 
           format:'M-yyyy',
           viewMode: "months", 
           minViewMode: "months"
        });
    });
    function callDateFunction() {
        $(".mfg_date, .exp_date, .retest_date").datepicker({ 
           format:'M-yyyy',
           viewMode: "months", 
           minViewMode: "months"
        });
    }
    function tareNetCalculation1(index) {
           
          $("#add_more-packing-list").prop('disabled', false);
           var innerRowCount = $('#table-packing-list tbody tr').length;
           if(innerRowCount > 0) {
               totalWeightDispatched = [];
               var loop = parseInt(innerRowCount) - parseInt(1);
               for(var i = 0; i <= loop; i++) {
                  var netWt = $('#table-packing-list tbody tr:eq('+i+') td:eq(8) input').val();
                  totalWeightDispatched.push(netWt);
               }
                var total = 0;
                for (var i = 0; i < totalWeightDispatched.length; i++) {
                    total += totalWeightDispatched[i] << 0;
                }

                $("#qauntity_dispatched").val(total.toFixed(2));
                var totalQtyInListToFixed = $("#qty_in_list").val();
                if(parseFloat(total) > parseFloat(totalQtyInListToFixed)) {
                    
                    toastr.info('Quantity dispatched must be less than total quantity in list.');
                    $("#add_more-packing-list").prop('disabled', true);
                    return false;
                }
           }

           var inner_tare = $("#inner_tare-"+index).val();
           var outer_tare = $("#outer_tare-"+index).val(); 
           var net_tare_weight = $("#net_weight-"+index).val();
           var inner_gross_weight = parseFloat(inner_tare) + parseFloat(net_tare_weight);
           var outer_gross_weight = parseFloat(outer_tare) + parseFloat(net_tare_weight);
           $("#inner_gross_weight-"+index).val(inner_gross_weight.toFixed(2));
           $("#outer_gross_weight-"+index).val(outer_gross_weight.toFixed(2));
           return true;
    }

  
    function tareNetCalculation(index) {
         
           var inner_tare = $("#inner_tare-"+index).val();
           var outer_tare = $("#outer_tare-"+index).val(); 
           var net_tare_weight = parseFloat(outer_tare) - parseFloat(inner_tare);
           var inner_gross_weight = parseFloat(inner_tare) + parseFloat(net_tare_weight);
           var outer_gross_weight = parseFloat(outer_tare) + parseFloat(net_tare_weight);

           if(net_tare_weight < 0) {

                $("#inner_tare-"+index).val('');
                $("#outer_tare-"+index).val('');
                $("#net_weight-"+index).val('');
                $("#inner_gross_weight-"+index).val('');
                $("#outer_gross_weight-"+index).val('');

              toastr.error('Inner tare weight should be less than outer tare weight.')
              return false;

           } else if(net_tare_weight > 0) {

              //$("#net_weight-"+index).val(net_tare_weight.toFixed(2));
              $("#inner_gross_weight-"+index).val(inner_gross_weight.toFixed(2));
              $("#outer_gross_weight-"+index).val(outer_gross_weight.toFixed(2));
              return true;

           } else {

              //toastr.error('Bad request.');
              return false;
          }
    } 


    $(document).ready(function() {
      $('#dataTable1').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'excelHtml5',
          ]
       });
    });

    $(document).ready(function() {
      $('#dataTable-license').DataTable( {
          
          'scrollX': true,
          dom: 'Bfrtip',
          buttons: [
              {
                extend: 'csv',        
                filename: function(){
                  return 'Advance License Consumption Report';
                },
              },
               {
                  extend: 'pdfHtml5',
                  orientation: 'landscape',
                  pageSize: 'LEGAL',
                  title: 'Advance License Consumption Report'
              },
              
          ]
       });
    });
    
    $(function () {
        $("#quantity_1").attr("disabled", "disabled");
        $("#required").click(function () {
            if ($(this).is(":checked")) {
                $("#quantity_1").removeAttr("disabled");
                $("#quantity_1").prop("required", true);
                $("#quantity_1").focus();
            } else {
                $("#quantity_1").attr("disabled", "disabled");
                $("#quantity_1").prop("required", false);
                $("#quantity_1").val('');
            }
        });

         if ($("#required").is(":checked")) {
              $("#quantity_1").removeAttr("disabled");
              $("#quantity_1").prop("required", true);
              $("#quantity_1").focus();
          } else {
              $("#quantity_1").attr("disabled", "disabled");
              $("#quantity_1").prop("required", false);
              $("#quantity_1").val('');
          }
    });

    $(function(){ 
       $('[id^="edit-ecgc-"]').click(function(e){
          e.preventDefault();  
          var id = $(this).data('id'); 
          var ecgc = $("#ecgc-"+id).val();
          var data = {ecgc: ecgc };
          $.ajax({
            url: "<?= base_url().'inhouseaccount/update_ecgc/'?>"+id,
            data: data, 
            type: "post",
            success: function(data){
               console.log(data);
               var result = JSON.parse(data);
               if(result.success) {
                  $("#myModal-ecgc-"+id).modal('hide');
                  toastr.success(result.success);
                  window.location.reload();
                  return;
               } if(result.error) {
                  toastr.error(result.error);
                  return false;
               }
               
            },
          });
       });
    }); // end of doc ready

    $(function(){ 
       $('[id^="payment_recieved-save-"]').click(function(e){
          e.preventDefault();  
          var id = $(this).data('id'); 
          var payment_recieved = $("#payment_recieved-"+id).val();
          var data = {payment_recieved: payment_recieved };
          $.ajax({
            url: "<?= base_url().'inhouseaccount/update_payment_recieved/'?>"+id,
            data: data, 
            type: "post",
            success: function(data){
               console.log(data);
               var result = JSON.parse(data);
               if(result.success) {
                  $("#myModal-payemnt-"+id).modal('hide');
                  toastr.success(result.success);
                  setTimeout(function(){ window.location.reload(); }, 2000);
                  return;
               } if(result.error) {
                  $("#payment_recieved-"+id).val('');
                  toastr.error(result.error);
                  return false;
               }
               
            },
          });
       });
    });
    
    $('#download-print').click(function(){
          window.print();
    });

    $('[id^="myModal-production-"]').click(function() {
       var id = $(this).data('id');
       var da_type = $(this).data('da');
       var dano = $(this).data('dano');
       var type = $(this).data('type');
       var dept = $(this).data('dept');

       $("#production-save").attr('data-id', id);
       $("#first b").text(dano);
       $("#second b").text(type);
       $("#third b").text(dept);

       $("#myModal-1").modal('show');
        var requestUrl = '<?= base_url().'administrator/get_department/' ?>'+da_type;
        commonAjax1(requestUrl);
    });

    $(function(){ 
       $("#production-save").click(function(e){
          e.preventDefault();  
          var id = $(this).data('id'); 
          var block = $('select[name="department"]').val();
          var data = {block: block };
          $.ajax({
            url: "<?= base_url().'ppic/assign_da/'?>"+id,
            data: data, 
            type: "post",
            success: function(data){
               console.log(data);
               var result = JSON.parse(data);
               if(result.success) {
                  $("#myModal-1").modal('hide');
                  toastr.success(result.success);
                   setTimeout(function(){ window.location.reload(); }, 2000);
                  return;
               } if(result.error) {
                  toastr.error(result.error);
                  return false;
               }
               
            },
          });
       });
    });

    $(document).ready(function() {
       $('[id^="invoice-form-"]').click(function(){
           var id = $(this).data('id');
           var invoice_number = $("#excise_invoice_no-"+id).val();
           var areone = $("#areone-"+id).val();
           
           var data = {invoice_number: invoice_number, areone: areone, id: id };
           $.ajax({
            url: "<?= base_url().'excise/invoice_entry/'?>"+id,
            data: data, 
            type: "POST",
            success: function(data){
               var result = JSON.parse(data);
               if(result.success) {

                  toastr.success(result.success);
                   setTimeout(function(){ window.location.reload(); }, 2000);
                  return;

               } if(result.error) {
                  toastr.error(result.error);
                  return false;
               }
               
            },
          });
          
       });
    });

    $(document).ready(function() {
       $('[id^="despatch-form-"]').click(function(){
           var id = $(this).data('id');
           var tentative_date = $("#tentative_date-"+id).val();
           var actual_date = $("#actual_date-"+id).val();
           
           var data = {tentative_date: tentative_date, actual_date: actual_date, id: id };
           $.ajax({
            url: "<?= base_url().'logistics/da_plant_despatch_date_form/'?>"+id,
            data: data, 
            type: "POST",
            success: function(data){
               var result = JSON.parse(data);
               if(result.success) {

                  toastr.success(result.success);
                   setTimeout(function(){ window.location.reload(); }, 2000);
                  return;

               } if(result.error) {
                  toastr.error(result.error);
                  return false;
               }
               
            },
          });
          
       });
    });


    $(document).ready(function() {
       $('[id^="tare-weight-form-"]').click(function(){
           var id = $(this).data('id');
           var inner = $("#new-inner-weight-"+id).val();
           var outer = $("#new-outer-weight-"+id).val();
           var netweight = $("#net-weight-"+id).val();
           
           var data = {inner: inner, outer: outer, id: id ,netweight:netweight};
           $.ajax({
            url: "<?= base_url().'production/tare_weight_change_update/'?>"+id,
            data: data, 
            type: "POST",
            success: function(data){
               var result = JSON.parse(data);
               if(result.success) {

                  toastr.success(result.success);
                   setTimeout(function(){ window.location.reload(); }, 2000);
                  return;

               } if(result.error) {
                  toastr.error(result.error);
                  return false;
               }
               
            },
          });
          
       });
    });
    
</script>

<script>
    $(document).ready(function() {
        $('#submit_data').click(function() {
          var url = $("#url").val();
          //alert(url);
         //$('#submit_data').css('display','none');
            //Get raw HTML of tbody in the data table
            var data_rows = $('#invoice').html();
           //build form HTML (hide keeps the form from being visible)
            $form = $('<form/>').attr({method: 'POST', action: url}).hide();
            //build textarea HTML
            $textarea = $('<textarea/>').attr({name: 'data_rows'}).val(data_rows);
            //add textarea to form
            $form.append($textarea);
            //add form to the document body
            $('#invoice1').append($form);
            //submit the form
            $form.submit();
        });
    });


    $(function() {
          
         $('[id^="check-id-"]').click(function(e){
            var id = $(this).attr('data-id');
            if ($(this).is(":checked")) {
                $("#row-"+id+" .my-class").removeAttr("disabled");
                $("#row-"+id+" .my-class").prop("required", true);
            } else {
                $("#row-"+id+" .my-class").attr("disabled", "disabled");
                $("#row-"+id+" .my-class").prop("required", false);
            }
         });
    });

 </script>
</body>

</html>
