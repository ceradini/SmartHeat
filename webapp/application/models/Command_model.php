<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Command_model extends CI_Model {

    /**
     * @vars
     */
    private $_table;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();

        // define primary table
        $this->_table = 'commands';
    }

    function add_command($command = false)
    {
        if($command){
            $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            $len = strlen($command);

            socket_sendto($sock, $command, $len, 0, $this->config->item('commands_socket_ip'), $this->config->item('commands_socket_port'));
            // $this->db->insert($this->_table, $item);
        }
    }

    function clear_old(){
        $this->db->where('executed', true);
        $this->db->delete($this->_table);
    }
}