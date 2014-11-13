<?php

requireClass("Postgres");
requireClass("User");

class Group {
	var $id;
	var $name;
	var $owner;

	private $_conn = NULL;

	function __construct(){
		$this->_conn = new Postgres("opendb", "localhost", 5432, "opendb", "q");
	}

	function __destruct(){
		$this->_conn->DBClose();
	}

	private function _check_owner($owner){
		if(is_a($owner, 'User'))
			return TRUE;
	}

	private function _insert(){
		if(!empty($this->name) && !empty($this->owner->id) && $this->_check_owner($this->owner)){
			$query = sprintf("INSERT INTO public.group (name, ownerid) VALUES ('%s', %d) RETURNING groupid", $this->name, $this->owner->id);
			$this->_conn->ExecQuery($query);
			$rs = $this->_conn->FetchResult();
			return $rs['groupid'];
		}
	}

	function get($id=''){
		if(!empty($id))
			$this->id = $id;

		if(!empty($this->id)){
			$query = sprintf("SELECT * FROM public.group WHERE groupid=%d", $this->id);
			$this->_conn->ExecQuery($query);
			$rs = $this->_conn->FetchResult();
			$this->name = $rs['name'];

			$u = new User();
			$u->get($rs['ownerid']);
			$this->owner = $u;
		}
	}

	private function _update(){
		if(!empty($this->id)){
			$set = "SET groupid=groupid ";

			if(!empty($this->name))
				$set .= sprintf(", name='%s' ", $this->name);

			if(!empty($this->owner->id))
				$set .= sprintf(", ownerid=%d ", $this->owner->id);

			$query = sprintf("UPDATE public.group %s WHERE groupid=%d", $set, $this->id);
			$this->_conn->ExecQuery($query);
		}
	}

	function Save(){
		if(!empty($this->id))
			$this->_update();
		else{
			$this->id = $this->_insert();
			$this->get();
			return $this->id;
		}
	}

	function Delete(){
		if(!empty($this->id)){
			$query = sprintf("DELETE FROM public.group WHERE groupid=%d", $this->id);
			$this->_conn->ExecQuery($query);
			unset($this->id);
			unset($this->name);
			unset($this->owner);
		}
	}
}

?>