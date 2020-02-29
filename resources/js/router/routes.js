/* eslint-disable */
import welcome from '@/pages/welcome.vue'
import login from '@/modules/auth/views/Login.vue'
import Admin from '@/components/Admin.vue'
import Calendar from '@/modules/dashboard/views/Calendar.vue'
import TwoFactor from '@/modules/auth/views/TwoFactor.vue'

export default [
    {
        path: '/',
        name: 'welcome',
        component: welcome
    },
    {
        path: '/login',
        name: 'login',
        component: login,
        meta: { transition: 'fade' },
    },
    {
        path: '/auth/:provide/callback',
        component: {
            template: '<div class="auth-component"></div>'
        },
    },
    {
        path: '/me',
        component: Admin,
        name: 'Dashboard',
        meta: {
            requiresAuth: true,
        },
        redirect: '/',
        children: [
            {
                path: '/',
                component: Calendar,
            },
            {
                path: '/2fa',
                component: TwoFactor,
                meta: { transition: 'fade' },
            }
        ]
    }
]
