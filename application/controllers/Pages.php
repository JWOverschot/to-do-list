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
			$next_listId = $this->ListModule->get_list_increment_id();
			$this->ListModule->set_list();

			for ($n=1; $n <= $n && $this->input->post('task_'.$n) != null; $n++) {
				if ($this->input->post('task_'.$n) != null) {
					$taskData = array(
						'TaskDescription' => $this->input->post('task_'.$n),
						'TaskSortIndex' => $n,
						'ListID_FK' => $next_listId
					);
					$this->ListModule->set_task($taskData);
				}
				else {
					$n = $n+1;
				}
			}

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
		$taskSortIndex = $this->input->post('TaskSortIndex');

		$this->ListModule->edit_task($taskDescription, $taskId, $listId, $taskDone, $taskSortIndex);
	}

	public function deleteTask($id)
	{
		$this->ListModule->delete_task($id);
		header('Location:'.base_url());
	}

	public function getTaskIncrementID()
	{
		return $this->ListModule->get_task_increment_id();
	}

	public function createTask()
	{
		$taskData = array(
			'TaskDescription' => '',
			'TaskSortIndex' => $this->input->post('TaskSortIndex'),
			'ListID_FK' => $this->input->post('ListID_FK')
		);

		$this->ListModule->set_task($taskData);
	}

	public function filterList() {
		$query = $this->input->post('query');
		
		$this->ListModule->get_filtered_list($query);
	}
}