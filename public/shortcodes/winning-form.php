<?php
//Front form Shortcode
function win_code_form() { ?>
    <form id="winning-code-form" method="post">
        <input type="hidden" name="action" value="winning_code_process">
        <!-- Codul promotional -->
        <div class="form-group col-md-6">
            <label for="input-win-code">*Winning Code:</label>
            <input type="text" class="form-control" id="input-win-code" name="input-win-code" placeholder="Codul promotional" required>
        </div>
        <div class="form-group col-md-6">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
<?php }

//Creating a new shortcode
add_shortcode('winning_code_form', 'custom_win_code_shortcode');

function custom_win_code_shortcode() {
    ob_start();
    win_code_form();
    return ob_get_clean();
}
