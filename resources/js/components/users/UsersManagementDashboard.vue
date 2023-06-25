<template>
    <div>
      <div class="card mt-3" v-if="active.dashboard">
        <div class="card-body">
          <h3>Manage Users
            <button class="btn btn-outline-success btn-sm float-right" @click="setActive('createUser')">
              <i class="fas fa-plus"></i> Add User
            </button>
          </h3>
          <div class="alert alert-success alert" role="alert" v-if="success_message !== null">
            {{ success_message }}
        </div>
          <paginator v-if="results !== null" :results="results" @get-page="getPage"></paginator>
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>User Since</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in results" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.member && user.member.since }}</td>
                <td>
                  <div class="btn-group">
                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</button>
                    <button class="btn btn-sm btn-danger" @click="deleteUser(user)"><i class="fas fa-trash"></i> Delete</button>

                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>


    <create-user
    v-if="active.createUser"
    v-on:view-dashboard="setActive('dashboard')"

    v-on:created-user="flashSuccessAndReload"
    ></create-user>

    </div>
  </template>

  <script>
  // Import Components
  import axios from 'axios';
  import Paginator from '../utilities/paginations/Paginator.vue';
  import CreateUser from './CreateUser.vue';

  export default {
    components: {
      Paginator,
      CreateUser,
    },
    data() {
      return {
        results: [],
        params: {
          page: 1,
        },
        active: {
          dashboard: true,
          createUser: false,
        },
        success_message: null,
      };
    },
    mounted() {
      this.getUsers();
    },
    methods: {
      getUsers() {
        axios
          .get('/data/users', { params: this.params })
          .then((response) => {
            const { data } = response;
            if (data && Array.isArray(data.data)) {
              this.results = data.data;
            } else {
              console.error('Invalid response data:', data);
            }
          })
          .catch((error) => {
            console.error('Error fetching users:', error);
          });
      },
      deleteUser(user) {
  let r = confirm("Are you sure you want to delete this user: " + user.name + "?");
  if (r) {
    axios.delete('data/users/' + user.id)
      .then(response => {
        // Handle successful deletion
        console.log("User Deleted");
        //
        this.getUsers();
      })
      .catch(error => {
        // Handle deletion error
        console.error("Error deleting user:", error);
      });
  }
},

      getPage(page) {
        if (page === 'previous') {
          this.params.page--;
        } else if (page === 'next') {
          this.params.page++;
        } else {
          this.params.page = page;
        }
        this.getUsers();
      },
      setActive(component) {
        Object.keys(this.active).forEach((key) => {
          this.active[key] = false;
        });
        this.active[component] = true;
      },
      flashSuccessAndReload(event) {
        this.setActive('dashboard'); // Set the active component to the dashboard
        this.success_message = event; // Set the success message
        this.flashSuccess(event); //
        this.getUsers(); // Refresh the user data
}
    },
        flashSuccess: function (message)
        {
            this.success_message = message;
            setTimeout(() => {
                this.success_message = null;
            }, 5000);
        }
  };
  </script>
