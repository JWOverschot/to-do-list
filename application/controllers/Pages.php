<?php
class Pages extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('ListModuel');
                $this->load->helper('url_helper');
        }

        public function view($page = 'home')
        {
                $data['lists'] = $this->ListModuel->get_lists();

                $this->load->view('templates/header');
                $this->load->view('pages/' . $page, $data);
                $this->load->view('templates/footer');
        }
}