<template>

    <section id="addpet">
      <h1><img src="../assets/patoune.png"><br/>
          Ajouter un animal</h1>

      <form v-on:submit.prevent="addpet" id="signup-form">
        <ul>
          <li>
            <h2>Pseudo</h2>
            <input type="text" name="name" class="pseudo" v-model="addPet.name">
          </li>

            <li>
              <h2>Espece</h2>
              <select name="species_id" v-model="addPet.species_id">
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
            </li>
        </ul>
      </form>

      <div class="button_validation" >
        <button class="button_style"  v-on:click="submit()">VALIDER
            <img src="../assets/search_mob.png" class="img_button"/>
        </button>
      </div>


    </section>

</template>

<script>
export default {
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
    submit : function(){
      this.$http.post('profile/edit', this.addPet, { emulateJSON : true })
        .then(function(response){
          let data = response.data;
          if(data.success){
            console.log('Profile créé');
            this.addPet = response.data.output;
            location.href = '/profileuser';
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
#addpet{
  background-color: white;
  width: 70%;
  padding: 3em;
  margin:auto;
  margin-top:2em;
  margin-bottom:5em;
}
#signup-form {
  text-align: center;
}
form#signup-form ul li input.pseudo{
  width:400px;
  margin:auto
}
form#signup-form ul li select{
  margin:auto;
  background-color:white;
  border-radius: 6px;
  box-shadow : 7px 7px 4px rgba(0, 0, 0, 0.3);
  width: 100px;
  font-size: 1em;
  padding:0.5em;
  padding-top:0.2em;
  padding-bottom:0.2em;
  margin-bottom:3em;
  color:@darkBlue;
  font-family: @fontTitle;
}

.button_validation{
    border-radius: 6px;
}

@media screen and (max-device-width:650px), screen  and (max-width:650px){
  #addpet{
    width: 90%;
    padding: 1em;
  }
  form#signup-form ul li input.pseudo{
    width:100%
  }
}
</style>
