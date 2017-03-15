<template>

	<div id="message-preview">
		<img src="../assets/razor.jpg" id="avatar">
		<div id = "txt">
			<div id="author">
				<span>{{message.author}}</span>
			</div>

			<div id="date">
				<p>{{message.date}}</p>
			</div>

			<div id="text-prev">
				{{message.text}}
			</div>
		</div>
		<button v-on:click="formMessage">Edit</button>
		<button v-on:click="deleteMessage">Suppr</button>
	</div>

	<!--
	<div id="message-form" v-if="editChoice == 1">
	<form v-on:submit.prevent="editMessage" id="edit-message">
			<span><p style="white-space: pre"></p>
			<br>
			<textarea v-model="content" placeholder="add multiple lines"></textarea>
			</span>
		</form>
		<button type="submit">Valider</button>
	</div>
	-->

</template>


<script>
	import Vue from 'vue'
	Vue.use(require('vue-resource'));

	export default {
		name:"PreviewmessageComponent",

		data() {
			return {
				editChoice:0,
				content:this.message.text
			}
		},

		// tu définis ton prop pour que vue sache qu'il doit aller le chercher
		props: {
			message: Object //change en Object pour le link back
		},
			// maintenant tu as acces à contact dans ton template
			//à partir du moment ou tu as accès à la contact list dans ton component à gauche là, ça sera automatiquement dispo ici, et mis à jour en temps réel

			//du coup ce qui est dans data sert à rien puisque ça va directement chercher dans la
			//contact list à gauche ?
			// exactement, c'est du "one-way data binding", tu fais descendere l'information et elle peut pas être modifié par le component, il peut seulement l'exploiter
			//ptn c'est beau	

		created: function() {

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

		},


		formMessage: function(event) {
			var that = this;
			that.editChoice = 1;
		},

		editMessage: function(event) {
			var that = this;
  			var message = this.message;
				that.choice = 1;
				console.log(that.choice);
				that.$http.post('https://api.meowtic.com/messenger/edit/',message.id,that.content,message.group_id)
				.then(function(response){
					let data = response.data;
					console.log(data);
					if(data.success){
						console.log(data);	
						that.choice = 0;					
					}
					else {
					}
				}, handleError)
		},

		deleteMessage: function(event) {
			var that = this;
  			var message = this.message;
				console.log(that.choice);
				that.$http.post('https://api.meowtic.com/messenger/delete/',message.id)
				.then(function(response){
					let data = response.data;
					console.log(data);
					if(data.success){
						console.log(data);						
					}
					else {
					}
				}, handleError)

		}


	}

</script>


<style lang="less">
	@import "../definitions";
/*scopt pour avoir le style propre à la page*/

	#message-preview{
		width:100%;
		background-color: white;
		margin-bottom:10px;
		margin-top:10px;
		border: 1px solid #DADADA;
	}

	#avatar{
		height:150px;
		position:relative;
		display:inline-block;
		bottom:0px;
		left:0px;
		float:left;
		margin-right:10px;
	}

	#txt{
		height:150px;
		position:relative;
		margin:auto;
		text-align:left;
		color:@darkBlue;
		font-family:'KhmerUi';
	}
	
	#author{
		margin:auto;
		font-weight: bold;
		font-size:1.2em;
	}

	#date{
		margin:auto;
		font-weight: lighter;
		font-size:0.8em;
	}

	#text-prev{
		margin:auto;
		font-weight: lighter;
		font-size:1em;
	}


</style>