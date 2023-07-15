<template>
  <i class="fas fa-spinner fa-spin fa-lg"></i>
</template>

<script>
export default {
  name: "Loader"
};
</script>

<style>
.loader {
  height: 50px;
  width: 50px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.loader .loader-item {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.loader i {
  font-size: 20px;
  color: white;
}
.loader span {
  color: white;
}
</style>