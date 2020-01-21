/* eslint-disable */
import welcome from '@/pages/welcome.vue'
import login from '@/pages/login.vue'
import Admin from '@/components/Admin.vue'
import Dashboard from '@/components/dashboard/views/Dashboard.vue'

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
        meta: { transition: 'zoom' },
    },
    {
        path: '/me',
        component: Admin,
        name: 'Dashboard',
        redirect: '/',
        children: [
            {
                path: '/',
                component: Dashboard,
            }
        ]
    }
]
