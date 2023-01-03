<?php
if (empty($_POST['page'])) {  // Initial display
                                
    $display_modal_window = 'no-modal';  // This variable will be used in 'view_startpage.php'.
    $error_msg_username = '';
    $error_msg_signup = '';
    $error_msg_password = ''; // Set an error message into a variable.
    include('project_startpage.php');
    exit();
}

require('project_model.php');

if ($_POST['page'] == 'StartPage')
{
    $command = $_POST['command'];
    switch($command) {  
        case 'LogIn':  
            if (!user_is_valid($_POST['username'], $_POST['password'])) {
                $display_modal_window = 'login';  // Upon failure, modal will display with error messages
                $error_msg_username = '* Wrong username, or';
                $error_msg_password = '* Wrong password'; 
                include('project_startpage.php');
            } 
            else {
                session_start();
                $_SESSION['username'] = $_POST['username'];
                include('project_mainpage.php');
            }
            exit();
            break;

        case 'SignUp':  // User tries to sign up
            if (signup_new_user($_POST['username'], $_POST['password'], $_POST['email'])) {
                $display_modal_window = 'login'; 
                $error_msg_username = '';
                $error_msg_password = ''; 
                include('project_startpage.php');
            }
            else {
                $display_modal_window = 'signup';  // Upon failure, modal will display with the error messages
                $error_msg_signup = 'User exists';
                $error_msg_username = '';
                $error_msg_password = '';  
                include('project_startpage.php');
            }
            exit();
            break;
            
        default:
            echo "Unknown command from StartPage<br>";
            exit();
            break;
    }
}

else if ($_POST['page'] == 'MainPage')
{
    session_start();
    
    $command = $_POST['command'];
    switch($command) {  
        case 'LogOut':
            session_reset(); // Reset and destroy the session when user logs out
            session_destroy();
            $display_modal_window = 'none';
            include('project_startpage.php');
            exit();
            break;

        // case 'AddFriend':
        //     if(!user_exists($_POST['friend'])) { // Upon failure, search friends modal will display with the error messages
        //         echo 'User does not exist';
        //     }

        //     else {
        //         $str_friends = '';
        //         $str_friends .= ''. $_SESSION['friends'] . ', ' . $_POST['friend'];
        //         add_friend($_SESSION['username'], $str_friends);
        //         $_SESSION['friends'] = $str_friends;
        //         echo ''.$_POST['friend'] . ' was added!';
        //     }

        //     exit();
        //     break;
        
        case 'ChangeProfile':
            if(!user_exists($_POST['NewUsername'])) {
                $changeP = change_password($_SESSION['username'], $_POST['NewPassword']);
                $changeU = change_username($_SESSION['username'], $_POST['NewUsername']);
                $changeA = change_author($_SESSION['username'], $_POST['NewUsername']);
                $changeOR = change_reply_Oauthor($_SESSION['username'], $_POST['NewUsername']); // Changes to new author name for replies
                $changeR = change_reply_author($_SESSION['username'], $_POST['NewUsername']); // Changes to new author name for replies
                $_SESSION['username'] = $_POST['NewUsername'];
                echo '<br><h4>Profile was changed!<h4>';
            }
            else {
                echo '<br><h4>User already exists, cannot change profile.<h4>';
            }
            exit();
            break;

        case 'DeletePost':
            if(delete_post($_SESSION['username'], $_POST['title'])) {
                $str = '<h3>Post was deleted</h3>';
                echo $str;
            }
            
            else {
                echo 'Post does not exist or is not owned by you';
            }
            exit();
            break;
        
        case 'DeleteProfile':
            delete_user($_SESSION['username']);
            delete_all_user_posts($_SESSION['username']);
            delete_replies($_SESSION['username']);
            $display_modal_window = 'no-modal';
            session_reset(); // Reset and destroy the session when user deletes their profile
            session_destroy();
            include('project_startpage.php');
            exit();
            break;
            
        case 'WritePost':
            new_post($_POST['contents'], $_POST['title'], $_SESSION['username']);
            exit();
            break;

        case 'EditPost':
            if(edit_post($_POST['postContents'], $_POST['postTitle'], $_SESSION['username'])) {
                echo 'Post was edited';
            }

            else {
                echo "Post does not exist or was not created by you.";
            }
            //include('project_mainpage.php');
            exit();
            break;

        case 'Reply':
            if(post_exists($_POST['replyTitle']) && user_exists($_POST['replyPostAuthor'])) {
                $reply = new_reply($_POST['replyContents'], $_POST['replyTitle'], $_SESSION['username'], $_POST['replyPostAuthor']);
                echo 'Reply successfully written!';
            }
            else {
                echo 'Post does not exist.';
            }
            exit();
            break;

        case 'ShowYourPosts':
            $contents = show_your_posts($_SESSION['username']);
            $str = $contents;
            echo $str;
            exit();
            break;
        
        case 'ShowOthersPosts':
            $contents = show_others_posts($_SESSION['username']);
            $str = $contents;
            echo $str;
            exit();
            break;
            
        case 'ShowRepliesYPosts':
            $contents = show_replies_Yposts($_SESSION['username']);
            $str = $contents;
            echo $str;
            exit();
            break;
        
        case 'ShowRepliesOPosts':
            $contents = show_replies_Oposts($_SESSION['username']);
            $str = $contents;
            echo $str;
            exit();
            break;
        
        default:
            echo "Unknown command from MainPage<br>";
            exit();
            break;
    }
}

// Wrong page
else {
    echo 'Page does not exist<br>';
}
?>