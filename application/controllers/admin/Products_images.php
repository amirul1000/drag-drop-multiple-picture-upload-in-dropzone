<?php

/**
 * Author: Amirul Momenin
 * Desc:Products_images Controller
 *
 */
class Products_images extends CI_Controller
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
        $this->load->model('Products_images_model');
        if (! $this->session->userdata('validated')) {
            redirect('admin/login/index');
        }
    }

    /**
     * Index Page for this controller.
     *
     * @param $start -
     *            Starting of products_images table's index to get query
     *            
     */
    function index($start = 0)
    {
        $limit = 10;
        $data['products_images'] = $this->Products_images_model->get_limit_products_images($limit, $start);
        // pagination
        $config['base_url'] = site_url('admin/products_images/index');
        $config['total_rows'] = $this->Products_images_model->get_count_products_images();
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

        $data['_view'] = 'admin/products_images/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Save products_images
     *
     * @param $id -
     *            primary key to update
     *            
     */
    function save($id = - 1)
    {
        $file_name = "";

        $params = array(
            'users_id' => html_escape($this->input->post('users_id')),
            'products_id' => html_escape($this->input->post('products_id')),
            'file_name' => $file_name,
            'order_no' => html_escape($this->input->post('order_no')),
            'uploaded' => html_escape($this->input->post('uploaded'))
        );

        $config['upload_path'] = "./public/uploads/images/products_images";
        $config['allowed_types'] = "gif|jpg|png";
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;
        $this->load->library('upload', $config);

        if (isset($_POST) && count($_POST) > 0) {
            if (strlen($_FILES['file_name']['name']) > 0 && $_FILES['file_name']['size'] > 0) {
                if (! $this->upload->do_upload('file_name')) {
                    $error = array(
                        'error' => $this->upload->display_errors()
                    );
                } else {
                    $file_name = "uploads/images/products_images/" . $_FILES['file_name']['name'];
                    $params['file_name'] = $file_name;
                }
            } else {
                unset($params['file_name']);
            }
        }

        $data['id'] = $id;
        // update
        if (isset($id) && $id > 0) {
            $data['products_images'] = $this->Products_images_model->get_products_images($id);
            if (isset($_POST) && count($_POST) > 0) {
                $this->Products_images_model->update_products_images($id, $params);
                $this->session->set_flashdata('msg', 'Products_images has been updated successfully');
                redirect('admin/products_images/index');
            } else {
                $data['_view'] = 'admin/products_images/form';
                $this->load->view('layouts/admin/body', $data);
            }
        } // save
        else {
            if (isset($_POST) && count($_POST) > 0) {
                $products_images_id = $this->Products_images_model->add_products_images($params);
                $this->session->set_flashdata('msg', 'Products_images has been saved successfully');
                redirect('admin/products_images/index');
            } else {
                $data['products_images'] = $this->Products_images_model->get_products_images(0);
                $data['_view'] = 'admin/products_images/form';
                $this->load->view('layouts/admin/body', $data);
            }
        }
    }

    /**
     * Details products_images
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function details($id)
    {
        $data['products_images'] = $this->Products_images_model->get_products_images($id);
        $data['id'] = $id;
        $data['_view'] = 'admin/products_images/details';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Deleting products_images
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function remove($id)
    {
        $products_images = $this->Products_images_model->get_products_images($id);

        // check if the products_images exists before trying to delete it
        if (isset($products_images['id'])) {
            $this->Products_images_model->delete_products_images($id);
            $this->session->set_flashdata('msg', 'Products_images has been deleted successfully');
            redirect('admin/products_images/index');
        } else
            show_error('The products_images you are trying to delete does not exist.');
    }

    /**
     * Search products_images
     *
     * @param $start -
     *            Starting of products_images table's index to get query
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
        $this->db->or_like('users_id', $key, 'both');
        $this->db->or_like('products_id', $key, 'both');
        $this->db->or_like('file_name', $key, 'both');
        $this->db->or_like('order_no', $key, 'both');
        $this->db->or_like('uploaded', $key, 'both');

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $data['products_images'] = $this->db->get('products_images')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }

        // pagination
        $config['base_url'] = site_url('admin/products_images/search');
        $this->db->reset_query();
        $this->db->like('id', $key, 'both');
        $this->db->or_like('users_id', $key, 'both');
        $this->db->or_like('products_id', $key, 'both');
        $this->db->or_like('file_name', $key, 'both');
        $this->db->or_like('order_no', $key, 'both');
        $this->db->or_like('uploaded', $key, 'both');

        $config['total_rows'] = $this->db->from("products_images")->count_all_results();
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
        $data['_view'] = 'admin/products_images/index';
        $this->load->view('layouts/admin/body', $data);
    }

    /**
     * Export products_images
     *
     * @param $export_type -
     *            CSV or PDF type
     */
    function export($export_type = 'CSV')
    {
        if ($export_type == 'CSV') {
            // file name
            $filename = 'products_images_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            // get data
            $this->db->order_by('id', 'desc');
            $products_imagesData = $this->Products_images_model->get_all_products_images();
            // file creation
            $file = fopen('php://output', 'w');
            $header = array(
                "Id",
                "Users Id",
                "Products Id",
                "File Name",
                "Order No",
                "Uploaded"
            );
            fputcsv($file, $header);
            foreach ($products_imagesData as $key => $line) {
                fputcsv($file, $line);
            }
            fclose($file);
            exit();
        } else if ($export_type == 'Pdf') {
            $this->db->order_by('id', 'desc');
            $products_images = $this->db->get('products_images')->result_array();
            // get the HTML
            ob_start();
            include (APPPATH . 'views/admin/products_images/print_template.php');
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
//End of Products_images controller