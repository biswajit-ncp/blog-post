<div class="container mt-5">

 <div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<h2>Login</h2>
		<?php echo  form_open(); ?>    
			<div class="mb-3 mt-3">
				<label for="email">Email:</label>
				<input autocomplete="off"  type="email" class="form-control" id="email" placeholder="Enter email" name="email">
				<p class="error_cls email_error"></p>
			</div>
			<div class="mb-3">
				<label for="pwd">Password:</label>
				<input autocomplete="off" type="password" class="form-control" id="password" placeholder="Enter password" name="password">
				<p class="error_cls password_error"></p>
			</div>
			 
			<button onclick="return lginVal()"  type="button"  class="btn btn-primary">Sign In</button> 

			<a href="<?php echo base_url('sign-up') ?>"  class="btn btn-info">Registration</a>
            <a href="<?php echo base_url('') ?>"  class="btn btn-warning">Home Page</a>

		<?php echo form_close() ?>			
			<span class="error_cls"   id="login_message"></span>
            <span class="success_cls" id="success_login_message"></span>

		 
	</div>
	<div class="col-md-4"></div>
 </div>
     
<script>
   // email check function start
   function validateEmail(email) {
       var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
       return re.test(String(email).toLowerCase());
   }        
   function lginVal() {

       $(".error_cls").text("");
       $('#login_message').html('');
       var login_email = document.getElementById("email").value;
       var login_password = document.getElementById("password").value;
       var validate_email = validateEmail(login_email);
       if (login_email == '') {
           $('#email').focus();
           $(".email_error").text("Please enter email");
       } else if (validate_email == false) {
           $('#email').focus();
           $(".email_error").text("Please enter valid email");
       } else if (login_password == '') {
           $('#password').focus();
           $(".password_error").text("Please enter password.");
       } else if (login_password.length < 6) {
           $('#password').focus();
           $(".password_error").text("Please enter valid password.");
       } else {
           var dataString = 'email=' + login_email + '&password=' + login_password  ;
           $.ajax({
               type: "POST",
               url: "<?=base_url('user-login-submit')?>",
               data: dataString,
               cache: false,
               success: function(text_response) {
                   var obj = jQuery.parseJSON(text_response);
                   if (obj.status == '1') {
                       $('#success_login_message').text(obj.message);
                       $('#login_message').html('');
                       window.setTimeout(function(){
                           var url = "<?=base_url('admin/blog-list')?>";
                           window.location = url;
                      }, 2000);

                   } else {
                       $('#login_message').text(obj.message);
                   }
               }
           });
      }
       return false;
   }        
</script>


</div>
