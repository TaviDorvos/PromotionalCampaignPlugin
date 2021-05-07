<?php

if (!class_exists('UsedCodesTable')) {
    require_once(WP_PLUGIN_DIR . '/codesCampaign/admin/users/users-tables.php');
}
?>

<div class="wrap">
    <h1>Codes used</h1>
    <br>
    <br>
    <div id="poststuff">
        <div id="post-body">

            <div id="postbox-container-2" class="postbox-container">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">

                    <div class="postbox">
                        <h2 class="hndle ui-sortable-handle">Codes used</h2>
                        <div class="inside">
                            <?php
                            $usedCodeTable = new UsedCodesTable();
                            ?>

                            <form method="post" id="search">
                                <?php
                                $usedCodeTable->prepare_items();
                                //displays the template
                                $usedCodeTable->display(); ?>
                            </form>
                        </div>
                    </div>

                </div>
                <div id="advanced-sortables" class="meta-box-sortables ui-sortable"></div>
            </div>

        </div>
    </div>
</div>