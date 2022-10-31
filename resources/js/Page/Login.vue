<template>
    <v-app>
        <v-content>
            <v-container fluid class="fill-height">
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4>
                        <v-card>
                            <v-card-title primary-title>
                                <div>
                                    <v-icon>mdi-login</v-icon>
                                    <span class="headline">Login</span>
                                </div>
                            </v-card-title>
                            <v-card-text>
                                <v-form ref="form" v-model="valid" lazy-validation>
                                    <v-text-field
                                        v-model="form.email"
                                        :rules="emailRules"
                                        label="Email Address"
                                        prepend-icon="mdi-email"
                                        @keyup.enter="login"
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="form.password"
                                        :rules="passwordRules"
                                        label="Password"
                                        type="password"
                                        prepend-icon="mdi-lock"
                                        @keyup.enter="login"
                                    ></v-text-field>
                                    <v-btn
                                        color="primary"
                                        class="mt-5"
                                        @click="login"
                                        :disabled="!valid"
                                    >
                                        Login
                                    </v-btn>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</template>
<script>
import mix from '../mixins/mix';
export default {    
    mixins: [mix],
    data() {
        return {
            valid: false,
            form: {
                email: '',
                password: ''
            },
            emailRules: [
                v => !!v || 'Email is required',
                v => /.+@.+\..+/.test(v) || 'Email must be valid'
            ],
            passwordRules: [
                v => !!v || 'Password is required'
            ],
        };
    },
    methods: {
        async login() {
            this.$refs.form.validate();
            if (this.valid) {
                await axios.post('api/login', this.form).then(response => {
                if (response.data.success) {
                    this.$router.push('/inventory');
                    this.$store.dispatch('setDataUser', response.data.user);
                } else {
                    this.form.password = '';
                }
              });
            }
        }
    }
}
</script>