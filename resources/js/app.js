import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './components/App'
import Home from './components/Home'
import Search from './components/Search'
import WatchedMovies from './components/WatchedMovies'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/search',
            name: 'search',
            component: Search
        },
        {
            path: '/watched-movies',
            name: 'watchedMovies',
            component: WatchedMovies
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});