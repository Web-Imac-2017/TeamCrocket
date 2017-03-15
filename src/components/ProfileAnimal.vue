<template>
   <div id="content_profile" v-on:submit.prevent="edit_profile" v-if="user != null">
    <h1>Profil</h1>
    <form  id="profile-form">
    <input type="hidden" name="id" v-bind:value="animal.id">
    <div id="cover">
      <div id="profile_picture">
        <img v-if="animal.image != null" v-bind:src="animal.image.path" v-bind:alt="animal.nickname">
        <img v-if="animal.image == null" src="../assets/none_profil.png">
      </div>
      <div id="info_princ">
        <span class="show_data" >{{animal.nickname}}</span>
        <input class="edit_data" v-model="animal.nickname" name="nickname" type="text" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
        <div id="icon_contact">
          <input type="file" id="edit_profile_picture" class="edit_data" name="image_file">
        </div>
      </div>
      <div id="img_edit_animal" v-if="edit == 1">
        <img src="../assets/edit.png" id="img_edit"  v-on:click="edit_details"/>
      </div>
      <p v-else>
      </p>
    </div>

      <div id="content_info">
        <div class="details">
          <h1>Details</h1>
          <ul>
            <li>
                <h2>Prenom</h2>
                <p>
                  <span class="show_data">{{animal.firstname}}</span>
                    <input class="edit_data" name="firstname" v-model="animal.firstname" type="text" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
                </p>
            </li>
            <li>
              <h2>Nom</h2>
              <p><span class="show_data">{{animal.lastname}}</span>
                <input class="edit_data" name="lastname" v-model="animal.lastname" type="text" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
              </p>
            </li>
            <li>
              <h2>Sexe</h2>
              <p><span class="show_data">
                    <img src="../assets/man.png" alt="Homme"  v-if="sex == 1"/>
                    <img src="../assets/woman.png" alt="Femme" v-if="sex == 2"/>
                    <img src="../assets/unknown.png"alt="Hermaphrodite" v-if="sex == 3"/>
                    <p v-else></p>
                  </span>
                <div class="edit_data">
                    <label for="m"><img src="../assets/man.png" alt="Homme"/></label>
                    <input type="radio" id="m" value="m" name="sex">
                    <label for="f"><img src="../assets/woman.png" alt="Femme"/></label>
                    <input type="radio" id="f" value="f" name="sex">
                    <label for="h"><img src="../assets/unknown.png" alt="Hermaphrodite" /></label>
                    <input type="radio" id="h" value="h" name="sex">
                </div>
              </p>
            </li>

            <li>
              <h2>Date de naissance</h2>
              <p>
                <span class="show_data">{{animal.date_birth}}, {{animal.age}} ans</span>
                <date-component v-if="choice == 1"></date-component>
              </p>
            </li>
            <li>
              <h2>Ville</h2>
              <p><span class="show_data">{{animal.city}}</span>
                <input class="edit_data" name="city" v-model="animal.city" type="text" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
              </p>
            </li>
        </ul>
        </div>
        <div class="desc">
          <h1>Description</h1>
          <p><span class="show_data">{{animal.description}}</span>
            <textarea style="width:97%;" cols="5" rows="5" class="edit_data" name="description" v-model="animal.description" ></textarea>
          </p>
        </div>
      </div>
      <div id="button_valid_2" class="edit_data">
        <button type="submit" class="button_style_2">VALIDER
          <img src="../assets/search_mob.png" class="img_button"/>
        </button>

      </div>

    </form>
    <div class="delete">
      <h2  v-on:click="delete_animal">Supprimer cette animal</h2>
    </div>
  </div>
  <div v-else>
    <img src="../assets/non_connecter.png"/>
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
    return {
      choice : 0,
      edit : 0,
      sex : 0,
      user : null,
      animal : '',
    }
  },
  created : function(){
      var get_id = this.$route.params.id;
      this.$http.get('https://api.meowtic.com/profile/get/'+ get_id )
        .then(function(response){
          let data = response.data;
          this.user = response.data.output;
          if(data.success){
            this.animal = this.user;
            if(this.$parent.user.id ==this.user.creator_id){
              this.edit = 1;
            }
          }
        })
        if(this.animal.sex == 'm'){
          this.sex = 1;
        }else if (this.animal.sex == 'f') {
          this.sex = 2;
        }else if (this.animal.sex == 'h') {
          this.sex = 3;
        }
    },
    methods : {
      edit_details : function (){
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
        let formData = new FormData(document.getElementById('profile-form'));
        this.$http.post('https://api.meowtic.com/profile/edit', formData)
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

      delete_animal : function(){
        this.$http.post('https://api.meowtic.com/profile/delete/'+this.animal.id)
        .then(function(response){
            let data = response.data
            if(data.success){
                location.href = 'profileuser'
                alert('votre compte à bien été supprimé');
            }
            else{

            }
        })
      },
    }
}


</script>

<style lang="less">
@import "../definitions"; /* import common definitions */

#content_profile .button_style_2{
  border-radius: 6px;
  background-color:@lightBlue;
  font-size:1.2em;
  font-family: 'Moon';
  color:white;
  cursor:pointer;
  padding-right: 0.8em;
  padding-left: 0.8em;
  padding-top: 0.2em;
  padding-bottom: 0.2em;
  display: block;



}


#button_valid_2{
  display: none;
  position:absolute;
  z-index:88;
  margin-left: 15%;
  margin-top:-9em;
}

@media screen and (max-device-width:1275px), screen  and (max-width:1275px){
  #button_valid_2{
  margin-top: -8em;
  }
}

  @media screen and (max-device-width:902px), screen  and (max-width:902px){
    #button_valid_2{
    margin-top: -4.3em;
    margin-left: 18em;
    }
}

@media screen and (max-device-width:610px), screen  and (max-width:610px){
  #button_valid_2{
  margin-top: -4.3em;
  margin-left: 10em;
  }
}


</style>
