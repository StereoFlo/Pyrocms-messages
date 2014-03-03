<?php

class Smpp {

  var $socket =0 ;
  var $seq = 0;
  var $debug = 0;
  var $data_coding = 0;
  var $timeout = 2;
  public $server;
  public $port;
  public $user;
  public $pass;
  public $src_number;

  function __construct ($param = array())
  {
    $this->server = $param['server'];
    $this->port = $param['port'];
    $this->user = $param['user'];
    $this->pass = $param['pass'];
    $this->src_number = $param['src_number'];
  }
  
  private function send_pdu($id, $data)
  {
    $this->seq += 1;
    $pdu = pack('NNNN', strlen($data)+16, $id, 0, $this->seq) . $data;
    fputs($this->socket, $pdu);

    $data = fread($this->socket, 4);
    if($data == false) die("\nSend PDU: Connection closed!");
    $tmp = unpack('Nlength', $data);
    $command_length = $tmp['length'];
    if($command_length < 12) return;
    $data = fread($this->socket, $command_length - 4);
    $pdu = unpack('Nid/Nstatus/Nseq', $data);
    if($this->debug) print "\n< R PDU (id,status,seq): " .join(" ",$pdu) ;
    return $pdu;
  }

  private function open($host, $port, $system_id, $password)
  {
    $this->socket = fsockopen($host, $port, $errno, $errstr, $this->timeout);
    if ($this->socket===false)
       die("$errstr ($errno)<br />");
    if (function_exists('stream_set_timeout'))
       stream_set_timeout($this->socket, $this->timeout);
    if($this->debug) print "\n> Connected";


    $data  = sprintf("%s\0%s\0", $system_id, $password); // system_id, password 
    $data .= sprintf("%s\0%c", "", 0x34);  // system_type, interface_version
    $data .= sprintf("%c%c%s\0", 5, 0, ""); // addr_ton, addr_npi, address_range 

    $ret = $this->send_pdu(2, $data);
    if($this->debug) print "\n> Bind done!" ;

    return ($ret['status'] == 0);
  }
  
  private function submit_sm($source_addr,$destintation_addr,$short_message,$optional='')
  {
    $data  = sprintf("%s\0", ""); // service_type
    $data .= sprintf("%c%c%s\0", 5,0,$source_addr); // source_addr_ton, source_addr_npi, source_addr
    $data .= sprintf("%c%c%s\0", 1,1,$destintation_addr); // dest_addr_ton, dest_addr_npi, destintation_addr
    $data .= sprintf("%c%c%c", 0,0,0); // esm_class, protocol_id, priority_flag
    $data .= sprintf("%s\0%s\0", "",""); // schedule_delivery_time, validity_period
    $data .= sprintf("%c%c", 0,0); // registered_delivery, replace_if_present_flag
    $data .= sprintf("%c%c", $this->data_coding,0); // data_coding, sm_default_msg_id
    $data .= sprintf("%c%s", strlen($short_message), $short_message); // sm_length, short_message
    $data .= $optional;

    $ret = $this->send_pdu(4, $data);
    return ($ret['status']==0);
  }

  private function close() {

    $ret = $this->send_pdu(6, "");
    fclose($this->socket);
    return true;
  }

  public function send_long($source_addr, $destintation_addr, $short_message, $utf = 0, $flash = 0) {
    if($utf) $this->data_coding = 0x08;
    if($flash) $this->data_coding = $this->data_coding | 0x18;
    $size = strlen($short_message);
    if($utf) $size += 20;
    if ($size < 160) {
      $this->submit_sm($source_addr, $destintation_addr, $short_message);
    } else {
      $sar_msg_ref_num = rand(1,255);
      $sar_total_segments = ceil(strlen($short_message)/130);
      for($sar_segment_seqnum=1; $sar_segment_seqnum<=$sar_total_segments; $sar_segment_seqnum++) {
        $part = substr($short_message, 0 ,130);
        $short_message = substr($short_message, 130);
        $optional  = pack('nnn', 0x020C, 2, $sar_msg_ref_num);
        $optional .= pack('nnc', 0x020E, 1, $sar_total_segments);
        $optional .= pack('nnc', 0x020F, 1, $sar_segment_seqnum);
        if ($this->submit_sm($source_addr,$destintation_addr,$part,$optional)===false)
           return false;
      }
    }
   return true;
  }
  
  public function send_ru ($destintation_addr, $short_message, $flash = 0)
  {
    $this->open($this->server, $this->port, $this->user, $this->pass);
    $this->data_coding = 0x08;
    if($flash) $this->data_coding = $this->data_coding | 0x18;
    $mess_converted = iconv('UTF-8','UTF-16BE', $short_message);
    $size = strlen($mess_converted);
    $size += 20;
    if ($size < 160)
    {
      $this->submit_sm($this->src_number, $destintation_addr, $mess_converted);
    }
    else
    {
      $sar_msg_ref_num = rand(1,255);
      $sar_total_segments = ceil(strlen($mess_converted)/130);
      for($sar_segment_seqnum = 1; $sar_segment_seqnum <= $sar_total_segments; $sar_segment_seqnum++)
      {
        $part = substr($mess_converted, 0 ,130);
        $mess_converted = substr($mess_converted, 130);
        $optional  = pack('nnn', 0x020C, 2, $sar_msg_ref_num);
        $optional .= pack('nnc', 0x020E, 1, $sar_total_segments);
        $optional .= pack('nnc', 0x020F, 1, $sar_segment_seqnum);
        if ($this->submit_sm($this->src_number, $destintation_addr, $part, $optional) === false)
           return false;
      }
    }
    return true;
  }
}
?>