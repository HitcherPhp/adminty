<template>
  <div>
    <v-card style="text-align: left;border: none" outlined>
      <v-card-title>
        Настройки
      </v-card-title>
      <v-card-text>
        <div style="max-width: 250px">
          <v-text-field label="Имя" :value="user.name"></v-text-field>
          <v-text-field label="Логин" :value="user.email"></v-text-field>
          <v-text-field label="Телефон" :value="user.phone"></v-text-field>
          <v-btn style="margin-bottom: 20px"><span class="textDefault" @click="dialog = true">Изменить пароль</span></v-btn>
          <v-btn color="primary" @click="saveSettings"><span class="textDefault">Сохранить</span></v-btn>
        </div>
      </v-card-text>
    </v-card>
    <v-dialog
        v-model="dialog"
        :persistent="step2"
        max-width="400px">
      <v-card>
        <v-card-title>
          Изменение пароля
        </v-card-title>
        <v-card-text>
          <template v-if="!step2">
            <v-text-field
                @focus="password.error = false;password.errorMessages = ''"
                v-model="password.value"
                :error="password.error"
                :error-messages="password.errorMessages"
                label="Введите старый пароль"
                required
                :append-icon="showPass ? 'mdi-eye' : 'mdi-eye-off'"
                :rules="[rules.required,]"
                :type="showPass ? 'text' : 'password'"
                @click:append="showPass = !showPass"
            ></v-text-field>
            <v-row justify="end">
              <v-col cols="auto">
                <v-btn color="primary" @click="checkPassword"><span class="textDefault">Далее</span></v-btn>
              </v-col>
            </v-row>

          </template>
          <template v-else>
            <v-text-field
                required
                @focus="newPassword.error = false; newPassword.errorMessages = ''"
                :append-icon="showPass2 ? 'mdi-eye' : 'mdi-eye-off'"
                :rules="[rules.required, rules.min]"
                :type="showPass2 ? 'text' : 'password'"
                @click:append="showPass2 = !showPass2"
                label="Введите новый пароль"
                :error="newPassword.error"
                :error-messages="newPassword.errorMessages"
                v-model="newPassword.value"></v-text-field>
            <v-text-field
                label="Повторите пароль"
                required
                @focus="newPassword2.error = false; newPassword2.errorMessages = ''"
                :append-icon="showPass3 ? 'mdi-eye' : 'mdi-eye-off'"
                :rules="[rules.required, rules.min]"
                :type="showPass3 ? 'text' : 'password'"
                @click:append="showPass3 = !showPass3"
                :error="newPassword2.error"
                :error-messages="newPassword2.errorMessages"
                v-model="newPassword2.value"></v-text-field>
            <v-row justify="end">
              <v-col  cols="auto">
                <v-btn
                    @click="dialog = false; step2 = false"
                >
                  <span class="textDefault">Закрыть</span>
                </v-btn>
              </v-col>
              <v-col cols="auto">
                <v-btn
                    color="primary"
                    @click="saveNewPassword"
                >
                  <span class="textDefault">Сохранить</span>
                </v-btn>
              </v-col>
            </v-row>
          </template>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>

</template>

<script>
import LayoutApp from "../Layout/LayoutApp";

export default {
  name: "Settings",
  data: () => ({
    dialog: false,
    showPass: false,
    showPass2: false,
    showPass3: false,
    step2: false,
    password: {
      value: '',
      error: false,
      errorMessages: ''
    },
    newPassword: {
      value: '',
      error: false,
      errorMessages: ''
    },
    newPassword2: {
      value: '',
      error: false,
      errorMessages: ''
    },
    rules: {
      required: value => !!value || 'Обязательное поле',
      min: v => v.length >= 6 || 'Минимальная длина 6 символов',
    },
  }),
  methods: {
    checkPassword() {
      if (this.password.value.length) {
        this.step2 = true
      } else {
        this.password.error = true
        this.password.errorMessages = 'Обязательное поле'
      }
    },
    saveNewPassword() {
      if (!this.newPassword.value.length) {
        this.newPassword.error = true
        this.newPassword.errorMessages = 'Введите новый пароль'
      } else {
        if (this.newPassword.value == this.newPassword2.value) {
          this.dialog = false
          this.step2 = false
          this.$store.commit('setSnackbarText','Пароль успешно сохранен!')
          this.$store.commit('setSnackbar', true)
        } else {
          this.newPassword.error = true
          this.newPassword.errorMessages = 'Пароли не совпадают'
          this.newPassword2.error = true
          this.newPassword2.errorMessages = 'Пароли не совпадают'
        }
      }
    },
    saveSettings(){
      this.$store.commit('setSnackbarText','Изменения сохранены!')
      this.$store.commit('setSnackbar', true)
    }
  },
  computed:{
    user(){
      return  this.$store.state.currentUser
    }
  },
  watch:{
    dialog(val){
      if (val === false){
        this.password.value = ''
        this.password.error = false
        this.password.errorMessages = ''
        this.newPassword.value = ''
        this.newPassword.error = false
        this.newPassword.errorMessages = ''
        this.newPassword2.value = ''
        this.newPassword2.error = false
        this.newPassword2.errorMessages = ''
      }
    }
  },
  created() {
  }
}
</script>

<style scoped>

</style>