<?php
//Front form Shortcode
function contact_form() { ?>
    <form id="contact-form" method="post">
        <input type="hidden" name="action" value="adding_details_process">
        <!-- Nume de familie -->
        <div class="form-group d-md-flex justify-content-center text-center">
            <label class="col-6 col-md-3 col-lg-2 mb-0" for="input-last-name">*Last Name:</label>
            <input type="text" class="form-control col-6 col-md-5 text-center text-md-left mx-auto mx-md-0" id="input-last-name" name="input-last-name">
        </div>
        <!-- Prenume -->
        <div class="form-group d-md-flex justify-content-center text-center">
            <label class="col-6 col-md-3 col-lg-2 mb-0" for="input-first-name">*First Name:</label>
            <input type="text" class="form-control col-6 col-md-5 text-center text-md-left mx-auto mx-md-0" id="input-first-name" name="input-first-name">
        </div>
        <!-- Telefon -->
        <div class="form-group d-md-flex justify-content-center text-center">
            <label class="col-6 col-md-3 col-lg-2 mb-0" for="input-phone">*Phone:</label>
            <input type="text" class="form-control col-6 col-md-5 text-center text-md-left mx-auto mx-md-0" id="input-phone" name="input-phone" minlength="10" maxlength="10">
        </div>
        <!-- Email -->
        <div class="form-group d-md-flex justify-content-center text-center">
            <label class="col-6 col-md-3 col-lg-2 mb-0" for="input-email">*Email:</label>
            <input type="email" class="form-control col-6 col-md-5 text-center text-md-left mx-auto mx-md-0" id="input-email" name="input-email" >
        </div>
        <!-- Tara -->
        <div class="form-group d-md-flex justify-content-center text-center">
            <label class="col-6 col-md-3 col-lg-2 mb-0" for="input-country">Country</label>
            <input type="text" class="form-control col-6 col-md-5 text-center text-md-left mx-auto mx-md-0" id="input-country" name="input-country" value="România" readonly>
        </div>
        <!-- Judet -->
        <div class="form-group d-md-flex justify-content-center text-center">
            <label class="col-6 col-md-3 col-lg-2 mb-0" for="input-county">*County:</label>
            <select class="form-control col-6 col-md-5 text-center text-md-left mx-auto mx-md-0" name="input-county" id="input-county">
                <option value="AB">Alba</option>
                <option value="AG">Argeș</option>
                <option value="AR">Arad</option>
                <option value="B">București</option>
                <option value="BC">Bacău</option>
                <option value="BH">Bihor</option>
                <option value="BN">Bistrița</option>
                <option value="BR">Brăila</option>
                <option value="BT">Botoșani</option>
                <option value="BV">Brașov</option>
                <option value="BZ">Buzău</option>
                <option value="CJ">Cluj</option>
                <option value="CL">Călărași</option>
                <option value="CS">Caras-Severin</option>
                <option value="CT">Constanța</option>
                <option value="CV">Covasna</option>
                <option value="DB">Dâmbovița</option>
                <option value="DJ">Dolj</option>
                <option value="GJ">Gorj</option>
                <option value="GL">Galați</option>
                <option value="GR">Giurgiu</option>
                <option value="HD">Hunedoara</option>
                <option value="HG">Harghita</option>
                <option value="IF">Ilfov</option>
                <option value="IL">Ialomița</option>
                <option value="IS">Iași</option>
                <option value="MH">Mehedinți</option>
                <option value="MM">Maramureș</option>
                <option value="MS">Mureș</option>
                <option value="NT">Neamț</option>
                <option value="OT">Olt</option>
                <option value="PH">Prahova</option>
                <option value="SB">Sibiu</option>
                <option value="SJ">Sălaj</option>
                <option value="SM">Satu-Mare</option>
                <option value="SV">Suceava</option>
                <option value="TL">Tulcea</option>
                <option value="TM">Timiș</option>
                <option value="TR">Teleorman</option>
                <option value="VL">Vâlcea</option>
                <option value="VN">Vrancea</option>
                <option value="VS">Vaslui</option>
            </select>
        </div>
        <!-- Localitate -->
        <div class="form-group d-md-flex justify-content-center text-center">
            <label class="col-6 col-md-3 col-lg-2 mb-0" for="input-city">*City:</label>
            <input type="text" class="form-control col-6 col-md-5 text-center text-md-left mx-auto mx-md-0" id="input-city" name="input-city" required>
        </div>
        <!-- Adresa -->
        <div class="form-group d-md-flex justify-content-center text-center">
            <label class="col-6 col-md-3 col-lg-2 mb-0" for="input-address">*Address:</label>
            <input type="text" class="form-control col-6 col-md-5 text-center text-md-left mx-auto mx-md-0" id="input-address" name="input-address" required>
        </div>
        <!-- Codul promotional -->
        <div class="form-group d-md-flex justify-content-center text-center">
            <label class="col-6 col-md-3 col-lg-2 mb-0" for="input-code">*Promotional Code:</label>
            <input type="text" class="form-control col-6 col-md-5 text-center text-md-left mx-auto mx-md-0" id="input-code" name="input-code" required>
        </div>
        <div class="form-group d-md-flex justify-content-center text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
            <img class="loader" style="display: none;" src="wp-content/plugins/codesCampaign/public/assets/images/loader1.gif">
        </div>
    </form>
<?php }

//Creating a new shortcode
add_shortcode('codes_campaign_contact_form', 'custom_contact_form_shortcode');

function custom_contact_form_shortcode() {
    ob_start();
    contact_form();
    return ob_get_clean();
}