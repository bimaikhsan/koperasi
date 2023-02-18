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
                            <h6 class="text-white text-capitalize ps-3">Input Transaksi Jurnal Umum</h6>
                        </div>
                    </div>
                    <div class="card-body ">
                        <form @submit.prevent="addPost">
                            <div class="inpute- mb-3">
                                <label>Nomor Bukti</label><span class="text-danger"> *</span>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="nomor_bukti" type="text" class="form-control" v-model="nomor_bukti" placeholder="Masukkan Nomor Bukti">
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Tanggal</label><span class="text-danger"> *</span>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="tanggal" type="date" class="form-control" v-model="tanggal">
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Uraian</label><span class="text-danger"> *</span>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="uraian" type="text" class="form-control" v-model="uraian" placeholder="Masukkan Uraian">
                                </div>
                            </div>
                            <button
                                type="button"
                                class="btn btn-success rounded-md border px-3 py-2 bg-pink-600 text-white"
                                @click="addMore()"
                            >
                            <i class="material-icons opacity-10">add</i> Tambah Rincian
                            </button>
                            <div v-for="(data, index) in datauraian" :key="index">
                                <div class="row" style="margin-top:-20px;">
                                    <div class="col p-3">
                                        <div class="inpute- mb-3">
                                            <label>Nama Uraian</label><span class="text-danger"> *</span>
                                                <div class="input-group input-group-outline mb-3">
                                                    <VueMultiselect
                                                    placeholder="Masukan Nama Uraian"
                                                    v-model="data.nama"
                                                    :options="optionsuraian"
                                                    mode="tags">
                                                        <template #noResult>
                                                        tidak ada data Uraian
                                                        </template>
                                                    </VueMultiselect>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:-40px;">
                                    <div class="col p-3">
                                        <div class="inpute- mb-3">
                                            <label>Debet</label>
                                            <div class="input-group input-group-outline mb-3">
                                                <input
                                                    type="number"
                                                    v-model="data.debet"
                                                    placeholder="Masukkan Debet"
                                                    class="form-control"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col p-3">
                                        <div class="inpute- mb-3">
                                            <label>Kredit</label>
                                            <div class="input-group input-group-outline mb-3">
                                                <input
                                                    type="number"
                                                    v-model="data.kredit"
                                                    placeholder="Masukkan Kredit"
                                                    class="form-control"

                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col p-3">
                                        <div class="inpute- mb-3">
                                            <label>Saldo</label>
                                            <div class="input-group input-group-outline mb-3">
                                                <input
                                                    type="number"
                                                    v-model="data.saldo"
                                                    placeholder="Masukkan Saldo"
                                                    class="form-control"

                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col p-3">
                                        <div class="inpute- mb-3">
                                            <div class="input-group input-group-outline mb-3">
                                                <button
                                                    style="margin-top:32px"
                                                    type="button"
                                                    class="rounded-md btn btn-danger border text-white"
                                                    @click="remove(index)"
                                                    v-show="index != 0"
                                                >
                                                    <i class="material-icons opacity-10">close</i>
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 mb-4"><i class="material-icons opacity-10">save</i> Simpan Transaksi Jurnal Umum</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

import VueMultiselect from 'vue-multiselect'
var today = new Date();
var tgl = today.getDate();
var bln = (today.getMonth()+1);
if(tgl < 10){
    tgl = '0'+tgl;
}
if(bln < 10){
    bln = '0'+bln;
}
var date = today.getFullYear()+'-'+bln+'-'+tgl;
export default{
    name: "AddPost",
    data() {
        return {
            loggedIn: localStorage.getItem('loggedIn'),
            token: localStorage.getItem('token'),
            uraian : '',
            tanggal:date,
            nomor_bukti:'',
            debit:0,
            kredit:0,
            saldo:0,
            error: null,
            datauraian: [
                {
                nama: "",
                debet: 0,
                kredit: 0,
                saldo: 0,
                },
            ],
            selected: null,
            optionsuraian : []

        }
    },
    created() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/uraian/selectnama')
                .then(response => {
                    this.optionsuraian = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
            });

        },
    methods: {
        addPost(e) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/posts/add', {
                    uraian : this.uraian,
                    tanggal : this.tanggal,
                    nomor_bukti : this.nomor_bukti,
                    data:this.datauraian,
                })
                .then(response => {
                    if (response.data.success) {
                        this.$router.push({name : 'home'})
                        // window.location.href = "/posts"
                    } else {
                        this.error = response.data.message
                        document.querySelector('.alert').style.display = 'block'
                    }
                })
                .catch(function(error) {
                    // existingObj.strSuccess ="";
                    this.error = response.data.message

                    // existingObj.strError = error.response.data.message;
                });
            });
        },
        addMore() {
        this.datauraian.push({
            nama: "",
            debet: 0,
            kredit: 0,
            saldo: 0,
        });
        },
        remove(index) {
        this.datauraian.splice(index, 1);
        },

    },
        components: {
            VueMultiselect
        },
        mounted() {
            if(!this.loggedIn) {
                window.location.href = "/";

            }
        }
}

</script>
