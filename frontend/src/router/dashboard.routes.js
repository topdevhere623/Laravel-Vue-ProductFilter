import i18n from '@/i18n'

export default [
    {
        path: '/dashboard',
        name: 'dashboard.index',
        component: () => import('../views/dashboard/Index.vue'),
        meta: { auth: true, visible: true, icon: 'mdi-timer-outline', text: i18n.t('scoliotracker.dashboard') }
    },

]
