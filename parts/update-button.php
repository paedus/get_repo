<?php

function get_current_theme_folder_name() {

    return isset($_POST['theme']) ? $_POST['theme'] : 'elitevoyage';

}


function get_themes_folders() {

    change_current_dir_to_themes_dir();

    $files = glob('*', GLOB_ONLYDIR);

    if( empty($files) ) $files = glob('/*', GLOB_ONLYDIR);

    return $files;

}


function the_theme_select_options($themes) {

    foreach( $themes as $theme ) {
        ?>

        <option value="<?php echo basename($theme); ?>"><?php echo basename($theme); ?></option>

        <?php
    }

}


function themes_select() {

    $themes = get_themes_folders();

    ?>

    <select name="theme" required id="theme">

        <option checked>Select Theme</option>

        <?php the_theme_select_options($themes); ?>

    </select>

    <?php

}


function change_current_dir_to_themes_dir() {

    return chdir('../wp-content/themes'); // Change server current directory to wp-content/themes

}


function check_for_old_theme() {

    change_current_dir_to_themes_dir();

    return file_exists(get_current_theme_folder_name() . ' - old');

}


function rename_old_themes() {

    if( check_for_old_theme() ) rename(get_current_theme_folder_name() . ' - old', get_current_theme_folder_name() . ' - old - ' . time()); // Setting time to old themes if there is more than one old theme

}


function rename_current_theme_to_old() {

    rename_old_themes();

    rename(get_current_theme_folder_name(), get_current_theme_folder_name() . ' - old');

}


function the_status($output) {

    ?>

    <div class="status_wrap" style="margin-top: 30px">

        <h4>Status: <?php echo $output; ?></h4>

    </div>

    <?php

}


function update_theme() {

    $output=null;

    $retval=null;

    change_current_dir_to_themes_dir();

    rename_current_theme_to_old();

    exec("git clone https://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@github.com/elitevoyage/elitevoyage.git", $out, $code);

    if( !empty($output) ) the_status($out[0]);

}


function rename_old_theme_to_current() {

    rename(get_current_theme_folder_name() . ' - old', get_current_theme_folder_name());

}


function deleteDir($dirPath) {
    if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}


function revert_theme() {

    change_current_dir_to_themes_dir();

    rename(get_current_theme_folder_name(), get_current_theme_folder_name() . ' - for remove - ' . time());

    rename_old_theme_to_current();

    rmdir(get_current_theme_folder_name() . ' - for remove - ' . time() ); // remove current live theme ( which is updated from GitHub )

}

function the_revert_button() {
    ?>
    <form action="" method="post">
        <input type="hidden" name="action" value="revert">
        <button type="submit" class="button button-secondary">Revert Old Theme</button>
    </form>
    <?php
}


function check_action() {

    $action_func_name = $_POST['action'] . '_theme'; // Running action Callback function

    $action_func_name();

}

if( isset($_POST['action']) ) check_action();

?>
<div>
    <form action="" method="post">
        <input type="hidden" name="action" value="update">
        <h3>Update live "elitevoyage" theme</h3>

        <?php //themes_select(); //disabled for now ?>

        <div style="margin-top: 35px;">
            <button type="submit" class="button button-primary">Update Theme</button>
            <h4 style="color: red;margin-top: 5px;">Only For Developers</h4>
        </div>
    </form>

    <?php ( check_for_old_theme() ) ? the_revert_button() : false;  ?>
</div>