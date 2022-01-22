<template>
  <div class="containerFull">
    <v-card>
      <v-card-title>
        <h2>forgot</h2>
      </v-card-title>
      <v-card-text>
        <template v-if="step1">
          <v-text-field
              v-model="email"
              :rules="emailRules"
              label="E-mail"
              required
          ></v-text-field>
          <v-btn @click="step1 = false;step2 = true"><span class="textDefault">Получить код</span></v-btn>
        </template>
        <template v-if="step2">
          <v-text-field
              v-model="code"
              label="Code"
              required
          ></v-text-field>
          <v-btn @click="step2 = false;step3 =true"><span class="textDefault">Потвердить код</span></v-btn>
        </template>
        <template v-if="step3">
          <v-text-field
              v-model="password"
              required

              :append-icon="showPass ? 'mdi-eye' : 'mdi-eye-off'"
              :rules="[rules.required, rules.min]"
              :type="showPass ? 'text' : 'password'"
              label="Password"
              @click:append="showPass = !showPass"
          ></v-text-field>
          <v-text-field
              v-model="password2"
              required
              :append-icon="showPass2 ? 'mdi-eye' : 'mdi-eye-off'"
              :rules="[rules.required, rules.min]"
              :type="showPass2 ? 'text' : 'password'"
              label="Password"
              @click:append="showPass2 = !showPass2"
          ></v-text-field>
          <v-btn><span class="textDefault">Сохранить</span></v-btn>
        </template>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  name: "Forgot",
  data: () => ({
    step1:true,
    step2:false,
    step3:false,
    email: '',
    emailRules: [
      v => !!v || 'E-mail is required',
      v => /.+@.+/.test(v) || 'E-mail must be valid',
    ],
    code:'',
    password:'',
    password2:'',
    showPass:false,
    showPass2:false,
    rules: {
      required: value => !!value || 'Required.',
      min: v => v.length >= 6 || 'Min 6 characters',
    },
  }),
  methods:{

  },
}
</script>

<style scoped>

</style>