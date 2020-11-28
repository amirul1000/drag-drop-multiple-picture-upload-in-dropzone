<a href="<?php echo site_url('admin/products_images/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Products_images'); ?></h5>
<!--Data display of products_images with id-->
<?php
$c = $products_images;
?>
<table class="table table-striped table-bordered">
	<tr>
		<td>Users</td>
		<td><?php
$this->CI = & get_instance();
$this->CI->load->database();
$this->CI->load->model('Users_model');
$dataArr = $this->CI->Users_model->get_users($c['users_id']);
echo $dataArr['email'];
?>
									</td>
	</tr>

	<tr>
		<td>Products</td>
		<td><?php
$this->CI = & get_instance();
$this->CI->load->database();
$this->CI->load->model('Products_model');
$dataArr = $this->CI->Products_model->get_products($c['products_id']);
echo $dataArr['product_name'];
?>
									</td>
	</tr>

	<tr>
		<td>File Name</td>
		<td><?php
if (is_file(APPPATH . '../public/' . $c['file_name']) && file_exists(APPPATH . '../public/' . $c['file_name'])) {
    ?>
										  <img src="<?php echo base_url().'public/'.$c['file_name']?>"
			class="picture_50x50">
										  <?php
} else {
    ?>
										<img src="<?php echo base_url()?>public/uploads/no_image.jpg"
			class="picture_50x50">
										<?php
}
?>	
										</td>
	</tr>

	<tr>
		<td>Order No</td>
		<td><?php echo $c['order_no']; ?></td>
	</tr>

	<tr>
		<td>Uploaded</td>
		<td><?php echo $c['uploaded']; ?></td>
	</tr>


</table>
<!--End of Data display of products_images with id//-->
