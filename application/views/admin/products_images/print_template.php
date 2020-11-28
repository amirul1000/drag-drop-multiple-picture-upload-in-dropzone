<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css">
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Products_images'); ?></h3>
Date: <?php echo date("Y-m-d");?>
<hr>
<!--*************************************************
*********mpdf header footer page no******************
****************************************************-->
<htmlpageheader name="firstpage" class="hide"> </htmlpageheader>

<htmlpageheader name="otherpages" class="hide"> <span class="float_left"></span>
<span class="padding_5"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span>
<span class="float_right"></span> </htmlpageheader>
<sethtmlpageheader name="firstpage" value="on" show-this-page="1" />
<sethtmlpageheader name="otherpages" value="on" />

<htmlpagefooter name="myfooter" class="hide">
<div align="center">
	<br>
	<span class="padding_10">Page {PAGENO} of {nbpg}</span>
</div>
</htmlpagefooter>

<sethtmlpagefooter name="myfooter" value="on" />
<!--*************************************************
*********#////mpdf header footer page no******************
****************************************************-->
<!--Data display of products_images-->
<table cellspacing="3" cellpadding="3" class="table" align="center">
	<tr>
		<th>Users</th>
		<th>Products</th>
		<th>File Name</th>
		<th>Order No</th>
		<th>Uploaded</th>

	</tr>
	<?php foreach($products_images as $c){ ?>
    <tr>
		<td><?php
    $this->CI = & get_instance();
    $this->CI->load->database();
    $this->CI->load->model('Users_model');
    $dataArr = $this->CI->Users_model->get_users($c['users_id']);
    echo $dataArr['email'];
    ?>
									</td>
		<td><?php
    $this->CI = & get_instance();
    $this->CI->load->database();
    $this->CI->load->model('Products_model');
    $dataArr = $this->CI->Products_model->get_products($c['products_id']);
    echo $dataArr['product_name'];
    ?>
									</td>
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
		<td><?php echo $c['order_no']; ?></td>
		<td><?php echo $c['uploaded']; ?></td>

	</tr>
	<?php } ?>
</table>
<!--End of Data display of products_images//-->
