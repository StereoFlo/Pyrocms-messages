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
    public function get_message_by_userid ($id, $num, $offset)
    {
	$this->db->order_by('id','desc');
	$this->db->where('from_id', $id);
	return $this->db->get('messages_content', $num, $offset)->result();
    }
    
    public function get_message_by_userid_count ($id)
    {
	$this->db->where('from_id', $id);
	return $this->db->get('messages_content')->num_rows();
    }
}