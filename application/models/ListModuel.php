<?php
class ListModuel extends CI_Model {
	public function __construct()
	{
		$this->load->database();
	}

	public function get_lists()
	{
		$this->db->from('lists');
		$this->db->join('tasks', 'lists.ListID = tasks.ListID_FK', 'left outer');
		$this->db->order_by('ListLastEditDate', 'desc');
		$this->db->order_by('TaskSortIndex', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function set_list()
	{
		//$this->load->helper('url');

		//$this->db->select('ListID');
		//$this->db->order_by(1, 'desc');

		//$query = $this->db->get('lists',1);

		$query = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'todo_db' AND TABLE_NAME = 'lists'";
		$result = $this->db->query($query);
		$next_listId = intval($result->result_array()[0]['AUTO_INCREMENT']);

		$data = array(
			'ListTitle' => $this->input->post('title'),
		);
		$this->db->insert('lists', $data);

		for ($n=1; $n <= $n && $this->input->post('task_'.$n) != null; $n++) {
			var_dump($this->input->post('task_'.$n));
			if ( $this->input->post('task_'.$n) != null) {
				$taskData = array(
					'TaskDescription' => $this->input->post('task_'.$n),
					'TaskSortIndex' => $n,
					'ListID_FK' => $next_listId
				);
				$this->db->insert('tasks', $taskData);
			}
			else {
				$n = $n+1;
			}
		}
	}

	public function delete_list($id)
	{
		$this->db->where('ListID', $id);
		$this->db->delete('lists');

		$this->db->where('ListID_FK', $id);
		$this->db->delete('tasks');	
	}

	public function delete_empty_tasks()
	{
		// when a task has no description it has to be deleted
	}
}