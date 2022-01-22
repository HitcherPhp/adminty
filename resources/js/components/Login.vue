<template>
  <div class="containerFull">
    <v-card>
      <v-card-title>
        <h2>login</h2>
      </v-card-title>
      <v-card-text>
        <v-form
            ref="form"
        >
          <v-text-field
              v-model="email"
              :rules="emailRules"
              label="E-mail"
              required
          ></v-text-field>
          <v-text-field
              v-model="password"
              required
              :append-icon="showPass ? 'mdi-eye' : 'mdi-eye-off'"
              :rules="[rules.required, rules.min]"
              :type="showPass ? 'text' : 'password'"
              label="Password"
              @click:append="showPass = !showPass"
          ></v-text-field>
          <v-row justify="space-between" align="center">
            <v-col cols="auto">
              <v-checkbox
                  v-model="checkbox"
                  label="Remember me"
              ></v-checkbox>
            </v-col>
            <v-col cols="auto">
              <router-link to="/forgot">Забыли пароль ?</router-link>
            </v-col>
          </v-row>

          <v-btn
              @click="submit"
          >
            <span class="textDefault">Войти</span>
          </v-btn>
        </v-form>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import {getCurrentUser, getFranchises, getNavBarList, login} from "../api";
import LayoutApp from "../Layout/LayoutApp";

export default {
  name: "Login",
  data: () => ({
    password:'',
    email: '',
    checkbox:false,
    emailRules: [
      v => !!v || 'E-mail is required',
      v => /.+@.+/.test(v) || 'E-mail must be valid',
    ],
    showPass: false,
    rules: {
      required: value => !!value || 'Required.',
      min: v => v.length >= 6 || 'Min 6 characters',
    },
  }),
  methods: {
    submit() {
      const valid = this.$refs.form.validate()
      if (valid){
        login(this.email,this.password).then(r=>{
          if (r.status === 200){
            this.$router.push('/')
            this.$emit('update:layout', LayoutApp)
            this.$store.commit('setLoadingApp', true)
            axios.all([getNavBarList(), getFranchises(), getCurrentUser()])
                .then(axios.spread((getNavBarList, getFranchises,getCurrentUser) => {
                  if (getNavBarList.status == 200){
                    this.$store.commit('setNavBar', getNavBarList.data)
                  }
                  if (getFranchises.status == 200) {
                    this.$store.commit('setItemsFranchises', getFranchises.data)
                  }
                  if (getCurrentUser.status == 200) {
                    this.$store.commit('setCurrentUser', getCurrentUser.data)
                  }
                  this.$store.commit('setLoadingApp', false)
                }))
          }
        })
      }
    },
  },
  created() {
    this.$emit(`update:layout`, `div`);
  }
}
</script>

<style scoped>

</style>
