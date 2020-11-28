<!--Fancybox-->
<script type="text/javascript"
	src="<?php echo base_url(); ?>public/fancybox/lib/jquery-1.8.2.min.js"></script>
<!--End of Pagination//-->
<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript"
	src="<?php echo base_url(); ?>public/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript"
	src="<?php echo base_url(); ?>public/fancybox/source/jquery.fancybox.js?v=2.1.3"></script>
<link rel="stylesheet" type="text/css"
	href="<?php echo base_url(); ?>public/fancybox/source/jquery.fancybox.css?v=2.1.2"
	media="screen" />

<!-- Add Button helper (this is optional) -->
<link rel="stylesheet" type="text/css"
	href="<?php echo base_url(); ?>public/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
<script type="text/javascript"
	src="<?php echo base_url(); ?>public/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

<!-- Add Thumbnail helper (this is optional) -->
<link rel="stylesheet" type="text/css"
	href="<?php echo base_url(); ?>public/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
<script type="text/javascript"
	src="<?php echo base_url(); ?>public/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

<!-- Add Media helper (this is optional) -->
<script type="text/javascript"
	src="<?php echo base_url(); ?>public/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.5"></script>
<!--Fancybox\\-->

<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Products'); ?></h5>
<?php
echo $this->session->flashdata('msg');
?>
<!--Action-->
<div>
	<div class="float_left padding_10">
		<a href="<?php echo site_url('admin/products/save'); ?>"
			class="btn btn-success">Add</a>
	</div>
	<div class="float_left padding_10">
		<i class="fa fa-download"></i> Export <select name="xeport_type"
			class="select"
			onChange="window.location='<?php echo site_url('admin/products/export'); ?>/'+this.value">
			<option>Select..</option>
			<option>Pdf</option>
			<option>CSV</option>
		</select>
	</div>
	<div class="float_right padding_10">
		<ul class="left-side-navbar d-flex align-items-center">
			<li class="hide-phone app-search mr-15">
                <?php echo form_open_multipart('admin/products/search/',array("class"=>"form-horizontal")); ?>
                    <input name="key" type="text"
				value="<?php echo isset($key)?$key:'';?>" placeholder="Search..."
				class="form-control">
				<button type="submit" class="mr-0">
					<i class="fa fa-search"></i>
				</button>
                <?php echo form_close(); ?>
            </li>
		</ul>
	</div>
</div>
<!--End of Action//-->

<!--Data display of products-->
<table class="table table-striped table-bordered">
	<tr>
		<th>Seller Users</th>
		<th>Category</th>
		<th>Product Name</th>
		<!--<th>Product Title</th>
