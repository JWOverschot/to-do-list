<?php
class ListModuel extends CI_Model {
	public function __construct()
	{
			$this->load->database();
	}

	public function get_lists()
	{
		$query = $this->db->get('lists');
		return $query->result_array();
	}
}