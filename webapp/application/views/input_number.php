<div class="input-group mb-3">
    <div class="number number-step-input">
        <input type="button" value="-" class="button-minus" data-field="quantity">
        <input type="number" step="<?php echo isset($step) ? $step : 1; ?>" 
            max="<?php echo isset($max) ? $max : 30; ?>"
            value="<?php echo isset($value) ? $value : ''; ?>"
            name="<?php echo $name; ?>" class="quantity-field <?php echo $name; ?>">
        <input type="button" value="+" class="button-plus" data-field="quantity">
    </div>
</div>