<th>Description</th>
<th>Price</th>
<th>Status</th>-->
		<th>Images</th>
		<th>Actions</th>
	</tr>
	<?php foreach($products as $c){ ?>
    <tr>
		<td><?php
    $this->CI = & get_instance();
    $this->CI->load->database();
    $this->CI->load->model('Users_model');
    $dataArr = $this->CI->Users_model->get_users($c['seller_users_id']);
    echo $dataArr['email'];
    ?>
									</td>
		<td><?php
    $this->CI = & get_instance();
    $this->CI->load->database();
    $this->CI->load->model('Category_model');
    $dataArr = $this->CI->Category_model->get_category($c['category_id']);
    echo $dataArr['cat_name'];
    ?>
									</td>
		<td><?php echo $c['product_name']; ?></td>
		<!--<td><?php echo $c['product_title']; ?></td>
<td><?php echo $c['description']; ?></td>
<td><?php echo $c['price']; ?></td>
-->
		<td>
		<?php
    // more images
    // $this->CI = & get_instance();
    $this->CI->load->database();
    $this->CI->db->order_by('order_no', 'asc');
    $this->CI->db->where('products_id', $c['id']);
    $res = $this->CI->db->get_where('products_images')->result_array();
    for ($i = 0; $i < count($res); $i ++) {

        if (is_file(APPPATH . '../public/' . $res[$i]['file_name']) && file_exists(APPPATH . '../public/' . $res[$i]['file_name'])) {

            ?>									
          <a class="fancybox"
			href="<?php echo base_url().'public/'.$res[$i]['file_name']?>"
			data-fancybox-group="gallery" title=""> <img
				src="<?php echo base_url().'public/'.$res[$i]['file_name']?>" alt=""
				class="picture_50x50" />
		</a>                            
                                            
       <?php
        }
    }
    ?>    
       </span>
			</div> <script type="text/javascript">
	        var $jQuery = jQuery.noConflict();
			// Use jQuery via $j(...)
			$jQuery(document).ready(function(){
			/*
			 *  Simple image gallery. Uses default settings
			 */

			$jQuery('.fancybox').fancybox();

			/*
			 *  Different effects
			 */

			// Change title type, overlay closing speed
			$jQuery(".fancybox-effects-a").fancybox({
				helpers: {
					title : {
						type : 'outside'
					},
					overlay : {
						speedOut : 0
					}
				}
			});

			// Disable opening and closing animations, change title type
			$jQuery(".fancybox-effects-b").fancybox({
				openEffect  : 'none',
				closeEffect	: 'none',

				helpers : {
					title : {
						type : 'over'
					}
				}
			});

			// Set custom style, close if clicked, change title type and overlay color
			$jQuery(".fancybox-effects-c").fancybox({
				wrapCSS    : 'fancybox-custom',
				closeClick : true,

				openEffect : 'none',

				helpers : {
					title : {
						type : 'inside'
					},
					overlay : {
						css : {
							'background' : 'rgba(238,238,238,0.85)'
						}
					}
				}
			});

			// Remove padding, set opening and closing animations, close if clicked and disable overlay
			$jQuery(".fancybox-effects-d").fancybox({
				padding: 0,

				openEffect : 'elastic',
				openSpeed  : 150,

				closeEffect : 'elastic',
				closeSpeed  : 150,

				closeClick : true,

				helpers : {
					overlay : null
				}
			});

			/*
			 *  Button helper. Disable animations, hide close button, change title type and content
			 */

			$jQuery('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});


			/*
			 *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
			 */

			$jQuery('.fancybox-thumbs').fancybox({
				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,
				arrows    : false,
				nextClick : true,

				helpers : {
					thumbs : {
						width  : 50,
						height : 50
					}
				}
			});

			/*
			 *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
			*/
			$jQuery('.fancybox-media')
				.attr('rel', 'media-gallery')
				.fancybox({
					openEffect : 'none',
					closeEffect : 'none',
					prevEffect : 'none',
					nextEffect : 'none',

					arrows : false,
					helpers : {
						media : {},
						buttons : {}
					}
				});

		});
	</script>
			<style type="text/css">
.fancybox-custom .fancybox-skin {
	box-shadow: 0 0 50px #222;
}
</style>

		</td>
		<!--<td><?php echo $c['status']; ?></td>-->

		<td><a
			href="<?php echo site_url('admin/products/details/'.$c['id']); ?>"
			class="action-icon"> <i class="zmdi zmdi-eye"></i></a> <a
			href="<?php echo site_url('admin/products/save/'.$c['id']); ?>"
			class="action-icon"> <i class="zmdi zmdi-edit"></i></a> <a
			href="<?php echo site_url('admin/products/remove/'.$c['id']); ?>"
			onClick="return confirm('Are you sure to delete this item?');"
			class="action-icon"> <i class="zmdi zmdi-delete"></i></a></td>
	</tr>
	<?php } ?>
</table>
<!--End of Data display of products//-->

<!--No data-->
<?php
if (count($products) == 0) {
    ?>
<div align="center">
	<h3>Data is not exists</h3>
</div>
<?php
}
?>
<!--End of No data//-->

<!--Pagination-->
<?php
echo $link;
?>
<!--End of Pagination//-->
