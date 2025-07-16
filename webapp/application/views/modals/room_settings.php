<form class="row" id="roomSettingsForm">
    <div class="col-md-6">
        <label for="temp_min" class="form-label">Temperatura minima</label>
        <input type="number" class="form-control" id="temp_min" min="-50" max="50" value="<?php echo $temp_threshold['min'] ? $temp_threshold['min'] : "" ?>" />
    </div>
    <div class="col-md-6">
        <label for="temp_max" class="form-label">Temperatura massima</label>
        <input type="number" class="form-control" id="temp_max" min="-50" max="50" value="<?php echo $temp_threshold['max'] ? $temp_threshold['max'] : "" ?>" />
    </div>
</form>