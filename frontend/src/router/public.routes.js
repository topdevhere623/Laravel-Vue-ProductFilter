
export  default [
    {
        path: '/',
        redirect: '/dashboard',
        name: 'home',
        beforeEnter: (to, from, next) => {
           console.log(to,from,next)
        }
    },
    {
        path: '/dashboard',
        name: 'dashboard.index',
        component: () => import('../views/dashboard/Index.vue'),
        meta: { auth: true, visible: true, icon: 'mdi-timer-outline', text: 'Dashboard' }
    },
    {
        path: '/about',
        name: 'about',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import(/* webpackChunkName: "about" */ '../views/About.vue'),
        meta: { }
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('../views/Login.vue'),
        meta: { auth: false}
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('../views/Register.vue'),
        meta: { auth: false}
    },
    {
        path: '/sign-up',
        name: 'sign-up',
        component: () => import('../views/SignUp.vue'),
        meta: { auth: false }
    },
    {
        path: '/forgot-password',
        name: 'forgot-password',
        component: () => import('../views/ForgotPassword.vue'),
        meta: { auth: false }
    },
    {
        path: '/reset-password',
        name: 'reset-password',
        component: () => import('../views/ResetPassword.vue'),
        meta: { auth: false }
    },
    {
        path: '/403',
        name: '403',
        component: () => import('../views/static/403.vue'),
        meta: { }
    },
    {
        path: '/privacy-policy',
        name: 'privacy-policy',
        component: () => import('../views/static/PrivacyPolicy.vue'),
        meta: { }
    },
]
