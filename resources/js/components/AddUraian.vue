<template>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div v-if="error" id="notif" class="alert alert-primary alert-dismissible text-white" role="alert">
                        <span class="text-sm">{{ error }}</span>
                        <button type="button" class="btn-close text-lg py-3 opacity-10" v-on:click="hideAlert()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Input Tambah Data Uraian</h6>
                            </div>
                        </div>
                        <div class="card-body ">
                            <form @submit.prevent="addPost">
                                <div class="inpute- mb-3">
                                    <label>Nama Uraian</label><span class="text-danger"> *</span>
                                    <div class="input-group input-group-outline mb-3">
                                        <input id="nama" type="text" class="form-control" v-model="nama" placeholder="Masukkan Nama Uraian">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4 mb-4"> Add Post</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </template>

    <script>

    export default{
        name: "AddPost",
        data() {
            return {
                loggedIn: localStorage.getItem('loggedIn'),
                token: localStorage.getItem('token'),
                nama : '',
                error: null,
            }
        },
        methods: {
            addPost(e) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('/api/uraian/add', {
                        nama : this.nama,
                    })
                    .then(response => {
                        if (response.data.success) {
                            this.$router.push({name : 'uraian'})
                            // window.location.href = "/posts"
                        } else {
                            this.error = response.data.message
                            document.querySelector('.alert').style.display = 'block'
                        }
                        // existingObj.strError = "";
                        // existingObj.strSuccess = response.data.success;
                    })
                    .catch(function(error) {
                        // existingObj.strSuccess ="";
                        // existingObj.strError = error.response.data.message;
                    });
                });
            },

        },
            mounted() {
                if(!this.loggedIn) {
                    window.location.href = "/";

                }
            }
    }

    </script>
