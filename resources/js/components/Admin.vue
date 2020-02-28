<template>
  <v-app id="inspire">
    <app-header></app-header>
    <vue-page-transition name="fade">
        <router-view></router-view>
    </vue-page-transition>
    <app-footer></app-footer>
  </v-app>
</template>

<script>
import { mapState } from 'vuex'
import AppHeader from '@/layouts/dashboard/Header'
import AppFooter from '@/layouts/dashboard/Footer'
import ConfigAxios from '@/config/axios'

export default {
    components: {
        AppHeader,
        AppFooter,
    },
    props: {
        source: String,
    },
    computed: {
        ...mapState({
            token: state => state.auth.token,
            google2fa: state => state.auth.google2fa_data,
        }),
    },
    data: () => ({
    }),
    async created () {
        if (this.token) {
            const tokenType = 'Bearer'
            const accessToken = this.token.access_token

            ConfigAxios.setAuthorizationHeader(tokenType, accessToken)
            await this.$store.dispatch('auth/get2FA')
        }
    },
}
</script>
