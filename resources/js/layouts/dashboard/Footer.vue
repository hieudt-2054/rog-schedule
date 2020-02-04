<template>
    <div>
        <v-btn
            bottom
            color="pink"
            dark
            fab
            fixed
            right
            @click="dialog = !dialog"
          >
            <v-icon>mdi-plus</v-icon>
        </v-btn>
        <v-dialog v-model="dialog" width="800px">
          <v-card>
            <v-card-title class="primary white--text">
              Create Schedule
            </v-card-title>
            <v-container>
              <v-row class="mx-2">
                <v-col class="align-center justify-space-between" cols="12">
                  <v-text-field
                    label="Title"
                    prepend-icon="mdi-format-title"
                    v-model="payload.name"
                  />
                </v-col>
                <v-col cols="6">
                  <v-menu
                    v-model="dialogStartDate"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="payload.startDate"
                        label="Picker Start Date"
                        prepend-icon="mdi-calendar-today"
                        readonly
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="payload.startDate" @input="dialogStartDate = false"></v-date-picker>
                  </v-menu>
                </v-col>
                <v-col cols="6">
                  <v-menu
                  ref="dialogStartTime"
                  v-model="dialogStartTime"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  :return-value.sync="payload.startTime"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="payload.startTime"
                      label="Picker Start Time"
                      prepend-icon="mdi-timer"
                      readonly
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-time-picker
                    v-if="dialogStartTime"
                    v-model="payload.startTime"
                    full-width
                    format="24hr"
                    @click:minute="$refs.dialogStartTime.save(payload.startTime)"
                  ></v-time-picker>
                </v-menu>
                </v-col>
                <v-col cols="6">
                  <v-menu
                    v-model="dialogEndDate"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="payload.endDate"
                        label="Picker End Date"
                        prepend-icon="mdi-calendar-today"
                        readonly
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="payload.endDate" @input="dialogEndDate = false"></v-date-picker>
                  </v-menu>
                </v-col>
                <v-col cols="6">
                  <v-menu
                  ref="dialogEndTime"
                  v-model="dialogEndTime"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  :return-value.sync="payload.endTime"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="payload.endTime"
                      label="Picker End Time"
                      prepend-icon="mdi-timer"
                      readonly
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-time-picker
                    v-if="dialogEndTime"
                    v-model="payload.endTime"
                    full-width
                    format="24hr"
                    @click:minute="$refs.dialogEndTime.save(payload.endTime)"
                  ></v-time-picker>
                </v-menu>
                </v-col>
                <v-col class="align-center justify-space-between" cols="12">
                  <v-text-field
                    label="Details"
                    prepend-icon="mdi-text"
                    v-model="payload.description"
                  />
                </v-col>
                <v-col cols="12">
                  <v-color-picker class="ma-2" v-model="payload.color"></v-color-picker>
                </v-col>
              </v-row>
            </v-container>
            <v-card-actions>
              <v-btn
                text
                color="primary"
              >More</v-btn>
              <v-spacer />
              <v-btn
                text
                color="primary"
                @click="dialog = false"
              >Cancel</v-btn>
              <v-btn
                text
                @click="dialog = false, submit()"
              >Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
    </div>
</template>
<script>
import { mapActions, mapState } from 'vuex'

export default {
    data: () => ({
        dialog: false,
        dialogStartDate: false,
        dialogStartTime: false,
        dialogEndDate: false,
        dialogEndTime: false,
        dialogColor: false,
        date: '',
        time: null,
        payload: {
            name: '',
            description: '',
            startDate: null,
            startTime: null,
            endDate: null,
            endTime: null,
            color: {
                hex: null,
            },
        },
    }),
    computed: {
        ...mapState({
            token: state => state.auth.token,
            storeSuccess: state => state.schedule.storeSuccess
        }),
    },
    methods: {
        ...mapActions({
            storeSchedule: 'schedule/storeSchedule',
        }),

        async submit () {
            const data = {
                name: this.payload.name,
                user_id: this.token.user.id,
                description: this.payload.description,
                start: this.payload.startDate + ' ' + this.payload.startTime,
                end: this.payload.endDate + ' ' + this.payload.endTime,
                color_code: this.payload.color.hex,
            }

            await this.storeSchedule({
                vue: this,
                params: data,
            })
            if (this.storeSuccess) {
                await this.$store.dispatch('schedule/actionGetScheduleByUser')
            }
        },
    },
}
</script>
