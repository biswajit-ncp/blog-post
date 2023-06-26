<div class="container mt-5">

 <div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<h2>Registration</h2>
		<?php echo  form_open(); ?>    
			<div class="mb-3 mt-3">
				<label for="email">User Name</label>
				<input autocomplete="off"  type="text" class="form-control" id="uname" placeholder="Enter User Name" name="uname">
				<p class="error_cls uname_error"></p>
			</div>
			<div class="mb-3 mt-3">
				<label for="email">Email</label>
				<input autocomplete="off"  type="email" class="form-control" id="email" placeholder="Enter email" name="email">
				<p class="error_cls email_error"></p>
			</div>
			<div class="mb-3">
				<label for="pwd">Password</label>
				<input autocomplete="off" type="password" class="form-control" id="password" placeholder="Enter password" name="password">
				<p class="error_cls password_error"></p>
			</div> 
			<button onclick="return registrationVal()"  type="button"  class="btn btn-primary">Registration</button> 
			<a href="<?php echo base_url('sign-in') ?>"  class="btn btn-info">Sign In</a>
            <a href="<?php echo base_url('') ?>"  class="btn btn-warning">Home Page</a>
		<?php echo form_close() ?>

            <span class="error_cls"   id="error_login_message"></span>
            <span class="success_cls" id="success_login_message"></span>
	</div>
	<div class="col-md-4"></div>
 </div>
    
<script> 
   function validateEmail(email) {
       var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
       return re.test(String(email).toLowerCase());
   }        
   function registrationVal() {

       $(".error_cls").text("");
       $('#error_login_message').html('');
       $('#success_login_message').html('');
       var uname 		  = document.getElementById("uname").value;
       var login_email    = document.getElementById("email").value;
       var login_password = document.getElementById("password").value;
       var validate_email = validateEmail(login_email);

       if (uname == '') {
           $('#uname').focus();
           $(".uname_error").text("Please enter user name");
       } else if (login_email == '') {
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
           $(".password_error").text("Please enter atleast 6 digit for your password.");
       } else {
           var dataString = 'email=' + login_email + '&password=' + login_password + '&uname=' + uname  ;
           $.ajax({
               type: "POST",
               url: "<?=base_url('user-registration-submit')?>",
               data: dataString,
               cache: false,
               success: function(text_response) {
                   var obj = jQuery.parseJSON(text_response);
                   if (obj.status == '1') {
                       $('#success_login_message').text(obj.mesage);
                       $('#error_login_message').html('');
                       window.setTimeout(function(){
                           var url = "<?=base_url('sign-in')?>";
                           window.location = url;
                      }, 7000);

                   } else {
                       $('#error_login_message').text(obj.mesage);
                   }
               }
           });
      }
       return false;
   }        
</script>


</div>

