<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Room_model extends CI_Model {

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
        $this->_table = 'rooms';
    }

    function get_all_days(){
        return [
            'lun',
            'mar',
            'mer',
            'gio',
            'ven',
            'sab',
            'dom'
        ];
    }

    function get_all_names(){
        $this->db->select('id,name');
        $this->db->from($this->_table);
        $this->db->order_by('home_order');

        $names = $this->db->get()->result_array();

        foreach($names as $val){
            $result[$val['id']] = $val['name'];
        }

        return $result;
    }

    function get_all(){
        $this->db->select('r.*, rules.name as rule_name, rto.temperature_offset, rto.humidity_offset');
        $this->db->from("$this->_table as r");
        $this->db->where('r.active','1');
        $this->db->join('rules','r.rule_id = rules.id','left');
        $this->db->join('rooms_temp_offsets as rto','r.id = rto.room_id','left');
        $this->db->order_by('r.home_order');

        $result = $this->db->get()->result_array();

        foreach ($result as $index => $room) {
            $temp_data = $this->get_last_temp($room['id']);
            $result[$index]['temp']              = $temp_data['temp'];
            $result[$index]['humidity']          = $temp_data['humidity'];
            $result[$index]['heat_index']        = $temp_data['heat_index'];
            $result[$index]['temp_color']        = $this->get_temp_color($temp_data['heat_index']);
            $result[$index]['time']              = $temp_data['time'];
            $result[$index]['manual_state']      = json_decode($result[$index]['manual_state'], true);
            $result[$index]['state']             = $result[$index]['manual_state']['state'];
            $result[$index]['manual_state_temp'] = $result[$index]['state'] == 1 ? $result[$index]['manual_state']['temp'] : '';
            $result[$index]['time_left']         = $result[$index]['state'] == 1 ? get_time_left($result[$index]['manual_state']['end'], $result[$index]['manual_state']['duration']): 0;
            $result[$index]['objective_temp']    = $this->get_objective_temp($room['id'], $result[$index]['manual_state'], $room['rule_id']);
        
            // to keep trace that it's not in a rule or manual state => ergo it's a default setting
            if($result[$index]['state'] == 0 and !$room['rule_id']){
                $result[$index]['state'] = -1;
            }
        }

        return $result;
    }

    function get_room_detail($room_id){
        $this->db->select('r.*, rules.name as rule_name');
        $this->db->from("$this->_table as r");
        $this->db->join('rules','r.rule_id = rules.id','left');
        $this->db->where('r.id',$room_id);
        $this->db->limit(1);

        $room = $this->db->get()->row_array();

        if($room['manual_state']){
            $room['manual_state'] = json_decode($room['manual_state'], 'array');
        }

        $room['objective_temp'] = $this->get_objective_temp($room_id, $room['manual_state'], $room['rule_id']);

        return $room;
    }

    function get_last_temp($room_id = false){
        $this->db->select('temperature_offset, humidity_offset');
        $this->db->from('rooms_temp_offsets');
        $this->db->where('room_id', $room_id);
        $this->db->limit(1);

        $offsets = $this->db->get()->row_array();

        $this->db->from('rooms_temperature');
        $this->db->where('room_id', $room_id);
        $this->db->limit(1);
        $this->db->order_by('id', 'DESC');

        $temp_data = $this->db->get()->row_array();

        $temp_data['temp'] = number_format($temp_data['temp'] + $offsets['temperature_offset'], 1, '.', '');
        $temp_data['humidity'] = number_format($temp_data['humidity'] + $offsets['humidity_offset'], 1, '.', '');

        return $temp_data;
    }

    function get_room_settings($room_id = false){
        $result = false;

        if($room_id){
            $this->db->from('rooms_settings');
            $this->db->where('room_id', $room_id);
            $this->db->limit(1);

            $result = $this->db->get()->row_array();
        }

        return $result;
    }

    function get_room_rule($room_id = false){
        $result = false;

        if($room_id){
            $this->db->select('rule_id');
            $this->db->from("$this->_table as r");
            $this->db->where('r.id',$room_id);
            $this->db->limit(1);

            $result = current($this->db->get()->row_array());
        }

        return $result;
    }

    function get_rooms_scheduling(){
        $this->db->from('rooms_scheduling');
        $this->db->order_by('days');
        $this->db->order_by('rooms');

        $scheduling = $this->db->get()->result_array();
        $names = $this->get_all_names();
        $days = $this->get_all_days();

        foreach($scheduling as $key=>$schedule){
            $rooms = json_decode($schedule['rooms'], true);

            foreach($rooms as $room){
                $rooms_names[] = $names[$room];
            }
        
            $scheduling[$key]['rooms'] = join($rooms_names,',');

            $sc_days = json_decode($schedule['days'], true);

            foreach ($sc_days as $sc_day) {
                $days_names[] = $days[$sc_day-1];
            }

            $scheduling[$key]['days'] = join($days_names, ',');
            $scheduling[$key]['start'] = date("H:i", strtotime($schedule['start']));
            $scheduling[$key]['end'] = date("H:i", strtotime($schedule['end']));
        }

        return $scheduling;
    }

    function get_all_room_settings(){
        $this->db->from('rooms_settings');

        return $this->db->get()->result_array();
    }

    function set_room_settings($room_id, $settings){
        if ($room_id && $settings) {
            $this->db->set('temp_threshold', $settings['temp_threshold']);
            $this->db->set('scheduling', $settings['scheduling']);
            $this->db->where('room_id', $room_id);
            $this->db->update('rooms_settings');
        }
    }

    function set_manual_state_all($state, $temp, $duration=false){
        $rooms = $this->get_all_names();
        $end = $duration ? date("Y-m-d H:i:s", strtotime("+$duration hours")) : '';

        $value = json_encode(array(
            'state'    => $state,
            'temp'     => $temp,
            'duration' => $duration ? $duration: '',
            'end'      => $end
        ));

        foreach($rooms as $room_id => $name){
            $this->db->set('manual_state', $value);
            $this->db->where('id', $room_id);
            $this->db->update('rooms');
        }
    }

    function set_manual_state($room_id, $state, $temp='null', $duration=false){
        // retrieve old rule (if set)
        $room_details = $this->get_room_detail($room_id);

        if($room_details['rule_id']){
            $old_rule = $room_details['rule_id'];
        }
        else {
            $old_rule = isset($room_details['manual_state']['old_rule']) ? $room_details['manual_state']['old_rule'] : null;
        }

        // set the manual state
        $end = $duration ? date("Y-m-d H:i:s", strtotime("+$duration hours")) : '';

        $value = json_encode(array(
            'state'    => $state,
            'temp'     => $temp,
            'duration' => $duration ? $duration: '',
            'end'      => $end,
            'old_rule' => $old_rule
        ));

        $this->db->set('manual_state', $value);
        $this->db->set('rule_id',null);
        $this->db->where('id', $room_id);
        $this->db->update('rooms');

        // if manual state is disable check if there is the old_rule set - if yes set to it
        if(!$state && $old_rule){
            $this->set_rule_id($room_id, $old_rule);
        }
    }

    function set_rule_id($room_id, $rule_id){
        $this->db->set('rule_id', $rule_id);
        $this->db->where('id', $room_id);
        $this->db->update('rooms');
    }

    // scheduling functions
    function add_schedule($schedule){
        $data = array(
            'rooms' => $schedule['rooms'],
            'days'  => $schedule['days'],
            'start' => $schedule['start'],
            'end'   => $schedule['end'],
            'temp'  => $schedule['temp']
        );

        $this->db->insert('rooms_scheduling', $data);
    }

    function update_schedule($schedule_id, $schedule){
        $this->db->set('rooms', $schedule['rooms']);
        $this->db->set('days', $schedule['days']);
        $this->db->set('start', $schedule['start']);
        $this->db->set('end', $schedule['end']);
        $this->db->set('temp', $schedule['temp']);
        $this->db->where('id', $schedule_id);

        $this->db->update('rooms_scheduling');
    }

    function delete_schedule($schedule_id){
        $this->db->where('id', $schedule_id);
        $this->db->delete('rooms_scheduling');
    }

    function get_temp_color($temp){
        $color = "temp-blue";

        if($temp > 18 && $temp <= 21){
            $color = "temp-green";
        }
        elseif($temp > 21 && $temp <= 24){
            $color = "temp-yellow";
        }
        elseif($temp > 24 && $temp <= 27){
            $color = "temp-orange";
        }
        elseif($temp > 27){
            $color = "temp-red";
        }

        return $color;
    }

    function get_objective_temp($room_id, $manual_state=false, $rule_id=false){
        $objective_temp = $this->config->item('default_temp');

        if(!$manual_state){
            $this->db->select('manual_state');
            $this->db->from('rooms');
            $this->db->where('id', $room_id);

            $manual_state = json_decode(current($this->db->get()->row_array()), true);
        }

        if($manual_state['state'] == '1'){
            $objective_temp = $manual_state['temp'];
        }
        else {
            if($rule_id){
                $objective_temp = $this->rule_model->get_current_temp($rule_id);
            }
            // else leave the default config setting
        }

        $objective_temp = round($objective_temp, 2);

        return $objective_temp;
    }

    function get_room_schedule($room_id){
        $this->db->select('start, end, temp');
        $this->db->from('rooms_scheduling');
        $this->db->like('rooms', $room_id);
        $this->db->like('days', date("w"));
        $this->db->order_by('LENGTH(days)','ASC');

        return $this->db->get()->result_array();
    }

    function delete_old_temperatures(){
        $this->db->where('time <', date('Y-m-d'));
        $this->db->delete('rooms_temperature');
    }
}