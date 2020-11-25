<template>
    <div class="navbar">
        <ul>
            <li><router-link to="/test/public">خونه</router-link></li>
            <li><router-link to="/about">درباره ما</router-link></li>
            <li><router-link to="/contact">تماس با ما</router-link></li>
            <li><router-link to="/users">لیست کاربران</router-link></li>
            <li v-if="!isLogin"><router-link to="/login">ورود</router-link></li>
            <li v-if="!isLogin"><router-link to="/register">عضویت</router-link></li>
            <li v-if="isLogin"><router-link to="/user/panel">{{user_name}}</router-link></li>
            <li v-if="isLogin"><a href="#" @click.prevent="logout">خروج</a></li>
        </ul>
    </div>
</template>

<script>
    var app;
    export default {
        data() {
            return {
              
            }
        },
        mounted() {
            app = this;
            name = localStorage.getItem('name');
            var expired_at = localStorage.getItem('expired_at');
            var current_time = new Date().getTime();
            current_time = Math.round(current_time / 1000);
            if (expired_at > current_time) {
                 
                this.$store.dispatch('set_status_login', true);
                this.$store.dispatch('set_user_name', name);
            } else {
                this.$store.dispatch('set_user_name', '');
                this.$store.dispatch('set_status_login', false);
                 
            }
        },
        methods: {
            logout() {

                var token = localStorage.getItem('access_token');
                axios.get('http://localhost/test/public/api/v1/logout', {
                    headers: {
                        Accept: 'Application/json',
                        Authorization: 'Bearer ' + token
                    }
                })
                .then(function(res) {
                    if (res.data.status == 'success') {
                        localStorage.removeItem('expired_at');
                        localStorage.removeItem('access_token');
                        localStorage.removeItem('name');
                        app.$store.dispatch('set_status_login', false);
                        app.$store.dispatch('set_user_name', '');
                        app.$router.push('/test/public');
                    }
                })
                .catch(function(er) {
                    
                    alert('err');
                });
                    
            }
        },
        computed: {
            isLogin() {
                return this.$store.getters.get_login
            },
            user_name() {
                return this.$store.getters.get_name
            }
        }
    }
</script>

<style scoped>
    .navbar{
        background: lightgray;

    }
    ul {
        display: flex;
        justify-content: space-between;
    }
    li{
        list-style: none;
        padding: 15px;
    }
</style>
