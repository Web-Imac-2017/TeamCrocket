<template>
   <div id="content_profile" v-if="user != null">
    <h1>Profil</h1>
    <form  v-on:submit.prevent="edit_animal"  id="profile-form">
    <input type="hidden" name="id" v-bind:value="animal.id">
    <div id="cover">
      <div id="profile_picture">
        <img v-if="animal.image != null" v-bind:src="animal.path" v-bind:alt="animal.name">
      </div>
      <div id="info_princ">
        <span class="show_data" >{{animal.name}}, {{animal.age}} ans </span>
        <input class="edit_data" v-model="animal.name" name="nickname" type="text" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{3,20}$" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
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
          {{this.animal.path}}
          <ul>
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
                <h2>Espèce</h2>
                <p><span class="show_data">{{animal.species.name}}</span>
                  <select class="edit_data"  v-model="animal.species.id">
                     <option value="12">Arthropode</option>
                     <option value="6">Chat</option>
                     <option value="8">Cheval</option>
                     <option value="9">Chien</option>
                     <option value="13">Lézard</option>
                     <option value="15">Poisson</option>
                     <option value="16">Rongeur</option>
                     <option value="10">Serpent</option>
                     <option value="14">Tortue</option>
                     <option value="17">Autre</option>
                  </select>
                </p>
              </li>

            <li>
              <h2>Date de naissance</h2>
              <p>
                <span class="show_data">{{animal.date_birth}}</span>
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
          {{this.test}}
          <p><span class="show_data">{{animal.description}}</span>
            <textarea class="edit_data" name="description" v-model="animal.description" ></textarea>
          </p>
          <h1>J'aime</h1>
          <p><span class="show_data">{{animal.like}}</span>
            <textarea class="edit_data" name="description" v-model="animal.like" ></textarea>
          </p>
          <h1>Je n'aime pas</h1>
          <p><span class="show_data">{{animal.dislike}}</span>
            <textarea class="edit_data" name="description" v-model="animal.dislike" ></textarea>
          </p>
        </div>
      </div>
      <div id="button_valid" class="edit_data">
        <button type="submit" class="button_style" v-on:click="edit_animal()">VALIDER
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
    return {
      choice : 0,
      edit : 0,
      sex : 0,
      user: null,
      animal : [],
      test:[]
    }
  },
  created : function(){

     this.$http.get('https://api.meowtic.com/user/whois')
        .then(function(response){
          let data = response.data;
          if(data.success){
            this.user = 1;
          }
      });

      var get_id = this.$route.params.id;
      this.$http.get('https://api.meowtic.com/profile/get/'+ get_id )
        .then(function(response){
          let data = response.data;
          this.animal = response.data.output;
          if(data.success){
            if(this.$parent.user.id ==this.animal.creator_id){
              this.edit = 1;
            }
          }
        })
        switch(this.animal.sex){
          case 'm':
            this.sex = 1;
            break;
          case 'f':
            this.sex = 2;
            break;
          default:
            this.sex = 3;
            break;
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
      edit_animal : function(){
        this.$http.post('https://api.meowtic.com/profile/edit', this.animal,  { emulateJSON : true })
          .then(function(response){
            let data = response.data;
            if(data.success){
              console.log('Profile modifié');
              this.animal = response.data.output;
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
@import "../definitions"; /* import common definitions */

</style>
