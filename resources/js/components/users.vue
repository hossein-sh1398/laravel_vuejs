<template>
    <div class="mt-3">
        <div class="d-flex justify-content-between">
        	<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modal-create-users">
    		  کاربر جدید
    		</button>
            <input type="text" v-model="stringSearch" @keypress.enter="search" class="mb-2">
        </div>
        <table class="table table-bordered">
        	<thead>
        		<tr>
        			<th>نام</th>
        			<th>ایمیل</th>
        			<th>عملیات</th>
        		</tr>
        	</thead>
        	<tbody>
        		<tr v-for="user in users.data">
        			<td>{{user.name}}</td>
        			<td>{{user.email}}</td>
                    <td><button class="btn btn-danger btn-sm ml-1" @click="destroy(user.id)">حذف</button>
        			<button class="btn btn-warning btn-sm" @click="edit(user.id)">ویرایش</button></td>
        		</tr>
        	</tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                    </td>
                </tr>
            </tfoot>
        </table>
        <pagination :data="users" @pagination-change-page="getUsers">
            <span slot="prev-nav">بعدی</span>
            <span slot="next-nav">قبل</span>
        </pagination>
        
		
		<div class="modal fade" id="modal-create-users" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">فرم ایجاد کاربر جدید</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true"></span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<label>نام</label>
								<input type="text" :class="['form-control', {'has-error': errors.has('name')}]" name="name" v-model="form.name" @keydown="errors.clear('name')">
                                <div v-if="errors.has('name')" style="color:red;">
                                    {{errors.get('name')}}
                                </div>
							</div>
							<div class="form-group">
								<label>ایمیل</label>
								<input type="text" class="form-control" :class="['form-control', {'has-error': errors.has('email')}]" v-model="form.email" @keydown="errors.clear('email')">
                                <div v-if="errors.has('email')" style="color:red;">
                                    {{errors.get('email')}}
                                </div>
							</div>
							<div class="form-group">
								<label>پسورد</label>
								<input type="password" class="form-control" :class="['form-control', {'has-error': errors.has('password')}]" v-model="form.password" @keydown="errors.clear('password')">
                                <div v-if="errors.has('password')" style="color:red;">
                                    {{errors.get('password')}}
                                </div>
							</div>

						</form>
					</div>
					<div class="modal-footer">
						<button type="button" id="hide-modal-create-user" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
						<button type="button" @click="create" :disabled="errors.any()" class="btn btn-primary">افزودن</button>
					</div>
				</div>
			</div>
		</div>

        <!-- edit modal -->
            <div class="modal fade" id="modal-edit-users" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">فرم ویرایش</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>نام</label>
                                <input type="text"class="'form-control'" v-model="form.name">

                            </div>
                            <div class="form-group">
                                <label>ایمیل</label>
                                <input type="text" class="form-control" v-model="form.email">
                            </div>
                            

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="hide-modal-edit-user" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                        <button type="button" @click="update" class="btn btn-warning">ویرایش</button>
                    </div>
                </div>
            </div>   </div>
    </div>
</template>

<script>
	var app;
    class Errors {
        constructor() {
            this.errors = {};
        }

        has(field) {
            return this.errors.hasOwnProperty(field);
        }

        get(field) {
            if (this.errors[field]) {
                return this.errors[field][0]; 
            }
        }

        clear(field) {
            if (this.errors[field]) {
                delete this.errors[field];
            }
        }
                
        any() {
            return Object.keys(this.errors).length > 0;
        }

        record(errors) {
            this.errors = errors;
        }
    }
    export default {
    	data() {
    		return {
    			users: {},
    			form: {
    				name: null,
    				email: null
    			},
                id: null,
                stringSearch: null,
                errors: new Errors()
    		}
    	},



        mounted() {
           app = this;
           this.getUsers();
        },
        methods: {
        	getUsers(page = 1) {
        		axios.get('http://localhost/test/public/api/v1/users?page=' + page)
        		.then(function(r) {
        			app.users = r.data;
        			 
        		});
        	},



        	create() {
                var token = localStorage.getItem('access_token');
                
        		axios.post('http://localhost/test/public/api/v1/users/create', this.form, {
                    headers: {
                        Accept: 'Application/json',
                        Authorization: 'Bearer ' + token
                    }
                })
        		.then(function(data) {
                    if (data.data.status == 'unauthorized') {
                        alert(data.data.message);
                    } else {
                        app.getUsers();                 
                         
                        app.empty();
                        $('#hide-modal-create-user').click();
                    }
                })
                .catch(function(error) {
                     console.log(error.response.data.messages);
                    app.errors.record(error.response.data.messages);
                    
                });
        	},



        	empty() {
        		this.form = {
        			name: '',
        			email: ''
        		}
        	},



        	destroy(id) {
        		var c = confirm('آیا از حذف کردن مطمءن هستید؟');
        		if (!c) {
        			return false;
        		}
        		var fd = new FormData();
        		fd.append('id', id);
        		fd.append('_method', 'delete');
        		axios.post('http://localhost/test/public/api/v1/users/destroy', fd)
        		.then(function(data) {
        			//app.empty();
        			//$('#hide-modal').click();
					app.getUsers();        			
        		});
        	},



            edit(id) {
                axios.get('http://localhost/test/public/api/v1/users/edit/' + id)
                .then(function(data) {
                   
                    $('#modal-edit-users').modal('show');                 
                    app.form = {
                        email: data.data.data.email,
                        name: data.data.data.name
                    };
                    app.id = data.data.data.id;
                });
            },



            update() {
                var fd = new FormData();
                
                fd.append('_method', 'patch');
                fd.append('name', this.form.name);
                fd.append('email', this.form.email);
                axios.post('http://localhost/test/public/api/v1/users/update/' + app.id, fd)
                .then(function(data) {
                    app.id = null;
                    app.empty();
                    $('#hide-modal-edit-user').click();
                    app.getUsers();                 
                });
            },



            search() {
                this.getUsers( this.stringSearch );
            }
        }
    }
</script>

<style scoped>
    .has-error{
        border: 1px solid brown;
    }
</style>