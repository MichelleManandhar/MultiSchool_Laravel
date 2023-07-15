<template>
  <div class="left-panel">
    <div class="left-panel-upper">
      <img src="../../../public/assets/smartschool.png" class="school-logo" />
      <div class="left-title">School Management System</div>
    </div>
    <router-link :to="{name:'mainDashBoard'}" style="display:flex" active-class="selected">
      <div class="left-bar-class">Dashboard</div>
    </router-link>

    <app-class v-for="singleClass in info" :singleClass="singleClass" :key="singleClass.id"></app-class>
  </div>
</template>

<script>
import axios from "axios";
import Classes from "./Classes";

export default {
  name: "Dashboard",
  components: {
    "app-class": Classes
  },
  data() {
    return {
      info: []
    };
  },
    created() {
      eventBus.$on('section-updated', this.getClass);
       this.getClass();
    },
    methods: {
      getClass(){
          axios
              .get("/class/")
              .then(response => {
                  this.info = response.data.classes; 
              })
              .catch(function(error) {
              });
      }
    }
};
</script>

<style>
.left-panel {
  padding: 0;
  margin: 0;
  top: 0;
  left: 0;
  width: 230px;
  height: 100%;
  background-color: #2792c6;
  color: #fff;
  font-family: "Poppins", sans-serif;
  box-shadow: 0 0 6px 0 #0056b3;
}
.left-panel a {
  text-decoration: none;
  color: white;
}

.left-panel-upper {
  text-align: center;
}

.school-logo {
  height: 13%;
  width: 40%;
  margin-top: 10%;
  margin-bottom: 10px;
}

.left-bar-class {
  font-size: 12px;
  height: 38px;
  width: 100%;
  padding: 8px 0 8px 50px;
}

.left-bar-class:hover {
  background-color: #0971a5;
  border: 1px solid #49a1cc;
  border-right: 5px;
}

.left-title {
  font-size: 14px;
  font-weight: bold;
  margin-bottom: 20px;
}
.left-panel:hover {
  overflow: auto;
}
</style>