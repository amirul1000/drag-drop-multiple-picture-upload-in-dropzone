<a href="<?php echo site_url('admin/products_images/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Products_images'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/products_images/save/'.$products_images['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
	<div class="card-body">
		<div class="form-group">
			<label for="Users" class="col-md-4 control-label">Users</label>
			<div class="col-md-8"> 
          <?php
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Users_model');
        $dataArr = $this->CI->Users_model->get_all_users();
        ?> 
          <select name="users_id" id="users_id" class="form-control" />
				<option value="">--Select--</option> 
            <?php
            for ($i = 0; $i < count($dataArr); $i ++) {
                ?> 
            <option value="<?=$dataArr[$i]['id']?>"
					<?php if($products_images['users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['email']?></option> 
            <?php
            }
            ?> 
          </select>
			</div>
		</div>
		<div class="form-group">
			<label for="Products" class="col-md-4 control-label">Products</label>
			<div class="col-md-8"> 
          <?php
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Products_model');
        $dataArr = $this->CI->Products_model->get_all_products();
        ?> 
          <select name="products_id" id="products_id"
					class="form-control" />
				<option value="">--Select--</option> 
            <?php
            for ($i = 0; $i < count($dataArr); $i ++) {
                ?> 
            <option value="<?=$dataArr[$i]['id']?>"
					<?php if($products_images['products_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['product_name']?></option> 
            <?php
            }
            ?> 
          </select>
			</div>
		</div>
		<div class="form-group">
			<label for="File Name" class="col-md-4 control-label">File Name</label>
			<div class="col-md-8">
				<input type="file" name="file_name" id="file_name"
					value="<?php echo ($this->input->post('file_name') ? $this->input->post('file_name') : $products_images['file_name']); ?>"
					class="form-control-file" />
			</div>
		</div>
		<div class="form-group">
			<label for="Order No" class="col-md-4 control-label">Order No</label>
			<div class="col-md-8">
				<input type="text" name="order_no"
					value="<?php echo ($this->input->post('order_no') ? $this->input->post('order_no') : $products_images['order_no']); ?>"
					class="form-control" id="order_no" />
			</div>
		</div>
		<div class="form-group">
			<label for="Uploaded" class="col-md-4 control-label">Uploaded</label>
			<div class="col-md-8">
				<input type="text" name="uploaded" id="uploaded"
					value="<?php echo ($this->input->post('uploaded') ? $this->input->post('uploaded') : $products_images['uploaded']); ?>"
					class="form-control-static datepicker" />
			</div>
		</div>

	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
		<button type="submit" class="btn btn-success"><?php if(empty($products_images['id'])){?>Save<?php }else{?>Update<?php } ?></button>
	</div>
</div>
<?php echo form_close(); ?>
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
