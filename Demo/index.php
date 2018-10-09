<?php 
include ("includes/header.php");
include ("includes/classes/User.php");
include ("includes/classes/Post.php");


if(isset($_POST['post'])) {
	$post = new Post ($con, $userLoggedIn);
	$post->submitPost($_POST['post_text'], 'none');
}
?> 
	
		<div class="user_details column">
			<a href="<?php echo $userLoggedIn; ?>"> <img src="<?php echo $user['profile_pic']; ?>"></a>

				<div class="user_details_left_right">
					<a href="<?php echo $userLoggedIn; ?>">
					<?php 
					echo $user['first_name'] . " " . $user['last_name'] . "<br>";
					?>
					</a>
					<?php 
					echo "Posts: " . $user['num_posts'] . "<br>";
					echo "Likes: " . $user['num_likes'];
					 ?>
				</div>

		</div>

		<div class="main_column column">
			
			<form class="post_form" action="index.php" method="POST">
				<textarea name="post_text" id="post_text" placeholder="What's up with you?"></textarea>
				<input type="submit" name="post" id="post_button" value="Post">
				
			</form>

			<?php 
			$post = new Post ($con, $userLoggedIn);
			$post->loadPostsFriends();
			?>

			<img src = "assets/images/icons/loading.gif">

		</div>

	<script>
		var userLoggedIn = '<?php echo $userLoggedIn; ?>';

		$(document).ready(function() {

			$('#loading').show();

			//Original ajax request for loading first posts
			$.ajax({
				url:"includes/handlers/ajax_load_posts.php",
				type: "POST",
				data: "page=1$userLoggedIn=" + userLoggenIn, cache:false,
			 });
			
		});

	</div> <!-- div1 otvoren unutar headera -->
</body>
</html>