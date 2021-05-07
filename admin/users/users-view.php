<?php

if (!class_exists('UsersTable')) {
    require_once(WP_PLUGIN_DIR . '/codesCampaign/admin/users/users-tables.php');
}
?>

<div class="wrap">
    <h1>Participants</h1>
    <br>
    <br>
    <div id="poststuff">
        <div id="post-body">

            <div id="postbox-container-2" class="postbox-container">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">

                    <div class="postbox">
                        <h2 class="hndle ui-sortable-handle">Registered participants</h2>
                        <div class="inside">
                            <?php
                            $usersTable = new UsersTable();
                            ?>

                            <form method="post" id="search">
                                <?php
                                $usersTable->prepare_items();
                                //displays the template
                                $usersTable->display(); ?>
                            </form>
                        </div>
                    </div>

                </div>
                <button id="get-winner" class="btn btn-info">Draw winners</button>
                <div id="advanced-sortables" class="meta-box-sortables ui-sortable"></div>
            </div>

        </div>
    </div>
</div>