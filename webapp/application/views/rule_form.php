<div class="settings-container">
    <div class="rules-container text-center">
        <h2>Generale</h2>
        <br />
        <form id="ruleForm" method="post" action="">
            <div class="row">
                <div class="col">
                    <?php if($rule_id) : ?><label for="name" class="form-label"><strong>Nome regola</strong></label><?php endif; ?>
                    <input type="text" class="form-control" placeholder="Nome regola" name="name" aria-label="Name" required 
                    value="<?php echo $rule_id ? $rule_details['name'] : ''; ?>" />
                </div>
                <div class="col">
                <?php if($rule_id) : ?><label for="temp_default" class="form-label"><strong>Temperatura base</strong></label><?php endif; ?>
                    <div class="input-group">
                        <input type="number" class="form-control" name="temp_default" id="temp_default" min="-20" max="50" step="any" lang="en" 
                        value="<?php echo $rule_id ? $rule_details['temp_default'] : '10.0'; ?>" placeholder="Temperatura base (es. 15.5)" />
                        <span class="input-group-text" id="basic-addon2">°C</span>
                    </div>
                </div>
            </div>
            <br />
            <hr />
            <br />
            <h2>Regole personalizzate</h2>
            <br />
            <div class="row">
                <div class="col">
                    <nav class="nav nav-pills flex-column flex-sm-row day-selection-container">
                        <?php foreach($days as $key => $day) : ?>
                            <a class="day-selection flex-sm-fill text-sm-center nav-link <?php echo $key == 0 ? 'active' : ''; ?>" type="button"
                            data-day="<?php echo $key; ?>">
                                <?php echo strtoupper($day); ?>
                            </a>
                        <?php endforeach; ?>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php foreach($days as $key => $day) : ?>
                        <div class="day-rules-container <?php echo $key == 0 ? 'active' : ''; ?>" id="day-<?php echo $key; ?>">
                            <br />
                            <button class="btn btn-light btn-add-rule-schedule" data-day="<?php echo $key; ?>" type="button">Aggiungi</button>
                            <?php
                                if(isset($rule_schedules[$key])) {

                                    foreach($rule_schedules[$key] as $num => $schedule){
                                        $content_data = array(
                                            'day'   => $key,
                                            'num'   => $num,
                                            'start' => $schedule['start'],
                                            'end'   => $schedule['end'],
                                            'temp'  => $schedule['temp'],
                                        );
                                
                                        echo $this->load->view('rule_schedule', $content_data, true);
                                    }
                                }
                            ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="row text-end mt-4">
                <div class="col">
                    <input type="submit" class="btn btn-lg btn-success f-right" value="Salva" />
                </div>
            </div>
            <input type="hidden" name="rule_id" value="<?php echo $rule_id ? $rule_id : ''; ?>" />
        </form>
    </div>
</div>