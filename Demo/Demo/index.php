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

			
			<div class="posts_area"></div>
			<img id='loading' src = "assets/images/icons/loading.gif"> 

		</div>

		<script>
			var userLoggedIn = '<?php echo  $userLoggedIn; ?>';

			$(document).ready(function() {

				$('#loading').show();

				//Original ajax request for loading first posts
				//Pokazuje loading icon dok nije pripremljen "dokument" s funkcijom loadPostsFriends unutar Post.php
				$.ajax({
					//u ajax_load_posts.php se nalazi veza za db te klase i funkcije user i post.php te pokretanje nove instance Post klase i poziva loadPostsFriends
					url:"includes/handlers/ajax_load_posts.php",
					type: "POST",
					data: "page=1&userLoggedIn=" + userLoggedIn, cache:false,
					// "data" predstavlja podatke iz ajax calla iznad - koji su uspjesno pozvani, pa će u tom slucaju funkcija sakriti loading.gif

					success: function(data) {
						$('#loading').hide();
						//umeće se "data" pozvan iznad u html divider koji se spominje ispod a nalazi se iznad <img id=#loading...>
						$('.posts_area').html(data);
					}
				 });

				$(window).scroll(function() {
					var height = $('.posts_area').height(); //div containing posts is as high as the posts require
					var	scroll_top = $(this).scrollTop(); //scrolltop je vrh trenutne stranice gdje god se nalazio sto se tice scrollanja
					var page = $('.posts_area').find('.nextPage').val();
					var noMorePosts = $('.posts_area').find('.noMorePosts').val();

					if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
						$('#loading').show();

						var ajaxReq = $.ajax({

							url: "includes/handlers/ajax_load_posts.php",
							type: "POST",
							data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
							cache: false,

							success: function(response) {
								$('.posts_area').find('.nextPage').remove();
								$('.posts_area').find('.noMorePosts').remove();

								$('#loading').hide();
								$('.posts_area').append(response);
							}
						});

					}//End if

					return false;

				}); // end $(window).scroll(function()
				
			});
		</script>

	</div> <!-- div1 otvoren unutar headera -->
</body>
</html>