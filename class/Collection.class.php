<?php

requireClass("Postgres");
requireClass("User");
requireClass("Database");

class Collection {
	var $id;
	var $oid;
	var $name;
	var $owner;
	var $database;
	var $created;
	var $timestamp;

	private $_conn_in = NULL;
	private $_conn = NULL;

	function __construct($database){
		if($this->_check_database($database)){
			$this->_conn_in = new Postgres(strtolower($database->owner->username) . '_' . $database->name, "localhost", 5432, "opendb", "q");
			$this->_conn = new Postgres("opendb", "localhost", 5432, "opendb", "q");
			$this->owner = $database->owner;
			$this->database = $database;
		}
	}

	function __destruct(){
		$this->_conn_in->DBClose();
		$this->_conn->DBClose();
	}

	private function _check_owner($owner){
		if(is_a($owner, 'User'))
			return TRUE;
	}

	private function _check_database($database){
		if(is_a($database, 'Database'))
			return TRUE;
	}

	function Exist(){
		if(!empty($this->name) && !empty($this->owner->id) && $this->_check_owner($this->owner)){
			$query = sprintf("SELECT oid FROM pg_namespace WHERE nspname=lower('%s')", $this->name);
			$this->_conn_in->ExecQuery($query);
			$rs = $this->_conn_in->FetchResult();
			return $rs['oid'];
		}
	}

	private function _insert(){
		if(!empty($this->name) && !empty($this->owner->id) && $this->_check_owner($this->owner)){
			if(!$this->Exist()){
				$query0 = sprintf("CREATE SCHEMA \"%s\"", $this->name);
				$this->_conn_in->ExecQuery($query0);
				$this->oid = $this->Exist();
				$query = sprintf("INSERT INTO public.collection (name, ownerid, baseid, oid) VALUES ('%s', %d, %d, %d) RETURNING collid", $this->name, $this->owner->id, $this->database->id, $this->oid);
				$this->_conn->ExecQuery($query);
				$rs = $this->_conn->FetchResult();
				return $rs['collid'];
			}
		}
	}

	function get($id=''){
		if(!empty($id))
			$this->id = $id;

		if(!empty($this->id)){
			$query = sprintf("SELECT * FROM public.collection WHERE collid=%d", $this->id);
			$this->_conn->ExecQuery($query);
			$rs = $this->_conn->FetchResult();
			$this->name = $rs['name'];

			$u = new User();
			$u->get($rs['ownerid']);
			$this->owner = $u;
			$this->created = $rs['created'];
			$this->timestamp = $rs['timestamp'];
			$this->oid = $rs['oid'];
		}
	}

	private function _update(){
		if(!empty($this->id)){
			$set = "SET collid=collid ";

			if(!empty($this->name)){
				if(!$this->Exist()){
					$set .= sprintf(", name='%s' ", $this->name);
					$query0 = sprintf("SELECT name FROM public.collection WHERE collid=%d", $this->id);
					$this->_conn->ExecQuery($query0);
					$rs = $this->_conn->FetchResult();
					$query1 = sprintf("ALTER SCHEMA \"%s\" RENAME TO \"%s\"", $rs['name'], $this->name);
					$this->_conn_in->ExecQuery($query1);
				}
			}

			if(!empty($this->owner->id))
				$set .= sprintf(", ownerid=%d ", $this->owner->id);

			$query = sprintf("UPDATE public.collection %s WHERE collid=%d", $set, $this->id);
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
			$query0 = sprintf("DROP SCHEMA \"%s\"", $this->name);
			$this->_conn_in->ExecQuery($query0);
			$query = sprintf("DELETE FROM public.collection WHERE collid=%d", $this->id);
			$this->_conn->ExecQuery($query);
			unset($this->id);
			unset($this->oid);
			unset($this->name);
			unset($this->owner);
			unset($this->database);
			unset($this->created);
			unset($this->timestamp);
		}
	}
}

?>