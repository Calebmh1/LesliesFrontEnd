<template>
  <div id="app">
    <header>

    </header>

    <router-view/>
  </div>
</template>


<script>
  import store from "@/store/index.js";

  export default{
  computed: {
    auth: function() {
      return store.state.auth;
    }
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
