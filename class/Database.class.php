<?php

requireClass("Postgres");
requireClass("User");

class Database {
	var $id;
	var $oid;
	var $name;
	var $owner;
	var $private;
	var $created;
	var $timestamp;

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

	function Exist(){
		if(!empty($this->name) && !empty($this->owner->id) && $this->_check_owner($this->owner)){
			$query = sprintf("SELECT oid FROM pg_database WHERE datname=lower('%s_%s')", $this->owner->username, $this->name);
			$this->_conn->ExecQuery($query);
			$rs = $this->_conn->FetchResult();
			return $rs['oid'];
		}
	}

	private function _insert(){
		if(!empty($this->name) && !empty($this->owner->id) && $this->_check_owner($this->owner)){
			if(!$this->Exist()){
				$query0 = sprintf("CREATE DATABASE %s_%s", $this->owner->username, $this->name);
				$this->_conn->ExecQuery($query0);
				$this->oid = $this->Exist();
				$query = sprintf("INSERT INTO public.database (name, ownerid, oid) VALUES ('%s', %d, %d) RETURNING baseid", $this->name, $this->owner->id, $this->oid);
				$this->_conn->ExecQuery($query);
				$rs = $this->_conn->FetchResult();
				return $rs['baseid'];
			}
		}
	}

	function get($id=''){
		if(!empty($id))
			$this->id = $id;

		if(!empty($this->id)){
			$query = sprintf("SELECT * FROM public.database WHERE baseid=%d", $this->id);
			$this->_conn->ExecQuery($query);
			$rs = $this->_conn->FetchResult();
			$this->name = $rs['name'];

			$u = new User();
			$u->get($rs['ownerid']);
			$this->owner = $u;
			$this->created = $rs['created'];
			$this->timestamp = $rs['timestamp'];
			$this->oid = $rs['oid'];
			$this->private = phpbool($rs['private']);
		}
	}

	private function _update(){
		if(!empty($this->id)){
			$set = "SET baseid=baseid ";

			if(!empty($this->name)){
				if(!$this->Exist()){
					$set .= sprintf(", name='%s' ", $this->name);
					$query0 = sprintf("SELECT name FROM public.database WHERE baseid=%d", $this->id);
					$this->_conn->ExecQuery($query0);
					$rs = $this->_conn->FetchResult();
					$query1 = sprintf("ALTER DATABASE %s_%s RENAME TO %s_%s", strtolower($this->owner->username), $rs['name'], strtolower($this->owner->username), $this->name);
					$this->_conn->ExecQuery($query1);
				}
			}

			if(!empty($this->owner->id))
				$set .= sprintf(", ownerid=%d ", $this->owner->id);

			if(!empty($this->owner->id))
				$set .= sprintf(", private='%s' ", pgbool($this->private));

			$query = sprintf("UPDATE public.database %s WHERE baseid=%d", $set, $this->id);
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
		if(!empty($this->name) && !empty($this->owner->id) && $this->_check_owner($this->owner)){
			$query0 = sprintf("DROP DATABASE %s_%s", $this->owner->username, $this->name);
			$this->_conn->ExecQuery($query0);
			$query = sprintf("DELETE FROM public.database WHERE baseid=%d", $this->id);
			$this->_conn->ExecQuery($query);
			unset($this->id);
			unset($this->oid);
			unset($this->name);
			unset($this->owner);
			unset($this->created);
			unset($this->timestamp);
		}
	}
}

?>