<template>
    <div class="card card-default bg-info text-white">
        <div class="card-header"><h3>
            Matches
            <i v-if="loading" class="fas fa-cog fa-spin"></i>
        </h3></div>

        <div class="list-group list-group-flush">
            <template v-if="matches.length">
                <div v-for="match in matches"
                     class="list-group-item text-body d-flex justify-content-between ">
                    {{ match.name }}
                    <div class="" role="group">
                        <button type="button" class="btn btn-info" @click="showMatch(match.id)">
                            join
                        </button>
                        <button type="button" class="btn btn-danger" @click="removeMatch(match.id)">
                            remove
                        </button>
                    </div>
                </div>
            </template>
            <a v-else class="list-group-item text-body text-center">
                <i class="fas fa-cog fa-spin"></i> loading...
            </a>
        </div>

        <div class="card-body text-center">
            <a href="#" class="btn btn-light" @click="createMatch" :disabled="loading">
                <i class="fas fa-plus"></i> New match</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['matches', 'loading'],
        methods: {
            showMatch(id) {
                this.$emit('showMatch', id)
            },
            createMatch() {
                this.$emit('createMatch')
            },
            removeMatch(id) {
                this.$emit('removeMatch', id)
            },
        }
    }
</script>