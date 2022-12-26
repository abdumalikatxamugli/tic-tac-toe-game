<html>
    <head>
        <link href="/bootstrap.min.css" rel="stylesheet"/>
        <script src="/alpine.min.js" defer></script>
        <style>
            input{
                width: 30px;
                cursor: pointer;
            }
        </style>
    </head>
    <body style="background-color: whitesmoke">
        <div class="container" x-data="managePage()" x-init="initialize()">
            <div class="d-flex justify-content-center align-items-center h-100 ">
                <div class="w-25 border p-4 bg-white">
                    <h6>Computer side: <span x-text="computerSide"></span></h6>
                    <h6 class="pb-5">Player side: <span x-text="playerSide"></span></h6>
                    <div class="pb-5">
                        <template x-for="(row, rowIndex) in states[activeStateIndex]">
                            <div class="d-flex w-100 justify-content-center">
                                <template x-for="(column, colIndex) in row">
                                    <div class="p-2 d-flex justify-content-center">
                                        <input type="text" readonly x-on:click="makeMove(rowIndex, colIndex)" x-bind:value="column"/>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                    <div class="p-2 text-center">
                        <i>
                            You may use your forward and backward keys of your keyword to move back and forth in game. 
                        </i>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button x-on:click="backward()" class="m-1 btn btn-outline-success"><<</button>
                        <button x-on:click="forward()" class="m-1 btn btn-outline-success">>></button>
                    </div>
                </div>
                
            </div>            
        </div>
        <script>
            function managePage()
            {
                return {
                    states: JSON.parse(`<?php echo json_encode($states)?>`),
                    activeStateIndex: 0,
                    playerSide: '<?php echo $game->player_side?>',
                    computerSide: '<?php echo $game->computer_side?>',
                    forwardKey: 39,
                    backwardKey: 37,
                    forward: function()
                    {
                        if( this.activeStateIndex < this.states.length -1 )
                        {
                            this.activeStateIndex = this.activeStateIndex + 1;
                        }
                    },
                    backward: function()
                    {
                        if( this.activeStateIndex > 0 )
                        {
                            this.activeStateIndex = this.activeStateIndex - 1;
                        }
                    },
                    initialize: function()
                    {
                        const self = this;
                        document.addEventListener('keyup', function(e)
                        {   
                            if(e.keyCode === self.forwardKey)
                            {
                                self.forward();
                            }
                            if(e.keyCode === self.backwardKey)
                            {
                                self.backward();
                            }
                        })
                    }
                }
            }
        </script>
    </body>
</html>