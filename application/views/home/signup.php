<div class="breadcrumb">
    <div class="container">
        <ul>
            <li><a href="index.html">Home</a></li>
            <li>Registration Form</li>
        </ul>
    </div>
</div>
<!-- Content -->
<div id="pageContent">
    <div class="container offset-18">
        <h1 class="block-title large">New User</h1>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <?php echo validation_errors();?>
                <?php echo checkFlash();?>
                <div class="login-form-box">
                    <h2>REGISTERED CUSTOMERS</h2>
                    <p>
                        If you have an account with us, please log in.
                    </p>
                    <form action="<?php echo site_url('signup/newUser')?>" method="post">
                        <div class="form-group">
                            <div class="input-group">
										<span class="input-group-addon">
										<span class="icon icon-person_outline"></span>
										</span>
                                <input type="text" name="fname" id="LoginFormName1" class="form-control" placeholder="First Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
										<span class="input-group-addon">
										<span class="icon icon-person_outline"></span>
										</span>
                                <input type="text" name="lname" id="LoginFormName1" class="form-control" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
										<span class="input-group-addon">
										<span class="icon icon-person_outline"></span>
										</span>
                                <input type="text" name="email" id="LoginFormName1" class="form-control" placeholder="Email Address">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
										<span class="input-group-addon">
										<span class="icon icon-lock_outline"></span>
										</span>
                                <input type="password" name="password" id="LoginFormPass1" class="form-control" placeholder="Password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-3">
                                <button type="submit" class="btn" onclick="document.getElementById('form-returning').submit();">Create Now</button>
                            </div>
                            <div class="col-md-12 col-lg-9">
                                <ul class="additional-links">
                                    <li><a href="#">Forgot your password?</a></li>
                                    <li><a href="<?php echo site_url('login')?>">Login</a></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>