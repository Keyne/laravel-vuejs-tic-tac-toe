/**
 * Tic Tac Toe Front End
 * Tienda Nube - Nuvem Shop
 */

require('./bootstrap');

window.Vue = require('vue');

const App = require('./components/App.vue');

const app = new Vue({
    el: '#app',
    components: {
        'app': App
    }
});
