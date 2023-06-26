<div class="container mt-5">

    <h3>List Of Comments By Users To This Post | <a class="btn btn-primary"  href="<?php echo base_url('admin/blog-list') ?>">To Blog List</a> </h3>
    <hr>

    <div class="list-group">
    <?php if(count($blog_comments) >0 ){ ?> 
            <?php $i=0; ?>
                <?php foreach ( $blog_comments as $comments ) { ?> 

                     
                        <div class="list-group-item mb-2">
                            <p><?php echo $comments['comment'] ?></p>
                            <span style="font-size: 13px;"><?php echo $comments['comment_by'] ?> , On <?php echo $comments['created_date'] ?></span>
                            <br>
                            <a onclick="deleteComment(<?php echo $comments['id'] ?>)" class="btn btn-danger" >Delete</a>
                        </div>
                      

                <?php $i++; ?>
            <?php } ?>  
        <?php } else { ?> 

            <h4 class="text-center">No comments are available to show</h4>

        <?php } ?> 
    </div>
</div>


<script>
    
    function deleteComment(id) {
    
    $.ajax({
           type: "POST",
           url: "<?=base_url('delete-comment')?>",
           data: {'id':id} ,
           cache: false,
           success: function(text_response) {
               var obj = jQuery.parseJSON(text_response);
               if (obj.status == '1') {
                   location.reload(true);
               }
           }
       });



    }

</script>