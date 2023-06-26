<template>
    <div>
      <div class="card mt-3">
        <div class="card-body">
          <h3>
            <button class="btn btn btn-outline-primary mr-3" @click="$emit('view-dashboard')">
              <i class="fas fa-chevron-left"></i>Back
            </button>
            Add New User
          </h3>
          <hr />
  
          <div class="alert alert-warning" v-if="errors.length > 0">
            <ul>
              <li v-for="error in errors" :key="error">{{ error }}</li>
            </ul>
          </div>
  
          <form action="#">
            <div class="form-group row">
              <label for="" class="col-3">Name</label>
              <div class="col-9">
                <input type="text" class="form-control" v-model="data.Name" />
              </div>
            </div>
  
            <div class="form-group row">
              <label for="" class="col-3">Email</label>
              <div class="col-9">
                <input type="email" class="form-control" v-model="data.Email" />
              </div>
            </div>
  
            <div class="form-group row">
              <label for="" class="col-3">Role</label>
              <div class="col-9">
                <select class="form-control" v-model="data.Role">
                  <option value="user">
                    <i class="fas fa-chevron-right"></i> User
                  </option>
                  <option value="admin">
                    <i class="fas fa-chevron-right"></i> Admin
                  </option>
                </select>
              </div>
            </div>
  
            <div class="form-group row">
              <label class="col-3">Password</label>
              <div class="col-9">
                <input type="password" v-model="data.Password" class="form-control" />
              </div>
            </div>
  
            <div class="form-group row">
              <label class="col-3">Confirm Password</label>
              <div class="col-9">
                <input type="password" v-model="data.ConfirmPassword" class="form-control" />
              </div>
            </div>
  
            <button class="btn btn-primary" @click.prevent="storeUser">Create User</button>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        data: {
          Name: '',
          Email: '',
          Role: '',
          Password: '',
          ConfirmPassword: '',
        },
        errors: [],
      };
    },
    methods: {
      storeUser() {
        axios
          .post('data/users', {
            name: this.data.Name,
            email: this.data.Email,
            role: this.data.Role,
            password: this.data.Password,
            password_confirmation: this.data.ConfirmPassword,
          })
          .then(response => {
            const user = response.data.user;
            const successMessage = 'Successfully created user: ' + user.name + ' | Email: ' + user.email;
            this.$emit('created-user', successMessage);
          })
          .catch(error => {
            this.flashErrors(error.response.data.errors);
          });
      },
      flashErrors(errors) {
        this.errors = []; // Clear the errors array before adding new errors
        for (const [key, value] of Object.entries(errors)) {
          for (let item in value) {
            this.errors.push(value[item]);
          }
        }
      },
    },
  };
  </script>
  