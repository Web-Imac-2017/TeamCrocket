<template>
  <div id="app">
  <menu-component></menu-component>
  <router-view></router-view>
  <footer-component></footer-component>

  </div>
</template>

<script>
import FooterComponent from "./components/Footer.vue"
import MenuComponent from "./components/Menu.vue"
import Vue from 'vue'
Vue.use(require('vue-resource'));

export default {
components: {
  FooterComponent,
  MenuComponent
},
data(){
  return{
    id_user :'',
    id_user :''
  }
},
  created : function(){
    this.$http.get('https://api.meowtic.com/user/whois')
      .then(function(response){
        let data = response.data;
        if(data.success){
          this.id_user = response.data.output.id;
          this.user = response.data.output;
        }
    })
  },

  methods: {
      popup: function(id){
      this.id_user = id

      },
  }
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
