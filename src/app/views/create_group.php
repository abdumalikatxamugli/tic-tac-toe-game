<!DOCTYPE html>
    <head>
        <link href="/bootstrap.min.css" rel="stylesheet"/>
        <script src="/alpine.min.js" defer></script>
    </head>
    <body>
        <div class="container" x-data="managePage()">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="w-25">
                    Create your own group
                    <?php if(isset($error)):?>
                        <div class="alert alert-danger">
                            <?php echo $error?>
                        </div>
                    <?php endif?>
                    <form action="/saveGroup" method="POST">
                        <div class="form-group pb-1">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="p-2 border my-2 mb-5">
                            <i>Users:</i>
                            <template x-for="(user, index) in users">
                                <select x-bind:name="'members['+index+']'" class="form-control mb-3">
                                    <?php foreach($users as $user):?>
                                        <option value="<?php echo $user->id?>">
                                            <?php echo $user->name?>
                                        </option>
                                    <?php endforeach?>    
                                </select>
                            </template>
                            <div class="d-flex justify-content-center align-items-center">
                                <button class="btn btn-success m-3" type="button" x-on:click="addUser()">add</button>
                                <button class="btn btn-danger m-3" type="button" x-on:click="removeUser()">remove</button>
                            </div>
                        </div>
                        <div class="p-2 border my-2 mb-5">
                            <i>Parent Group:</i>
                            <select name="parent_group_id" class="form-control mb-3">
                                <option selected disabled>None</option>
                                <?php foreach($groups as $group):?>
                                    <option value="<?php echo $group->id?>">
                                        <?php echo $group->name?>
                                    </option>
                                <?php endforeach?>  
                            </select>
                        </div>
                        <div class="form-group pb-3">
                            <button class="btn btn-success w-100">Save</button>
                        </div>                        
                    </form>                 
                </div>
            </div>            
        </div>
        <script>
            function managePage()
            {
                return {
                    users:[],
                    addUser: function()
                    {
                        this.users.push(1)
                    },
                    removeUser: function()
                    {
                        const temp = [...this.users];
                        temp.splice(-1,1);
                        this.users = temp;
                    }
                }
            }
        </script>
    </body>
</html>