/* eslint-disable */
function page (path) {
    return () => import(`@/pages/${path}`).then(m => m.default || m)
}

export default [
    { path: '/', name: 'welcome', component: page('welcome.vue') }
]
