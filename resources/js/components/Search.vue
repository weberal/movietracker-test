<template>
    <div class="container col-lg-8">
        <h2 class="mb-2">Search for movies:</h2>
        <form class="d-flex" @submit.prevent>
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" v-model="search">
            <button class="btn btn-primary my-2 my-sm-0" type="submit" v-on:click="searchMovies()">Search</button>
        </form>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mt-3">
            <h3 class="mb-1 w-100" v-if="foundMovies > 0">{{ foundMovies }} movies found.</h3>
            <div class="col" v-for="movie in movies" :key="movie.imdbID">
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

            <nav class="w-100 mt-5" v-if="foundMovies > 10">
                <ul class="pagination justify-content-center flex-wrap">
                    <li class="page-item">
                        <a class="page-link" role="button" v-if="page != 1" @click="searchMovies(page-1)">Previous</a>
                    </li>
                    <li class="page-item" :class="{active: page == 1}">
                        <a class="page-link" role="button" @click="searchMovies(1)">1</a>
                    </li>
                    <li class="page-item" v-if="page > 3">
                        <span class="page-link">...</span>
                    </li>
                    <li class="page-item" :class="{active: page == pageNumber}" v-for="pageNumber in pageArray" :key="pageNumber">
                        <a class="page-link" role="button" @click="searchMovies(pageNumber)">{{ pageNumber}}</a>
                    </li>
                    <li class="page-item" v-if="page < maxPages - 2">
                        <span class="page-link">...</span>
                    </li>
                    <li class="page-item" :class="{active: page == maxPages}">
                        <a class="page-link" role="button" @click="searchMovies(maxPages)">{{ maxPages }}</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" role="button" v-if="page < maxPages" @click="searchMovies(page+1)">Next</a>
                    </li>
                </ul>
            </nav>

            <p class="alert alert-danger mx-auto text-center" v-if="foundMovies == 0">No movie found for this title!</p>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                watchedIDs: [],
                movies : [],
                foundMovies: -1,
                search : "",
                page: 1,
                maxPages: 1,
                pageArray: []
            }
        },
        methods : {
            addMovie(imdbID) {
                axios.post(`api/movies`, {imdbID}).then(response => {
                    if ( response.data.status ) {
                        this.watchedIDs.push(imdbID);
                    }
                })
            },
            removeMovie(movie) {
                axios.delete(`api/movies/${movie.imdbID}`).then(response => {
                    if ( response.data.status ) {
                        this.watchedIDs.splice(this.watchedIDs.indexOf(movie.imdbID, 1));
                    }
                })
            },
            searchMovies(page = 1) {
                this.movies = [];
                if ( page != this.page ) this.page = page;

                axios.get(`api/movies/${this.search}/${this.page}`).then(response => {
                    if ( response.data.Response == "True" ) {
                        this.foundMovies = response.data.totalResults;
                        this.maxPages = Math.ceil(this.foundMovies / 10);
                        response.data.Search.forEach((data) => {
                            this.movies.push(data)
                        });

                        this.getPagination();
                    } else {
                        this.foundMovies = 0;
                        this.maxPages = 0;
                    }
                    
                });
            },
            isMovieWatched(imdbID) {
                if (this.watchedIDs.indexOf(imdbID) > -1) {
                    return true
                }
                return false
            },
            getPagination() {
                this.pageArray = [];

                if ( this.page > 2 && this.page < this.maxPages - 1 ) {
                    this.pageArray.push(this.page - 1);
                    this.pageArray.push(this.page);
                    this.pageArray.push(this.page + 1);
                } else if ( this.page < 3 ) {
                    this.pageArray.push(2);
                    this.pageArray.push(3);
                    this.pageArray.push(4);
                } else if ( this.page == this.maxPages ) {
                    this.pageArray.push(this.page - 3);
                    this.pageArray.push(this.page - 2);
                    this.pageArray.push(this.page - 1);
                } else if ( this.page > this.maxPages - 2 ) {
                    this.pageArray.push(this.page - 2);
                    this.pageArray.push(this.page - 1);
                    this.pageArray.push(this.page);
                }
            }
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