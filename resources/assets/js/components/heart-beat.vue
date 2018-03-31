<template>
<div class="animated-box" style="width: 480px !important;">
		<img src="/img/heart-beat.png" width="480" height="265"/>
	</div>
</template>
<style scoped>
		.animated-box{
			max-width: 100%;
			margin: 0 auto;
			display: block;
			 
			background: #000000 url('/img/red-glow.png') 0 0 no-repeat;
		    -moz-animation: bganim 2s linear infinite;
		    -webkit-animation: bganim 2s linear infinite;
		    -o-animation: bganim 2s linear infinite;
		    animation: bganim 2s linear infinite;
		     background-color: rgba(0,0,1,0.4); 
		}
		.animated-box img{
			width: 100%;
			max-width: 100%;
			height: auto!important;
			margin: 0 auto;
			display: block;
		}
		.animated-box-top{
			margin: 0 auto;
			display: block;	
			width: 100%;
			background: transparent url('http://127.0.0.1:8000/img/heart-beat.png') center center no-repeat;
			height: 265px;
		}
		/* Firefox */
		@-moz-keyframes bganim {
		  from {
		    background-position: -256px 0; }
		  to {
		    background-position: calc(100% + 256px) 0; } }
		/* WebKit - Chrome and Safari */
		@-webkit-keyframes bganim {
		  from {
		    background-position: -256px 0; }
		  to {
		    background-position: calc(100% + 256px) 0; } }
		/* Opera */
		@-o-keyframes bganim {
		  from {
		    background-position: -256px 0; }
		  to {
		    background-position: calc(100% + 256px) 0; } }
		/* general syntax */
		@keyframes bganim {
		  from {
		    background-position: -256px 0; }
		  to {
		    background-position: calc(100% + 256px) 0; } 
		}	 
</style>
<script>
export default {
	data() {
		return { }
	}
}
</script>