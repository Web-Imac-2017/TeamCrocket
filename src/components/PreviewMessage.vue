<template>

	<div id="message-preview">
		<img src="../assets/razor.jpg" id="avatar">
		<div id = "txt">
			<div id="author">
				<span>{{message.creator.nickname}}</span>
			</div>

			<div id="date">
				<p>{{message.creation_date}}</p>
			</div>

			<div id="text-prev">
				{{message.content}}
			</div>
		</div>
		<button v-on:click="formMessage">Modifier</button>
		<button v-on:click="deleteMessage">Supprimer</button>
	

	
		<div id="message-form" v-if="editChoice == 1">
			<form v-on:submit.prevent="editMessage" id="edit-message">
				<input type="hidden" name="formData.id" v-model="message.id">
      			<input type="hidden" name="formData.group_id" v-model="message.group_id">
				<span><p style="white-space: pre"></p>
				<br>
				<textarea v-model="formData.content" placeholder="add multiple lines"></textarea>
				<button type="submit">Valider</button>
				</span>
			</form>
		</div>
	</div>
	
</template>


<script>
	import Vue from 'vue'
	Vue.use(require('vue-resource'));

	export default {
		name:"PreviewmessageComponent",

		data() {
			return {
				editChoice: 0,
				
				formData: {
			        id: message.id,
			        content: message.content,
			        group_id: message.group_id
			    }
			}
		},

		props: {
			message: {} 
		},

		created: function() {
			var that = this;
			that.editChoice = 0;
		},

		methods: {


			formMessage: function(event) {
				var that = this;
				that.editChoice = 1;
			},

			editMessage: function(event) {
				var that = this;
					console.log(that.choice);
					that.$http.post('messenger/edit/',that.formData)
					.then(function(response){
						let data = response.data;
						console.log(data);
						if(data.success){
							console.log(data);	
							that.editChoice = 0;					
						}
						else {
						}
					}, handleError)
			},

			deleteMessage: function(event) {
				var that = this;
	  			var message = this.message;
					console.log(that.choice);
					that.$http.post('messenger/delete/',message.id)
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