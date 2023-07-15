import bearer from '@websanova/vue-auth/drivers/auth/bearer'
import axios from '@websanova/vue-auth/drivers/http/axios.1.x'
import router from '@websanova/vue-auth/drivers/router/vue-router.2.x'

const config = {
    auth: bearer,
    http: axios,
    router: router,
    tokenStore: ['localStorage'],
    authRedirect: {path: 'sign'},
    rolesVar: 'role',
    registerData: {url: 'auth/register', method: 'POST', redirect: '/sign'},
    loginData: {url: 'login-custom', method: 'POST', redirect: '/dashboard', fetchUser: true},
    logoutData: {url: 'auth/logout', method: 'POST', redirect: '/', makeRequest: true},
    fetchData: {url: 'user', method: 'GET', enabled: true},
    refreshData: {url: 'login-refresh', method: 'GET', enabled: true, interval: 30}
}
export default config