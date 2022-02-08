<template>
  <section class="user-authentication">
    <div class="user_options-container">
      <div class="user_options-text">
        <div class="user_options-unregistered">
          <h2 class="user_unregistered-title">Don't have an account?</h2>
          <p class="user_unregistered-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras quis nibh in leo lacinia blandit et quis lorem.</p>
          <button class="user_unregistered-signup" @click="signUp()" id="signup-button">Sign up</button>
        </div>

        <div class="user_options-registered">
          <h2 class="user_registered-title">Have an account?</h2>
          <p class="user_registered-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras quis nibh in leo lacinia blandit et quis lorem.</p>
          <button class="user_registered-login" @click="logIn()" id="login-button">Login</button>
        </div>
      </div>
      <div class="user_options-forms" ref="user_options-forms">
        <div class="user_forms-login">
          <h2 class="forms_title">Login</h2>
          <div class="forms_form">
            <fieldset class="forms_fieldset">
              <div class="forms_field">
                <custom-input
                  :error="errors.email"
                  :label="$t('scoliotracker.email')"
                  v-model="email"
                  placeholder="Email"
                />
              </div>
              <div class="forms_field">
                <custom-input
                  :error="errors.password"
                  type="password"
                  :label="$t('scoliotracker.password')"
                  v-model="password"
                  placeholder="Password"
                />
              </div>
            </fieldset>
            <div class="forms_buttons">
              <button type="button" class="forms_buttons-forgot" @click="forgetPass()" id="forget-button">Forgot password?</button>
              <button type="submit" class="forms_buttons-action" @click="handleLogin">Login</button>
                          <a class="forms_buttons-mb-button" @click="signUpMb()" id="signup-button-mb">Sign up</a>
            </div>
          </div>
        </div>
        <div class="user_forms-signup">
          <h2 class="forms_title">Sign Up</h2>
          <form class="forms_form">
            <fieldset class="forms_fieldset">
              <div class="forms_field">
                <custom-input
                    :error="errors.email"
                    :label="$t('scoliotracker.email')"
                    v-model="email"
                    placeholder="Email"
                    required
                />
              </div>
              <div class="forms_field">
                <custom-input
                    :error="errors.fullname"
                    :label="$t('scoliotracker.fullname')"
                    v-model="fullname"
                    placeholder="Full Name"
                    required
                />
              </div>
              <div class="forms_field">
                <custom-input
                    :error="errors.password"
                    type="password"
                    :label="$t('scoliotracker.password')"
                    v-model="password"
                    placeholder="Password"
                    required
                />
              </div>
              <div class="forms_field">
                <custom-input
                    :error="errors.password_confirmation"
                    type="password"
                    :label="$t('scoliotracker.password_confirmation')"
                    v-model="password_confirmation"
                    required
                />
              </div>
              <input class="checkbox" v-model="terms_service" type="checkbox" id="checkbox">
              <label class="agreement" for="checkbox">Продолжая, вы соглашаетесь с нашими условиями предоставления услуг, политикой конфиденциальности и политикой использования файлов cookie.</label>
              <p v-if="errors.terms_service">{{ errors.terms_service }}</p>
              <vue-recaptcha class="recaptcha" sitekey="6Le0KPIdAAAAANMxibfO_OS8xPTFeS2yuRgXK6gR" @verify="markRecaptchaAsVerified"></vue-recaptcha>
              <div><strong>{{ pleaseTickRecaptchaMessage }}</strong></div>
            </fieldset>
            <div class="forms_buttons">
              <button type="button" class="forms_buttons-action" @click="handleSignUp">Sign up</button>
              <a class="forms_buttons-mb-button" @click="logInMb()" id="login-button-mb">Login</a>
            </div>
          </form>
        </div>
              <div class="user_forms-forgot">
          <h2 class="forms_title">Forgot Password</h2>
          <form class="forms_form">
            <fieldset class="forms_fieldset">
              <div class="forms_field">
                <input type="email" placeholder="Email" class="forms_field-input" required autofocus />
              </div>
            </fieldset>
            <div class="forms_buttons">
              <button type="submit" class="forms_buttons-action">Send reset link</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { VueRecaptcha } from 'vue-recaptcha';
export default {
  name: 'Auth',
  components: {
    VueRecaptcha,
  },
  data: function () {
    return {
      email: "",
      fullname: "",
      password: "",
      password_confirmation: "",
      terms_service: false,
      errors: {},
      forms: null,
      recaptchaVerified: false,
      pleaseTickRecaptchaMessage: '',
    };
  },
  mounted() {
    this.forms = this.$refs['user_options-forms'];
  },
  methods: {
    async handleSignUp() {
      if (!this.recaptchaVerified) {
        this.pleaseTickRecaptchaMessage = 'Please tick recaptcha.';
        return; // prevent form from submitting
      }
      const { email, fullname, password, password_confirmation, terms_service } = this;
      await this.$auth
          .register({
              data: { email, fullname, password, password_confirmation, terms_service },
              success() {
                  this.$auth.ready();
              },
              staySignedIn: true,
              redirect: { name: "dashboard.index" },
          })
          .catch((e) => (this.errors = e.response.data.errors));
    },
    async handleLogin() {
      const { email, password } = this;
      this.$auth
        .login({ data: { email, password }, redirect: null })
        .then((res) => {
          let route =
            res.data.data.roles.findIndex((role) => role.name === "admin") > -1
              ? this.$auth.options.loginData.redirect.admin10
              : this.$auth.options.loginData.redirect.other;
          this.$router.push(route);
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },
    markRecaptchaAsVerified(response) {
      console.log('response', response);
      this.pleaseTickRecaptchaMessage = '';
      this.recaptchaVerified = true;
    },
    signUp() {
      this.forms.classList.remove('show-forgotPass');
      this.forms.classList.remove('bounceRight');
      this.forms.classList.add('bounceLeft');
    },
    signUpmb() {
      this.forms.classList.remove('show-forgotPass');
      this.forms.classList.remove('show-login');
      this.forms.classList.add('show-signup');
    },
    logIn() {
      this.forms.classList.remove('show-forgotPass');
      this.forms.classList.remove('bounceLeft');
      this.forms.classList.add('bounceRight');
    },
    logInMb() {
      this.forms.classList.remove('show-forgotPass');
      this.forms.classList.add('show-login');
      this.forms.classList.remove('show-signup');
    },
    forgetPass() {
      this.forms.classList.add('show-forgotPass');
      this.forms.classList.remove('show-login');
      this.forms.classList.remove('show-signup');
    }
  },

};

</script>

<style lang="scss">
  @import '../scss/auth';

  .forms_fieldset {
    border-width: 0px;
  }
  .agreement {
    width: 100%;
    font-size: 1rem;
    margin-top: 100px;
    font-weight: 300;
    color: $darkGray;
    line-height: 20px;
    cursor: pointer;
    margin-left: 10px;
  }
  .checkbox {
    margin-top: 20px;
    cursor: pointer;
  }
  .recaptcha {
      margin-top: 20px;
      display: flex;
      justify-content: center;
  }
</style>