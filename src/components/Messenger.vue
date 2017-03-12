<template>

	<section id="frame">
		<div id="messenger-index">
			<img src="../assets/Meetic.png" id="logo" alt="Logo"/>
	      	<h1>Messagerie</h1>
	    	
	    	<div id="list-preview">
	      	<previewmessage-component></previewmessage-component>
	      	</div>

		</div>
	</section>
</template>




<script>
	import Vue from 'vue'
	Vue.use(require('vue-resource'));

	import PreviewmessageComponent from "./PreviewMessage.vue"

	export default {
		components: {
			PreviewmessageComponent
		},

		data() {

		},

		methods:{
			list_contacts : function() {

			},

			get_full_conv : function(contactId) {

			},

			send_message : function() {

			},

			get_last_message : function (contactId) {

			},


		}

	}

	var handleError = function(error){
      console.log('Error! Could not reach the API. ' + error)
  	}



</script>


<style lang="less">
	@import "../definitions";

	#messenger-index #logo{
		display: block;
		margin: auto;
	 	width:110px;
	}

	#list-preview{
		width:80%;

	}


</style>