<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Class MY_Controller
 */
class MY_Controller extends CI_Controller {

    public $controller;
    public $action;
    public $layer = 'frontend';
    public $layout;
    public $title;
    public $meta;
    public $breadcrumb;
    public $message;
    public $css;
    public $js;
    public $translates;
    public $fileUpload = false;
    public $totalRec;
    public $perPage;

    function __construct() {
        parent::__construct();

        //$this->load->model('user_model');

        //cache
        if(!$this->session->userdata('admin_id')){
              // user is not logged in then redirect user to any page you want
                redirect(base_url(), 'auto');
            } 

        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        if ($this->uri->segment(1) != 'admin') {
            $this->controller = $this->uri->segment(1);
            $this->action = empty($this->uri->segment(2)) ? $this->uri->segment(1) : $this->uri->segment(2);

            if (empty($this->controller))
                $this->controller = 'site';
        } else {
            $this->layer = 'backend';
            $this->controller = $this->uri->segment(2);
            $this->action = $this->uri->segment(3);
            $this->load->model('user_model');
        }


        $this->message = $this->getFlash();
    }

    /**
     * @param $partial, html code from buffer
     * @param null $data [optional] array variables with local scope
     */
    function render($view, $data = null, $returnAsString = false) {

        if ($this->layer == 'frontend') {
            $this->data['view'] = $view;
            $this->data['data'] = $data;
            $this->load->view('layouts/' . (!empty($this->layout) ? $this->layout : 'default'), $this->data);
        } else {
            $this->data['view'] = 'admin/' . $view;
            $this->data['data'] = $data;
            $this->load->view('layouts/' . (!empty($this->layout) ? $this->layout : 'admin'), $this->data);
        }
    }

    /**
     * @param $partial, html code from buffer
     * @param null $data [optional] array variables with local scope
     */
    function renderPartial($view, $data = null, $returnAsString = false) {
        $this->data = $data;
        if($returnAsString)
            return $this->load->view($view, $this->data, $returnAsString);
        else
            $this->load->view($view, $this->data);
    }

    /**
     * @param string $url, url for redirect
     */
    function redirect($url = '') {
        header('Location: ' . base_url($url));
        die();
    }

    /**
     * function to set flash messages
     * @param $message, message to show
     * @param $type, array: info, error, success, warning
     */
    function setFlash($message, $type = 'success') {
        $this->session->set_flashdata($type, $message);
    }

    /**
     * @return string, print flash message
     */
    function getFlash() {
        $message = '';
        foreach (array('info', 'error', 'success', 'warning') as $type) {
            if ($text = $this->session->flashdata($type)) {
                if ($type == 'error')
                    $type = 'danger';
                $message .= '<div class="row"><div class="col-md-12"><div class="alert alert-' . $type . ' alert-dismissable">
                    <strong>' . $text . '</strong>
                </div></div></div>';
                //<button type="button" class="close" data-dismiss="alert">×</button>
            }
        }
        return $message;
    }

    /**
     * check user for administrator permissions
     */
    function require_administrator() {
        if ($this->auth->is_administrator())
            return TRUE;

        $this->setFlash('error', 'Area is restricted to administrators only.');
        $this->redirect('admin/login');
    }

    function require_access($item) {
        if (empty($item)) {
            $this->redirect('admin/' . $this->controller);
        }
    }

    /**
     * @param $value
     * @return mixed
     */
    function translate($value) {
        $translates = $this->translates;
        if (!empty($translates[$value])) {
            return $translates[$value];
        } else {
            return $value;
        }
    }

