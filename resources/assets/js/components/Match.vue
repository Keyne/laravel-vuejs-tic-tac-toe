<template>
    <div class="card card-default bg-info text-white">
        <div class="card-header"><h3>
            {{match.name}} - You: {{ currentPlayerSign() }}
            <i v-if="loading" class="fas fa-cog fa-spin"></i>
        </h3></div>

        <div class="card-body text-center">
            <p v-if="ended" class="card-text alert alert-success">
                <span v-if="match.winner < 3">The winner is: {{ winner()}}</span>
                <span v-else>Draw!</span>
            </p>
            <p class="card-text alert alert-success" v-else>Next to play: {{ next()}}</p>


            <div v-if="(!currentPlayer && (match.player_1 == null || match.player_2 == null))">
                Who are you?
                <button class="btn btn-light" @click="playAs(1)" :disabled="match.player_1 !== null">X</button>
                <button class="btn btn-light" @click="playAs(2)"  :disabled="match.player_2 !== null">O</button>
            </div>
            <div v-else>
                <div class="alert alert-dark" v-if="(match.player_1 == null || match.player_2 == null)">
                    Waiting for next player to connect
                </div>
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
  const RELOAD_TIME = 1000
  export default {
    props: ['match', 'loading', 'currentPlayer'],
    data() {
      return {

        timeout: null,
      }
    },
    computed: {
      ended() {
        return this.match.winner !== 0
      }
    },
    methods: {
      playAs(player) {
        this.$emit('playAs', {
          player: player,
          match_id: this.match.id
        })
      },
      field(index) {
        return this.player(this.match.board[index])
      },
      next() {
        return this.player(this.match.next)
      },
      currentPlayerSign() {
        if (!this.currentPlayer) {
          return "Watching...";
        }
        return this.player(this.currentPlayer)
      },
      winner() {
        return this.player(this.match.winner)
      },
      player(value) {
        return value === 1 ? 'X' : (value === 2 ? 'O' : '')
      },
      move(position) {
        if (this.match.winner !== 0) {
          return alert('The winner is: ' + (this.match.winner === 1 ? 'X' : 'O'))
        }
        if (this.match.next !== this.currentPlayer) {
          alert('Not your turn!')
          return
        }
        this.$emit('move', {
          position: position,
          id: this.match.id
        })
      },
      load() {
        if (!this.loading) {
          this.$emit('load')
        }
        if (!this.ended) {
          this.timeout = setTimeout(this.load, RELOAD_TIME)
        }
      },
      back() {
        clearTimeout(this.timeout)
        this.$emit('showMatches')
      }
    },
    mounted() {
      this.timeout = setTimeout(this.load, RELOAD_TIME / 3)
      this.$emit('fetchCurrentPlayer', {id: this.match.id})
      this.$emit('newSession')
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
