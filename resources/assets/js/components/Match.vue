<template>
    <div class="card card-default bg-info text-white">
        <div class="card-header"><h3>
            {{match.name}}
            <i v-if="loading" class="fas fa-cog fa-spin"></i>
        </h3></div>

        <div class="card-body text-center">
            <p v-if="ended" class="card-text">The winner is: {{ winner()}}</p>
            <p v-else class="card-text">Next: {{ next()}}</p>


            <div v-if="!currentPlayer">
                Who are you?
                <button class="btn btn-light" @click="playAs(1)">X</button>
                <button class="btn btn-light" @click="playAs(2)">O</button>
            </div>
            <div v-else>
                <table id="board" class="board">
                    <tr>
                        <td id="one" @click="move(0)">{{ field(0) }}</td>
                        <td id="two" @click="move(1)">{{ field(1) }}</td>
                        <td id="three" @click="move(2)">{{ field(2) }}</td>
                    </tr>
                    <tr>
                        <td id="four" @click="move(3)">{{ field(3) }}</td>
                        <td id="five" @click="move(4)">{{ field(4) }}</td>
                        <td id="six" @click="move(5)">{{ field(5) }}</td>
                    </tr>
                    <tr>
                        <td id="seven" @click="move(6)">{{ field(6) }}</td>
                        <td id="eight" @click="move(7)">{{ field(7) }}</td>
                        <td id="nine" @click="move(8)">{{ field(8) }}</td>
                    </tr>
                </table>
            </div>
            <hr>
            <div class="text-left">
                <a href="#" class="btn btn-light" @click="back"><i class="fas fa-back"></i>Back</a>
            </div>
        </div>
    </div>
</template>

<script>
    const RELOAD_TIME = 3000;
    export default {
        props: ['match', 'loading'],
        data() {
            return {
                currentPlayer: null,
                timeout: null,
            }
        },
        computed: {
            ended() {
                return this.match.winner !== 0;
            }
        },
        methods: {
            playAs(player) {
                this.currentPlayer = player
            },
            field(index) {
                return this.player(this.match.board[index]);
            },
            next() {
                return this.player(this.match.next);
            },
            winner() {
                return this.player(this.match.winner);
            },
            player(value) {
                return value === 1 ? 'X' : (value === 2 ? 'O' : '');
            },
            move(position) {
                if (this.match.next !== this.currentPlayer) {
                    alert('Not your turn!');
                    return;
                }
                this.$emit('move', {
                    position: position,
                    id: this.match.id
                })
            },
            load() {
                if (!this.loading) {
                    this.$emit('load');
                }
                if(!this.ended){
                    this.timeout = setTimeout(this.load, RELOAD_TIME);
                }
            },
            back() {
                clearTimeout(this.timeout);
                this.$emit('showMatches');
            }
        },
        mounted() {
            this.timeout = setTimeout(this.load, RELOAD_TIME / 3);
        }
    }
</script>

<style scoped="scoped">
    .board {
        margin: 0 20%;
        width: 60%;
        padding: 0;
        font-size: 250%;
        font-weight: bold;
    }

    .board td {
        height: 120px;
        text-align: center;
        vertical-align: middle;
        width: 120px;
        cursor: pointer;
    }

    .board td:hover {
        font-weight: bold;
    }

    .board #one,
    .board #two {
        border-right: 1px solid white;
        border-bottom: 1px solid white;
    }

    .board #three,
    .board #six {
        border-bottom: 1px solid white;
    }

    .board #four,
    .board #five {
        border-right: 1px solid white;
        border-bottom: 1px solid white;
    }

    .board #seven,
    .board #eight {
        border-right: 1px solid white;
    }

</style>
