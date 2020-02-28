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
      <v-snackbar
        v-model="google2fa_enable_fail"
        color="error"
      >
        Invalid Verification Code, Please try again.
        <v-btn
          color="white"
          text
          right
          @click="refresh2faState()"
        >
          Close
        </v-btn>
      </v-snackbar>
      <v-snackbar
        v-model="google2fa_enable_success"
        color="success"
      >
        2FA Enabled successfully
        <v-btn
          color="white"
          text
          right
          @click="refresh2faState()"
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
                </strong><br/>
                <div class="my-2" v-if="!google2fa.passwordSecurity && !google2fa.google2fa_enable">
                  <v-btn large color="primary" @click="generate2FA" v-if="!google2fa.passwordSecurity">Generate Secret Key to Enable 2FA</v-btn>
                </div>
                <v-alert
                  dense
                  text
                  type="success"
                  v-if="google2fa.google2fa_enable"
                >
                  2FA is Enabled
                </v-alert>
                <div class="my-2" v-if="google2fa.passwordSecurity && !google2fa.google2fa_enable">
                    <v-alert
                      dense
                      outlined
                      type="error"
                    >
                      Secret Key is generated. Please verify Code to Enable 2FA
                    </v-alert>
                    <strong>1. Scan this barcode with your Google Authenticator App:</strong><br/>
                    <img :src="google2fa.google2fa_url"><br/>
                    <strong>2.Enter the pin the code to Enable 2FA</strong><br/>
                    <v-row>
                      <v-col cols="8" sm="6">
                        <v-text-field
                          label="PIN"
                          v-model="pinBarcode"
                          prepend-icon="mdi-barcode-scan"
                        ></v-text-field>
                      <div class="my-2">
                        <v-btn color="primary" dark @click="enable2fa" :loading="enableStateLoading">Enable 2FA</v-btn>
                      </div>
                      </v-col>
                    </v-row>
                </div>
            </v-card-text>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-card>
  </v-content>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
    data () {
        return {
            tab: null,
            items: [
                { tab: 'Two Factor Authentication' },
            ],
            snackbar: false,
            pinBarcode: null,
            enableStateLoading: false,
        }
    },
    created () {
        this.get2FA()
    },
    computed: {
        ...mapState({
            google2fa: state => state.auth.google2fa_data,
            google2faState: state => state.auth.google2fa_success,
            google2fa_enable_fail: state => state.auth.google2fa_enable_fail,
            google2fa_enable_success: state => state.auth.google2fa_enable_success,
        }),
    },
    methods: {
        ...mapActions({
            get2FA: 'auth/get2FA',
            refresh2faState: 'auth/refresh2faState',
        }),

        async generate2FA () {
            await this.$store.dispatch('auth/generate2FA')
            if (this.google2faState) {
                this.snackbar = true
            }
            this.get2FA()
        },

        async enable2fa () {
            this.enableStateLoading = true
            this.refresh2faState()
            await this.$store.dispatch('auth/enable2FA', {
                verifyCode: this.pinBarcode,
            })
            this.get2FA()
            this.enableStateLoading = false
        },
    },
}
</script>
