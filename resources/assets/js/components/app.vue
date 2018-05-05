<template>
	<div class="container">
		
		<transition name="fade">
			<router-view></router-view>

		</transition>
	</div>

</template>

<style>	
.alert {
	z-index: 2000;
}
</style>
<!--
<script>
export default {
	mounted() {
		console.log('Component mounted.')
		console.log(this.$notify)
		this.$notify({
          title: 'Title',
          content: 'This sample notification will dismiss automatically.',
          duration: 5000
        }).then(() => {
          // resolve after dismissed
          console.log('dismissed')
        })
	}
}
</script>
-->