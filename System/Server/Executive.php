<?php
/* By Abdullah As-Sadeed */

if($TeleChirkut) {
    $is_development_mode = false;

    $includings_path = '../../Server/PHP_Includings/';
    $user_uploads_path = '../../../User_Uploads/';

    require_once $includings_path.'Manually_Required/Shell_Execution_Variables.php';

    date_default_timezone_set('UTC');

    foreach(glob($includings_path.'*.php') as $php_including) {
        require_once $php_including;
    }

    $javascript_nonce = 'aTeg3yvCGbMLcoMKHqR29ksn';
    header("Content-Security-Policy: script-src 'self' 'unsafe-eval' 'nonce-".$javascript_nonce."'; script-src-elem 'self' 'unsafe-eval'; script-src-attr 'self' 'unsafe-eval'; img-src 'self' data:; font-src 'self'; connect-src 'self'; media-src 'self'; object-src 'none'; child-src 'none'; frame-src 'none'; worker-src 'self'; frame-ancestors 'none'; form-action 'self'; upgrade-insecure-requests; block-all-mixed-content; sandbox allow-forms allow-same-origin allow-scripts allow-top-navigation allow-popups; base-uri 'self'; manifest-src 'self'");

    require_once $includings_path.'Manually_Required/Paired_Cookies_CareTaker.php';
    Ensure_Paired_Cookies();

    require_once $includings_path.'Manually_Required/DataBase_Connector.php';
    Connect_DataBase();

    require_once $includings_path.'Manually_Required/Registration_Evaluator.php';
    $registration = Evaluate_Registration();

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['sitemap'])) {
        require_once $includings_path.'Manually_Required/SiteMap_Generator.php';

        header('Content-type: text/xml');
        echo Generate_SiteMap();
    } elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['javascript'])) {
        $time = Sanitize_String($_GET['javascript']);

        if(intval($time)) {
            require_once $includings_path.'Manually_Required/JavaScript_Bundler.php';

            header('Content-type: application/javascript');
            echo Bundle_JavaScript($is_development_mode);
        } else {
            http_response_code(404);
        }
    } elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['public'])) {
        $public = Sanitize_String($_GET['public']);

        if($public == 'registration') {
            if(!$registration) {
                require_once $includings_path.'Manually_Required/Registration_Page_Generator.php';

                echo Generate_Registration_Page();
            } elseif($registration) {
                header('Location: /');
            }
        } elseif($public == 'rules') {
            require_once $includings_path.'Manually_Required/Rules_Printer.php';

            echo Print_Rules(true);
        } else {
            http_response_code(404);
        }
    } elseif($registration && $_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['image_message'])) {
        $serial = Sanitize_String($_GET['image_message']);

        require_once $includings_path.'Manually_Required/Image_Message_Retriever.php';

        $file = Retrieve_Image_Message($serial);

        if(!$file) {
            http_response_code(404);
        } else {
            header('Cache-Control: max-age=86400');
            header('Expires: '.gmdate("D, d M Y H:i:s \G\M\T", time() + 3600));
            header('Content-type: image/webp');

            readfile($file);
        }
    } elseif(isset($_GET['face_logo'])) {
        $profile_code = Sanitize_String($_GET['face_logo']);

        require_once $includings_path.'Manually_Required/Face_Logo_Retriever.php';

        $file = Retrieve_Face_Logo($profile_code);

        if(!$file) {
            http_response_code(404);
        } else {
            header('Cache-Control: max-age=86400');
            header('Expires: '.gmdate("D, d M Y H:i:s \G\M\T", time() + 3600));
            header('Content-type: image/webp');

            readfile($file);
        }
    } elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['post_image'])) {
        $serial = Sanitize_String($_GET['post_image']);

        require_once $includings_path.'Manually_Required/Post_Image_Retriever.php';

        $file = Retrieve_Post_Image($serial);

        if(!$file) {
            http_response_code(404);
        } else {
            header('Cache-Control: max-age=86400');
            header('Expires: '.gmdate("D, d M Y H:i:s \G\M\T", time() + 3600));
            header('Content-type: image/webp');

            readfile($file);
        }
    } elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['error'])) {
        require_once $includings_path.'Manually_Required/Error_Page_Generator.php';

        $error_code = Sanitize_String($_GET['error']);

        if($error_code == 403) {
            http_response_code(403);
            echo Generate_Error_Page($error_code, 'You are not permitted to request this!');
        } elseif($error_code == 404) {
            http_response_code(404);
            echo Generate_Error_Page($error_code, 'Your request was invalid!');
        } else {
            http_response_code(404);
        }
    } elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['notify_unseen_counts'])) {
        require_once $includings_path.'Manually_Required/Unseen_Counts_Notifier.php';

        header('Content-Type: application/json');
        echo Notify_Unseen_Counts();
    } elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['clean'])) {
        require_once $includings_path.'Manually_Required/Cleaner.php';

        header('Content-Type: application/json');
        echo Clean();
    } elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['reset_test_user_password'])) {
        require_once $includings_path.'Manually_Required/Test_User_PassWord_Resetter.php';

        echo Reset_Test_User_PassWord();
    } elseif($_SERVER['REQUEST_METHOD'] == 'POST' && !$registration && isset($_POST['password']) && isset($_POST['retyped_password']) && isset($_POST['full_name']) && isset($_POST['timezone']) && isset($_POST['introduction']) && isset($_POST['recovery_email_address']) && is_uploaded_file($_FILES['face_logo']['tmp_name'])) {
        $full_name = Sanitize_String($_POST['full_name']);
        $timezone = Sanitize_String($_POST['timezone']);
        $introduction = Sanitize_String($_POST['introduction']);
        $password = Sanitize_String($_POST['password']);
        $retyped_password = Sanitize_String($_POST['retyped_password']);
        $recovery_email_address = Sanitize_String($_POST['recovery_email_address']);

        require_once $includings_path.'Manually_Required/Registration.php';

        header('Content-Type: application/json');
        echo Register($full_name, $timezone, $introduction, $password, $retyped_password, $recovery_email_address);
    } elseif($_SERVER['REQUEST_METHOD'] == 'POST' && !$registration && isset($_POST['profile_code']) && isset($_POST['password'])) {
        require_once $includings_path.'Manually_Required/Logger_In.php';

        $profile_code = Sanitize_String($_POST['profile_code']);
        $password = Sanitize_String($_POST['password']);

        header('Content-Type: application/json');
        echo Log_In($profile_code, $password);
    } elseif($_SERVER['REQUEST_METHOD'] == 'POST' && $registration && isset($_POST['type'])) {
        require_once $includings_path.'Manually_Required/Registered_POST_Request_Handler.php';

        echo Handle_Registered_POST_Requests();
    } elseif($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['client_caches'])) {
        require_once $includings_path.'Manually_Required/Client_Caches_Lister.php';

        header('Content-Type: application/json');
        echo List_Client_Caches();
    } elseif($_SERVER['REQUEST_METHOD'] == 'POST' && !$registration && isset($_POST['type'])) {
        $type = Sanitize_String($_POST['type']);

        if($type == "PassWord_Recovery_1" && isset($_POST['profile_code'])) {
            $profile_code = Sanitize_String($_POST['profile_code']);

            require_once $includings_path.'Manually_Required/PassWord_Recovery_Initiator.php';

            header('Content-Type: application/json');
            echo Initiate_PassWord_Recovery($profile_code);
        } elseif($type == "PassWord_Recovery_2" && isset($_POST['profile_code']) && isset($_POST['verification_code']) && isset($_POST['authentication_code']) && isset($_POST['new_password']) && isset($_POST['retyped_password'])) {
            $profile_code = Sanitize_String($_POST['profile_code']);
            $verification_code = Sanitize_String($_POST['verification_code']);
            $authentication_code = Sanitize_String($_POST['authentication_code']);
            $new_password = Sanitize_String($_POST['new_password']);
            $retyped_password = Sanitize_String($_POST['retyped_password']);

            require_once $includings_path.'Manually_Required/PassWord_Recoverer.php';

            header('Content-Type: application/json');
            echo Recover_PassWord($profile_code, $verification_code, $authentication_code, $new_password, $retyped_password);
        } else {
            http_response_code(404);
        }
    } else {
        if(!$registration) {
            echo Generate_Page('TeleChirkut', 'A social network, built from scratch, for a better world', '', false, false, ''); /* home */
        } elseif($registration) {
            require_once $includings_path.'Manually_Required/Client_Page_Generator.php';

            echo Generate_Client_Page();
        }
    }

    pg_close($connection);
}

exit();