<div class="header-container mb-3">
    <div class="row">
        <div class="d-none d-sm-block col-sm-4  box-header text-center" id="currentDateTime">
            <?php echo $this->load->view('current_date_time',array(),TRUE); ?>
        </div>
        <div class="col-xs-12 col-sm-4 text-center">
            <div class="controls">
                <button type="button" class="btn-circle btn-status-manual-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-index" viewBox="0 0 16 16">
                        <path d="M6.75 1a.75.75 0 0 1 .75.75V8a.5.5 0 0 0 1 0V5.467l.086-.004c.317-.012.637-.008.816.027.134.027.294.096.448.182.077.042.15.147.15.314V8a.5.5 0 1 0 1 0V6.435a4.9 4.9 0 0 1 .106-.01c.316-.024.584-.01.708.04.118.046.3.207.486.43.081.096.15.19.2.259V8.5a.5.5 0 0 0 1 0v-1h.342a1 1 0 0 1 .995 1.1l-.271 2.715a2.5 2.5 0 0 1-.317.991l-1.395 2.442a.5.5 0 0 1-.434.252H6.035a.5.5 0 0 1-.416-.223l-1.433-2.15a1.5 1.5 0 0 1-.243-.666l-.345-3.105a.5.5 0 0 1 .399-.546L5 8.11V9a.5.5 0 0 0 1 0V1.75A.75.75 0 0 1 6.75 1zM8.5 4.466V1.75a1.75 1.75 0 1 0-3.5 0v5.34l-1.2.24a1.5 1.5 0 0 0-1.196 1.636l.345 3.106a2.5 2.5 0 0 0 .405 1.11l1.433 2.15A1.5 1.5 0 0 0 6.035 16h6.385a1.5 1.5 0 0 0 1.302-.756l1.395-2.441a3.5 3.5 0 0 0 .444-1.389l.271-2.715a2 2 0 0 0-1.99-2.199h-.581a5.114 5.114 0 0 0-.195-.248c-.191-.229-.51-.568-.88-.716-.364-.146-.846-.132-1.158-.108l-.132.012a1.26 1.26 0 0 0-.56-.642 2.632 2.632 0 0 0-.738-.288c-.31-.062-.739-.058-1.05-.046l-.048.002zm2.094 2.025z" />
                    </svg>
                </button>
                <div class="switch-status-container">
                    <div class="my-switch-icon <?php echo $global_state == '1' ? 'off' : ''; ?>" id="globalSwitchOff">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
                            <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
                        </svg>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switchGeneralStatus" <?php echo $global_state == '1' ? 'checked' : ''; ?>>
                    </div>
                    <div class="my-switch-icon <?php echo $global_state == '0' ? 'off' : ''; ?>" id="globalSwitchOn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-snow" viewBox="0 0 16 16">
                            <path d="M8 16a.5.5 0 0 1-.5-.5v-1.293l-.646.647a.5.5 0 0 1-.707-.708L7.5 12.793V8.866l-3.4 1.963-.496 1.85a.5.5 0 1 1-.966-.26l.237-.882-1.12.646a.5.5 0 0 1-.5-.866l1.12-.646-.884-.237a.5.5 0 1 1 .26-.966l1.848.495L7 8 3.6 6.037l-1.85.495a.5.5 0 0 1-.258-.966l.883-.237-1.12-.646a.5.5 0 1 1 .5-.866l1.12.646-.237-.883a.5.5 0 1 1 .966-.258l.495 1.849L7.5 7.134V3.207L6.147 1.854a.5.5 0 1 1 .707-.708l.646.647V.5a.5.5 0 1 1 1 0v1.293l.647-.647a.5.5 0 1 1 .707.708L8.5 3.207v3.927l3.4-1.963.496-1.85a.5.5 0 1 1 .966.26l-.236.882 1.12-.646a.5.5 0 0 1 .5.866l-1.12.646.883.237a.5.5 0 1 1-.26.966l-1.848-.495L9 8l3.4 1.963 1.849-.495a.5.5 0 0 1 .259.966l-.883.237 1.12.646a.5.5 0 0 1-.5.866l-1.12-.646.236.883a.5.5 0 1 1-.966.258l-.495-1.849-3.4-1.963v3.927l1.353 1.353a.5.5 0 0 1-.707.708l-.647-.647V15.5a.5.5 0 0 1-.5.5z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 text-center box-header" id="roofTemp">
        </div>
    </div>
