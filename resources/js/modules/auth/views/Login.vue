<template>
  <v-app id="inspire">
    <v-content>
      <v-container
        class="fill-height"
        fluid
      >
        <v-row
          align="center"
          justify="center"
        >
          <v-col
            cols="12"
            sm="1"
            md="4"
          >
            <v-card class="elevation-12">
              <v-toolbar
                color="primary"
                dark
                flat
              >
                <v-toolbar-title v-if="login.isBtnLoggingIn">Login Your Account</v-toolbar-title>
                <v-toolbar-title v-else>Register New An Account</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field
                    v-if="!login.isBtnLoggingIn"
                    v-model="login.payload.name"
                    light="light"
                    prepend-icon="mdi-account-card-details"
                    label="Name"
                  />

                  <v-text-field
                    label="Email"
                    name="login"
                    prepend-icon="mdi-account"
                    v-model="login.payload.email"
                    type="text"
                  />

                  <v-text-field
                    id="password"
                    label="Password"
                    name="password"
                    v-model="login.payload.password"
                    prepend-icon="mdi-textbox-password"
                    type="password"
                  />

                  <v-text-field
                    v-if="!login.isBtnLoggingIn"
                    v-model="login.payload.password_confirmation"
                    light="light"
                    prepend-icon="mdi-textbox-password"
                    label="Password Confirm"
                    type="password"
                  />
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer />
                <v-btn color="blue-grey lighten-3" to="/">Back</v-btn>
                <v-btn
                  color="primary"
                  @click="this.signin"
                  :loading="isLoading"
                  v-if="login.isBtnLoggingIn"
                >
                  Login
                </v-btn>
                <v-btn
                  color="primary"
                  @click="this.signup"
                  :loading="isLoading"
                  v-else
                >
                  Register
                </v-btn>
              </v-card-actions>
            </v-card>
            <div align="center" class="mt-4" v-if="login.isBtnLoggingIn">Don't have an account?
              <v-btn light="light" @click="login.isBtnLoggingIn = false">Sign up</v-btn>
            </div>
            <div align="center" class="mt-4" v-else>Have an account?
              <v-btn light="light" @click="login.isBtnLoggingIn = true">Sign In</v-btn>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>
<script>
import { mapState, mapGetters } from 'vuex'

export default {
    data () {
        return {
            login: {
                payload: {},
                isBtnLoggingIn: true,
            },
            httpResponseStatusCode: this.$route.query.code,
        }
    },
    watch: {
        isLoggedIn () {
            return this.$router.push({
                path: '/me',
            })
        },
    },
    computed: {
        ...mapState({
            isLoading: state => state.auth.loading,
            error: state => state.auth.error,
            token: state => state.auth.token,
        }),

        ...mapGetters({
            isLoggedIn: 'auth/isLoggedIn',
        }),
    },
    beforeMount () {
        if (this.isLoggedIn) {
            return this.$router.push({
                path: '/me',
            })
        }
    },
    methods: {
        async signin () {
            await this.$store.dispatch('auth/login', {
                vue: this,
                params: this.login.payload,
            })
        },

        async signup () {
            await this.$store.dispatch('auth/register', {
                vue: this,
                params: this.login.payload,
            })
        },
    },
}
</script>
