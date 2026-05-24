<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sync extends CI_Controller
{
    public function check_rules()
    {
        $this->load->model('settings_model');

        $rooms = $this->room_model->get_all();
        $global_settings = $this->settings_model->get_all_global_settings();

        $min_threshold = $global_settings['min_diff_threshold'];

        $global_state = $this->settings_model->get_setting_value('global_state', true);

        if($global_state == '1'){
            foreach ($rooms as $room) {
                // check if you need to turn thermostat on or off
                $turn_on = false;
                $turn_off = false;

                if($room['temp'] != NULL){
                    $diff = $room['temp'] - $room['objective_temp'];

                    if (abs($diff) > $min_threshold) {
                        if ($diff < 0 && $room['thermostat_status'] == 0) {
                            $turn_on = true;
                        } elseif ($diff > 0 && $room['thermostat_status'] == 1) {
                            $turn_off = true;
                        }
                    }
                }
                elseif($room['state'] == 1) {
                    $turn_off = true;
                }

                if ($turn_on) {
                    $command = array(
                        'type' => 'turn_on',
                        'room_id' => $room['id']
                    );

                    $this->command_model->add_command(json_encode($command));
                } elseif ($turn_off) {
                    $command = array(
                        'type' => 'turn_off',
                        'room_id' => $room['id']
                    );
                    
                    $this->command_model->add_command(json_encode($command));
                }

                // check if manual state timer is expired
                if ($room['state'] == 1 && $room['time_left'] == 0) {
                    $state = 0;

                    $this->room_model->set_manual_state($room['id'], $state, false, false);
                }
            }
        }
    }

    public function clear_commands(){
        $this->command_model->clear_old();
    }

    public function aggregate_temperatures(){
        $export_dir = FCPATH . 'exports/temperatures';
        echo "Export directory: " . $export_dir . "<br>";

        $grouped = $this->room_model->get_temperatures_for_export();

        if (!empty($grouped)) {
            $files = $this->room_model->export_temperatures_to_csv($grouped, $export_dir);
            echo "Exported " . count($files) . " CSV file(s).<br>";
        } else {
            echo "<strong>No data found to export (no records older than today).</strong><br>";
        }

        // 3. Delete old records as before
        $this->room_model->delete_old_temperatures();
    }
}
