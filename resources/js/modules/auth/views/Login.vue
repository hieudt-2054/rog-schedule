<template>
  <v-app id="inspire">
    <v-content>
      <v-container
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
                <v-form ref="form" v-model="valid" lazy-validation>
                  <v-text-field
                    v-if="!login.isBtnLoggingIn"
                    v-model="login.payload.name"
                    light="light"
                    prepend-icon="mdi-account-card-details"
                    label="Name"
                    :rules="nameRules"
                    :counter="100"
                    required
                  />

                  <v-text-field
                    label="Email"
                    name="login"
                    prepend-icon="mdi-account"
                    v-model="login.payload.email"
                    type="text"
                    :rules="emailRules"
                    required
                  />

                  <v-text-field
                    id="password"
                    label="Password"
                    name="password"
                    v-model="login.payload.password"
                    prepend-icon="mdi-textbox-password"
                    type="password"
                    :rules="passwordRules"
                    required
                  />

                  <v-text-field
                    v-if="!login.isBtnLoggingIn"
                    v-model="login.payload.password_confirmation"
                    light="light"
                    prepend-icon="mdi-textbox-password"
                    label="Password Confirm"
                    type="password"
                    :rules="passwordConfirmRules"
                    requried
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
                  :disabled="!valid"
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
            <div align="center" class="mt-4">
              <v-btn color="secondary" @click="AuthProvider('google')">
                Login with Google
                <v-icon color="blue">mdi-google</v-icon>
              </v-btn>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
    <v-snackbar
      v-model="snackbar"
      bottom
      right
    >
      {{ error.message }}
      <v-btn
        color="red"
        text
        @click="snackbar = false"
      >
        Close
      </v-btn>
    </v-snackbar>
  </v-app>
</template>
<script>
import { mapState, mapGetters } from 'vuex'

export default {
    data () {
        return {
            valid: true,
            snackbar: false,
            login: {
                payload: {},
                isBtnLoggingIn: true,
            },
            httpResponseStatusCode: this.$route.query.code,
            nameRules: [
                v => !!v || 'Name is required',
                v => (v && v.length <= 100) || 'Name must be less than 10 characters',
            ],
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
            passwordRules: [
                v => !!v || 'Password is required',
                v => (v && v.length >= 6) || 'Password must be greater than 6 characters',
            ],
            passwordConfirmRules: [
                v => !!v || 'Password confirmation is required',
                v => (v && v === this.login.payload.password) || 'Password confirmation does not match',
            ],
        }
    },
    watch: {
        isLoggedIn () {
            return this.$router.push({
                path: '/me',
            })
        },

        'login.isBtnLoggingIn' () {
            this.resetValidation()
        },

        error (value) {
            this.snackbar = true
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
            if (this.$refs.form.validate()) {
                await this.$store.dispatch('auth/login', {
                    vue: this,
                    params: this.login.payload,
                })
            }
        },

        async signup () {
            if (this.$refs.form.validate()) {
                await this.$store.dispatch('auth/register', {
                    vue: this,
                    params: this.login.payload,
                })
            }
        },

        AuthProvider (provider) {
            this.$auth.authenticate(provider).then(response => {
                this.SocialLogin(provider, response)
            })
        },

        SocialLogin (provider, response) {
            this.$http.post('/sociallogin/' + provider, response).then(response => {
                this.$store.dispatch('auth/setToken', response)
            })
        },

        resetValidation () {
            this.$refs.form.resetValidation()
        },
    },
}
</script>
