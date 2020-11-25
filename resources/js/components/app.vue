<template>
    <div class="mt-3 main">
        <nav-bar></nav-bar>
        <router-view></router-view>
        <app-footer></app-footer>
    </div>
</template>

<script>
    import AppFooter from './footer';
    import login from './auth/login';
    import NavBar from './navbar';
    export default {
        data() {
            return {
                name: ''
            }
        },
        mounted() {
           
        },
        components: {
            AppFooter,
            NavBar 
        }
    }
</script>

<style scoped>
	.main{
	   padding: 20px;

	}
</style>
