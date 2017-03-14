<template>
  <div id="content_profile" v-on:submit.prevent="edit_profile" v-if="user != null">
    <h1>Profil</h1>
    <form  id="profile-form">
    <input type="hidden" name="id" v-bind:value="user.id">
    <div id="cover">
      <div id="profile_picture">
        <img v-if="user.image != null" v-bind:src="user.image.path" v-bind:alt="user.nickname">
      </div>
      <div id="info_princ">
    <span class="show_data" >{{user.nickname}}</span>
        <input class="edit_data" v-model="user.nickname" name="nickname" type="text" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
        <div id="icon_contact">
          <input type="file" id="edit_profile_picture" class="edit_data" name="image_file">
        </div>
      </div>
      <img src="../assets/edit.png" id="img_edit"  v-on:click="edit_details"/>
    </div>

      <div id="content_info">
        <div class="details">
          <h1>Details</h1>
          <div class="trait"></div>
            <div id="first">
          <ul>
            <li>
                <h2>Prenom</h2>
                <p>
                  <span class="show_data">{{user.firstname}}</span>
                    <input class="edit_data" name="firstname" v-model="user.firstname" type="text" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
                </p>
            </li>
            <li>
              <h2>Nom</h2>
              <p><span class="show_data">{{user.lastname}}</span>
                <input class="edit_data" name="lastname" v-model="user.lastname" type="text" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
              </p>
            </li>
            <li>
              <h2>Sexe</h2>
              <p><span class="show_data">
                    <img src="../assets/man.png" alt="Homme"  v-if="sex == 1"/>
                    <img src="../assets/woman.png" alt="Femme" v-if="sex == 2"/>
                    <p v-else></p>
                  </span>
                <div class="edit_data">
                    <label for="m"><img src="../assets/man.png" alt="Homme"/></label>
                    <input type="radio" id="m" value="m" name="sex">
                    <label for="f"><img src="../assets/woman.png" alt="Femme"/></label>
                   <input type="radio" id="f" value="f" name="sex">
                </div>
              </p>
            </li>
          </ul>
        </div>
        <div id="second">
          <ul>
            <li>
              <h2>Date de naissance</h2>
              <p>
                <span class="show_data">{{user.date_birth}}, {{user.age}} ans</span>
                <date-component v-if="choice == 1"></date-component>
              </p>
            </li>
            <li>
              <h2>Ville</h2>
              <p><span class="show_data">{{user.city}}</span>
                <input class="edit_data" name="city" v-model="user.city" type="text" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
              </p>
            </li>
        </ul>
      </div>
        </div>
        <div class="desc">
          <h1>Description</h1>
          <div class="trait"></div>
          <p><span class="show_data">{{user.description}}</span>
            <textarea class="edit_data" name="description" v-model="user.description" ></textarea>
          </p>
          <h1>Mes Animaux</h1>

          {{animals.id}}
          <div v-for="a in animals" class="my_animal">
                <router-link  v-bind:to="'/profileanimal/'+ a.id">
                <div class="profile_animal">
                  <img v-if="a.profile_image != null" v-bind:src="a.profile_image.path" v-bind:alt="a.name">
                </div>
                <span>{{a.name}}   /   {{a.date_birth}}
                  <img src="../assets/man.png" alt="Homme"  v-if="a.sex == 'h'"/>
                  <img src="../assets/woman.png" alt="Homme"  v-if="a.sex == 'f'"/>
                </span>

              </router-link>
          </div>
          <h1 class="add_pet">Ajouter un animal</h1>

          <router-link :to="{name: 'addpet'}"><button>+</button></router-link>

        </div>
      </div>
      <div id="button_valid" class="edit_data">
        <button type="submit" class="button_style">VALIDER
          <img src="../assets/search_mob.png" class="img_button"/>
        </button>

      </div>

    </form>
  </div>
  <div v-else>
    <p>Vous devez vous connecter...</p>
  </div>
</template>

<script>
import Vue from 'vue'

Vue.use(require('vue-resource'));
import DateComponent from "./Date.vue"

