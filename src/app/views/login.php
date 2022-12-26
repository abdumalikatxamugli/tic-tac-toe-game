<html>
    <head>
        <link href="/bootstrap.min.css" rel="stylesheet"/>
    </head>
    <body>
        <div class="container">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="w-25">
                    <form action="/loginUser" method="POST">
                        <div class="form-group pb-1">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="form-group pb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group pb-3">
                            <button class="btn btn-success w-100">Login</button>
                        </div>                        
                    </form> 
                    <div class="form-group pb-3">
                        <span>Don't have an account? <a href="/register">Register</a></span>
                    </div>                   
                </div>
            </div>            
        </div>
    </body>
</html>