<template>
  <div class="home" id="front">
    <img src="../../../public/assets/smartschool.png" class="school-logo" />
    <div class="upper-title">WELCOME TO SMS</div>
    <button type="button" class="init-button">WATCH TUTORIAL</button>
    <br />
    <router-link to="/dashboard">
      <button type="button" class="init-button">SKIP</button>
    </router-link>
  </div>
</template>

<script>
export default {
  name: "Home"
};
</script>

<style scoped>
.home {
  position: fixed;
  padding: 0;
  margin: 0;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  text-align: center;
  background-image: linear-gradient(#10deff, #094b95);
  font-family: "Poppins", sans-serif;
}
.upper-title {
  font-weight: bold;
  font-size: 34px;
  color: #fff;
  margin-bottom: 15px;
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
.init-button:hover {
  height: 52px;
  text-shadow: #0c5460;
  width: 305px;
  transition: all 0.2s;
}
.school-logo {
  height: 100px;
  width: 100px;
  margin-top: 10%;
  margin-bottom: 10px;
}
</style>