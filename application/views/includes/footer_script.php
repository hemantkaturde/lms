<?php
if($pageTitle=='Course Listing'){?>
    <script type="text/javascript">
		$(document).ready(function() {

         
            var dt = $('#view_courselist').DataTable({
	            "columnDefs": [ 
	                //  { className: "details-control", "targets": [ 0 ] },
	                 { "width": "10%", "targets": 0 },
	                 { "width": "10%", "targets": 1 },
	                 { "width": "5%", "targets": 2 },
	                 { "width": "8%", "targets": 3 },
	            ],

	            responsive: true,
	            "oLanguage": {
	                "sEmptyTable": "<i>No Trips Found.</i>",
	            }, 
	            "bSort" : false,
	            "bFilter":true,
	            "bLengthChange": false,
	            "iDisplayLength": 10,   
	            "bProcessing": true,
	            "serverSide": true,
	            "ajax":{
                    url :"<?php echo base_url();?>/fetchcourse",
                    type: "post",
	            },

	            // "columns": [
	                // { "data": "course_name" },
	                // { "data": "ttype" },
	                // { "data": "user_full_name" },
	                // { "data": "user_mobile_no" }
	                // { "data": "driver_full_name" },
	                // { "data": "driver_mobile_no" },
	                // { "data": "source_address" },                
	                // { "data": "dest_address" }, 
				    // { "data": "journey_status" },
					// { "data": "trip_flag" },  
					// { "data": "gross_bill" },              
	                // { "data": "dial4242_commision_charge" },
					// { "data": "amount_paid" },
	                // { "data": "action" },               
	            // ],

	        });
	        var detailRows = [];
	        $('#view_courselist tbody').on( 'click', 'tr td.details-control', function () {
	            var tr = $(this).closest('tr');
	            var row = dt.row( tr );
	            var idx = $.inArray( tr.attr('id'), detailRows );

	            if ( row.child.isShown() ) {
	                tr.removeClass( 'parent' );
	                row.child.hide();

	                // Remove from the 'open' array
	                detailRows.splice( idx, 1 );
	            }
	            else {
	                tr.addClass( 'parent' );
	                row.child( format( row.data() ) ).show();

	                // Add to the 'open' array
	                if ( idx === -1 ) {
	                    detailRows.push( tr.attr('id') );
	                }
	            }
	        });
	        // On each draw, loop over the `detailRows` array and show any child rows
	        dt.on( 'draw', function () {
	            $.each( detailRows, function ( i, id ) {
	                $('#'+id+' td.details-control').trigger( 'click' );
	            } );
	        } );










            // $('#view_courselist').DataTable({
	        //     "columnDefs": [ 
	        //         //  { className: "details-control", "targets": [ 0 ] },
	        //          { "width": "8%", "targets": 0 },
	        //         //  { "width": "9%", "targets": 2 },
	        //         //  { "width": "7%", "targets": 3 },
	        //         //  { "width": "9%", "targets": 4 },
	        //     ],

	        //     responsive: true,
	        //     "oLanguage": {
	        //         "sEmptyTable": "<i>No Trips Found.</i>",
	        //     }, 
	        //     "bSort" : false,
	        //     "bFilter":true,
	        //     "bLengthChange": false,
	        //     "iDisplayLength": 50,   
	        //     "bProcessing": true,
	        //     "serverSide": true,
	        //     "ajax":{
            //         url :"<?php echo base_url();?>/fetchcourse",
	        //         type: "post",
	        //     },
	        //     "columns": [
	        //         // { "data": "course_name" },
	        //         // { "data": "course_name" },
	        //         // { "data": "course_name" },
	        //         // { "data": "course_name" },
	                              
	        //     ],




		    // $('#view_courselist').DataTable({
	        //     "columnDefs": [ {
	        //           "targets": 'no-sort',
	        //           "orderable": false,
	        //     },
				
	        //     { "width": "20%","targets": 0 },
	        //     { "width": "5%", "targets": 1 },
            //     { "width": "5%", "targets": 2 },
            //     { "width": "5%", "targets": 3 },
			// 	],
	        //     responsive: true,
	        //     "oLanguage": {
	        //         "sEmptyTable": "<i>No Equipments Found.</i>",
	        //     }, 
	        //     "bSort" : false,
	        //     "bFilter":true,
	        //     "bLengthChange": false,
	        //     "iDisplayLength": 15,   
	        //     "bProcessing": true,
	        //     "serverSide": true,
	        //     "ajax":{
	        //         url :"<?php echo base_url();?>/fetchcourse", 
	        //         type: "post",   
                    
	        //         error: function(){  
	        //             $("#viewequipments_processing").css("display","none");
	        //         }
	        //     },
                
                // "columns": [
	            //     { "data": "course_desc" },
	            //     { "data": "course_desc" },  
                //     { "data": "course_desc" },  
                //     { "data": "course_desc" },           
	            // ],
		    });
		// });
    </script>   
<?php } ?>