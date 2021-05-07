<?php

if (!class_exists('ExtractedDatesTable')) {
    require_once(WP_PLUGIN_DIR . '/codesCampaign/admin/winners/winners-tables.php');
}
?>

<div class="wrap">
    <h1>Draw dates</h1>
    <br>
    <br>
    <div id="poststuff">
        <div id="post-body">

            <div id="postbox-container-2" class="postbox-container">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">

                    <div class="postbox">
                        <h2 class="hndle ui-sortable-handle">Draw dates</h2>
                        <div class="inside">
                            <?php
                            $extractedDatesTable = new ExtractedDatesTable();
                            ?>

                            <form method="post" id="search">
                                <?php
                                $extractedDatesTable->prepare_items();
                                //displays the template
                                $extractedDatesTable->display(); ?>
                            </form>
                        </div>
                    </div>

                </div>
                <div id="advanced-sortables" class="meta-box-sortables ui-sortable"></div>
            </div>

        </div>
    </div>
</div>