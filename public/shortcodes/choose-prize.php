<?php

//choose a prize form
function choose_prize_form() {
    global $wpdb;

    //get all the prizes 
    $getPrizesQuery = "SELECT * FROM prizes ORDER BY id_prize";
    $getPrizesResults = $wpdb->get_results($getPrizesQuery, ARRAY_A);
?>
    <form id="choose-prize-form" method="post">
        <h1 class="text-center">Choose only one prize!</h1>
        <input type="hidden" name="action" value="choose_prize_process">
        <div class="row justify-content-center">
            <?php
            foreach ($getPrizesResults as $result) {
                if ($result['quantity'] != 0) {
            ?>
                <!-- more than 0 quantity = available prize -->
                    <input type="radio" class="sr-only" name="prize" id="<?php echo $result['id_prize'] ?>" value="<?php echo $result['id_prize'] ?>">
                    <label for="<?php echo $result['id_prize'] ?>" class="col-4 label-prize">
                        <img class="img-fluid" src="<?php echo $result['image'] ?>">
                        <p class="text-center"><?php echo $result['name_prize'] ?></p>
                    </label>
                <?php } else { ?>
                <!-- 0 quantity = prize not available-->
                    <label class="col-4 grayscale">
                        <img class="img-fluid" src="<?php echo $result['image'] ?>">
                        <p class="text-center"><?php echo $result['name_prize'] ?></p>
                    </label>
            <?php
                }
            }
            ?>
        </div> <!-- row -->
        <div class="text-center">
            <button type="submit" class="btn btn-warning">Choose the prize</button>
        </div>
    </form>
<?php }

//Creating a new shortcode
add_shortcode('choosing_prize_form', 'custom_choose_prize_shortcode');

function custom_choose_prize_shortcode() {
    ob_start();
    choose_prize_form();
    return ob_get_clean();
}
