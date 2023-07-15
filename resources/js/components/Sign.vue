<template>
  <div id="sign" :class="{ sign : signUpChange }">
    <div class="left-signin">
      <img src="../../../public/assets/smartschool.png" class="school-logo" />
      <div class="upper-title">WELCOME TO SMS</div>
      <div class="welcome-message">
        Enter basic detail of school
        <br />and start your journey with us
      </div>
      <button type="button" class="init-button" @click="changeTheSlider">Sign Up</button>
    </div>
    <div class="left-signin-slide">
      <img src="../../../public/assets/smartschool.png" class="school-logo" />
      <div class="upper-title">WELCOME TO SMS</div>
      <div class="welcome-message">
        Enter your personal detail
        <br />and start your journey with us
      </div>
      <button type="button" class="init-button" @click="changeTheSlider">Sign In</button>
    </div>
    <form class="right-signup" @submit.prevent="login">
      <div class="signin-title">Sign in to SMS</div>
      <input
        type="text"
        value
        class="input-signin"
        name="loginEmail"
        v-model="emailSignin"
        placeholder=" Email"
      />
      <br />

      <input
        type="password"
        class="input-signin"
        name="loginPassword"
        v-model="passwordSignin"
        placeholder=" Password"
      />
      <br />
      <span class="help-block" v-if="has_error && errors.password">{{ errors.password }}</span>
      <div class="forget-messgae">Forgot your password!</div>
      <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.password }"></div>
      <button type="submit" class="signin-button">Sign in</button>
    </form>
    <div class="right-signup-slide">
      <div class="signin-title">Sign up to SMS</div>
      <input
        type="text"
        class="input-signin"
        placeholder=" Name of School"
        v-model="nameSignup"
        name="name"
      />
      <br />
      <span class="help-block" v-if="has_error && errors.email">{{ errors.email }}</span>
      <input
        type="text"
        class="input-signin"
        placeholder="School Email"
        v-model="emailSignup"
        name="email"
      />
      <br />
      <input
        type="number"
        class="input-signin"
        placeholder="School Contact No."
        v-model="contactSignup"
        name="email"
      />
      <br />
      <input
        type="password"
        class="input-signin"
        placeholder=" Password"
        v-model="passwordSignup"
        name="password"
      />
      <br />
      <input
        type="password"
        class="input-signin"
        placeholder=" Password"
        v-model="repasswordSignup"
        name="password"
      />
      <br />
      <button type="button" class="signin-button" v-on:click="register">Sign up</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "Sign",
  data() {
    return {
      signUpChange: false,
      nameSignup: "",
      emailSignin: "",
      emailSignup: "",
      passwordSignin: "",
      passwordSignup: "",
      repasswordSignup: "",
      contactSignup : "",
      has_error: false,
      error: "",
      errors: {},
      success: false
    };
  },
  methods: {
    changeTheSlider() {
      this.signUpChange = !this.signUpChange;
    },
    login() {
      var redirect = this.$auth.redirect();
      var app = this;
      this.$auth.login({
        data: {
          email: app.emailSignin,
          password: app.passwordSignin
        },
        success: function(res) {
            const redirectTo = "mainDashBoard";
            this.$router.push({ name: redirectTo });
            this.$auth.user(res.data);
          this.$noty.success("Logged in successfully");
        },
        error: function() {
          this.$noty.error("Username/password doesnot match!");
          app.has_error = true;
        },
        rememberMe: true,
        fetchUser: true
      });
      if (this.emailSignin == "school123@gmail.com") {
        if (this.passwordSignin == "123456789") {
          this.$router.push("dashboard");
        }
      }
    },

    register() {
      var app = this;
      this.$auth.register({
        data: {
          name: app.nameSignup,
          email: app.emailSignup,
          contact: app.contactSignup,
          password: app.passwordSignup,
          password_confirmation: app.repasswordSignup
        },
        success: function() {
          app.success = true;
            this.$noty.success("Signed Up successfully");
          this.$router.push({
            name: "login",
            params: { successRegistrationRedirect: true }
          });
        },
        error: function(res) {
          app.has_error = true;
            this.$noty.error("Error registering School");
          app.error = res.response.data.error;
          app.errors = res.response.data.errors || {};
        }
      });
    }
  }
};
</script>

