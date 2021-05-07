# PromotionalCampaignPlugin

This project is a plugin I've made for WordPress using PHP, jQuery and Ajax.
For design I've used only Bootstrap and a little bit of CSS, trying to focus only on functionalities.

This plugin is helping WordPress users to easily implement a promotional campaign to their websites without coding too much. The 

## Functionalities & Screenshots
After a registration of an user, all participants who have registered with one or multiple promotional codes, along with his details, will be displayed on <i>Participants</i> menu exactly on <i>Participants</i> field on Dashboard. There is a column where the admin can see all the used codes of the participant, if it's a winning one or not and the registration date. 5 winners will be drawn randomly by pressing the button "Draw Winners" (the number of winners can be changed) and an email will be sent to the winners on the inserted email. After the draw every winning code will be crypted using MD5.
![participants](https://user-images.githubusercontent.com/73690608/117469765-c281b880-af5e-11eb-8fe2-08b1f141a353.png)
![codes-used](https://user-images.githubusercontent.com/73690608/117469761-c1e92200-af5e-11eb-86b5-01a9423c57c5.png)

On <i>Prizes</i> sub-menu, an admin can add a prize along with some informations such as: the name, description, available stock and an image of the prize. Of course the prize can be deleted or modified.
![prizes](https://user-images.githubusercontent.com/73690608/117469760-c1e92200-af5e-11eb-8039-3df74ef1e96c.png)
![edit-prize](https://user-images.githubusercontent.com/73690608/117474579-ba784780-af63-11eb-9771-35158495cc18.png)

On <i>Raffle Draw</i> submenu will be a table with all the draws that have been made so far.
![draw-dates](https://user-images.githubusercontent.com/73690608/117469759-c1508b80-af5e-11eb-90b8-dc301732fdee.png)

By clicking on the date of the raffle you can see all the winning codes and if the winners choosed their prize already or not. You can also see if the informations about the winner were been exported to an excel for delivering the prize. The export can be made easily by clicking the <i>Export</i> button.<br>
If a winner has choosed his prize the response will return under a clickable green "yes" and you can see all the informations about the winner and of the choosen prize, otherwise will be returning as unclickable red "no".
![winners](https://user-images.githubusercontent.com/73690608/117469756-c0b7f500-af5e-11eb-9c49-4aa8f67c5a9b.png)
![winner-info](https://user-images.githubusercontent.com/73690608/117469766-c281b880-af5e-11eb-8896-3039b22e3d45.png)

Of course, there will be a Statistics page where you can see some statistics about your campaign. This part is still under develop.
![Statistics](https://user-images.githubusercontent.com/73690608/117469763-c1e92200-af5e-11eb-85f1-45a5b9a09dc5.png)

## Shortcodes
- codes_campaign_contact_form <br>
This form will be the registration one, where the participants need to fill it with their informations and the available code they have.
![front-page](https://user-images.githubusercontent.com/73690608/117469768-c281b880-af5e-11eb-9563-f3112c305df3.png)

- winning_code_form <br>
This form has only one field and will accept only the winning codes in order to redirect to the choosing prize page.
![winning-page](https://user-images.githubusercontent.com/73690608/117477837-26a87a80-af67-11eb-9975-b33174042e4b.png)

- choosing_prize_form <br>
This is the choosing prize page where only the participants who have inserted their winning code to the last shortcode can access it and will let the person to choose their prize (only if is available, that means the stock has to be greater than 0, otherwise will turn into grey, unselectable).
![choose-prize](https://user-images.githubusercontent.com/73690608/117478281-9fa7d200-af67-11eb-8a30-ec1eb9de6576.png)

## How to use?
1. Download or clone this repo to your <i>'plugins'</i> directory from your website.
2. Enter to your dashboard and select `Plugins`. There it will be a plugin named <i>Codes Campaign</i>.
3. Click on `activate` and will appear 2 more new fields into your menu called <i>Participants</i>, <i>Statistics</i> and every table needed will be created automatically to your MySQL database.
4. There are 3 shortcodes you gonna implement wherever you want into your website.
    - <i>codes_campaign_contact_form</i> - registering form for the users
    - <i>winning_code_form</i> - winning form for the winning codes in order to choose their prize
    - <i>choosing_prize_form</i> - choosing prize after the code is validated as a winning one
5. In order to use shortcodes and display the forms you have to write the following code:
<br>`<?php echo do_shortcode('[the_shortcode_you_want]'); ?>`
