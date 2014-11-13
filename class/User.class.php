<?php

requireClass("Postgres");

class User {
	var $id;
	var $username;
	var $password;
	var $email;
	var $email_confirmed;
	var $blocked;
	var $reputation;
	var $note;
	var $created;
	var $timestamp;

	private $_conn = NULL;

	function __construct(){
		$this->_conn = new Postgres("opendb", "localhost", 5432, "opendb", "q");
	}

	function __destruct(){
		$this->_conn->DBClose();
	}

	private function _insert(){
		if(!empty($this->username) && !empty($this->password) && !empty($this->email)){
			$query = sprintf("INSERT INTO public.user (username, password, email) VALUES ('%s', '%s', '%s') RETURNING userid", $this->username, $this->password, $this->email);
			$this->_conn->ExecQuery($query);
			$rs = $this->_conn->FetchResult();
			return $rs['userid'];
		}
	}

	function get($id=''){
		if(!empty($id))
			$this->id = $id;
	
		if(!empty($this->id)){
			$query = sprintf("SELECT * FROM public.user WHERE userid=%d", $this->id);
			$this->_conn->ExecQuery($query);
			$rs = $this->_conn->FetchResult();
			$this->username = $rs['username'];
			$this->email = $rs['email'];
			$this->email_confirmed = phpbool($rs['email_confirmed']);
			$this->blocked = phpbool($rs['blocked']);
			$this->reputation = $rs['reputation'];
			$this->note = $rs['note'];
			$this->created = $rs['created'];
			$this->timestamp = $rs['timestamp'];
		}
	}

	private function _update(){
		if(!empty($this->id)){
			$set = "SET userid=userid ";

			if(!empty($this->username))
				$set .= sprintf(", username='%s' ", $this->username);

			if(!empty($this->email))
				$set .= sprintf(", email='%s' ", $this->email);

			if(!empty($this->email_confirmed))
				$set .= sprintf(", email_confirmed='%s' ", pgbool($this->email_confirmed));

			if(!empty($this->blocked))
				$set .= sprintf(", blocked='%s' ", pgbool($this->blocked));

			if(!empty($this->reputation))
				$set .= sprintf(", reputation=%d ", $this->reputation);

			if(!empty($this->note))
				$set .= sprintf(", note='%s' ", $this->note);

			$query = sprintf("UPDATE public.user %s WHERE userid=%d", $set, $this->id);
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
			$query = sprintf("DELETE FROM public.user WHERE userid=%d", $this->id);
			$this->_conn->ExecQuery($query);
			unset($this->id);
			unset($this->username);
			unset($this->password);
			unset($this->email);
			unset($this->email_confirmed);
			unset($this->blocked);
			unset($this->reputation);
			unset($this->note);
			unset($this->created);
			unset($this->timestamp);
		}
	}
}

?>