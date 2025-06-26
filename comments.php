<?php 
  include 'db.php'; 
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['comment'])){ 
    $comment = $_POST['comment']; 
    $sql = "INSERT INTO comments (comment) VALUES ('$comment')"; 
    mysqli_query($conn, $sql); } 
?>

<!DOCTYPE html> 
  <html> 
    <head> 
      <meta charset="UTF-8"> 
      <title>Comment Page (Vulnerable)</title> 
      <style> 
        body { 
          font-family: sans-serif;
          background-color: #f4f4f4; 
          padding: 20px; 
          } 
        
        #commentBox { 
          width: 100%; 
          padding: 10px; 
          font-size: 16px; 
        } 
        
        #submitBtn{ 
          margin-top: 10px; 
          padding: 8px 16px; 
        } 
        
        .comment{ 
          background: #fff; 
          margin-top: 15px; 
          padding: 10px; 
          border-left: 4px solid #2196F3; 
        } 
        </style> 
      </head> 
      <body> 
        <h2>Leave a Comment</h2> 
        <form method="POST" action=""> 
          <textarea id="commentBox" name="comment" rows="5" placeholder="Type your comment..."></textarea>
          <br> 
          <button id="submitBtn" type="submit">Submit Comment</button>
        </form> 
        <div id="commentsSection"> 
          <h3>Previous Comments:</h3> 
          
          <?php if (file_exists($comments_file)){ 
            $comments = file($comments_file, FILE_IGNORE_NEW_LINES); 
            foreach ($comments as $c){ 
              echo "<div class='comment'>$c</div>"; // Vulnerable to stored XSS 
              } 
            }
          ?> 
          </div> 
          <script> // DOM: Highlight empty field 
            const form = document.querySelector("form"); 
            const commentBox = document.getElementById("commentBox"); 
            form.addEventListener("submit", function (e) { 
              if (commentBox.value.trim() === "") { 
                e.preventDefault(); 
                commentBox.style.border = "2px solid red"; 
                alert("Please enter a comment."); } }); 
      </script> 
    </body> 
  </html>