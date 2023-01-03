<?php
    if (empty($_SESSION['username'])) {
        include ('Assignment8_view_startpage.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Everything Forum</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <style>
    
    .btn{
        margin-left:20px;
    }

    .col-lg-6{
        color: white;
    }

    html,body {
    width: 100%;
    height: 100%;
    margin: 0px;
    padding: 0px;
    overflow-x: hidden; 
}

    #mainLayout {
      background-color: #303030;
    }

</style>
</head>

<body>
<nav class="navbar navbar-expand-sm bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand text-white" href="#">Everything Forum</a>
    <ul class="navbar-nav">
    <button id="writePost" class="btn btn-primary navbar-btn">Write A Post</button>
    <button id="editPost" class="btn btn-primary navbar-btn">Edit A Post</button>
    <button id="Reply" class="btn btn-success navbar-btn">Reply to a Post</button>
    <button id="changeProfile" class="btn btn-info navbar-btn text-white">Change Profile</button>
    <button id="deleteProfile" class="btn btn-warning navbar-btn text-white">Delete Profile</button>
    <button id="logOut" class="btn btn-danger navbar-btn">Log Out</button>
    </ul>
  </div>
</nav>


<div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-header">My Posts</div>
      <div id="myPosts" class="card-body"></div>
      <div class="card-footer">
        <button id="showYPosts" class="btn btn-info navbar-btn text-white">Show your posts</button>
        <button id="deletePost" class="btn btn-danger navbar-btn text-white">Delete a Post</button>
        <button id="hidePosts" class="btn btn-primary navbar-btn text-white">Hide your Posts</button>
      </div>
    </div>
    <br><br>
    <div class="card">
      <div class="card-header">Replies to your Posts</div>
      <div id="UReplies" class="card-body"></div>
      <div class="card-footer">
        <button id="showUReplies" class="btn btn-info navbar-btn text-white">Show Replies</button>
        <button id="hideUReplies" class="btn btn-primary navbar-btn text-white">Hide Replies</button>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-header">Others' Posts</div>
      <div id ="othersPosts" class="card-body"></div>
      <div class="card-footer">
      <button id="showOPosts" class="btn btn-info navbar-btn text-white">Show others' posts</button>
      <button id="hideOPosts" class="btn btn-primary navbar-btn text-white">Hide others' Posts</button>
      </div>
    </div>
    <br><br>
    <div class="card">
      <div class="card-header">Replies to Others' Posts</div>
      <div id="OReplies" class="card-body"></div>
      <div class="card-footer">
        <button id="showOReplies" class="btn btn-info navbar-btn text-white">Show Replies</button>
        <button id="hideOReplies" class="btn btn-primary navbar-btn text-white">Hide Replies</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="EditPostModal"> <!-- Edit Post Modal -->
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit A Post</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <input type='hidden' name='page' value='MainPage'>
            <input type='hidden' name='command' value='ChangeProfile'>
            <label class='modal-label-input' for='postTitle'>Enter Post Title:</label>
            <input id='postTitle' type='text' name='postTitle'>
            <br><br>
            <label class='form-label' for='postContents'>New Post Contents:</label>
            <textarea class="form-control" id='postContents' type='text' name='postContents' rows="5"></textarea>
            <br>
            <div id="edit-post-body"></div>
            <br>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type='button' class="btn btn-outline-danger" data-bs-dismiss='modal'>Cancel</button>
        <button id='edit-post' type='button' class="btn btn-outline-primary">Submit</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="WritePostModal"> <!-- Write Post Modal -->
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Write A Post</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <label class='modal-label-input' for='input-post-title'>Post Title:</label>
            <input id='title' type='text' name='title'>
            <br><br>
            <label class='form-label' for='input-post-contents'>Post Contents:</label>
            <textarea class="form-control" id='contents' type='text' name='contents' rows="5"></textarea>
            <br>
      </div>
 
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type='button' class="btn btn-outline-danger" data-bs-dismiss='modal'>Cancel</button>
        <button id='write-post' type='button' class="btn btn-outline-primary">Submit</button> 
      </div>

    </div>
  </div>
</div>

<div class="modal" id="ReplyModal"> <!-- Write Post Modal -->
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Reply to a Post</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <label class='modal-label-input' for='reply-title'>Post Title:</label>
            <input id='reply-title' type='text' name='reply-title' placeholder='Title of the Post you wish to reply to' style='width: 400px;'>
            <br><br>
            <label class='modal-label-input' for='reply-post-author'>Post Author:</label>
            <input id='reply-post-author' type='text' name='reply-post-author' placeholder='Original author of the post' style='width: 400px;'>
            <br><br>
            <label class='form-label' for='reply-contents'>Reply:</label>
            <textarea class="form-control" id='reply-contents' type='text' name='reply-contents' rows="5"></textarea>
            <br>
            <div id="reply-post-body"></div>
            <br>
      </div>
 
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type='button' class="btn btn-outline-danger" data-bs-dismiss='modal'>Cancel</button>
        <button id='reply-post' type='button' class="btn btn-outline-primary">Submit Reply</button> 
      </div>

    </div>
  </div>
</div>

<div class="modal" id="ChangeProfileModal"> <!-- Change Profile Modal -->
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Change Profile</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <input type='hidden' name='page' value='MainPage'>
            <input type='hidden' name='command' value='ChangeProfile'>
            <label class='modal-label-input' for='input-change-username'>Enter New Username:</label>
            <input id='input-change-username' type='text' name='input-change-username'>
            <br><br>
            <label class='modal-label-input' for='input-change-password'>Enter New Password:</label>
            <input id='input-change-password' type='text' name='input-change-password'>
            <br>
            <div id="change-profile-body"></div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type='button' class="btn btn-outline-danger" data-bs-dismiss='modal'>Cancel</button>
        <button id='change-profile' type='button' class="btn btn-outline-success">Change Profile</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="AddFriendsModal"> <!-- Add Friends Modal -->
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Friend</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          <input type='hidden' name='page' value='MainPage'>
          <input type='hidden' name='command' value='AddFriend'>
          <label class='modal-label-input' for='add-friend-input'>Enter their Username:</label>
          <input id='add-friend-input' type='text' name='add-friend-input'>
          <div id='friend-body'></div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type='button' class="btn btn-outline-danger" data-bs-dismiss='modal'>Cancel</button>
        <button id='add-friend' type='button' class="btn btn-outline-primary">Add Friend</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="DeletePostModal"> <!-- Delete a Post Modal -->
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Delete a Post</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <input type='hidden' name='page' value='MainPage'>
            <input type='hidden' name='command' value='AddFriend'>
            <label class='modal-label-input' for='delete-post-title'>Enter the Post Title:</label>
            <input id='delete-post-title' type='text' name='delete-post-title'>
            <div id="delete-post-body"></div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type='button' class="btn btn-outline-primary" data-bs-dismiss='modal'>Cancel</button>
        <button id='delete-post' type='button' class="btn btn-outline-danger">Delete</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="DeleteProfileModal"> <!-- Delete Profile Modal -->
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Delete Your Profile</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      <h5 class="modal-title">Are you sure you want to delete your profile?</h5>
      </div> 

      <!-- Modal footer -->
      <div class="modal-footer">
      <form id='deleteForm' method='post' action='project_controller.php'>
            <input type='hidden' name='page' value='MainPage'>
            <input type='hidden' name='command' value='DeleteProfile'>
            <button type='button' class="btn btn-outline-primary" data-bs-dismiss='modal'>Cancel</button>
            <button id='delete-profile' type='submit' class="btn btn-outline-danger">Delete</button>
      </form>
      </div>

    </div>
  </div>
</div>

<!-- Logout Form -->
<form id='logoutForm' method='post' action='project_controller.php'>
        <input type='hidden' name='page' value='MainPage'>
        <input type='hidden' name='command' value='LogOut'>
</form>


</body>
</html>

<script>
  // Delete
  $('#deleteProfile').click(function() {
        $('#DeleteProfileModal').modal('show');
    });

  $('#delete-profile').click(function() {
    document.getElementById('deleteForm').submit();
  });

  $('#Reply').click(function() {
        $('#ReplyModal').modal('show');
    });

  // Change Profile
  $('#changeProfile').click(function() {
        $('#ChangeProfileModal').modal('show');
    });

  // Hide Users' Posts
  $('#hidePosts').click(function() {
      $('#myPosts').hide();
    });
  
  // Hide friends' posts
  $('#hideOPosts').click(function() {
      $('#othersPosts').hide();
    });

  $('#hideUReplies').click(function() {
      $('#UReplies').hide();
    });

  $('#hideOReplies').click(function() {
      $('#OReplies').hide();
    });
  
  // Add Friends
  $('#addFriends').click(function() {
        $('#AddFriendsModal').modal('show');
    });

  // Log Out
  $('#logOut').click(function() {
        document.getElementById('logoutForm').submit();
    });

  // Edit a Post
  $('#editPost').click(function() {
        $('#EditPostModal').modal('show');
    });

  // Write a Post modal
  $('#writePost').click(function() {
        $('#WritePostModal').modal('show');
  });

  // Delete a Post modal
  $('#deletePost').click(function() {
        $('#DeletePostModal').modal('show');
  });

  // Show Posts your posts
  $('#showYPosts').click(function() {
    $('#myPosts').show();
    $.post("project_controller.php",
            {
                page: "MainPage",
                command: "ShowYourPosts"
            },
            function(data) {
              $('#myPosts').html("<p>" + data + "<p>");
            });
  });

  $('#showUReplies').click(function() {
    $('#UReplies').show();
    $.post("project_controller.php",
            {
                page: "MainPage",
                command: "ShowRepliesYPosts"
            },
            function(data) {
              $('#UReplies').html("<p>" + data + "<p>");
            });
  });

  $('#showOReplies').click(function() {
    $('#OReplies').show();
    $.post("project_controller.php",
            {
                page: "MainPage",
                command: "ShowRepliesOPosts"
            },
            function(data) {
              $('#OReplies').html("<p>" + data + "<p>");
            });
  });

  // Show others posts
  $('#showOPosts').click(function() {
    $('#othersPosts').show();
    $.post("project_controller.php",
            {
                page: "MainPage",
                command: "ShowOthersPosts"
            },
            function(data) {
              $('#othersPosts').html("<p>" + data + "<p>");
            });
  });

  // Delete a Post Ajax
  $('#delete-post').click(function() {
    $.post("project_controller.php",
            {
                page: "MainPage",
                command: "DeletePost",
                title: "" + $('#delete-post-title').val()
            },
            function(data) {
              $('#delete-post-body').html(data);
              $('#showYPosts').click();
              $('#showOPosts').click();
              $('#showUReplies').click();
              $('#showOReplies').click();
            });  
  });

  $('#change-profile').click(function() {
    $.post("project_controller.php",
            {
                page: "MainPage",
                command: "ChangeProfile",
                NewUsername: "" + $('#input-change-username').val(),
                NewPassword: "" + $('#input-change-password').val()
            },
            function(data) {
              $('#change-profile-body').html(data);
              $('#showYPosts').click();
              $('#showOPosts').click();
              $('#showUReplies').click();
              $('#showOReplies').click();
            });  
  });

  
  // Edit a post Ajax
  $('#edit-post').click(function() {
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {  // register an event handler for the onreadystatechange event
    if (this.readyState == 4 && this.status == 200) {  // check readyState and status
      $('#edit-post-body').html('<h4>' + this.responseText + '</h4>');  // text response
      }
    };

    var controller = "project_controller.php";
    
    xhttp.open('POST', controller);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    var query = "page=MainPage&command=EditPost";
    query += "&postTitle=" + $('#postTitle').val(); // Gets the post contents that was written
    query += "&postContents=" + $('#postContents').val(); // Gets the post title that was inputted
    xhttp.send(query);
    $('#showYPosts').click();
    $('#showOPosts').click();
    $('#showUReplies').click();
    $('#showOReplies').click();            
  });

  // Write a post Ajax
  $('#write-post').click(function() { // Will send the WritePost command to the controller
    var xhttp = new XMLHttpRequest();
    $('#WritePostModal').modal('hide');

    // xhttp.onreadystatechange = function() {  
    // if (this.readyState == 4 && this.status == 200) {  
    //     alert(this.responseText);  
    //   }
    // };

    var controller = "project_controller.php";
    
    xhttp.open('POST', controller);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    var query = "page=MainPage&command=WritePost";
    query += "&contents=" + $('#contents').val(); // Gets the post contents that was written
    query += "&title=" + $('#title').val(); // Gets the post title that was inputted
    xhttp.send(query);
    $('#showYPosts').click();
    $('#showOPosts').click();
    $('#showUReplies').click();
    $('#showOReplies').click();
  });

  $('#reply-post').click(function() { // Will send the Reply command to the controller
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {  
    if (this.readyState == 4 && this.status == 200) {  
      $('#reply-post-body').html('<h4>' + this.responseText + '</h4>');  
      }
    };

    var controller = "project_controller.php";
    
    xhttp.open('POST', controller);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    var query = "page=MainPage&command=Reply";
    query += "&replyContents=" + $('#reply-contents').val(); // Contents of the reply
    query += "&replyTitle=" + $('#reply-title').val(); // Title of the original post
    query += "&replyPostAuthor=" + $('#reply-post-author').val(); // Original post author
    xhttp.send(query);
    $('#showYPosts').click();
    $('#showOPosts').click();
    $('#showUReplies').click();
    $('#showOReplies').click();
  });

  // Show all the posts and replies when this page is loaded
  $(window).on('load', function() {
    $('#showYPosts').click();
    $('#showOPosts').click();
    $('#showUReplies').click();
    $('#showOReplies').click();
});
</script> 


