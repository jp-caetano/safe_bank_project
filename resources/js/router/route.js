import {createRouter, createWebHistory} from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: () => import('../pages/Home.vue')
        },
        {
            path: '/login',
            component: () => import('../pages/Login.vue')
        },
        {
            path: '/register',
            component: () => import('../pages/Register.vue')
        },
        {
            path: '/main',
            component: () => import('../pages/Main.vue')
        },
        {
            path: '/profile',
            component: () => import('../pages/Profile.vue')
        },
        {
            path: '/deposit',
            component: () => import('../pages/Deposit.vue')
        },
        {
            path: '/withdraw',
            component: () => import('../pages/Withdraw.vue')
        },
        {
            path: '/transfer',
            component: () => import('../pages/Transfer.vue')
        },
        {
            path: '/statement',
            component: () => import('../pages/Statement.vue')
        }
    ],
})
router.beforeEach((to, from, next) => {
    if (to.path !== '/' && to.path !== '/login' && to.path !== '/register' && !isAuthenticated()) {
        return next({path: '/'})
    }
    return next()
})

function isAuthenticated() {
    return Boolean(localStorage.getItem('APP_DEMO_USER_TOKEN'))
}

export default router;
