<template>
    <div>
        <v-navigation-drawer
        v-model="drawer"
        :clipped="$vuetify.breakpoint.lgAndUp"
        app
        >
            <v-list dense>
                <template v-for="item in items">
                <v-row
                    v-if="item.heading"
                    :key="item.heading"
                    align="center"
                >
                    <v-col cols="6">
                    <v-subheader v-if="item.heading">
                        {{ item.heading }}
                    </v-subheader>
                    </v-col>
                    <v-col
                    cols="6"
                    class="text-center"
                    >
                    <a
                        href="#!"
                        class="body-2 black--text"
                    >EDIT</a>
                    </v-col>
                </v-row>
                <v-list-group
                    v-else-if="item.children"
                    :key="item.text"
                    v-model="item.model"
                    :prepend-icon="item.model ? item.icon : item['icon-alt']"
                    append-icon=""
                >
                    <template v-slot:activator>
                    <v-list-item-content>
                        <v-list-item-title>
                        {{ item.text }}
                        </v-list-item-title>
                    </v-list-item-content>
                    </template>
                    <v-list-item
                    v-for="(child, i) in item.children"
                    :key="i"
                    link
                    >
                    <v-list-item-action v-if="child.icon">
                        <v-icon>{{ child.icon }}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>
                        {{ child.text }}
                        </v-list-item-title>
                    </v-list-item-content>
                    </v-list-item>
                </v-list-group>
                <v-list-item
                    v-else
                    :key="item.text"
                    link
                >
                    <v-list-item-action>
                    <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                    <v-list-item-title>
                        {{ item.text }}
                    </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                </template>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar
        :clipped-left="$vuetify.breakpoint.lgAndUp"
        app
        color="blue darken-3"
        dark
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
            <v-toolbar-title
                style="width: 300px"
                class="ml-0 pl-4"
            >
            <router-link
                linkActiveClass="hidden-sm-and-down"
                to="/me"
            >
                <span class="hidden-sm-and-down white--text">Home Schedule</span>
            </router-link>
                <!-- <span class="hidden-sm-and-down">Google Contacts</span> -->
            </v-toolbar-title>
            <v-text-field
                flat
                solo-inverted
                hide-details
                prepend-inner-icon="mdi-magnify"
                label="Search"
                class="hidden-sm-and-down"
            />
            <v-spacer />
            <v-btn icon>
                <v-icon>mdi-apps</v-icon>
            </v-btn>
            <v-btn icon>
                <v-icon>mdi-bell</v-icon>
            </v-btn>
            <v-menu
                transition="slide-y-transition"
                bottom
                offset-y
            >
                <template v-slot:activator="{ on }">
                    <v-btn
                        icon
                        v-on="on"
                    >
                        <v-icon>mdi-account</v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item
                      v-for="(item, i) in userMenu"
                      :key="i"
                      @click="() => {}"
                      :to="item.link"
                    >
                        <v-list-item-title @click="_funcCall(item.method)">
                            <v-icon>{{ item.icon }}</v-icon> {{ item.title }}
                        </v-list-item-title>
                    </v-list-item>
              </v-list>
            </v-menu>
        </v-app-bar>
    </div>
</template>
<script>
import { mapState, mapActions } from 'vuex'
import Cookies from 'js-cookie'

export default {
    computed: {
        ...mapState({
            user: state => state.auth.user,
        }),
    },
    data: () => ({
        drawer: null,
        items: [
            { icon: 'mdi-contacts', text: 'Contacts' },
            { icon: 'mdi-history', text: 'Frequently contacted' },
            { icon: 'mdi-content-copy', text: 'Duplicates' },
            {
                icon: 'mdi-chevron-up',
                'icon-alt': 'mdi-chevron-down',
                text: 'Labels',
                model: true,
                children: [
                    { icon: 'mdi-plus', text: 'Create label' },
                ],
            },
            {
                icon: 'mdi-chevron-up',
                'icon-alt': 'mdi-chevron-down',
                text: 'More',
                model: false,
                children: [
                    { text: 'Import' },
                    { text: 'Export' },
                    { text: 'Print' },
                    { text: 'Undo changes' },
                    { text: 'Other contacts' },
                ],
            },
            { icon: 'mdi-settings', text: 'Settings' },
            { icon: 'mdi-message', text: 'Send feedback' },
            { icon: 'mdi-help-circle', text: 'Help' },
            { icon: 'mdi-cellphone-link', text: 'App downloads' },
            { icon: 'mdi-keyboard', text: 'Go to the old version' },
        ],
        userMenu: [
            { title: 'Profile', icon: 'mdi-note', method: '', link: '' },
            { title: 'Log out', icon: 'mdi-logout', method: 'logoutAndRedirect', link: '' },
            { title: '2FA Settings', icon: 'mdi-logout', method: '', link: '2fa' },
        ],
    }),
    methods: {
        ...mapActions({
            logout: 'auth/logout',
        }),

        async logoutAndRedirect () {
            await this.logout()
            localStorage.clear()
            Cookies.remove('vuex')
            this.$router.push('/login')
        },

        _funcCall (funcName) {
            if (funcName) {
                this[funcName]()
            }
        },
    },
}
</script>
<style scoped>
a {
    text-decoration: none;
}
</style>
