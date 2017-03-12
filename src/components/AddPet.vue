<template>

    <section>
      <h2>Informations du proprietaire</h2>

      <form v-on:submit.prevent="addpet" id="signup-form">
        <ul>
          <li>
            <label>Pseudo (entre 4 et 20 caractères - lettres, chiffres - _ ou . acceptés)*</label>
            <input type="text" name="name" v-model="addPet.name">
          </li>

            <li>
              <select name="species_id" v-model="addPet.species_id">
                  <option value="6">Chat</option>
                  <option value="7">Chien</option>
              </select>
            </li>
        </ul>
      </form>

    <div>
      <button v-on:click="submit()">Valider</button>
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
      this.$http.post('https://api.meowtic.com/profile/edit', this.addPet, { emulateJSON : true })
        .then(function(response){
          let data = response.data;
          if(data.success){
            console.log('Profile créé');
            this.addPet = response.data.output;
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

#signup-form {
  text-align: center;
}
</style>
