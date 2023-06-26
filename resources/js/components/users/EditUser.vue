<template>
    <div class="card mt-3">
      <div class="card-body">
        <h3>
          <button class="btn btn-outline-primary btn-sm" @click="emit('view-dashboard')">
            <i class="fas fa-chevron"></i> Back
          </button>
          Edit User
          <small class="text-muted">{{ user.name }}</small>
        </h3>
        <hr>
  
        <div class="form-group row">
          <label class="col-3">Name</label>
          <div class="col-9">
            <input type="text" class="form-control" v-model="data.name">
          </div>
        </div>
  
        <div class="form-group row">
          <label class="col-3">Email</label>
          <div class="col-9">
            <input type="text" class="form-control" v-model="data.email">
          </div>
        </div>
  
        <div class="form-group row">
          <label class="col-3">Role</label>
          <div class="col-9">
            <select class="form-control" v-model="data.role">
              <option value="admin">Admin</option>
              <option value="user">User</option>
            </select>
          </div>
        </div>
  
        <button class="btn btn-primary" @click.prevent="updateUser">Update User</button>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';
  
  export default {
    props: ['user'],
    data() {
      return {
        data: {
          name: '',
          email: '',
          role: '',
        },
      };
    },
    methods: {
        updateUser: function() {
  axios.put('data/users/' + this.user.id, {
    name: this.data.name,
    email: this.data.email,
    role: this.data.role
  })
  .then(response => {
    this.$emit('user-updated');
  })
  .catch(error => {
    console.error("Error updating user:", error);
  });
},

      assignUserToData: function() {
        Object.keys(this.data).forEach(key => this.data[key] = this.user[key]);
      }
    },
    mounted() {
      this.assignUserToData();
    },
    watch: {
      user: function() {
        this.assignUserToData();
      },
    },
  };
  </script>
  