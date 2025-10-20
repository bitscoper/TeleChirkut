<?php
/* By Abdullah As-Sadeed */

function Generate_Registration_Page()
{
    $includings_path = $GLOBALS['includings_path'];
    require_once $includings_path . 'Manually_Required/TimeZone_Select_Generator.php';

    $additional_css = 'body {
background-color: var(--back-light);
}';

    $body = '<div id="sub_header">
<h4>Register and Be Connected</h4>
</div>
<form id="registration_form" id="registration_form">
<span class="field">
<span class="field_heading">Full Name</span>
<input type="text" autocomplete="off" name="full_name" placeholder="Full Name" title="Enter Full Name"/>
</span>
<span class="field">
<span class="field_heading">Timezone</span>' . Generate_TimeZone_Select() . '</span>
<span class="field">
<span class="field_heading" id="face_logo_heading">Snap of face</span>
<input type="file" accept="image/*" name="face_logo" id="registration_image_selector"/>
<div id="face_logo_editor"></div>
<div class="face_logo_editor_actions">
<label class="button" title="Upload A Snap" for="registration_image_selector">Upload</label>
<label class="button" title="Rotate By -90 Degree" id="rotate_negative">↻</label>
<label class="button" title="Rotate By 90 Degree" id="rotate_positive">↺</label>
</div>
</span>
<span class="field">
<span class="field_heading">Introduction</span>
<textarea autocomplete="off" name="introduction" placeholder="Introduction" title="Enter Introduction"></textarea>
</span>
<span class="field">
<span class="field_heading">Password</span>
<input type="password" name="password" title="Enter Password" placeholder="Password" autocomplete="off"/>
</span>
<span class="field">
<span class="field_heading">Re-enter Password</span>
<input type="password" name="retyped_password" title="Re-enter Password" placeholder="Re-enter Password" autocomplete="off"/>
</span>
<span class="field">
<span class="field_heading">Recovery Email Address</span>
<input type="email" autocomplete="off" name="recovery_email_address" placeholder="Recovery Email Address" title="Enter an email address which you want to use in case of account recovery"/>
</span>
<div id="instruction">
You are agreeing to the <a href="rules" title="Read the TeleChirkut Rules" target="new">TeleChirkut Rules</a>.
</div>
<input type="submit" value="Register" title="Register" class="button"/>
</form>';

    return Generate_Page('Registration - TeleChirkut', 'Register on TeleChirkut and be connected', $additional_css, false, true, $body);
}