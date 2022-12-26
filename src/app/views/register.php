<html>
    <head>
        <link href="/bootstrap.min.css" rel="stylesheet"/>
    </head>
    <body>
        <div class="container">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="w-25">
                    <h3>Register</h3>
                    <?php if(isset($error)):?>
                        <div class="alert alert-danger">
                            <?php echo $error?>
                        </div>
                    <?php endif?>
                    <form action="/registerUser" method="POST">
                        <div class="form-group pb-1">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group pb-1">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="form-group pb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success w-100">Register</button>
                        </div>
                    </form>
                    <div class="form-group pb-3">
                        <span>Already have an account? <a href="/login">Login</a></span>
                    </div>
                </div>
            </div>            
        </div>
    </body>
</html>