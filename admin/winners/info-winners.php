<?php

if (!class_exists('InfoWinnersTable')) {
    require_once(WP_PLUGIN_DIR . '/codesCampaign/admin/winners/winners-tables.php');
}
?>

<div class="wrap">
    <h1>Winner informations</h1>
    <br>
    <br>
    <div id="poststuff">
        <div id="post-body">

            <div id="postbox-container-2" class="postbox-container">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">

                    <div class="postbox">
                        <h2 class="hndle ui-sortable-handle">Winner informations</h2>
                        <div class="inside">
                            <?php
                            $infoWinnersTable = new InfoWinnersTable();
                            ?>

                            <form method="post" id="search">
                                <?php
                                $infoWinnersTable->prepare_items();
                                //displays the template
                                $infoWinnersTable->display(); ?>
                            </form>
                        </div>
                    </div>

                </div>
                <div id="advanced-sortables" class="meta-box-sortables ui-sortable"></div>
            </div>

        </div>
    </div>
</div>