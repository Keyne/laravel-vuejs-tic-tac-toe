<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <template v-if="inMatches">
                    <match-list :matches="matches" :loading="loading" @showMatch="showMatch"
                                @createMatch="createMatch" @removeMatch="removeMatch"/>
                </template>
                <template v-if="inMatch">
                    <match :match="match" :loading="loading"
                           @load="loadMatch(match.id)"
                           @move="handleMove"
                           @showMatches="showMatches"/>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import api from '../api';
    import MatchList from "./MatchList";
    import Match from "./Match";

    const
        MATCHES = 'matches',
        MATCH = 'match';

    export default {
        components: {MatchList, Match},
        data: function () {
            return {
                matches: {},
                match: {},
                loading: true,
                current: MATCHES,
            }
        },
        computed: {
            inMatches() {
                return this.current === MATCHES;
            },
            inMatch() {
                return this.current === MATCH;
            }
        },
        methods: {
            showMatch(id) {
                let that = this;
                that.loading = true;
                // Load match
                api.match({id: id}).then(({data}) => {
                    this.match = data;
                    that.loading = false;
                    this.current = MATCH;
                });
            },
            loadMatch(id) {
                let that = this;
                that.loading = true;
                // Load match
                api.match({id: id}).then(({data}) => {
                    this.match = data;
                    that.loading = false;
                });
            },
            showMatches() {
                let that = this;
                that.loading = true;
                this.current = MATCHES;
                // Load matches
                api.matches().then(({data}) => {
                    that.matches = data;
                    that.loading = false;
                });
            },
            handleMove(data) {
                let that = this;
                that.loading = true;
                api.move(data).then(({data}) => {
                    this.match = data;
                    that.loading = false;
                });
            },
            createMatch() {
                let that = this;
                that.loading = true;
                api.create().then(({data}) => {
                    that.matches = data;
                    that.loading = false;
                    this.current = MATCHES;
                });
            },
            removeMatch(id) {
                let that = this;
                that.loading = true;
                api.destroy({id: id}).then(({data}) => {
                    that.matches = data;
                    that.loading = false;
                    this.current = MATCHES;
                });
            }
        },
        mounted() {
            this.showMatches();
        }
    }
</script>
