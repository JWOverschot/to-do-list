<?php
class ListModuel extends CI_Model {
	public function __construct()
	{
			$this->load->database();
	}

	public function get_lists()
	{
		$this->db->from('lists');
		$this->db->join('tasks', 'lists.ListID = tasks.ListID', 'left outer');
		$query = $this->db->get();
		return $query->result_array();
	}
}