export default {
  components: {
    DateComponent
  },
  data() {
    return{
      sex : 0,
      choice : 0,
      user : null,
      animals: [],
      animals_info: {id:'',name:'', profile_image:''}
    }
  },
  created(){
    var that = this;
    if(this.$parent.user === ""){
      this.$http.get('https://api.meowtic.com/user/whois')
        .then(function(response){
          let data = response.data;
          if(data.success){
            this.user = response.data.output;
          }
      });
    } else {
      this.user = this.$parent.user;
    }
    this.$http.get('https://api.meowtic.com/user/list_animal')
    .then(function(response){
      let data = response.data;
      that.animal = response.data.output;
      if(data.success){
        var total = response.data.output.item_total;
          for(var i = 0 ; i<total ; i++){
            this.animals_info = this.animal.data[i];
            this.animals.push(this.animals_info);

          }
        }
      })
      if(this.user.sex == 'm'){
        this.sex = 1;
      }else if (this.user.sex == 'f') {
        this.sex = 2
      }

  },
  methods : {
    edit_details : function(){
        this.choice = 1;
        var show = document.getElementsByClassName("show_data");
        for (var i=0;i<show.length;i+=1){
          show[i].style.display = 'none';
        }
        var edit = document.getElementsByClassName("edit_data");
        for (var i=0;i<edit.length;i+=1){
          edit[i].style.display = 'block';
        }
    },
    edit_profile : function(){
      // on sérialise le formulaire (IMPORTANT de bien mettre les champs NAME en correspondance avec le nom des champs ATTENDUS côté serveur)
      let formData = new FormData(document.getElementById('profile-form'));

      this.$http.post('https://api.meowtic.com/user/edit', formData)
        .then(function(response){
          let data = response.data;
          if(data.success){
            console.log('Profile modifié');
            this.user = response.data.output;
            this.choice = 0;
            var show = document.getElementsByClassName("show_data");
            for (var i=0;i<show.length;i+=1){
              show[i].style.display = 'block';
            }
            var edit = document.getElementsByClassName("edit_data");
            for (var i=0;i<edit.length;i+=1){
              edit[i].style.display = 'none';
            }
          }
          else{
            alert(response.data.message);
          }
      })
    },
  }
}



</script>

<style lang="less">

 @import "../definitions";
@blue : #212D48;

.edit_data{
  display: none;
}
img#img_edit{
  right:0;
  bottom:0;
  position: absolute;
  width:3em;
  cursor:pointer;
}
#content_profile{
  margin:auto;
  margin-top: 100px;
  top:100px;
  width:80%;
  background-color:white;
  margin-bottom: 100px
}
#content_profile  h1{
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

#first{
  float:left;
  width: 50%;
}

#second{
  float:left;
}

.profile_animal{
  width: 100px;
  height:100px;
  display: inline-block;
  vertical-align: middle;
}
.profile_animal img{
  width: 100%
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
  bottom: -30px;
}

.add_pet{

font-size: 1.1em;
}



#icon_contact img{
  width:20px
}
#content_info{
  position:relative;
  display: inline-block;
  width:100%;
  margin-bottom: 50px
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
    color:gray;
}

#content_info p{
  font-family: @fontText;
  color:@darkBlue;
  margin-top: 2%;
  margin-left: 1.5%;
  font-size: 1.1em;

}


.ajout_animal{
width:150%;
}

.name{
  font-family: @fontTitle;
  text-transform:uppercase;
  font-weight: bold;
  color:@darkBlue;
  font-size:1.2em;
  padding-left: 3%;

}

div.desc p{
  margin-top: 1em;
}

.my_animal{
  margin-top: 1em;
padding-top: 0.2em;
padding-bottom: 0.2em;
border-radius: 6px;
border: solid 0.1em #e2e3e3;
}


.my_animal div{
padding-top: 0.2em;

}

.my_animal span{
  font-size: 1.3em;
  font-family: @fontTitle;
  font-weight : bold;
  color:@darkBlue;
  padding-left: 1em;
}

.desc button{

border-radius: 6px;
background-color:@lightBlue;
display: block;
margin: auto;
font-size:1.2em;
font-family: 'Moon';
color:white;
cursor:pointer;

}

div#cover{
  background-image: url(../assets/gorille.jpg) ;
  background-size: 100%;
}
.desc h2{
  float:left;
}

.show_data{
  font-size: 1.3em;
}

div#content_info div.desc div.my_animal a span img{
width:1.3em;
padding-left:0.6em;
padding-top: 0.3em;
}

#content_profile .button_style{
  border-radius: 6px;
  background-color:@lightBlue;
  font-size:1.2em;
  font-family: 'Moon';
  color:white;
  cursor:pointer;

}

div#content_info h1{
padding-top: 1em;
}


div#content_info div.details h2{
padding-top: 1em;
}


#button_valid{
  display: none;
  position:absolute;
  z-index:88;
  margin-left: 9em;
  margin-top:-4em;
}



.desc p{
padding-top:1em;
padding-bottom:1em;
padding-left: 0.3em;
background-color: #e2e3e3;
border-radius: 5px;
}

div.desc div{

}

@media screen and (max-device-width:1000px), screen  and (max-width:1000px){
  #content_profile{
    width:90%;
  }
}
@media screen and (max-device-width:900px), screen  and (max-width:900px){
  #content_profile{
    width:95%;
  }
  #content_info .details,#content_info .desc{
    width: 90%;
    margin: auto;
    float: none;
    margin-top: 80px
  }
}
@media screen and (max-device-width:810px), screen  and (max-width:810px){
  #content_profile{
    width:600px;
  }

  h1{
    font-size: 1.2em;
  }

}
@media screen and (max-device-width:620px), screen  and (max-width:620px){
  #content_profile{
    width:400px;
  }
}
</style>
