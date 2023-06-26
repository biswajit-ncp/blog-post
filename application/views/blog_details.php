<div class="container mt-5">

    

     <div class="text-center">
     	<div style="width: 100%;height: 350px;overflow: hidden;">
     		<img src="<?php echo $blog_data['image'] ?>" style="width: 100%;" alt="Blog Image"  class="img-fluid" >
     	</div>
     </div>
     <p  class="mt-3">Created By <strong><?php echo $blog_data['user_name'] ?></strong> , on <?php echo $blog_data['created_date'] ?> |  <a href="<?php echo base_url('') ?>">To Home</a> </p>
     <h4 class="mt-2"><?php echo $blog_data['title'] ?></h4>
     <hr>
     <p>
     	<?php echo $blog_data['content'] ?>
     </p>

     <hr>

     <h5>Comment On This Post</h5>
     <?php if($this->session->flashdata('comment_message')){ ?> 

        <div class="alert alert-success alert-dismissible">
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          Your comment successfully submitted.
        </div>

     <?php  } ?>
     <form class="mb-5" id="first_form" action="<?php echo base_url('comment-post') ?>"  method="post">  
     	<div class="mb-3 mt-3">
			<label for="email">Your Name</label>
			<input autocomplete="off" type="text" class="form-control" id="comment_by" placeholder="Your Name" name="comment_by">
			<p class="error_cls comment_by_error"></p>
		</div>
     	<div class="mb-3 mt-3">
			<label for="email">Comment</label>
			<textarea name="comment" id="comment" class="form-control"></textarea>
			<p class="error_cls comment_error"></p>
		</div>
		<input type="hidden" value="<?php echo $blog_data['id'] ?>" name="blog_id">
		<input type="hidden" value="<?php echo $blog_data['url'] ?>" name="blog_url">
		<button onclick="return commentPost()" type="button" class="btn btn-primary">Comment Now</button>
     </form>

     <?php if(count($blog_comments) > 0 ) { ?> 



	     <hr>
	     <h5>Comment List</h5>

	     <?php foreach ($blog_comments as $comments) { ?>

	     	<h6> <?php echo $comments['comment_by'] ?> <span style="    font-size: 12px;
    font-weight: 300;">on <?php echo $comments['created_date'] ?></span></h6>
	     	<p><?php echo $comments['comment'] ?></p>

	     	 
	     <?php } ?>


	     
     	  
     <?php } ?>
</div>

<script>
	function commentPost() {

       $(".error_cls").text("");  
       var comment_by = document.getElementById("comment_by").value; 
       var comment    = document.getElementById("comment").value;

       if (comment_by == '') {
           $('#comment_by').focus();
           $(".comment_by_error").text("Please enter your name");
       } else if (comment == '') {
           $('#comment').focus();
           $(".comment_error").text("Please enter your comment");
       } else { 
       		$("#first_form").submit();
       }
       return false;
   }
</script>