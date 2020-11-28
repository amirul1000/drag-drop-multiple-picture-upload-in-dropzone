<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<script type="text/javascript"
	src="<?php echo base_url(); ?>public/selectize/selectize.js"></script>
<link rel='stylesheet'
	href='<?php echo base_url(); ?>public/selectize/selectize.css'>
<link rel='stylesheet'
	href='<?php echo base_url(); ?>public/selectize/selectize.default.css'>
<style type="text/css">
.selectize-input {
	width: 100% !important;
	height: 62px !important;
}
</style>
<style>
/*progressbar*/
#progressbar {
	margin-bottom: 30px;
	overflow: hidden;
	/*CSS counters to number the steps*/
	counter-reset: step;
}

#progressbar li {
	list-style-type: none;
	color: #333;
	text-transform: uppercase;
	text-align: center;
	font-size: 12px;
	width: 13%;
	float: left;
	position: relative;
}

#progressbar li:before {
	content: counter(step);
	counter-increment: step;
	width: 20px;
	line-height: 20px;
	display: block;
	font-size: 10px;
	color: #333;
	background: white;
	border-radius: 3px;
	margin: 0 auto 5px auto;
}
/*progressbar connectors*/
#progressbar li:after {
	content: '';
	width: 100%;
	height: 2px;
	background: white;
	position: absolute;
	left: -50%;
	top: 9px;
	z-index: -1; /*put it behind the numbers*/
}

#progressbar li:first-child:after {
	/*connector not needed before the first step*/
	content: none;
}
/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar li.active:before, #progressbar li.active:after {
	background: #27AE60;
	color: white;
}
</style>
<a href="<?php echo site_url('admin/products/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Products'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/products/save/'.$products['id'],array("id"=>"frm_products","class"=>"form-horizontal")); ?>
<div class="card">
	<div class="card-body">
		<div class="form-group">
			<label for="Seller Users" class="col-md-4 control-label">Seller Users</label>
			<div class="col-md-8"> 
          <?php
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Users_model');
        $dataArr = $this->CI->Users_model->get_all_users();
        ?> 
          <select name="seller_users_id" id="seller_users_id"
					class="form-control" />
				<option value="">--Select--</option> 
            <?php
            for ($i = 0; $i < count($dataArr); $i ++) {
                ?> 
            <option value="<?=$dataArr[$i]['id']?>"
					<?php if($products['seller_users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['email']?></option> 
            <?php
            }
            ?> 
          </select>
			</div>
		</div>
		<div class="form-group">
			<label for="Category" class="col-md-4 control-label">Category</label>
			<div class="col-md-8"> 
          <?php
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Category_model');
        $dataArr = $this->CI->Category_model->get_all_category();
        ?> 
          <select name="category_id" id="category_id"
					class="form-control" />
				<option value="">--Select--</option> 
            <?php
            for ($i = 0; $i < count($dataArr); $i ++) {
                ?> 
            <option value="<?=$dataArr[$i]['id']?>"
					<?php if($products['category_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['cat_name']?></option> 
            <?php
            }
            ?> 
          </select>
			</div>
		</div>
		<div class="form-group">
			<label for="Product Name" class="col-md-4 control-label">Product Name</label>
			<div class="col-md-8">
				<input type="text" name="product_name"
					value="<?php echo ($this->input->post('product_name') ? $this->input->post('product_name') : $products['product_name']); ?>"
					class="form-control" id="product_name" />
			</div>
		</div>
		<div class="form-group">
			<label for="Product Title" class="col-md-4 control-label">Product
				Title</label>
			<div class="col-md-8">
				<input type="text" name="product_title"
					value="<?php echo ($this->input->post('product_title') ? $this->input->post('product_title') : $products['product_title']); ?>"
					class="form-control" id="product_title" />
			</div>
		</div>
		<div class="form-group">
			<label for="Description" class="col-md-4 control-label">Description</label>
			<div class="col-md-8">
				<textarea name="description" id="description" class="form-control"
					rows="4" /><?php echo ($this->input->post('description') ? $this->input->post('description') : $products['description']); ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="Price" class="col-md-4 control-label">Price</label>
			<div class="col-md-8">
				<input type="text" name="price"
					value="<?php echo ($this->input->post('price') ? $this->input->post('price') : $products['price']); ?>"
					class="form-control" id="price" />
			</div>
		</div>
		<div class="form-group">
			<label for="Status" class="col-md-4 control-label">Status</label>
			<div class="col-md-8"> 
           <?php
        $enumArr = $this->customlib->getEnumFieldValues('products', 'status');
        ?> 
           <select name="status" id="status" class="form-control" />
				<option value="">--Select--</option> 
             <?php
            for ($i = 0; $i < count($enumArr); $i ++) {
                ?> 
             <option value="<?=$enumArr[$i]?>"
					<?php if($products['status']==$enumArr[$i]){ echo "selected";} ?>><?=ucwords($enumArr[$i])?></option> 
             <?php
            }
            ?> 
           </select>
			</div>
		</div>

	</div>
</div>
<?php echo form_close(); ?>


<div class="form-group">
	<label for="More Pictures" class="col-md-4 control-label">More Pictures</label>
	<div class="col-md-8">
		<form action="<?php echo site_url('admin/products/more_pictures')?>"
			class="dropzone" id="my-dropzone"></form>
		<link href="<?php echo base_url(); ?>public/dropzone/css/dropzone.css"
			rel="stylesheet" />
		<script src="<?php echo base_url(); ?>public/dropzone/dropzone.js"></script>
		<script type="text/javascript">
                 var FormDropzone = function () {
                    return {
                        //main function to initiate the module
                        init: function () {  
                
                            Dropzone.options.myDropzone = {
                                init: function() {
                                    this.on("addedfile", function(file) {
                                        // Create the remove button
                                        var removeButton = Dropzone.createElement("<button class='btn btn-sm btn-block'>Remove file</button>");
                                        
                                        // Capture the Dropzone instance as closure.
                                        var _this = this;
                
                                        // Listen to the click event
                                        removeButton.addEventListener("click", function(e) {
                                          // Make sure the button click doesn't submit the form:
                                          e.preventDefault();
                                          e.stopPropagation();
                
                                          // Remove the file preview.
                                          _this.removeFile(file);
                                          // If you want to the delete the file on the server as well,
                                          // you can do the AJAX request here.
                                          remove_file(file.name);
                                        });
                
                                        // Add the button to the file preview element.
                                        file.previewElement.appendChild(removeButton);
                                    });
                                }            
                            }
                        }
                    };
                }();
                
                function remove_file(file)
                {
                   $.ajax({
                        url: "<?php echo site_url('admin/products/remove_file')?>",
                        type: "POST",
                            data: { 
                                'cmd':'delete_dropzone_file',
                                'name': file
                            }
                        });
                }
                </script>
		<script>
                    $(document).ready(function() {  
                             FormDropzone.init();
                   });
                </script>


	</div>
</div>

</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
		<button type="submit" class="btn btn-success" id="btn_submit"><?php if(empty($products['id'])){?>Save<?php }else{?>Update<?php } ?></button>
		<script language="javascript">
		 $(document).ready(function(){
			  $("#btn_submit").click(function() {
				  $("#frm_products").submit();
				});
		  });
		  
		  function checkRequired()
		  {
			  
		  }
		</script>

	</div>
</div>
<!--End of Form to save data//-->
<!--JQuery-->
<script>
	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '<?php echo base_url(); ?>public/datepicker/images/calendar.gif',
	});
</script>
