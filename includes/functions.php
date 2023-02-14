<?php


/**
 * Display the feedback after a typical form submission
 * @param string $message the feedback message for the user
 * @param string $class the CSS class for the feedback div - use 'error' or 'success'
 * @param array $list the list of error issues
 * @return mixed HTML output
 */
function show_feedback(&$message, &$class, $list = array())
{
    if (isset($message)) { ?>
        <div class="alert alert-<?php echo $class; ?> text-white block">
            <h5 class="text-xl font-semibold"><?php if($class == 'error') { echo <i class="fa-light fa-circle-exclamation"></i>; }else{ echo <i class="fa-light fa-circle-check"></i>; } ?><?php echo $message; ?></h5>
            <?php if (!empty($list)) {

                echo '<ul>';
                foreach ($list as $item) {
                    echo "<li>$ast; $item</li>";
                }
                echo '</ul>';
            } ?>
        </div>
    <?php }

}

/**
 * Sanitize a string by stripping tags
 * @param string $dirty the untrusted string
 * @return string       the string with tags removed and trimmed
 */
function clean_string($dirty)
{
    return trim(strip_tags($dirty));
}
/**
 * 
 */
function clean_int($dirty)
{
    return filter_var($dirty, FILTER_SANITIZE_NUMBER_INT);
}
/**
 * 
 */
function clean_boolean(&$dirty)
{
    if ($dirty) {
        return 1;
    } else {
        return 0;
    }
}




/**
 * Output a class on a form input that triggered an error
 * @param string $field the name of the field we're checking
 * @param array $list the list of all errors on the form
 * @return string   css class 'field-error'
 */
function field_error($field, $list = array())
{
    if (isset($list[$field])) {
        echo 'input-error';
    }
}


