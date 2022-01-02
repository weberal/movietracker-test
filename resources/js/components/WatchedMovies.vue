<template>
    <div class="container col-lg-8">
        <h2>My watched movies ({{ watchedIDs.length }})</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mt-3">
            <div class="col" v-for="movie in movies" :key="movie.imdb_id">
                <div class="card h-100">
                    <figure class="card-img-top ratio overflow-hidden" style="--bs-aspect-ratio: 133.3333%;">
                        <img class="top-50 start-50 translate-middle h-auto" :src="movie.Poster" v-if="movie.Poster != 'N/A'" />
                        <span class="top-50 start-50 translate-middle h-auto text-muted text-center" v-if="movie.Poster == 'N/A'">Poster not available</span>
                    </figure>
                    <div class="card-body">
                        <h4 class="card-Title">{{ movie.Title }}</h4>
                        <p class="card-text text-muted">{{ movie.Year }}</p>
                    </div>
                    <div class="card-footer text-end">
                        <a href="#" class="btn btn-secondary" role="button" data-bs-toggle="button" v-if="!isMovieWatched(movie.imdbID)" @click="addMovie(movie.imdbID)">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="#" class="btn btn-primary" role="button" data-bs-toggle="button" v-if="isMovieWatched(movie.imdbID)" @click="removeMovie(movie)">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                watchedIDs: [],
                movies : [],
            }
        },
        methods : {
            removeMovie(movie) {
                axios.delete(`api/movies/${movie.imdbID}`).then(response => {
                    if ( response.data.status ) {
                        this.watchedIDs.splice(this.watchedIDs.indexOf(movie.imdbID, 1));
                        this.movies.splice(this.movies.indexOf(movie), 1);
                    }
                });
            },
            isMovieWatched(imdbID) {
                if (this.watchedIDs.indexOf(imdbID) > -1) {
                    return true
                }
                return false
            }
        },
        mounted(){
            axios.defaults.headers.common['Content-Type'] = 'application/json'

            axios.get('api/movie-ids').then(response => {
                response.data.forEach((data) => {
                    this.watchedIDs.push(data);
                });
            });

            axios.get('api/movies').then(response => {
                response.data.forEach((data) => {
                    this.movies.push(data)
                });
            });
        },
    }
</script>