<template>

<!-- <div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between pb-2 mb-2">
            <h5 class="card-title">All Posts Data</h5>
            <div>
                <button class="btn btn-success" type="button" @click="this.$router.push('/posts/add')">New Post</button>
            </div>
        </div>

        <table class="table table-hover table-sm"  id="example">
            <thead class="bg-dark text-light">
                <tr>
                    <th width="50" class="text-center">#</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Nomor Bukti</th>
                    <th>Nomor Rekening</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(post, index) in posts" :key="post.id">
                    <td class="text-center">{{index+1}}.</td>
                    <td>{{post.nama}}</td>
                    <td>{{post.tanggal}}</td>
                    <td>{{post.nomor_bukti}}</td>
                    <td>{{post.nomor_rekening}}</td>

                    <td class="text-center">
                        <router-link :to="{name:'editpost', params: {id:post.id}}" class="btn btn-warning">Edit</router-link>
                        <button class="btn btn-danger" @click="deletePost(post.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>


    </div>
</div> -->
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Cari Data</h6>
                    </div>
                </div>
                <div class="card-body ">
                        <form @submit.prevent="cariPost">

                            <div class="inpute- mb-3">
                                <label>Tanggal</label><span class="text-danger"> *</span>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="tanggal" type="date" class="form-control" v-model="tanggal">
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Nomor Bukti</label><span class="text-danger"> *</span>
                                <div class="input-group input-group-outline mb-3">
                                    <VueMultiselect
                                    placeholder="Masukan Nomor Bukti"
                                    v-model="nomor_bukti"
                                    :options="optionsbukti"
                                    mode="tags">
                                        <template #noResult>
                                        tidak ada data Nomor Bukti
                                        </template>
                                    </VueMultiselect>
                                    <!-- <input id="nomor_bukti" type="text" class="form-control" v-model="nomor_bukti" placeholder="Masukkan Nomor Bukti"> -->
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Nomor Rekening</label><span class="text-danger"> *</span>
                                <div class="input-group input-group-outline mb-3">
                                    <VueMultiselect
                                    placeholder="Masukan Nomor Rekening"
                                    v-model="nomor_rekening"
                                    :options="optionsrekening"
                                    mode="tags">
                                        <template #noResult>
                                        tidak ada data Nomor Rekening
                                        </template>
                                    </VueMultiselect>
                                    <!-- <input id="nomor_rekening" type="text" class="form-control" v-model="nomor_rekening" placeholder="Masukkan Nomor Rekening"> -->
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 mb-4"> Cari</button>
                        </form>
                    </div>
            </div>
            <div class="card my-4" >
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Hasil Perncarian </h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2" id="hasilpencarian">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Author</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Function</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Employed</th>
                                    <th class="text-secondary opacity-7"></th>
                                    <th class="text-secondary opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(post, index) in posts" :key="post.id">
                                    <td class="text-center">{{index+1}}.</td>
                                    <td>{{post.nama}}</td>
                                    <td>{{post.tanggal}}</td>
                                    <td>{{post.nomor_bukti}}</td>
                                    <td>{{post.nomor_rekening}}</td>
                                    <td class="text-center">
                                        <router-link :to="{name:'lihatpost', params: {id:post.id}}" class="btn btn-primary btn-sm"><i class="material-icons opacity-24">visibility</i></router-link> &nbsp
                                        <router-link :to="{name:'editpost', params: {id:post.id}}" class="btn btn-warning btn-sm"><i class="material-icons opacity-24">edit</i></router-link> &nbsp
                                        <button class="btn btn-danger btn-sm" @click="deletePost(post.id)"><i class="material-icons opacity-24">delete</i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script>
    import VueMultiselect from 'vue-multiselect'
    export default {
        data() {
            return {
                loggedIn: localStorage.getItem('loggedIn'),
                token: localStorage.getItem('token'),
                posts: [],
                tanggal : '',
                nomor_bukti : '',
                nomor_rekening : '',
                selected: null,
                optionsbukti:[],
                optionsrekening:[],
                // options: ['list', 'of', 'options'],
                strSuccess: '',
                strError: ''
            }
        }
        ,
        created() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('api/posts/selectnama/nomor_bukti')
                .then(response => {
                    // console.log(response.data);
                    this.optionsbukti = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
            });
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('api/posts/selectnama/nomor_rekening')
                .then(response => {
                    // console.log(response.data);
                    this.optionsrekening = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
            });
        },
        methods: {
            cariPost(e) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/posts/cari', {
                    nama : this.nama,
                    tanggal : this.tanggal,
                    nomor_bukti : this.nomor_bukti,
                    nomor_rekening : this.nomor_rekening,
                    debit:this.debit,
                    kredit:this.kredit,
                    saldo:this.saldo
                })
                .then(response => {
                    if (response.data.data) {
                        // this.$router.push({name : 'posts'})
                        // window.location.href = "/posts"
                        const element = document.getElementById("hasilpencarian");
                        element.scrollIntoView();
                        // console.log(response.data.data);
                        this.posts = response.data.data;
                    } else {

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
            deletePost(id) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    let existingObj = this;

                    if(confirm("Do you really want to delete this data?")) {
                        this.$axios.delete(`/api/posts/delete/${id}`)
                        .then(response => {

                            let i = this.posts.map(item => item.id).indexOf(id); // find index of your object
                            this.posts.splice(i, 1);
                            existingObj.strError = "";
                            existingObj.strSuccess = response.data.success;

                        })
                        .catch(function(error) {
                            existingObj.strError = "";
                            existingObj.strSuccess = error.response.data.message;
                        });
                    }
                });
            }
        },
        components: {
            VueMultiselect
        },
        mounted() {
            if(!this.loggedIn) {
                window.location.href = "/";

            }
        }
        // beforeRouteEnter(to, from, next) {
        //     if (!this.loggedIn) {
        //         window.location.href = "/";
        //     }
        //     next();
        // }
    }

</script>
