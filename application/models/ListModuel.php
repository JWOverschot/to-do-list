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
		//var_dump($query->result_array());
		return $query->result_array();
	}

	public function set_list()
	{
		$this->load->helper('url');

		$data = array(
			'ListTitle' => $this->input->post('title')
		);

		return $this->db->insert('lists', $data);
	}

	public function delete_empty_tasks()
	{
		// when a task has no description it has to be deleted
	}
}