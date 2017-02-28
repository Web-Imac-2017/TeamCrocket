<template>

  <body>
  <menu-component></menu-component>
  <main-component></main-component>
  <footer-component></footer-component>
  </body>

</template>
<script>

import FooterComponent from "./Footer.vue"
import MainComponent from "./Menu.vue"
import MenuComponent from "./Main.vue"

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
