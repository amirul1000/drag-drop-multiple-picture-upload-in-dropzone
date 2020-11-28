<a href="<?php echo site_url('admin/products/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Products'); ?></h5>
<!--Data display of products with id-->
<?php
$c = $products;
?>
<table class="table table-striped table-bordered">
	<tr>
		<td>Seller Users</td>
		<td><?php
$this->CI = & get_instance();
$this->CI->load->database();
$this->CI->load->model('Users_model');
$dataArr = $this->CI->Users_model->get_users($c['seller_users_id']);
echo $dataArr['email'];
?>
									</td>
	</tr>

	<tr>
		<td>Category</td>
		<td><?php
$this->CI = & get_instance();
$this->CI->load->database();
$this->CI->load->model('Category_model');
$dataArr = $this->CI->Category_model->get_category($c['category_id']);
echo $dataArr['cat_name'];
?>
									</td>
	</tr>

	<tr>
		<td>Product Name</td>
		<td><?php echo $c['product_name']; ?></td>
	</tr>

	<tr>
		<td>Product Title</td>
		<td><?php echo $c['product_title']; ?></td>
	</tr>

	<tr>
		<td>Description</td>
		<td><?php echo $c['description']; ?></td>
	</tr>

	<tr>
		<td>Price</td>
		<td><?php echo $c['price']; ?></td>
	</tr>

	<tr>
		<td>Created At</td>
		<td><?php echo $c['created_at']; ?></td>
	</tr>

	<tr>
		<td>Updated At</td>
		<td><?php echo $c['updated_at']; ?></td>
	</tr>

	<tr>
		<td>Status</td>
		<td><?php echo $c['status']; ?></td>
	</tr>


</table>
<!--End of Data display of products with id//-->
