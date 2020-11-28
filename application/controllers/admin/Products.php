<?php

/**
 * Author: Amirul Momenin
 * Desc:Products Controller
 *
 */
class Products extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->library('Customlib');
        $this->load->helper(array(
            'cookie',
            'url'
        ));
        $this->load->database();
        $this->load->model('Products_model');
        if (! $this->session->userdata('validated')) {
            redirect('admin/login/index');
        }
    }

    /**
     * Index Page for this controller.
     *
     * @param $start -
     *            Starting of products table's index to get query
     *            
     */
    function index($start = 0)
    {
        $limit = 10;
        $data['products'] = $this->Products_model->get_limit_products($limit, $start);
        // pagination
        $config['base_url'] = site_url('admin/products/index');
        $config['total_rows'] = $this->Products_model->get_count_products();
        $config['per_page'] = 10;
        // Bootstrap 4 Pagination fix
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
        $config['next_tag_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();

        $data['_view'] = 'admin/products/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Save products
     *
     * @param $id -
     *            primary key to update
     *            
     */
    function save($id = - 1)
    {
        $created_at = "";
        $updated_at = "";

        if ($id <= 0) {
            $created_at = date("Y-m-d H:i:s");
        } else if ($id > 0) {
            $updated_at = date("Y-m-d H:i:s");
        }

        $params = array(
            'seller_users_id' => html_escape($this->input->post('seller_users_id')),
            'category_id' => html_escape($this->input->post('category_id')),
            'product_name' => html_escape($this->input->post('product_name')),
            'product_title' => html_escape($this->input->post('product_title')),
            'description' => html_escape($this->input->post('description')),
            'price' => html_escape($this->input->post('price')),
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'status' => html_escape($this->input->post('status'))
        );
        $seller_users_id = $this->input->post('seller_users_id');
        if ($id > 0) {
            unset($params['created_at']);
        }
        if ($id <= 0) {
            unset($params['updated_at']);
        }
        $data['id'] = $id;
        // update
        if (isset($id) && $id > 0) {
            $data['products'] = $this->Products_model->get_products($id);
            if (isset($_POST) && count($_POST) > 0) {
                $this->Products_model->update_products($id, $params);
                $this->Products_model->update_products($id, $params);
                $this->session->set_flashdata('msg', 'Products has been updated successfully');
                redirect('admin/products/index');
            } else {
                $data['_view'] = 'admin/products/form';
                $this->load->view('layouts/admin/body', $data);
            }
        } // save
        else {
            if (isset($_POST) && count($_POST) > 0) {
                $products_id = $this->Products_model->add_products($params);
                $this->add_more_images($products_id, $seller_users_id);
                $this->session->set_flashdata('msg', 'Products has been saved successfully');
                redirect('admin/products/index');
            } else {
                $data['products'] = $this->Products_model->get_products(0);
                $data['_view'] = 'admin/products/form';
                $this->load->view('layouts/admin/body', $data);
            }
        }
    }

    function add_more_images($products_id, $seller_users_id)
    {
        foreach ($_SESSION as $key => $value) {
            if (substr($key, 0, strlen("file_tmp_name")) == "file_tmp_name") {
                $time = substr($key, strlen("file_tmp_name_"), strlen($key));

                $file_tmp_name = base64_decode($_SESSION["file_tmp_name_" . $time]);
                $file_file = $_SESSION["file_file_" . $time];

                if (! file_exists("./public/uploads/images/products/products_more_images")) {
                    mkdir("./public/uploads/images/products/products_more_images", 0755);
                }
                if (! file_exists("./public/uploads/images/products/products_more_images/" . $seller_users_id)) {
                    mkdir("./public/uploads/images/products/products_more_images/" . $seller_users_id, 0755);
                }

                $file = $products_id . "_" . str_replace(" ", "_", strtolower($file_file));

                $this->load->model('Products_images_model');
                $file_name = "";
                $params = array(
                    'users_id' => $seller_users_id,
                    'products_id' => $products_id,
                    'file_name' => "uploads/images/products/products_more_images/" . $seller_users_id . "/" . $file,
                    'order_no' => $this->get_order_no($products_id),
                    'uploaded' => date("Y-m-d H:i:s")
                );

                $fp = fopen("./public/uploads/images/products/products_more_images/" . $seller_users_id . "/" . $file, "w");
                fwrite($fp, $file_tmp_name);
                fclose($fp);

                unset($_SESSION["file_tmp_name_" . $time]);
                unset($_SESSION["file_file_" . $time]);

                $products_images_id = $this->Products_images_model->add_products_images($params);
            }
        }
    }

    function get_order_no($products_id)
    {
        $this->load->database();
        $this->db->where('products_id', $products_id);
        $arr = $this->db->get_where('products_images')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        $order_no = $arr[0]['order_no'];

        if (empty($order_no) || $order_no == 0) {
            $order_no = 1;
        } else {
            $order_no = $order_no + 1;
        }

        return $order_no;
    }
    
    function more_pictures()
    {
        if (! $this->session->userdata('validated')) {
            exit();
        }
        
        if ($this->check_file_extension($_FILES) == false) {
            exit(json_encode(array(
                'success' => false,
                'msg' => 'Error:  .' . $_SESSION['extension'] . ' is not a supported file'
            )));
        }
        
        if (! empty($_FILES)) {
            
            if (strlen($_FILES['file']['name']) > 0 && $_FILES['file']['size'] > 0) {
                $time = time() . rand(0, 100) . rand(0, 100);
                $_SESSION['file_tmp_name_' . $time] = base64_encode(file_get_contents($_FILES['file']['tmp_name']));
                $_SESSION['file_file_' . $time] = $_FILES['file']['name'];
                echo json_encode(array(
                    'success' => true
                ));
                exit();
            }
        }
    }
    
    function check_file_extension($_files)
    {
        foreach ($_files as $key => $name) {
            if (strlen($_files[$key]['name']) > 0 && $_files[$key]['size'] > 0) {
                unset($arr);
                $arr = explode(".", $_files[$key]['name']);
                $extension = strtolower($arr[count($arr) - 1]);
                if (! ($extension == "png" || $extension == "jpg" || $extension == "jpeg" || $extension == "gif")) {
                    $_SESSION['extension'] = $extension;
                    // echo '<font color="red"><h3>Error:'.$extension .' is not supported file</h3></font>';
                    return false;
                }
            }
            // echo $arr[count($arr)-1];
        }
        return true;
    }
    
    function delete_more($id)
    {
        $this->load->database();
        $this->db->where('products_id', $id);
        $res = $this->db->get_where('products_images')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        
        if (count($res) > 0) {
            for ($i = 0; $i < count($res); $i ++) {
                $id = $res[$i]['id'];
                $this->load->model('Products_images_model');
                $products_images = $this->Products_images_model->get_products_images($id);
                
                $file_products = "./public/" . $products_images['file_name'];
                if (file_exists($file_products)) {
                    chmod($file_products, 0777);
                    unlink($file_products);
                }
                
                // check if the products_images exists before trying to delete it
                if (isset($products_images['id'])) {
                    $this->Products_images_model->delete_products_images($id);
                }
            }
        }
    }
    

    /**
     * Details products
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function details($id)
    {
        $data['products'] = $this->Products_model->get_products($id);
        $data['id'] = $id;
        $data['_view'] = 'admin/products/details';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Deleting products
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function remove($id)
    {
        $products = $this->Products_model->get_products($id);

        // check if the products exists before trying to delete it
        if (isset($products['id'])) {
            $this->Products_model->delete_products($id);
            $this->session->set_flashdata('msg', 'Products has been deleted successfully');
            redirect('admin/products/index');
        } else
            show_error('The products you are trying to delete does not exist.');
    }

    /**
     * Search products
     *
     * @param $start -
     *            Starting of products table's index to get query
     */
    function search($start = 0)
    {
        if (! empty($this->input->post('key'))) {
            $key = $this->input->post('key');
            $_SESSION['key'] = $key;
        } else {
            $key = $_SESSION['key'];
        }

        $limit = 10;
        $this->db->like('id', $key, 'both');
        $this->db->or_like('seller_users_id', $key, 'both');
        $this->db->or_like('category_id', $key, 'both');
        $this->db->or_like('product_name', $key, 'both');
        $this->db->or_like('product_title', $key, 'both');
        $this->db->or_like('description', $key, 'both');
        $this->db->or_like('price', $key, 'both');
        $this->db->or_like('created_at', $key, 'both');
        $this->db->or_like('updated_at', $key, 'both');
        $this->db->or_like('status', $key, 'both');

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $data['products'] = $this->db->get('products')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }

        // pagination
        $config['base_url'] = site_url('admin/products/search');
        $this->db->reset_query();
        $this->db->like('id', $key, 'both');
        $this->db->or_like('seller_users_id', $key, 'both');
        $this->db->or_like('category_id', $key, 'both');
        $this->db->or_like('product_name', $key, 'both');
        $this->db->or_like('product_title', $key, 'both');
        $this->db->or_like('description', $key, 'both');
        $this->db->or_like('price', $key, 'both');
        $this->db->or_like('created_at', $key, 'both');
        $this->db->or_like('updated_at', $key, 'both');
        $this->db->or_like('status', $key, 'both');

        $config['total_rows'] = $this->db->from("products")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        $config['per_page'] = 10;
        // Bootstrap 4 Pagination fix
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
        $config['next_tag_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();

        $data['key'] = $key;
        $data['_view'] = 'admin/products/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Export products
     *
     * @param $export_type -
     *            CSV or PDF type
     */
    function export($export_type = 'CSV')
    {
        if ($export_type == 'CSV') {
            // file name
            $filename = 'products_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            // get data
            $this->db->order_by('id', 'desc');
            $productsData = $this->Products_model->get_all_products();
            // file creation
            $file = fopen('php://output', 'w');
            $header = array(
                "Id",
                "Seller Users Id",
                "Category Id",
                "Product Name",
                "Product Title",
                "Description",
                "Price",
                "Created At",
                "Updated At",
                "Status"
            );
            fputcsv($file, $header);
            foreach ($productsData as $key => $line) {
                fputcsv($file, $line);
            }
            fclose($file);
            exit();
        } else if ($export_type == 'Pdf') {
            $this->db->order_by('id', 'desc');
            $products = $this->db->get('products')->result_array();
            // get the HTML
            ob_start();
            include (APPPATH . 'views/admin/products/print_template.php');
            $html = ob_get_clean();
            include (APPPATH . "third_party/mpdf60/mpdf.php");
            $mpdf = new mPDF('', 'A4');
            // $mpdf=new mPDF('c','A4','','',32,25,27,25,16,13);
            // $mpdf->mirrorMargins = true;
            $mpdf->SetDisplayMode('fullpage');
            // ==============================================================
            $mpdf->autoScriptToLang = true;
            $mpdf->baseScript = 1; // Use values in classes/ucdn.php 1 = LATIN
            $mpdf->autoVietnamese = true;
            $mpdf->autoArabic = true;
            $mpdf->autoLangToFont = true;
            $mpdf->setAutoBottomMargin = 'stretch';
            $stylesheet = file_get_contents(APPPATH . "third_party/mpdf60/lang2fonts.css");
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->WriteHTML($html);
            // $mpdf->AddPage();
            $mpdf->Output($filePath);
            $mpdf->Output();
            // $mpdf->Output( $filePath,'S');
            exit();
        }
    }
}
//End of Products controller