</div>
<div class="rooms-container">
</div>
<div class="modal" tabindex="-1" id="modalRoomSettings">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Chiudi</button>
                <button type="button" class="btn btn-success btn-save-room-settings">Salva</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="modalManualSettings">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Impostazione manuale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label for="temp" class="form-label"><strong>Durata</strong></label>
                        <?php echo $this->load->view('input_number', array('name'=>'manual-duration','value'=>1), TRUE); ?>
                    </div>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check quick-duration" name="btnradio" id="btnradio1" autocomplete="off" value="1" checked>
                        <label class="btn btn-outline-light" for="btnradio1">1 ora</label>
                        <input type="radio" class="btn-check quick-duration" name="btnradio" id="btnradio2" autocomplete="off2" value="2">
                        <label class="btn btn-outline-light" for="btnradio2">2 ore</label>
                        <input type="radio" class="btn-check quick-duration" name="btnradio" id="btnradio3" autocomplete="off2" value="3">
                        <label class="btn btn-outline-light" for="btnradio3">3 ore</label>
                        <input type="radio" class="btn-check quick-duration" name="btnradio" id="btnradio4" autocomplete="off2" value="4">
                        <label class="btn btn-outline-light" for="btnradio4">4 ore</label>
                        <input type="radio" class="btn-check quick-duration" name="btnradio" id="btnradio0" autocomplete="off2" value="0">
                        <label class="btn btn-outline-light" for="btnradio0">Indeterminato</label>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <label for="temp" class="form-label"><strong>Temperatura</strong></label>
                        <?php echo $this->load->view('input_number', array('name'=>'temp','value'=>20,'step'=>0.5), TRUE); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-success" id="btnConfirmManualSettings">Conferma</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="modalRoom">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button" role="tab" aria-controls="manual" aria-selected="true">Manuale</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="rule-tab" data-bs-toggle="tab" data-bs-target="#rule" type="button" role="tab" aria-controls="rule" aria-selected="false">Automatico</button>
                    </li>
                </ul>
                <div class="tab-content justify-content-center" id="myTabContent">
                    <div class="tab-pane fade show active text-center" id="manual" role="tabpanel" aria-labelledby="manual-tab">
                        <br />
                        <div class="row">
                            <div class="col">
                                <label for="temp" class="form-label"><strong>Durata</strong></label>
                                <?php echo $this->load->view('input_number', array('name'=>'manual-duration','value'=>1), TRUE); ?>
                            </div>
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check quick-duration" name="btnradio" id="btnquick1" autocomplete="off" value="1" checked>
                                <label class="btn btn-outline-light" for="btnquick1">1 ora</label>
                                <input type="radio" class="btn-check quick-duration" name="btnradio" id="btnquick2" autocomplete="off2" value="2">
                                <label class="btn btn-outline-light" for="btnquick2">2 ore</label>
                                <input type="radio" class="btn-check quick-duration" name="btnradio" id="btnquick3" autocomplete="off2" value="3">
                                <label class="btn btn-outline-light" for="btnquick3">3 ore</label>
                                <input type="radio" class="btn-check quick-duration" name="btnradio" id="btnquick4" autocomplete="off2" value="4">
                                <label class="btn btn-outline-light" for="btnquick4">4 ore</label>
                                <input type="radio" class="btn-check quick-duration" name="btnradio" id="btnquick0" autocomplete="off2" value="0">
                                <label class="btn btn-outline-light" for="btnquick0">Indeterminato</label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <label for="temp" class="form-label"><strong>Temperatura</strong></label>
                                <?php echo $this->load->view('input_number', array('name'=>'temp','value'=>20,'step'=>0.5), TRUE); ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="rule" role="tabpanel" aria-labelledby="rule-tab">
                        <br />
                        <label for="temp" class="form-label"><strong>Regola</strong></label>
                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg" id="ruleSelect">
                            <?php foreach ($rules as $key => $rule) : ?>
                                <option value="<?php echo $rule['id']; ?>"><?php echo $rule['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annulla</button>
                <button type="button" class="btn btn-success" id="btnConfirmRoomMode">Conferma</button>
            </div>
        </div>
    </div>
</div>