<?php
$conn = mysqli_connect('localhost', 'isarkor', 'isarkor136', 'C354_isarkor');

function user_is_valid($u, $p) 
{
    global $conn;
    
    $sql = "SELECT * FROM ProjectUsers WHERE Username = '$u' and Password = '$p'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}

function user_exists($u) // Checks to see if a user exists in the Database
{
    global $conn;
    
    $sql = "SELECT * FROM ProjectUsers WHERE Username = '$u'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}

function post_exists($t) 
{
    global $conn;
    
    $sql = "SELECT * FROM ProjectPosts WHERE Title = '$t'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}

function edit_post_check($t, $a) {
    global $conn;
    
    $sql = "SELECT * FROM ProjectPosts WHERE Title = '$t' AND Author = '$a'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}

// function get_friends($u)
// {
//     global $conn;

//     $sql = "SELECT * FROM ProjectUsers WHERE Username = '$u'";
//     $result = mysqli_query($conn, $sql);
//     $friends = '';

//     while($row = mysqli_fetch_assoc($result)) {
//         $friends .= ''. $row['Friends'];
//     }

//     return $friends;
// }

function signup_new_user($u, $p, $e)
{
    global $conn;
    
    if (user_exists($u))
        return false;
    
    $current_date = date("Ymd");
    $friends = '';
    $sql = "INSERT INTO ProjectUsers VALUES (NULL, '$u', '$p', '$friends', '$e', $current_date)";
    $result = mysqli_query($conn, $sql);
    return true;
}

function delete_all_user_posts($a) {
    global $conn;
        
    $sql = "DELETE FROM ProjectPosts WHERE Author = '$a'";
    $result = mysqli_query($conn, $sql);
    return true;
}

function delete_replies($a) {
    global $conn;
        
    $sql = "DELETE FROM ProjectReplies WHERE Author = '$a'";
    $result = mysqli_query($conn, $sql);
    return true;
}

function delete_user($u) {
    global $conn;
        
    $sql = "DELETE FROM ProjectUsers WHERE Username = '$u'";
    $result = mysqli_query($conn, $sql);
    return true;
}

function new_post($c, $t, $a) {
    global $conn;
    $sql = "INSERT INTO ProjectPosts VALUES (NULL, '$t', '$c', '$a')";
    $result = mysqli_query($conn, $sql);
}

function new_reply($r, $t, $a, $o) {
    global $conn;
    $sql = "INSERT INTO ProjectReplies VALUES (NULL, '$a', '$r', '$t', '$o')";
    $result = mysqli_query($conn, $sql);
}

function show_your_posts($u) {
    global $conn;
    $sql = "SELECT * FROM ProjectPosts WHERE Author = '$u'";
    $result = mysqli_query($conn, $sql);
    $data = '';

    while($row = mysqli_fetch_assoc($result)) {
        $data .= '<h3>' . $row['Title'] . '</h3>';
        $data .= 'Written by: ' . $row['Author'] . '<br>';
        $data .= '<p>' . $row['Contents'] . '</p>';
        $data .= '<br><br>';
    }
    return $data;
}

function show_others_posts($u) {
    global $conn;

    $sql = "SELECT * FROM ProjectPosts WHERE NOT Author = '$u'";
    $result = mysqli_query($conn, $sql);
    $data = '';

    while($row = mysqli_fetch_assoc($result)) {
        $data .= '<h3>' . $row['Title'] . '</h3>';
        $data .= 'Written by: ' . $row['Author'] . '<br>';
        $data .= '<p>' . $row['Contents'] . '</p>';
        $data .= '<br><br>';
    }
    return $data;
}

function show_replies_Yposts($u) {
    global $conn;

    $sql = "SELECT * FROM ProjectReplies WHERE PostAuthor = '$u'";
    $result = mysqli_query($conn, $sql);
    $data = '';

    while($row = mysqli_fetch_assoc($result)) {
        $data .= '<h3>@' . $row['PostAuthor'] . '</h3>';
        $data .= '<h5>RE: ' . $row['Title'] . '</h5>';
        $data .= '<h6>Written by: ' . $row['Author'] . '</h6>';
        $data .= '<p>' . $row['Reply'] . '</p>';
        $data .= '<br><br>';
    }
    return $data;
}

function show_replies_Oposts($u) {
    global $conn;

    $sql = "SELECT * FROM ProjectReplies WHERE NOT PostAuthor = '$u'";
    $result = mysqli_query($conn, $sql);
    $data = '';

    while($row = mysqli_fetch_assoc($result)) {
        $data .= '<h3>@' . $row['PostAuthor'] . '</h3>';
        $data .= '<h5>RE: ' . $row['Title'] . '</h5>';
        $data .= '<h6>Written by: ' . $row['Author'] . '</h6>';
        $data .= '<p>' . $row['Reply'] . '</p>';
        $data .= '<br><br>';
    }
    return $data;
}

function delete_post($a, $t) {
    global $conn;
    $sql = "DELETE FROM ProjectPosts WHERE Author = '$a' AND Title = '$t'";
    $result = mysqli_query($conn, $sql);

    return $result;
}

function edit_post($c, $t, $a) {
    global $conn;

    if(edit_post_check($t, $a)) {
    $sql = "UPDATE ProjectPosts SET Contents = '$c' WHERE Title = '$t' AND Author = '$a'";
    mysqli_query($conn, $sql);

    return true;
    }

    else {
        return false;
    }
}

function change_author($u, $n) {
    global $conn;
    $sql = "UPDATE ProjectPosts SET Author = '$n' WHERE Author = '$u'";
    $result = mysqli_query($conn, $sql);

    return $result;
}

function change_reply_Oauthor($u, $n) {
    global $conn;
    $sql = "UPDATE ProjectReplies SET PostAuthor = '$n' WHERE PostAuthor = '$u'";
    $result = mysqli_query($conn, $sql);

    return $result;
}

function change_reply_author($u, $n) {
    global $conn;
    $sql = "UPDATE ProjectReplies SET Author = '$n' WHERE Author = '$u'";
    $result = mysqli_query($conn, $sql);

    return $result;
}

// function add_friend($u, $f) {
//     global $conn;
//     $sql = "UPDATE ProjectUsers SET Friends = '$f' WHERE Username = '$u'";
//     $result = mysqli_query($conn, $sql);
// }

function change_username($u, $n) {
    global $conn;
    $sql = "UPDATE ProjectUsers SET Username = '$n' WHERE Username = '$u'";
    $result = mysqli_query($conn, $sql);

    return $result;
}

function change_password($u, $p) {
    global $conn;
    $sql = "UPDATE ProjectUsers SET Password = '$p' WHERE Username = '$u'";
    $result = mysqli_query($conn, $sql);

    return $result;
}

?>