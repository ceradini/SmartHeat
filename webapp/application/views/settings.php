<div class="settings-container">
    <a href="<?php echo site_url('/index.php/settings/system_reboot'); ?>" class="btn btn-lg btn-warning">
        <i class="bi bi-power"></i> Riavvia sistema
    </a>
    <br />
    <h1>Regole</h1>
    <div class="rules-container text-center">
        <a href="<?php echo site_url('/index.php/settings/form'); ?>" class="btn btn-lg btn-success">Aggiungi</a>
        <table class="table table-striped mt-2">
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Temperatura base</th>
                    <th class="options"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rules as $rule) : ?>
                    <tr>
                        <td><?php echo $rule['name']; ?></td>
                        <td><?php echo $rule['temp_default']; ?> °C</td>
                        <td class="options" width="275" data-id="<?php echo $rule['id']; ?>">
                            <a class="btn btn-secondary btn-sm btn-edit-rule" href="<?php echo site_url('/index.php/settings/form/' . $rule['id']); ?>">modifica</a>
                            <button type="button" class="btn btn-danger btn-sm btn-delete-rule">elimina</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php /*
    <div class="d-flex align-items-start">
        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" id="tab-lun" data-bs-toggle="pill" data-bs-target="#tab-cont-lun" type="button" role="tab" aria-controls="tab-lun" aria-selected="true">Lunedì</button>
            <button class="nav-link" id="tab-mar" data-bs-toggle="pill" data-bs-target="#tab-cont-mar" type="button" role="tab" aria-controls="tab-mar" aria-selected="true">Martedì</button>
            <button class="nav-link" id="tab-mer" data-bs-toggle="pill" data-bs-target="#tab-cont-mer" type="button" role="tab" aria-controls="tab-mer" aria-selected="true">Mercoledì</button>
            <button class="nav-link" id="tab-gio" data-bs-toggle="pill" data-bs-target="#tab-cont-gio" type="button" role="tab" aria-controls="tab-gio" aria-selected="true">Giovedì</button>
            <button class="nav-link" id="tab-ven" data-bs-toggle="pill" data-bs-target="#tab-cont-ven" type="button" role="tab" aria-controls="tab-ven" aria-selected="true">Venerdì</button>
            <button class="nav-link" id="tab-sab" data-bs-toggle="pill" data-bs-target="#tab-cont-sab" type="button" role="tab" aria-controls="tab-sab" aria-selected="true">Sabato</button>
            <button class="nav-link" id="tab-dom" data-bs-toggle="pill" data-bs-target="#tab-cont-dom" type="button" role="tab" aria-controls="tab-dom" aria-selected="true">Domenica</button>
        </div>
        <div class="tab-content daily-scheduling-container" id="v-pills-tabContent"></div>
    </div>
    */ ?>

    <div class="modal fade" id="editRuleModal" tabindex="-1" aria-labelledby="editRuleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRuleModalLabel">Modifica regola</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="scheduleForm">
                        <div class="row">
                            <div class="col">
                                <label for="temp_max" class="form-label"><strong>Giorni</strong></label>
                                <br />
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="days" id="day1" value="1">
                                    <label class="form-check-label" for="day1">Lun</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="days" id="day2" value="2">
                                    <label class="form-check-label" for="day2">Mar</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="days" id="day3" value="3">
                                    <label class="form-check-label" for="day3">Mer</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="days" id="day4" value="4">
                                    <label class="form-check-label" for="day4">Gio</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="days" id="day5" value="5">
                                    <label class="form-check-label" for="day5">Ven</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="days" id="day6" value="6">
                                    <label class="form-check-label" for="day6">Sab</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="days" id="day7" value="7">
                                    <label class="form-check-label" for="day7">Dom</label>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="row mt-2">
                            <div class="col">
                                <label for="temp_max" class="form-label"><strong>Stanze</strong></label>
                                <br />
                                <?php foreach ($rooms_names as $room_id => $room_name) : ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="rooms" id="room<?php echo $room_id; ?>" value="<?php echo $room_id; ?>">
                                        <label class="form-check-label" for="room<?php echo $room_id; ?>"><?php echo $room_name; ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <hr />
                        <div class="row mt-2">
                            <div class="col-md-4 col-lg-3">
                                <label for="start" class="form-label"><strong>Ora inizio</strong></label>
                                <input type="text" class="form-control" name="start" id="start" value="0:00" />
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="end" class="form-label"><strong>Ora fine</strong></label>
                                <input type="text" class="form-control" name="end" id="end" value="24:00" />
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="temp" class="form-label"><strong>Temperatura</strong></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="temp" id="temp" min="-50" max="50" value="" />
                                    <span class="input-group-text" id="basic-addon2">°C</span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="schedule_id" id="scheduleId" value="" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                    <button type="button" class="btn btn-success btn-save-schedule">Salva</button>
                </div>
            </div>
        </div>
    </div>
</div>