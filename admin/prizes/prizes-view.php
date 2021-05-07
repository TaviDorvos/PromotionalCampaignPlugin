<?php

if (!class_exists('PrizesTable')) {
    require_once(WP_PLUGIN_DIR . '/codesCampaign/admin/prizes/prizes-tables.php');
}
?>

<div class="wrap">
    <h1>Prizes</h1>
    <br>
    <br>
    <div id="poststuff">
        <div id="post-body">

            <div id="postbox-container-2" class="postbox-container">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">

                    <div class="postbox">
                        <h2 class="hndle ui-sortable-handle">Available Prizes</h2>
                        <div class="inside">
                            <?php
                            $prizesTable = new PrizesTable();
                            ?>

                            <form method="post" id="search">
                                <?php
                                $prizesTable->prepare_items();
                                //displays the template
                                $prizesTable->display(); ?>
                            </form>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#add-prize">Add a new prize</button>
                <div id="advanced-sortables" class="meta-box-sortables ui-sortable"></div>
            </div>

        </div>
    </div>
</div>

<!-- MODAL FOR ADDING NEW PRIZES-->
<div id="add-prize" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6 id="modal-title" class="modal-title">Add a new prize</h6>
      </div>
      <div id="modal-body" class="modal-body">

        <!-- ADD A NEW PRIZE FORM -->
        <form id="add-prize-form" method="post">
          <input type="hidden" name="action" value="add_prize_form_process">
          <!-- Name -->
          <div class="form-group row">
            <label class="col-3" for="input-name-add">Prize name:</label>
            <input class="col-6 form-control" type="text" id="input-name-add" name="input-name-add" required>
          </div>
          <!-- Quantity -->
          <div class="form-group row">
            <label class="col-3" for="input-add-quantity">Stock:</label>
            <input class="col-6 form-control" type="text" id="input-add-quantity" name="input-add-quantity" required>
          </div>
          <!-- Description -->
          <div class="form-group row">
            <label class="col-3" for="input-add-description">Description:</label>
            <input class="col-6 form-control" type="text" id="input-add-description" name="input-add-description">
          </div>
          <!-- Image -->
          <div class="form-group row">
            <label class="col-3" for="input-add-image">Image:</label>
            <input class="col-6 form-control" type="file" id="input-add-image" name="input-add-image">
          </div>
          <br>
          <!-- Submit button -->
          <button type="submit" id="add" class="btn btn-success">Add</button>
        </form>
        <!-- Close button -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!--modal content -->
  </div>
  <!--modal dialog -->
</div>
<!--modal fade -->