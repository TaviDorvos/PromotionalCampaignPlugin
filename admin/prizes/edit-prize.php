<?php

if (!class_exists('PrizesTable')) {
    require_once(WP_PLUGIN_DIR . '/codesCampaign/admin/prizes/prizes-tables.php');
}

global $wpdb;

$id_prize = $_GET['id_prize'];


//QUERIES FOR GETTING THE CURRENT VALUES
$nameCurrentQuery = "SELECT name_prize FROM prizes WHERE id_prize='$id_prize'";
$quantityCurrentQuery = "SELECT quantity FROM prizes WHERE id_prize='$id_prize'";
$imageCurrentQuery = "SELECT image FROM prizes WHERE id_prize='$id_prize'";
$descriptionCurrentQuery = "SELECT description FROM prizes WHERE id_prize='$id_prize'";

$nameCurrent = $wpdb->get_var($nameCurrentQuery);
$quantityCurrent = $wpdb->get_var($quantityCurrentQuery);
$imageCurrent = $wpdb->get_var($imageCurrentQuery);
$descriptionCurrent = $wpdb->get_var($descriptionCurrentQuery);
?>

<!-- EDIT A PRIZE FORM -->
<form id="edit-prize-form" method="post">
    <input type="hidden" name="action" value="edit_prize_form_process">
    <input type="hidden" id="input-id-prize" name="input-id-prize" value=" <?php echo $id_prize ?>">
    <!-- Name of the prize -->
    <div class="form-group col-md-5">
        <label for="input-name-prize">Prize name:</label>
        <input type="text" class="form-control" id="input-name-prize" name="input-name-prize" value="<?php echo $nameCurrent ?>">
    </div>
    <!-- Available quantity -->
    <div class="form-group col-md-5">
        <label for="input-quantity">Available Stock:</label>
        <input type="text" class="form-control" id="input-quantity" name="input-quantity" value="<?php echo $quantityCurrent ?>">
    </div>
    <!-- Description -->
    <div class="form-group col-md-5">
        <label for="input-description">Description:</label>
        <input type="text" class="form-control" id="input-description" name="input-description" value="<?php echo $descriptionCurrent ?>">
    </div>
    <div class="form-group col-md-5">
        <label class="mr-5">Current Image:</label>
        <img width="150px" height="150px" src="<?php echo $imageCurrent ?>">
    </div>
    <!-- Image -->
    <div class="form-group col-md-5">
        <label for="input-edit-image">Choose new image:</label>
        <input type="file" class="form-control" id="input-edit-image" name="input-edit-image">
    </div>
    <!-- Submit button -->
    <div class="form-group col-md-6">
        <button type="submit" name="update-button" class="btn btn-primary">Update</button>
    </div>
</form>