<template>
  <div class="top-container">
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  data() {
    return {
      routes: {
        unlogged: [
          {
            name: "sign",
            path: "/sign"
          },
          {
            name: "home",
            path: "/home"
          }
        ],
        user: [
          {
            name: "Dashboard",
            path: "dashboard"
          }
        ]
      }
    };
  },
  mounted() {
 
 }
};
</script>

<style lang = "scss">
@import "../../../node_modules/ag-grid-community/dist/styles/ag-grid.css";
@import "~vuejs-noty/dist/vuejs-noty.css";
select option {
  color: black !important;
  background-color: white !important;
  text-shadow: 0 1px 0 rgba(0, 0, 0, 0.4) !important;
}
.ag-cell-edit-input {
  background: transparent !important;
  padding-left: 10px;
  border: none !important;
  outline: none !important;
}
.ag-cell-edit-input:focus {
  background: transparent;
  color: transparent !important;
  text-shadow: 0 0 0 black !important;
}
.ag-input-text-wrapper {
  outline: none !important;
  border: none !important;
}
.top-container {
  height: 100vh;
  width: 100%;
}
.ag-cell-focus {
  border: none !important;
  border: 3px solid green !important;
}
.ag-floating-top {
  text-align: center;
}
</style>