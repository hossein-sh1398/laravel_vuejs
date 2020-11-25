<template>
    <div class="mt-3">
        <h3>پنل کاربری</h3>
        <ul>
        	<li>نام: {{user.name}}</li>
        	<li>ایمیل: {{user.email}}</li>
        </ul>
    </div>
</template>

<script>
	var app;
    export default {
    	data() {
    		return {
    			user:{
    				name: '',
    				email: ''
    			}
    		}
    	},
        mounted() {

           app = this;
           this.getUser();
        },
        methods: {
        	getUser() {
        		var token = localStorage.getItem('access_token');
        		axios.get('http://localhost/test/public/api/v1/user', {
        			headers: {
        				Accept: 'Application/json',
        				Authorization: 'Bearer ' + token
        			}
        		})
        		.then(function(res) {
        			app.user = {
        				name: res.data.name,
        				email: res.data.email
        			}
        		})
        		.catch(function(er) {
        			console.log(er);
        			alert('خطا در دریافت اطلاعات');
        		});
        	}
        }
    }
</script>
