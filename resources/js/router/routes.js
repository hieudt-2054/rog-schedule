/* eslint-disable */
import welcome from '@/pages/welcome.vue'
import login from '@/modules/auth/views/Login.vue'
import Admin from '@/components/Admin.vue'
import HelloWord from '@/modules/dashboard/views/HelloWord.vue'

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
                component: HelloWord,
            }
        ]
    }
]
