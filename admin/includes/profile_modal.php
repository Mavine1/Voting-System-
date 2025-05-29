<!-- Add -->
<div class="modal fade" id="profile">
    <div class="modal-dialog">
        <div class="modal-content" style="border: none; border-radius: 10px; box-shadow: 0 10px 30px rgba(30, 64, 175, 0.3);">
          	<div class="modal-header" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #ef4444 100%); color: #ffffff; border-radius: 10px 10px 0 0; padding: 20px;">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 0.8; font-size: 28px;">
              		<span aria-hidden="true">&times;</span>
              	</button>
            	<h4 class="modal-title" style="font-family: Times; font-size: 24px; font-weight: bold; margin: 0;">
            		<i class="fa fa-user-circle" style="margin-right: 10px;"></i>Admin Profile
            	</h4>
          	</div>
          	
          	<div class="modal-body" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); padding: 30px;">
            	<form class="form-horizontal" method="POST" action="profile_update.php?return=<?php echo basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
          		  
          		  <div class="form-group" style="margin-bottom: 25px;">
                  	<label for="username" class="col-sm-3 control-label" style="color: #1e40af; font-weight: bold; font-family: Times; font-size: 16px; padding-top: 10px;">Username</label>
                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" 
                    		style="border: 2px solid #3b82f6; border-radius: 8px; padding: 12px; font-size: 16px; transition: all 0.3s ease; background-color: #ffffff;">
                  	</div>
                </div>
                
                <div class="form-group" style="margin-bottom: 25px;">
                    <label for="password" class="col-sm-3 control-label" style="color: #1e40af; font-weight: bold; font-family: Times; font-size: 16px; padding-top: 10px;">Password</label>
                    <div class="col-sm-9"> 
                      <input type="password" class="form-control" id="password" name="password" value="<?php echo $user['password']; ?>"
                      	style="border: 2px solid #3b82f6; border-radius: 8px; padding: 12px; font-size: 16px; transition: all 0.3s ease; background-color: #ffffff;">
                    </div>
                </div>
                
                <div class="form-group" style="margin-bottom: 25px;">
                  	<label for="firstname" class="col-sm-3 control-label" style="color: #1e40af; font-weight: bold; font-family: Times; font-size: 16px; padding-top: 10px;">Firstname</label>
                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $user['firstname']; ?>"
                    		style="border: 2px solid #3b82f6; border-radius: 8px; padding: 12px; font-size: 16px; transition: all 0.3s ease; background-color: #ffffff;">
                  	</div>
                </div>
                
                <div class="form-group" style="margin-bottom: 25px;">
                  	<label for="lastname" class="col-sm-3 control-label" style="color: #1e40af; font-weight: bold; font-family: Times; font-size: 16px; padding-top: 10px;">Lastname</label>
                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $user['lastname']; ?>"
                    		style="border: 2px solid #3b82f6; border-radius: 8px; padding: 12px; font-size: 16px; transition: all 0.3s ease; background-color: #ffffff;">
                  	</div>
                </div>
                
                <div class="form-group" style="margin-bottom: 25px;">
                    <label for="photo" class="col-sm-3 control-label" style="color: #1e40af; font-weight: bold; font-family: Times; font-size: 16px; padding-top: 10px;">Photo:</label>
                    <div class="col-sm-9">
                      <input type="file" id="photo" name="photo" 
                      	style="border: 2px solid #3b82f6; border-radius: 8px; padding: 10px; font-size: 16px; background-color: #ffffff; width: 100%;">
                    </div>
                </div>
                
                <hr style="border: none; height: 2px; background: linear-gradient(90deg, #1e40af 0%, #ef4444 100%); margin: 30px 0;">
                
                <div class="form-group" style="margin-bottom: 25px;">
                    <label for="curr_password" class="col-sm-3 control-label" style="color: #ef4444; font-weight: bold; font-family: Times; font-size: 16px; padding-top: 10px;">Current Password:</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="curr_password" name="curr_password" placeholder="Input current password to save changes" required
                      	style="border: 2px solid #ef4444; border-radius: 8px; padding: 12px; font-size: 16px; transition: all 0.3s ease; background-color: #ffffff;">
                    </div>
                </div>
          	</div>
          	
          	<div class="modal-footer" style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); border-radius: 0 0 10px 10px; padding: 20px; border-top: 2px solid #e2e8f0;">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal" 
            		style="background: linear-gradient(135deg, #6b7280 0%, #9ca3af 100%); color: #ffffff; border: none; border-radius: 8px; padding: 12px 20px; font-size: 16px; font-weight: bold; transition: all 0.3s ease;">
            		<i class="fa fa-close" style="margin-right: 8px;"></i> Close
            	</button>
            	
            	<button type="submit" class="btn btn-success btn-flat" name="save" 
            		style="background: linear-gradient(135deg, #1e40af 0%, #ef4444 100%); color: #ffffff; border: none; border-radius: 8px; padding: 12px 20px; font-size: 16px; font-weight: bold; transition: all 0.3s ease; margin-left: 10px;">
            		<i class="fa fa-check-square-o" style="margin-right: 8px;"></i> Save
            	</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<style>
/* Hover effects for form inputs */
.form-control:focus {
    border-color: #1e40af !important;
    box-shadow: 0 0 0 0.2rem rgba(30, 64, 175, 0.25) !important;
    outline: none !important;
}

/* Hover effects for buttons */
.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

/* Special hover for current password field */
#curr_password:focus {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 0.2rem rgba(239, 68, 68, 0.25) !important;
}

/* File input styling */
input[type="file"] {
    cursor: pointer;
}

input[type="file"]:hover {
    border-color: #1e40af !important;
}
</style>