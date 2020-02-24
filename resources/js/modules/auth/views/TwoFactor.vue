<template>
  <v-content>
    <div class="text-center ma-2">
      <v-snackbar
        v-model="snackbar"
      >
        Secret Create Successfully
        <v-btn
          color="blue"
          text
          right
          @click="snackbar = false"
        >
          Close
        </v-btn>
      </v-snackbar>
    </div>
    <v-card class="mx-2 mt-2">
      <v-tabs
        v-model="tab"
        background-color="primary"
        dark
      >
        <v-tab
          v-for="item in items"
          :key="item.tab"
        >
          {{ item.tab }}
        </v-tab>
      </v-tabs>
      <v-tabs-items v-model="tab">
        <v-tab-item
          v-for="item in items"
          :key="item.tab"
        >
          <v-card flat>
            <v-card-text>
                <p>Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.</p>
                <br/>
                <p>To Enable Two Factor Authentication on your Account, you need to do following steps</p>
                <strong>
                <ol>
                    <li>Click on Generate Secret Button , To Generate a Unique secret QR code for your profile</li>
                    <li>Verify the OTP from Google Authenticator Mobile App</li>
                </ol>
                </strong>
                <div class="my-2">
                  <v-btn large color="primary" @click="generate2FA" v-if="!google2faState && !google2fa">Generate Secret Key to Enable 2FA</v-btn>
                </div>
            </v-card-text>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-card>
  </v-content>
</template>

<script>
import { mapState } from 'vuex'

export default {
    data () {
        return {
            tab: null,
            items: [
                { tab: 'Two Factor Authentication' },
            ],
            snackbar: false,
        }
    },
    computed: {
        ...mapState({
            google2fa: state => state.auth.google2fa_url,
            google2faState: state => state.auth.google2fa_success,
        }),
    },
    methods: {
        async generate2FA () {
            await this.$store.dispatch('auth/generate2FA')
            if (this.google2faState) {
                this.snackbar = true
            }
        },
    },
}
</script>
