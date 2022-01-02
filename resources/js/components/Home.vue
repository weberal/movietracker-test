<template>
    <div class="container">
        <div class="text-center my-5 px-5 py-5">
            <h1 class="fw-bold mb-4">MovieTracker</h1>
            <p class="lead">I watched {{ watchedIDs.length }} movies.</p>
            
            <div class="d-grid gap-4 d-sm-flex justify-content-center">
                <router-link :to="{ name: 'watchedMovies' }" class="">See list of my watched movies</router-link>
                <router-link :to="{ name: 'search' }" class="">Search for more movies</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                watchedIDs: []
            }
        },
        methods : {
        },
        mounted(){
            axios.defaults.headers.common['Content-Type'] = 'application/json'

            axios.get('api/movie-ids').then(response => {
                response.data.forEach((data) => {
                    this.watchedIDs.push(data);
                });
            });
        },
    }
</script>