    public function do_upload($name) {
        $config['upload_path'] = 'uploads/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 1024 * 8;
        //$config['max_width'] = 1024;
        //$config['max_height'] = 768;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($name)) {
            $error = array('error' => $this->upload->display_errors());

            return $error;
        } else {
            $data = array('upload_data' => $this->upload->data());

            return $data;
        }
    }

    /**
     * @param $dir
     * @param int $id
     * @param bool $image
     * @param int $min_width
     * @param int $min_height
     * @return bool
     */
    function fileUpload($dir, $id = 0, $image = true, $min_width = 0, $min_height = 0) {
        $file = ($image) ? 'image' : 'file';

        $path = UPLOAD_DIR . "/$dir";
        if (!is_dir(FCPATH . $path))
            mkdir(FCPATH . $path, 0777, true);

        if ($id != 0) {
            $path .= "/$id";
            if (!is_dir(FCPATH . $path))
                mkdir(FCPATH . $path, 0777, true);
        }

        $config = array(
            'upload_path' => "./$path",
            'allowed_types' => ($image) ? "gif|jpg|png|jpeg" : "pdf|mp4",
            'overwrite' => FALSE,
            'max_size' => IMAGE_UPLOAD_MAX_SIZE * 1024 * 1024, // Can be set to particular file size , here it is 5 MB(2048 Kb)
            'remove_spaces' => true,
        );

        $file_type = strstr(mime_content_type($_FILES[$file]['tmp_name']), '/', true);

        if ($file_type == 'video')
            $config['max_size'] = VIDEO_UPLOAD_MAX_SIZE * 1024 * 1024;
        elseif ($file_type == 'application')
            $config['max_size'] = FILE_UPLOAD_MAX_SIZE * 1024 * 1024;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($file)) {

            $image_data = $this->upload->data();


            //Resize the image to the restricted dimensions of frontend (to avoid big heavy unecessary images which slows the server)
            if ($file == 'image' && $min_width > 0 && $min_height > 0) {
                $this->load->library('image_lib');
                $configurer = array(
                    'image_library' => 'gd2',
                    'source_image' => $image_data['full_path'], //'/home/www/cineville2015/html/files/sliders/test.jpg', //base_url($path.'/'.$image_data['file_name']),
                    'new_image' => $image_data['full_path'], //'/home/www/cineville2015/html/files/sliders/test_1.jpg',
                    'maintain_ratio' => FALSE, // to be sure image has the required size by frontend
                    'width' => $min_width,
                    'height' => $min_height,
                        //'create_thumb'	=> TRUE
                );
                $this->image_lib->clear();
                $this->image_lib->initialize($configurer);
                $this->image_lib->resize();
            }


            $image_data['success'] = true;

            if ($image)
                $image_data['src'] = base_url($path . '/' . $image_data['file_name']);

            return $image_data;
        } else {
            $image_data['success'] = false;

            $error = $this->upload->display_errors();

            //f($this->lang->line('upload_invalid_filesize') == strip_tags($error))
            //    $error .= ' La taille maximale autorisée : ' . $config['max_size']/1024 . 'MB';

            if ($this->lang->line('upload_invalid_dimensions') == strip_tags($error))
                $error .= ' Largeur Minimale : ' . $min_width . ' et hauteur minimale : ' . $min_height;

            if ($this->lang->line('upload_invalid_filetype') == strip_tags($error))
                $error .= ' Types autorisés : ' . str_replace('|', ' , ', $config['allowed_types']);

            $image_data['error'] = $error;

            return $image_data;
        }

        return false;
    }

    function generateFileName($filename) {
        return time() . '.' . pathinfo($filename, PATHINFO_EXTENSION);
    }

    /**
     * @param $$image_data
     * @return bool|string
     */
    function imageCrop($image_data) {
        if (!empty($image_data)) {
            $image = $image_data['img'];
            $id = $image_data['id'];

            $new_image = $image;

            $source_path = UPLOAD_DIR . "/" . $image_data['dir'];
            $path = UPLOAD_DIR . "/" . (isset($image_data['create_thumb']) && $image_data['create_thumb'] ? $image_data['dir'] . "/" . $image_data['thumb_dir'] : $image_data['dir']);
            if (!is_dir(FCPATH . $path))
                mkdir(FCPATH . $path, 0777, true);

            if ($id != 0) {
                $path .= "/$id";
                if (!is_dir(FCPATH . $path))
                    mkdir(FCPATH . $path, 0777, true);
            }

            //crop it
            $config['image_library'] = 'gd2';
            //$config['source_image'] = "./files/temp/$image"; //http://localhost/resume/uploads/apache.jpg
            $config['source_image'] = "./$source_path/$image"; //http://localhost/resume/uploads/apache.jpg
            // $config['create_thumb'] = TRUE;
            $config['new_image'] = "./$path/$new_image";
            $config['maintain_ratio'] = FALSE;
            $config['width'] = $image_data['w'];
            $config['height'] = $image_data['h'];
            $config['x_axis'] = $image_data['x'];
            $config['y_axis'] = $image_data['y'];

            $this->load->library('image_lib', $config);

            if ($this->image_lib->crop()) {
                $resize_width = $image_data['resize_width'];
                $resize_height = $image_data['resize_height'];
                if(isset($image_data['create_thumb']) && $image_data['create_thumb'] && !empty($image_data['resize_width']) && !empty($image_data['resize_height'])) {
                    $resize_width = $image_data['resize_width'];
                    $resize_height = $image_data['resize_height'];
                }
                $config_resize['source_image'] = "./$path/$new_image";
                $config_resize['new_image'] = "./$path/$new_image";
                $config_resize['maintain_ratio'] = FALSE;
                $config_resize['width'] = $resize_width;
                $config_resize['height'] = $resize_height;
                $this->image_lib->initialize($config_resize);
                if ($this->image_lib->resize()) {
                    return $new_image;
                } else {
                    echo $this->image_lib->display_errors();
                    die;
                }
                return $new_image;
            } else {
                echo $this->image_lib->display_errors();
                die;
            }
        } else {
            return false;
        }
    }
    
    public function createThumb($dir, $image, $width, $height, $thumb_dir = '', $thumb_prefix = '') {
        $this->load->library('image_lib');
        $path = UPLOAD_DIR . "/" . $dir;
        $configurer = array(
            'image_library' => 'gd2',
            'source_image' => "./$path/$image", //'/home/www/cineville2015/html/files/sliders/test.jpg', //base_url($path.'/'.$image_data['file_name']),
            'new_image' => "./$path/" . (!empty($thumb_dir) ? $thumb_dir. '/' : '') . "$thumb_prefix$image", //'/home/www/cineville2015/html/files/sliders/test_1.jpg',
            'maintain_ratio' => FALSE, // to be sure image has the required size by frontend
            'width' => $width,
            'height' => $height,
        );
        $this->image_lib->clear();
        $this->image_lib->initialize($configurer);
        $this->image_lib->resize();
    }

    public function get_captcha() {
        $this->load->helper('captcha');
        if(!is_dir(FCPATH . '/captcha'))
            mkdir(FCPATH . '/captcha', 0777);
        $vals = array(
            'font_path' => FCPATH . 'assets/fonts/helvetica.ttf',
            'img_path' => FCPATH . 'captcha/',
            'img_url' => base_url() . 'captcha/',
            'img_width' => 130,
            'img_height' => 42,
            'img_id' => 'captcha-img',
            'font_size' => 20,
            'pool' => '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'word_length' => 5,
        );
        $cap = create_captcha($vals);
        $data = array(
            'captcha_time' => $cap['time'],
            'ip_address' => $this->input->ip_address(),
            'word' => $cap['word']
        );
        $this->session->set_userdata('captcha', $data);
        return $cap;
    }
    
    public function refresh_captcha() {
        $cap = self::get_captcha();
        echo $cap['filename'];
    }

    public function isValidCaptcha($input_captcha) {
        $session = $this->session->userdata('captcha');
        if (!empty($session) && $session['word'] == $input_captcha)
            return true;

        $this->form_validation->set_message('isValidCaptcha', 'Invalid Captcha.');
        return false;
    }
    
    protected function adminPaginationConfig() {
        $url = base_url() . $this->controller . '/index/';
        return $config = [
            'base_url' => $url,
            'total_rows' => $this->totalRec,
            'per_page' => $this->perPage,
            'uri_segment' => 4,
            'first_link' => '<< Premier',
            'first_tag_open' => '<li>',
            'last_link' => 'Dernier >>',
            'last_tag_open' => '<li>',
            'next_link' => 'Suivant >',
            'next_tag_open' => '<li class="pg-next">',
            'prev_link' => '< Précédent',
            'prev_tag_open' => '<li class="pg-prev">',
            'cur_tag_open' => '<li><a href="javascript:void(0);" class="active">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
        ];
    }

    public function currentSession() {

        $last_row = $this->db->select('financial_year')->order_by('id',"desc")->limit(1)->get('financial_year')->row_array();

        if(!empty($last_row)) {
               return $last_row['financial_year'];
        } else {
              return false;
        }
    }
  
}
