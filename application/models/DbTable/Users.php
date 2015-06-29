<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'users';
	
	public function add($username, $password, $firstName, $lastName, $email, $role)
    {
		// create a new row
		$rowUser = $this->createRow();
		if($rowUser)
		{
			// update the row values
			$rowUser->username = $username;
			$rowUser->password = md5($password);
			$rowUser->first_name = $firstName;
			$rowUser->last_name = $lastName;
			$rowUser->role = $role;
			$rowUser->status = 'pending';
			$rowUser->email = $email;
			$rowUser->save();
			//return the new user
			return $rowUser;
			
		}else{
			throw new Zend_Exception("Could not create user!");
		}
		
        
        //return $this->insert($data);
    }
 	
    public function getSingleWithUsername($username)
    {
        $select = $this->select();
        $where = $this->getAdapter()->quoteInto('username = ?', $username);
        $select->where($where);
        return $this->fetchRow($select);
    }
 
    public function getSingleWithEmail($email)
    {
        $select = $this->select();
        $where = $this->getAdapter()->quoteInto('email = ?', $email);
        $select->where($where);
        return $this->fetchRow($select);
    }
 
    public function getSingleWithEmailHash($hash)
    {
        $select = $this->select();
        $where = $this->getAdapter()->quoteInto('SHA1(email) = ?', $hash);
        $select->where($where);
        return $this->fetchRow($select);
    }
	
	public static function getUsers()
	{
		$userModel = new Application_Model_DbTable_Users();
		$select = $userModel->select();
		$select->order(array('last_name', 'first_name'));
		return $userModel->fetchAll($select);
		
	}
	
	public function updateUser($id, $username, $firstName, $lastName, $role)
	{
		//fetch the user's row
		$rowUser = $this->find($id)->current();
		if ($rowUser)
		{
			//update the row values
			$rowUser->username = $username;
			$rowUser->first_name = $firstName;
			$rowUser->last_name = $lastName;
			$rowUser->role = $role;
			$rowUser->save();
			// return the updated user
		}else {
			throw new Zend_Exception("User update failed. User not found!");
		}
	}
	
	public function updatePassword($id, $password)
	{
		//fetch the user's row
		$rowUser = $this->find($id)->current();
		if ($rowUser)
		{
			//update the password
			$rowUser->password_hash = md5($password);
			$rowUser->save();
		}else{
			throw new Zend_Exception ("Password update failed. user not found");
		}
	}
	
	public function deleteUser($id)
	{
		//fetch the user's row
		$rowUser = $this->find($id)->current();
		if ($rowUser)
		{
			$rowUser->delete();
		}else{
			throw new Zend_Exception("Could not delete user. User not found!");
		}
	}


}

