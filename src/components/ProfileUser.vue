<template>
  <div id="content_profile" v-if="user != null">
    <h1>Profil</h1>
    <div id="cover">
      <div id="profile_picture">
        <img v-bind:src="user.image.path" v-bind:alt="user.nickname">
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
                    <form v-on:submit.prevent="edit_profile" id="login-form">
                      <input type="hidden" v-model="user.id">
                      <input class="pseudo" v-model="userForm.nickname" type="text" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
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
  <div v-else>
    <p>Vous devez vous connecter...</p>
  </div>
</template>

<script>
import Vue from 'vue'

Vue.use(require('vue-resource'));

export default {
  data() {
    return {
      user : null,
      userForm : {
        id : 0,
        nickname : ''
      }
    }
  },
  created : function(){
    this.$http.get('https://api.meowtic.com/user/whois')
      .then(function(response){
        let data = response.data;
        if(data.success){
          this.user = response.data.output;
          this.reloadUserForm();
        }
    })
  },
  methods : {
    reloadUserForm : function(){
      this.userForm.id = this.user.id
      this.userForm.nickname = this.user.nickname
    },
    edit_profile : function(){
      this.$http.post('https://api.meowtic.com/user/edit', this.userForm, { emulateJSON : true })
        .then(function(response){
          let data = response.data;
          if(data.success){
            console.log('Profile modifié');
            this.user = response.data.output;
            this.reloadUserForm();
          }
          else{
            alert(response.data.message);
          }
      })
    }
  }
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

  img{
    width:100%;
    height:100%;
  }
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
