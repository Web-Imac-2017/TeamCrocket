<template>
  <div id="content_profile" >
    <h1>Profil</h1>
    <div id="cover">
      <div id="profile_picture">
      </div>
      <div id="info_princ">
        <span class="name">{{user.nickname}}</span>


        <div id="icon_contact">
          <img src="../assets/search_mob.png" alt="search">
          <img src="../assets/search_mob.png" alt="search">
        </div>
      </div>
    </div>

      <div id="content_info">
        <div class="details">
          <h1>Details</h1>
          <ul>
              <li>
                  <h2>Nom <!--<img src="../assets/crayon.png" class="change"  v-on:click="lastname"/>--></h2>
                  <p>
                    <span id="detail_lastname">{{user.lastname}}</span>
                    <span id="detail_lastname2">
                    <form v-on:submit.prevent="editlastname" id="login-form">
                      <input class="pseudo" v-model="user.lastname" type="text">
                      <button type="submit" class="button_style">VALIDER
                        <img src="../assets/search_mob.png" class="img_button"/>
                      </button>
                    </form>
                    </span>
                  </p>
              </li>
              <li>
                <h2>Prenom</h2>
                <p><span class="detail_profil">{{user.firstname}}</span></p>
              </li>
              <li>
                <h2>Sexe</h2>
                <p><span id="detail_tg">{{user.sex}}</span></p>
              </li>
        </ul>
        </div>
        <div class="desc">
          <h1>Description</h1>
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
        date_birth:'',
        id_profil:''
      }
    }
  },
  created:function(){

      var instance = this;

      var user = instance.$http.get('https://api.meowtic.com/user/whois/')
        .then(function(response){
          let data = response.data;
          if(data.success){
                this.user.nickname = response.data.output.nickname;
                this.user.lastname = response.data.output.lastname;
                this.user.firstname = response.data.output.firstname;
                this.user.sex = response.data.output.sex;
                this.user.description = response.data.output.description;
                this.user.city = response.data.output.city;
                this.user.country_id = response.data.output.country.name;
                alert(response.data.output.country.id_profil);


      }})

    },
    methods: {
      editlastname : function(){
        this.$http.post('https://api.meowtic.com/user/edit/', this.user, { emulateJSON : true })
        .then(function(response){
            let data = response.data
            if(data.success){

            }
            else{

            }
        }, handleError)
      }
    /*  lastname: function(){
          document.getElementById("detail_tg").style.visibility="hidden";
      }*/
    }
}

var handleError = function(error){
    console.log('Error! Could not reach the API. ' + error)
}



</script>

<style lang="less">

 @import "../definitions";
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

#content_info h2{
    font-size:1.1em;
    text-align: left;
}

#content_info p{
  font-family: @fontText;
  color:gray;
  margin-top: -2%;
  margin-left: 1.5%;

}

.name{
  font-family: @fontTitle;
  text-transform:uppercase;
  font-weight: bold;
  color:@darkBlue;
  font-size:1.2em;
  padding-left: 3%;

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
