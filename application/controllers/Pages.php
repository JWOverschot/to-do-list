<?php
class Pages extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ListModule');
		$this->load->helper('url_helper');
	}

	public function view($page = 'home')
	{
		if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
			show_404();
		}
		else {
			$data['lists'] = $this->ListModule->get_lists();

			$this->load->view('templates/header');
			$this->load->view('pages/' . $page, $data);
			$this->load->view('templates/footer');
		}
	}

	public function create()
	{
		$this->form_validation->set_rules('title', 'Title', 'required');

		if ($this->form_validation->run() !== FALSE)
		{
			$this->ListModule->set_list();
			header('Location:'.base_url());
		}
	}

	public function delete($id)
	{
		$this->ListModule->delete_list($id);
		header('Location:'.base_url());
	}

	public function edit()
	{
		$listId = $this->input->post('ListID');
		$listTitle = $this->input->post('ListTitle');

		$this->ListModule->edit_list($listId, $listTitle);
	}

	public function editTask()
	{
		// TODO: detect if its description change or status
		$taskDescription = $this->input->post('TaskDescription');
		$taskId = $this->input->post('TaskID');
		$listId = $this->input->post('ListID');
		$taskDone = $this->input->post('TaskDone');

		$this->ListModule->edit_task($taskDescription, $taskId, $listId, $taskDone);
	}
}