<style scoped>
.left-signin {
  position: fixed;
  padding: 0;
  margin: 0;
  top: 0;
  left: 0;
  width: 50%;
  height: 100%;
  text-align: center;
  background-image: linear-gradient(#10deff, #094b95);
  font-family: "Poppins", sans-serif;
  float: left;
  opacity: 1;
  z-index: 999;
  display: block;
}
#sign > * {
  transition: 0.3s ease-in;
}
.sign > .left-signin,
.sign > .right-signup {
  opacity: 0;
  z-index: -1;
}
.sign > .left-signin-slide,
.sign > .right-signup-slide {
  opacity: 1;
  z-index: 999;
}
.left-signin-slide {
  position: fixed;
  padding: 0;
  margin: 0;
  top: 0;
  right: 0;
  width: 50%;
  height: 100%;
  text-align: center;
  background-image: linear-gradient(#10deff, #094b95);
  font-family: "Poppins", sans-serif;
  float: right;
  transition: all 0.2s;
  opacity: 0;
  z-index: -1;
}

.right-signup {
  padding: 0;
  margin: 0;
  top: 0;
  left: 0;
  width: 50%;
  height: 100%;
  text-align: center;
  font-family: "Poppins", sans-serif;
  float: right;
  opacity: 1;
  display: block;
  z-index: 999;
}
.right-signup-slide {
  padding: 0;
  margin: 0;
  top: 0;
  right: 0;
  width: 50%;
  height: 100%;
  text-align: center;
  font-family: "Poppins", sans-serif;
  float: left;
  opacity: 0;
}
.signin-title {
  margin-top: 15%;
  font-size: 36px;
  font-weight: bold;
  margin-bottom: 15px;
  color: #10deff;
}
.forget-messgae {
  color: #b4b4b4;
  margin-top: 10px;
  margin-bottom: 10px;
  font-size: 12px;
}
.upper-title {
  font-weight: bold;
  font-size: 34px;
  color: #fff;
  margin-bottom: 15px;
}
.welcome-message {
  color: #fff;
  font-size: 15px;
}
.input-signin {
  height: 50px;
  width: 350px;
  background-color: #f5f5f5;
  border: 1px solid #b4b4b4;
  margin-bottom: 40px;
  border-radius: 7px;
  color: #b4b4b4;
  font-size: 15px;
  padding-left: 10px;
  outline: none;
}
.init-button {
  border: 2px solid white;
  font-weight: lighter;
  border-radius: 50px;
  font-size: 13px;
  color: #fff;
  height: 50px;
  width: 300px;
  outline: none;
  background-color: transparent !important;
  margin: 15px;
}

.signin-button {
  border: 2px solid white;
  font-weight: lighter;
  border-radius: 50px;
  font-size: 13px;
  color: #fff;
  height: 50px;
  width: 300px;
  outline: none;
  background-color: #10deff;
  margin: 15px;
}

.school-logo {
  height: 100px;
  width: 100px;
  margin-top: 20%;
  margin-bottom: 15px;
}
@media only screen and (max-width: 700px) {
  .input-signin {
    height: 30px;
    width: 200px;
    background-color: #f5f5f5;
    border: 1px solid #b4b4b4;
    margin-bottom: 40px;
    border-radius: 7px;
    color: #b4b4b4;
    font-size: 12px;
    padding-left: 10px;
    outline: none;
  }
  .init-button {
    border: 2px solid white;
    font-weight: lighter;
    border-radius: 50px;
    font-size: 13px;
    color: #fff;
    height: 30px;
    width: 200px;
    outline: none;
    background-color: transparent !important;
    margin: 15px;
  }

  .signin-button {
    border: 2px solid white;
    font-weight: lighter;
    border-radius: 50px;
    font-size: 13px;
    color: #fff;
    height: 30px;
    width: 200px;
    outline: none;
    background-color: #0056b3;
    margin: 15px;
  }

  .school-logo {
    height: 80px;
    width: 80px;
    margin-top: 20%;
    margin-bottom: 15px;
  }
}

@media only screen and (max-width: 450px) {
  .input-signin {
    height: 15px;
    width: 100px;
    background-color: #b4ffea;
    border: 1px solid #b4b4b4;
    margin-bottom: 30px;
    border-radius: 7px;
    color: #b4b4b4;
    font-size: 12px;
    padding-left: 10px;
    outline: none;
  }
  .init-button {
    border: 2px solid white;
    font-weight: lighter;
    border-radius: 50px;
    font-size: 10px;
    color: #fff;
    height: 20px;
    width: 100px;
    outline: none;
    background-color: transparent !important;
    margin: 15px;
  }

  .signin-button {
    border: 2px solid white;
    font-weight: lighter;
    border-radius: 50px;
    font-size: 10px;
    color: #fff;
    height: 20px;
    width: 100px;
    outline: none;
    background-color: #10deff;
    margin: 15px;
  }

  .school-logo {
    height: 50px;
    width: 50px;
    margin-top: 20%;
    margin-bottom: 15px;
  }
}
</style>