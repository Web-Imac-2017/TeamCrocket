<template>

  <body>
  <menu-component></menu-component>
  <main-component></main-component>
  <footer-component></footer-component>
  </body>

</template>
<script>

import FooterComponent from "./Footer.vue"
import MenuComponent from "./Menu.vue"
import MainComponent from "./Main.vue"

export default {
components: {
  FooterComponent,
  MainComponent,
  MenuComponent
},
}
</script>

<style>
body{
  top:0;
  left:0;
  margin:0;
  width:100%;
  height:100%;
}
</style>
