<?php

if (!class_exists('WinnersTable')) {
    require_once(WP_PLUGIN_DIR . '/codesCampaign/admin/winners/winners-tables.php');
}

?>

<div class="wrap">
    <h1>Winners</h1>
    <br>
    <br>
    <div id="poststuff">
        <div id="post-body">

            <div id="postbox-container-2" class="postbox-container">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">

                    <div class="postbox">
                        <h2 class="hndle ui-sortable-handle">Extracted winners</h2>
                        <div class="inside">
                            <?php
                            $winnersTable = new WinnersTable();
                            ?>

                            <form method="post" id="search">
                                <?php
                                $winnersTable->prepare_items();
                                //displays the template
                                $winnersTable->display(); ?>
                            </form>
                        </div>
                    </div>

                </div>
                <button id="export" class="btn btn-info">Export winners</button>
                <div id="advanced-sortables" class="meta-box-sortables ui-sortable"></div>
            </div>

        </div>
    </div>
</div>