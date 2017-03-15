<template>
  <footer>
    © Meowtic, 2017 -
    <router-link :to="{name: 'legalnotice'}">Mentions légales</router-link>
       - Charte de confiance
  </footer>
</template>

<script>


</script>

<style lang="less">
@import "../definitions"; /* import common definitions */

footer {
 text-align:center;
 width:100%;
 bottom:0;
 padding-top: 1em;
 padding-bottom: 1em;
 font-size: 0.7em;
 background-color:@darkBlue;
 color:white;
 position: fixed;
}
</style>
