import Vue from 'vue';
import VueRouter from 'vue-router';
import Index from './views/Index'
import PostCreate from './views/posts/Create'

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',

    routes: [
        {
            path: '/', name: 'index', component: Index,
            meta: { title: 'Index' }
        },
        {
            path: '/posts/create', name: 'index', component: PostCreate,
            meta: { title: 'Post Create' }
        },
    ]
})
