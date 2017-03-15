<template>
   <div id="content_profile" v-on:submit.prevent="edit_animal" v-if="user != null">
    <h1>Profil</h1>
    <form  id="profile-form">
    <input type="hidden" name="id" v-bind:value="animal.id">
    <div id="cover">
      <div class="cover">
        <div class="input-cover-container edit_data">
          <input class="input-cover" type="file" name="cover_file">
          <label for="my-file" class="input-cover-trigger" tabindex="0">
            <img src="../assets/photo.png" id="img_change_cover"/>
            Importer une nouvelle couverture de profil
          </label>
        </div>
        <p class="cover-return  edit_data"></p>
        <img v-if="animal.cover_image != null" v-bind:src="animal.cover_image.path" v-bind:alt="animal.name" id="ban">
      </div>
      <div id="profile_picture">

        <img v-if="animal.profile_image != null" v-bind:src="animal.profile_image.path" v-bind:alt="animal.name">
        <div class="input-file-container edit_data">
          <input class="input-file" id="my-file" type="file" name="profile_file">
          <label for="my-file" class="input-file-trigger" tabindex="0">Importer une photo</label>
        </div>
        <p class="file-return  edit_data"></p>
      </div>
      <div id="info_princ">
        <span class="show_data" >{{animal.name}}, {{animal.age}} ans </span>
        <input class="edit_data" v-model="animal.name" name="name" type="text" title="Min 4, max 20 caractères, lettre, chifres - _ ou . acceptés">
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
          <div id="first">
            <ul>
              <li>
                <h2>Sexe</h2>
                <p><span class="show_data">
                      <img src="../assets/man.png" alt="Homme"  v-if="sex == 1"  class="img_sex" />
                      <img src="../assets/woman.png" alt="Femme" v-if="sex == 2"  class="img_sex" />
                      <img src="../assets/unknown.png"alt="Hermaphrodite" v-if="sex == 3" class="img_sex" />
                      <p v-else></p>
                    </span>
                  <div class="edit_data">
                      <label for="m"><img src="../assets/man.png" alt="Homme" class="img_sex" /></label>
                      <input type="radio" id="m" value="m" name="sex">
                      <label for="f"><img src="../assets/woman.png" alt="Femme" class="img_sex" /></label>
                      <input type="radio" id="f" value="f" name="sex">
                      <label for="h"><img src="../assets/unknown.png" alt="Hermaphrodite" class="img_sex" /></label>
                      <input type="radio" id="h" value="h" name="sex">
                  </div>
                </p>
              </li>

                <li>
                  <h2>Espèce</h2>
                  <p><span class="show_data">{{animal.species.name}}</span>
                    <select class="edit_data"  name="species.id" v-model="animal.species.id">
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
          </ul>
        </div>

        <div id="second">
          <ul>
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
                <input class="edit_data" name="city" v-model="animal.city" type="text" >
              </p>
            </li>
          </ul>
      </div>

        </div>
        <div class="desc">
          <h1>Description</h1>
          <p><span class="show_data">{{animal.description}}</span>
            <textarea style="width:97%;" cols="5" rows="5" class="edit_data" name="description" v-model="animal.description" ></textarea>
          </p>
            <h1>J'aime</h1>
            <p><span class="show_data">{{animal.like}}</span>
              <textarea style="width:97%;" cols="5" rows="5" class="edit_data" name="info_like" v-model="animal.like" ></textarea>
            </p>
            <h1>Je n'aime pas</h1>
            <p><span class="show_data">{{animal.dislike}}</span>
              <textarea style="width:97%;" cols="5" rows="5" class="edit_data" name="info_dislike" v-model="animal.dislike" ></textarea>
            </p>
        </div>
      </div>

      <div id="button_valid_2" class="edit_data">
        <button type="submit" class="button_style_2">VALIDER
          <img src="../assets/search_mob.png" class="img_button"/>
        </button>

      </div>

    </form>
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
      user: null,
      animal : [],
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
        switch(this.animal.sex){
          case "m":
            this.sex=1;
            break;
          case "f":
            this.sex=2;
            break;
          default:
              this.sex=3;
              break;
        }
         // Type file
          document.querySelector("html").classList.add('js');
          var fileInput  = document.querySelector( ".input-file, .input-cover" ),
              button     = document.querySelector( ".input-file-trigger, .input-cover-trigger" ),
              the_return = document.querySelector(".file-return, .cover-return");
          button.addEventListener( "keydown", function( event ) {
              if ( event.keyCode == 13 || event.keyCode == 32 ) {
                  fileInput.focus();
              }
          });
          button.addEventListener( "click", function( event ) {
             fileInput.focus();
             return false;
          });
          fileInput.addEventListener( "change", function( event ) {
              the_return.innerHTML = this.value;
          });
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
        let formData = new FormData(document.getElementById('profile-form'));
        this.$http.post('https://api.meowtic.com/profile/edit', formData)
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
      getBackgroundImage () {
       // Get Background image
           return `url("this.animal.cover_image" )`
     }
    }
}
</script>

<style lang="less">
@import "../definitions"; /* import common definitions */
#ban{
  width: 100%;
  overflow: hidden;
}
.cover{
  height: 300px;
  overflow: hidden;
}
/* styles de base si JS est activé */
#profile_picture img{
  position: absolute;
}
.js .input-file-container {
  position: absolute;
  width: 170px;
  bottom: 0
}
.js .input-file-trigger {
  display: block;
  padding: 1em;
  background: rgba(0,0,0,0.5);
  color: #fff;
  font-size: 1em;
  transition: all .4s;
  cursor: pointer;
}
.js .input-file {
  position: absolute;
  top: 0; left: 0;
  width: 170px;
  padding: 14px 0;
  opacity: 0;
  cursor: pointer;
}
.js .input-cover-container {
  position: absolute;
  top: 0;
}
.js .input-cover-trigger {
  display: block;
  padding: 1em;
  background: rgba(0,0,0,0.5);
  color: #fff;
  font-size: 1em;
  transition: all .4s;
  cursor: pointer;
}
.js .input-cover {
  position: absolute;
  top: 0; left: 0;
  width: 170px;
  padding: 14px 0;
  opacity: 0;
  cursor: pointer;
  overflow: hidden;
}
.cover-return{
  margin: 0
}
#img_change_cover{
  height: 30px;
  padding-right: 1em;
  vertical-align: middle;
}
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
