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
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}
		else {
			$data['lists'] = $this->ListModuel->get_lists();

			$this->load->view('templates/header');
			$this->load->view('pages/' . $page, $data);
			$this->load->view('templates/footer');
		}
	}

	public function create($page = 'create')
	{
		$this->form_validation->set_rules('title', 'Title', 'required');

		if ($this->form_validation->run() !== FALSE)
		{
			header('Location:'.base_url());
			$this->ListModuel->set_list();
		}
	}

	public function delete($id)
	{
		header('Location:'.base_url());
		$this->ListModuel->delete_list($id);
	}
}