<div class="container mt-5">

 <div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-6">
		    <h2>Create Blog</h2>
            <hr>

            <?php if($this->session->flashdata('success_message')){ ?> 

                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  <strong>Success!</strong> Blog Post successfully updated.
                </div>

            <?php  } ?>
 

		    <form id="first_form" action="<?php echo base_url('blog-update-submit') ?>"  method="post" enctype="multipart/form-data">  

                <img id="previewHolder" src="<?php echo  $blog_data['image'] ?>" alt="Uploaded Image Preview Holder" width="500px" height="200px" style="border-radius:3px;border:1px solid black;"/>

                <div class="mb-3 mt-3">
                    <label for="email">Blog Image</label>
                    <br>
                    <input type="file"  accept="image/png, image/jpeg"  name="filePhoto"  id="filePhoto" class="required borrowerImageFile" data-errormsg="PhotoUploadErrorMsg">
                    <p class="error_cls blog_image_error"></p>
                </div>

    			<div class="mb-3 mt-3">
    				<label for="email">Title</label>
    				<input autocomplete="off" onkeyup="createBlogUrl()"  value="<?php echo  $blog_data['title'] ?>" type="text" class="form-control" id="title" placeholder="Blog Title" name="title">
    				<p class="error_cls title_error"></p>
    			</div>

                <div class="mb-3 mt-3">
                    <label for="email">Blog Url</label>
                    <input autocomplete="off"  value="<?php echo  $blog_data['url'] ?>"  type="text" class="form-control" id="blog_url" placeholder="Blog-URL" name="blog_url"> 
                </div>

    			<div class="mb-3 mt-3">
    				<label for="email">Blog Content</label>
                    <textarea autocomplete="off" rows="5" type="text" class="form-control" id="blog_content" placeholder="Enter email" name="blog_content"><?php echo  $blog_data['content'] ?></textarea>
    				<p class="error_cls blog_content_error"></p>
    			</div>
                <input type="hidden" value="<?php echo $blog_data['uid'] ?>" name="blog_id">
    			<button onclick="return blogCreate()"  type="button"  class="btn btn-primary">Update</button> 
                <a href="<?php echo base_url('admin/blog-list') ?>"  class="btn btn-info">To Blog List</a>

		    <?php echo form_close() ?>
            <span class="error_cls"   id="error_blo_message"></span>
            <span class="success_cls" id="success_blog_message"></span>
	</div>
	<div class="col-md-2"></div>
 </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>    
<script>       
   function blogCreate() {

       $(".error_cls").text("");
       $('#error_blo_message').html('');
       $('#success_blog_message').html('');
       var title 		 = document.getElementById("title").value;
       var blog_content  = document.getElementById("blog_content").value;
       var blog_url  = document.getElementById("blog_url").value;
       
       if (title == '') {
           $('#title').focus();
           $(".title_error").text("Please provide blog title");
       } else if (blog_content == '') {
           $('#blog_content').focus();
           $(".blog_content_error").text("Please provide blog contents");
       } else {
          $("#first_form").submit();
      }
       
   }    


   function createBlogUrl() {
        var t = $("#title").val();
        var r = t.replace(/[$@%!%^&*(?/\|:;}{]['',#~`_+=)]/g, '');
        var str = r.replace(/\s+/g, '-').toLowerCase();
        $("#blog_url").val(str);
    }    

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#previewHolder').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      } else {
        alert('select a file to see preview');
        $('#previewHolder').attr('src', '');
      }
    }

    $("#filePhoto").change(function() {
      readURL(this);
    });

</script>


</div>

