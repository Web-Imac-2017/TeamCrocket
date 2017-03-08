<template>
  <div id="content_profile">
    <h1>Profil</h1>
    <div id="cover">
      <div id="profile_picture">
      </div>
      <div id="info_princ"><span class="name">{{user.nickname}}</span>
        <button @click="user_profile">blabla</button>
        <div id="icon_contact">
          <img src="../assets/search_mob.png" alt="search">
          <img src="../assets/search_mob.png" alt="search">
        </div>
      </div>
      <div id="content_info">
        <div class="details">
          <h1>Détails</h1>
        </div>
        <div class="desc">
          <h1>Description</h1>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import Vue from 'vue'

Vue.use(require('vue-resource'));

export default {
  data() {
    return {
      user : {
        nickname: '',
        lastname: '',
        firstname: '',
        sex: '',
        description:'',
        city:'',
        country_id:'',
        date_birth:''
      }
    }
  }, methods: {
  user_profile : function(){
    var instance = this;
    instance.$http.get('https://api.meowtic.com/user/get/146')

    .then(function(response){
        let data = response.data;
        if(data.success){
            instance.list = data.output;
            alert(response.data.output.nickname);
        }
    })
  }
}
}

</script>

<style lang="less">
@blue : #212D48;

#content_profile{
  margin:auto;
  margin-top: 100px;
  top:100px;
  width:800px;
  background-color:white;
}
#content_profile  h1{
  position:absolute;
  z-index:10;
  text-align:center;
  margin:auto;
  margin-top:-20px;
}
#cover{
  position:relative;
  width:100%;
  top:20px;
  height:300px;
  background-color:#9ca7be;
}
#profile_picture{
  background-color:#445680;
  width:170px;
  height:170px;
  position:absolute;
  z-index:2;
  left:20px;
  bottom:-30px;
}
#info_princ{
  background-color:white;
  padding: 5px;
  width : 200px;
  position:absolute;
  z-index:2;
  left:190px;
  bottom: 0px;
}
#icon_contact{
  padding: 5px;
  width : 200px;
  position:absolute;
  z-index:2;
  left:190px;
  bottom: -30px;
}
#icon_contact img{
  width:20px
}
#content_info{
  display:inline-block;
  position:relative;
  height:200px;
  width:100%;
}
#content_info .details{
  float:left;
  background-color:#f6f6f7;
  width:40%;
  margin:5%;
  margin-top:10%;
  padding:2%;
  margin-right:1%;
}
#content_info .desc{
  float:left;
  background-color:#f6f6f7;
  width:40%;
  margin:5%;
  margin-top:10%;
  padding:2%;
  margin-left:1%;
}

@media screen and (max-device-width:810px), screen  and (max-width:810px){
  #content_profile{
    width:600px;
  }
}
@media screen and (max-device-width:620px), screen  and (max-width:620px){
  #content_profile{
    width:400px;
  }
}
</style>
