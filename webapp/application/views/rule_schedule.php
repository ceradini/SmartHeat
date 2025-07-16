<div class="row rule-schedule">
    <div class="col">
        <label for="start" class="form-label"><strong>Ora inizio</strong></label>
        <input type="text" class="form-control" name="start_<?php echo $day; ?>[]" value="<?php echo isset($start) ? substr($start, 0, 5) : "0:00"; ?>" />
    </div>
    <div class="col">
        <label for="end" class="form-label"><strong>Ora fine</strong></label>
        <input type="text" class="form-control" name="end_<?php echo $day; ?>[]" value="<?php echo isset($end) ? substr($end, 0, 5) : "23:59"; ?>" />
    </div>
    <div class="col">
        <label for="temp" class="form-label"><strong>Temperatura</strong></label>
        <div class="input-group">
            <input type="number" class="form-control" name="temp_<?php echo $day; ?>[]" min="-50" max="50" step="any" lang="en"
            value="<?php echo isset($temp) ? $temp : "15"; ?>" />
            <span class="input-group-text" id="basic-addon2">°C</span>
        </div>
    </div>
    <div class="col-2 text-end">
        <label class="form-label"><strong>Opzioni</strong></label>
        <br />
        <button class="btn btn-outline-danger btn-delete-rule-schedule">Elimina</button> 
    </div>
</div>