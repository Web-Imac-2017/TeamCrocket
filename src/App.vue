<template>
  <div id="app">
  <menu-component></menu-component>
  <main-component></main-component>
  <footer-component></footer-component>
  </div>
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

<style lang="less">
 @import "definitions"; /* import common definitions */

/* main css properties */
 html, body {
   width: 100%;
   top:0;
   left:0;
   margin:0;
 }

 html{
   height: 100%;
   font-size: 100%; /* global font size definitions */
 }

 body{
   height: calc(100% - @headerHeight); /* not the best solution -- to improve */
   padding-top: @headerHeight;
   font-size: 1em;

   @media (max-width: 700px) /* responsive text example */
   {
     font-size: .8em;
   }

   font-family: @fontText;
   background-image: url(@bgImage);
   background-repeat: repeat;
 }
</style>
