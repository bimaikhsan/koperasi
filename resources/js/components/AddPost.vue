<template>
<!--
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Add New Post Data</h5>
                <div>
                    <router-link :to="{name: 'posts'}" class="btn btn-success">Go Back</router-link>
                </div>
            </div>

            <div v-if="strSuccess" class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{strSuccess}}</strong>
            </div>

            <div v-if="strError" class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{strError}}</strong>
            </div>


            <form @submit.prevent="addPost" enctype="multipart/form-data">
                <div class="form-group mb-2">
                    <label>Name</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="name" placeholder="Enter post name">
                </div>

                <div class="form-group mb-2">
                    <label>Name</label><span class="text-danger"> *</span>
                   <textarea class="form-control" rows="3" v-model="description" placeholder="Enter post description"></textarea>
                </div>

                <div class="form-gorup mb-2">
                    <label>Image</label><span class="text-danger"> *</span>
                    <input type="file" class="form-control mb-2" v-on:change="onChange">

                    <div v-if="img">
                        <img v-bind:src="imgPreview" width="100" height="100"/>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4"> Add Post</button>

            </form>

        </div>
    </div> -->
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
                            <h6 class="text-white text-capitalize ps-3">Tambah Data Buku Besar</h6>
                        </div>
                    </div>
                    <div class="card-body ">
                        <form @submit.prevent="addPost">

                            <div class="inpute- mb-3">
                                <label>Nama</label><span class="text-danger"> *</span>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="nama" type="text" class="form-control" v-model="nama" placeholder="Masukkan Nama">
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Tanggal</label><span class="text-danger"> *</span>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="tanggal" type="date" class="form-control" v-model="tanggal">
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Nomor Bukti</label><span class="text-danger"> *</span>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="nomor_bukti" type="text" class="form-control" v-model="nomor_bukti" placeholder="Masukkan Nomor Bukti">
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Nomor Rekening</label><span class="text-danger"> *</span>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="nomor_rekening" type="text" class="form-control" v-model="nomor_rekening" placeholder="Masukkan Nomor Rekening">
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Debit</label>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="debit" type="number" min="0" class="form-control" v-model="debit" placeholder="Masukkan Debit">
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Kredit</label>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="kredit" type="number" min="0" class="form-control" v-model="kredit" placeholder="Masukkan Kredit">
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Saldo</label>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="saldo" type="number" min="0" class="form-control" v-model="saldo" placeholder="Masukkan Saldo">
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
            tanggal:'',
            nomor_bukti:'',
            nomor_rekening:'',
            debit:0,
            kredit:0,
            saldo:0,
            error: null

        }
    },
    methods: {
        addPost(e) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/posts/add', {
                    nama : this.nama,
                    tanggal : this.tanggal,
                    nomor_bukti : this.nomor_bukti,
                    nomor_rekening : this.nomor_rekening,
                    debit:this.debit,
                    kredit:this.kredit,
                    saldo:this.saldo
                })
                .then(response => {
                    if (response.data.success) {
                        this.$router.push({name : 'posts'})
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
        }

    },
        mounted() {
            if(!this.loggedIn) {
                window.location.href = "/";

            }
        }
}

</script>
