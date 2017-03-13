<template>
  <div id="popup_profile">
    <router-link :to="{name: 'profileuser'}">Mon compte</router-link>
    <div v-on:click="logout"><img src="../assets/deconnexion.png" alt="deco" id="img_deco">Se déconnecter</div>
  </div>
</template>

<script>
export default {
  components : {

  },
  data(){
    return{
      addPet: {
        id: 0,
        name: '',
        species_id: ''
    }
  }
},
  methods: {
    logout : function(){
        this.$http.post('https://api.meowtic.com/user/logout')
        .then(function(response){
            let data = response.data
            if(data.success){
                location.href = 'root'
            }
            else{

            }
        })
    }

  }

}
</script>

<style lang="less">
@import "../definitions";

#popup_profile {
  background-color: white
}
#img_deco{
  width: 20px;
  vertical-align: middle;
}
</style>
