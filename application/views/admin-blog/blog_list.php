<div class="container mt-5">

    

    <div class="clearfix">
	  <span class="float-start">
	  	<a href="<?php echo base_url('admin/blog-create'); ?>"  class="btn btn-primary">New Blog Create</a>
	  </span>
	  <span class="float-end">
	  	<a href="<?php echo base_url('log-out') ?>" type="button" class="btn btn-warning">Logout</a>
	  </span>
	</div>

	 <?php if($this->session->flashdata('delete_message')){ ?> 

        <div class="alert alert-danger alert-dismissible mt-3">
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          <strong>Success!</strong> Blog successfully deleted!
        </div>

    <?php  } ?>


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
								
								<a href="<?php echo base_url('admin/blog/delete/'.$post['uid']) ?>" class="btn btn-info">Delete</a>
								<a href="<?php echo base_url('admin/blog/edit/'.$post['uid']) ?>" class="btn btn-info">Edit</a>
								<a href="<?php echo base_url('admin/blog/comment/'.$post['uid']) ?>" class="btn btn-info">Commment</a>

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
