<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Messages_m extends MY_Model
{
    public function get_settings ()
    {
        return $this->db->get('messages_settings')->result();
    }
    
    public function update_settings($input)
    {
	$data = array(
        'host' => $input['host'],
        'port' => $input['port'],
        'user' => $input['user'],
        'pass' => $input['pass'],
        'src_number' => $input['src_number'],
	'template' => $input['template'],
        );

	$this->db->where('id', $input['id']);
	$this->db->update('messages_settings', $data);
    }
    
    public function add_settings($data)
    {
	$this->db->set('host', $data['host']);
	$this->db->set('port', $data['port']);
	$this->db->set('user', $data['user']);
	$this->db->set('pass', $data['pass']);
	$this->db->set('src_number', $data['src_number']);
	$this->db->set('template', $data['template']);

	$this->db->insert('messages_settings');
	return $this->db->insert_id();
    }
    
    public function get_messages ($num, $offset, $user = null)
    {
	$this->db->order_by('id','desc');
	if ($user) $this->db->where('from_id', $user);
        return $this->db->get('messages_content', $num, $offset)->result();
    }
    
    public function count_messages($user = null)
    {
	if (!is_null($user)) $this->db->where('from_id', $user);
        return $this->db->get('messages_content')->num_rows();
    }
    
    public function delete_message ($id)
    {
	$this->db->where('id', $id);
	$this->db->delete('messages_content');
    }
    
    public function add_message ($data)
    {
	$this->db->set('to', $data['to']);
	$this->db->set('from', $data['from']);
	$this->db->set('from_id', $data['from_id']);
	$this->db->set('ip', $data['ip']);
	$this->db->set('message', $data['message']);
	$this->db->insert('messages_content');
    }
    
    public function get_users ()
    {
    	$this->db->distinct();
    	$this->db->select('from_id');
		return $this->db->get('messages_content')->result();
	}
    
    public function get_message_by_userid ($id, $num, $offset)
    {
		$this->db->order_by('id','desc');
		$this->db->where('from_id', $id);
		return $this->db->get('messages_content', $num, $offset)->result();
    }

    public function get_message_by_id ($id)
    {
		$this->db->where('id', $id);
		return $this->db->get('messages_content')->row();
    }
    
    public function get_message_by_userid_count ($id)
    {
	$this->db->where('from_id', $id);
	return $this->db->get('messages_content')->num_rows();
    }
    
    public function get_block ()
    {
		return $this->db->get('messages_block')->result();
	}
    public function get_block_by_user ($userid)
    {
    	$this->db->where('user_id', $userid);
		return $this->db->get('messages_block')->row();
	}
    
    public function check_block ($id)
    {
		$this->db->where('user_id', $id);
		return $this->db->get('messages_block')->num_rows();
	}
    
    public function block_user ($id, $reason)
    {
		$this->db->where('user_id', $id);
		$result = $this->db->get('messages_block')->num_rows();
		if ($result > 0)
		{
			$this->db->set('reason', $reason);
			$this->db->update('messages_block');
		}
		else
		{
			$this->db->set('user_id', $id);
			$this->db->set('reason', $reason);
			$this->db->insert('messages_block');
		}
		return $this->db->affected_rows();
	}
	
	public function unblock_user ($id)
	{
		$this->db->where('user_id', $id);
		$this->db->delete('messages_block');
	}
	
	public function add_to_book ($name, $phone, $user_id)
	{
		$this->db->set('name', $name);
		$this->db->set('phone', $phone);
		$this->db->set('user_id', $user_id);
		$this->db->insert('messages_book');
	}
	
	public function get_contacts ($user_id)
	{
		$this->db->where('user_id', $user_id);
		return $this->db->get('messages_book')->result();
	}
	
	public function delete_contact ($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('messages_book');
	}
	
}