import Vue from 'vue'
import VueRouter from 'vue-router'
import publicRoutes from './public.routes'

Vue.use(VueRouter)

const routes = [
    ...publicRoutes,
]

const router = new VueRouter({
    mode: 'history',
    base: '/',
    routes
})

export default router
