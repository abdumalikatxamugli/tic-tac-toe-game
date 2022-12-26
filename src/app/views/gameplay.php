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
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="w-25 border p-4 bg-white">
                    <h6>Computer side: <span x-text="computerSide"></span></h6>
                    <h6 class="pb-5">Player side: <span x-text="playerSide"></span></h6>
                    <div class="pb-5">
                        <template x-for="(row, rowIndex) in state">
                            <div class="d-flex w-100 justify-content-center">
                                <template x-for="(column, colIndex) in row">
                                    <div class="p-2 d-flex justify-content-center">
                                        <input type="text" readonly x-on:click="makeMove(rowIndex, colIndex)" x-bind:value="column"/>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>            
        </div>
        <script>
            function managePage()
            {
                return {
                    state : JSON.parse(`<?php echo json_encode($state)?>`),
                    canMove: true,
                    playerSide : '<?php echo $game->player_side?>',
                    computerSide : '<?php echo $game->computer_side?>',
                    game_id: <?php echo $game->id?>,
                    winOptions: {
                        computer:"computer",
                        player: "player",
                        draw: "draw",
                        none: "none"
                    },
                    makeMove: function(rowIndex, colIndex)
                    {
                        if( this.state[rowIndex][colIndex] !== null)
                        {
                            return;
                        }
                        if(this.canMove)
                        {
                            this.state[rowIndex][colIndex] = this.playerSide;
                        }
                        this.canMove = false;
                        const self = this;
                        fetch("/makemove", {
                                method: 'POST',
                                body: JSON.stringify({state:this.state, side: this.computerSide, game_id: this.game_id}) 
                        })
                        .then(function(response)
                        {
                            return response.json();   
                        })
                        .then(function(jsonResponse)
                        {
                            self.canMove = true;
                            if( jsonResponse.win  === self.winOptions.computer)
                            {
                                alert("Game is over. Computer won.");
                                window.location.assign("/");
                            }
                            if( jsonResponse.win === self.winOptions.player)
                            {
                                alert("Congratulations !!! You won! ");
                                window.location.assign("/");
                            }
                            if( jsonResponse.win === self.winOptions.draw )
                            {
                                alert("Game is over. It is a draw.");
                                window.location.assign("/");
                            }
                            self.state = jsonResponse.nextState;
                        })
                        .catch(function(err)
                        {
                            console.log(err)
                        })
                    },
                    initialize: function()
                    {
                        /**
                         * Front does not decide who is playing what side.
                         * Backend do it.
                         */
                        // if( Math.random() < 0.5 )
                        // {
                        //     this.playerSide = 'x';
                        //     this.computerSide = 'o';
                        // }else{
                        //     this.playerSide = 'o';
                        //     this.computerSide = 'x';
                        // }
                    }
                }
            }
        </script>
    </body>
</html>