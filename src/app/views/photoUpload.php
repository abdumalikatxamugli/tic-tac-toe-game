<html>
    <head>
        <link href="/bootstrap.min.css" rel="stylesheet"/>
    </head>
    <body style="background-color: whitesmoke">
        <div class="container">
            <div class="d-flex flex-column justify-content-center align-items-center h-100">
                <div class="w-25 border p-4 bg-white">
                    <?php if(isset($errors) && count($errors)>0):?>
                        <?php foreach($errors as $error):?>
                            <div class="bg bg-danger text-white mb-3 p-2">
                                <?php echo $error?>
                            </div>
                        <?php endforeach?>
                    <?php endif?>
                    <form action="/photoUploadSave" method="POST" enctype="multipart/form-data">
                        <input type="file" name="photo">
                        <button class="btn btn-success mt-3">Save</button> 
                    </form>
                </div>
            </div>            
        </div>
    </body>
</html>