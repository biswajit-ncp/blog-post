<div class="container mt-5">

    

    <div class="clearfix">
	  <span class="float-end">

	  	<?php if($is_login == 'yes'){ ?>

	  		<a href="<?php echo base_url('log-out') ?>" type="button" 
	  			class="btn btn-warning">Log Out</a>

	  	 <?php } else { ?> 

	  	 	<a href="<?php echo base_url('sign-in') ?>" type="button" class="btn btn-warning">Log In</a>

	  	 <?php } ?>
	  	
	  	
	  </span>
	</div>


    <hr>
	<div class="row">

		 <?php if(count($blog_list) >0 ){ ?> 
            <?php $i=0; ?>
                <?php foreach ( $blog_list as $post ) { ?> 


					<div class="col-md-3">
						<div class="blog-border shadow-lg">
							<img class="img-fluid" src="<?php echo $post['image'] ?>">
							<h5 class="p-2 "><?php echo $post['limit_title'] ?></h5>
							<hr style="margin: 0;">
							<p class="p-2">
								<?php echo $post['limit_content'] ?>
							</p>
							<hr>
							<div class="text-center pb-3">
								<a href="<?php echo base_url('blog/'.$post['url']) ?>" class="btn btn-info">View</a>
							</div>
						</div>
					</div>


				<?php $i++; ?>
            <?php } ?>  
        <?php } else { ?> 

        	<h4 class="text-center">No blogs are available to show</h4>

        <?php } ?> 


	</div>

</div>
