<template>
    <!-- <div class="container">
        <div class="row jutify-content-center">
            <div class="col-md-8">
                <div v-if="error !== null" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    <strong>{{error}}</strong>
                </div>

                <div class="card card-default">
                    <div class="card-header"><h5>Login</h5></div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" v-model="email" required
                                           autofocus autocomplete="off" placeholder="Enter your email">
                                </div>
                            </div>


                            <div class="form-group row mt-1">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" v-model="password"
                                           required autocomplete="off" placeholder="Enter your password">
                                </div>
                            </div>

                            <div class="form-group row mt-1 mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success" @click="handleSubmit">
                                        Login
                                    </button>
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-md-8 offset-md-4">
                                    <small class="text-muted">
                                        Don't have any account yet? Please
                                        <router-link to="/register" >Register</router-link>
                                    </small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div> -->


    <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h4>
                </div>
              </div>
              <div class="card-body">

                <div v-if="error" id="notif" class="alert alert-primary alert-dismissible text-white" role="alert">
                    <span class="text-sm">{{ error }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" v-on:click="hideAlert()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form role="form" class="text-start">
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">Email</label>
                    <input id="email" type="email" class="form-control" v-model="email" name="email">
                  </div>
                  <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Password</label>
                    <input id="password" type="password" class="form-control" v-model="password" name="password">
                  </div>
                  <div class="form-check form-switch d-flex align-items-center mb-3">
                    <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                    <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
                  </div>
                  <div class="text-center">
                    <button type="button" class="btn bg-gradient-primary w-100 my-4 mb-2" @click="handleSubmit">Sign in</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>

    export default {
        data() {
            return {
                loggedIn: localStorage.getItem('loggedIn'),
                token: localStorage.getItem('token'),
                email: "",
                password: "",
                error: null
            }
        },

        methods: {
            handleSubmit(e) {
                e.preventDefault()
                if(this.password.length > 0) {
                    this.$axios.get('/sanctum/csrf-cookie').then(response => {
                        this.$axios.post('api/login', {
                            email: this.email,
                            password: this.password
                        })
                        .then(response => {
                            if (response.data.success) {
                                localStorage.setItem("loggedIn", "true")
                                localStorage.setItem("token", response.data.token)
                                this.loggedIn = true
                                this.$router.go('/dashboard')


                            } else {
                                this.error = response.data.message
                                document.querySelector('.alert').style.display = 'block'
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                    })
                }
            },
            hideAlert() {
                console.log("hapus")
                document.querySelector('.alert').style.display = 'none'
            }
        },
        mounted() {
            if(this.loggedIn) {
                return window.location.href = "/dashboard";
            }

        }
    }
</script>
