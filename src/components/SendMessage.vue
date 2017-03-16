<template>

	<div id="message-form">
		<h2>Entamez la discussion !</h2>    
    <form v-on:submit.prevent="sendmessage">
      <input type="hidden" name="formData.id" value="0">
      <input type="hidden" name="formData.group_id" value="1"> <!--remplacer value par
      le group_id envoyé en props quand on aura le lien entre components et back-->
			
      <span><p style="white-spacea"></p>
			<br>
			<textarea v-model="formData.content" placeholder="Ecrivez votre message" class="white-space"></textarea>
      <br>
      </span>
      <div id="button_form">
        <button type="submit" class="button_form">Envoyer
        </button>
      </div>
		</form>
	</div>

</template>

<script>
import Vue from 'vue'
Vue.use(require('vue-resource'));

export default {

  name:"SendmessageComponent",

  data(){
    return{
      formData: {
        id: 0,
        content: '',
        group_id: 1
      },
      animal:null,
    }
  },

created: function() {
  //this.getrandom();
},

methods: {

    /*getrandom : function()
    {
      var that = this;
      var get_id = this.$route.params.id;
      this.loading = true;
      that.$http.get('https://api.meowtic.com/user/get/' + get_id)
      .then(function(response){
        let data = response.data;
        that.loading = false;
          if(data.success){
              that.animal = data.output;
              if(data.ouput == null)
              {
                return
              }
          }
      }, handleError)
    },*/

  	sendmessage: function(event) { //envoie au compte id 146, on aurait pu envoyer à n'importe qui si on avait le lien back...
  		var that = this;
			var FRIEND_UID = 146;
			that.choice = 1;
			console.log(that.choice);
			that.$http.post('https://api.meowtic.com/messenger/edit/'+FRIEND_UID,that.formData)
				.then(function(response){
					let data = response.data;
					if(data.success){
						console.log(data);
           // alert(data.content);
						
					}
					else {
            alert(response.data.message);
					}
				}, handleError)

  	}
  }
}


 var handleError = function(error){
      console.log('Error! Could not reach the API. ' + error)
  }


</script>


<style lang="less">
	@import "../definitions";

	#message-form{
		width:80%;
		background-color: white;
		margin-top:2%;
    margin: auto;

    @media (max-width: 700px)
    {
      flex-direction: column;
      width: 100%;
      img, div, textarea {
      width: 100%;
      }
    }

	}

  .white-space {
    width:100%;
    height:200px;
    margin-bottom:2%;
    margin-top:2%;
    margin: auto;
    border: 1px solid #DADADA;
    font-size:1em;

    @media (max-width: 700px)
    {
      flex-direction: column;
      width: auto;
      img, div, textarea {
      width: auto;
      }
    }

  }

</style>