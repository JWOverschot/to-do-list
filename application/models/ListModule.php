<?php
class ListModule extends CI_Model {
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
		$data = array(
			'ListTitle' => $this->input->post('title'),
		);
		$this->db->insert('lists', $data);
	}

	public function get_list_increment_id()
	{
		$query = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'todo_db' AND TABLE_NAME = 'lists'";
		$result = $this->db->query($query);
		return intval($result->result_array()[0]['AUTO_INCREMENT']);
	}

	public function delete_list($id)
	{
		$this->db->where('ListID', $id);
		$this->db->delete('lists');

		$this->db->where('ListID_FK', $id);
		$this->db->delete('tasks');	
	}

	public function edit_list($listId, $listTitle)
	{
		$data = array(
			'ListID' => trim($listId),
			'ListTitle'  => trim($listTitle)
		);
		var_dump($data);
		$this->db->replace('lists', $data);
	}

	public function edit_task($taskDescription, $taskId, $listId, $taskDone, $taskSortIndex)
	{
		$data = array(
			'ListID_FK' => trim($listId),
			'TaskID' => trim($taskId),
			'TaskDescription' => trim($taskDescription),
			'TaskDone' => trim($taskDone),
			'TaskSortIndex' => trim($taskSortIndex)
		);
		var_dump($data);
		$this->db->replace('tasks', $data);
	}

	public function set_task($taskData)
	{
		$this->db->insert('tasks', $taskData);
	}

	public function delete_task($id)
	{
		$this->db->where('TaskID', $id);
		$this->db->delete('tasks');
	}

	public function get_task_increment_id()
	{
		$query = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'todo_db' AND TABLE_NAME = 'tasks'";
		$result = $this->db->query($query);
		$id = intval($result->result_array()[0]['AUTO_INCREMENT']);
		echo $id;
	}

	public function get_filtered_list($serachQuery) {
		$this->db->select('ListID');
		$this->db->from('lists');
		$this->db->not_like('ListTitle', $serachQuery);
		$query = $this->db->get();
		echo json_encode($query->result_array());
	}
}