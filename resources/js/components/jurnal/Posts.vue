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
            <div class="card my-4" v-if="trueValue">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Browse Jurnal umum</h6>
                    </div>
                </div>
                <div class="card-body">
                        <form @submit.prevent="cariPost">
                            <div class="row">
                                <div class="col p-3">
                                    <div class="inpute- mb-3">
                                        <label>tanggal</label>
                                        <div class="input-group input-group-outline mb-3">
                                            <VueMultiselect
                                                placeholder="Masukkan tanggal"
                                                v-model="tanggal"
                                                :options="optionstanggal"
                                                mode="tags">
                                                <template #noResult>
                                                    tidak ada data tanggal
                                                </template>
                                            </VueMultiselect>
                                        </div>
                                    </div>
                                </div>
                                <div class="col p-3 text-white">
                                    <div class="inpute- mb-3">
                                        <label>Bulan</label>
                                        <div class="input-group input-group-outline mb-3">
                                            <VueMultiselect
                                                placeholder="Masukkan Bulan"
                                                v-model="bulan"
                                                :options="optionsbulan"
                                                mode="tags">
                                                <template #noResult>
                                                    tidak ada data Bulan
                                                </template>
                                            </VueMultiselect>
                                        </div>
                                    </div>
                                </div>
                                <div class="col p-3 text-white">
                                    <div class="inpute- mb-3">
                                        <label>Tahun</label>
                                        <div class="input-group input-group-outline mb-3">
                                            <VueMultiselect
                                                placeholder="Masukkan Tahun"
                                                v-model="tahun"
                                                :options="optionstahun"
                                                mode="tags">
                                                <template #noResult>
                                                    tidak ada data Tahun
                                                </template>
                                            </VueMultiselect>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="inpute- mb-3">
                                <label>Tanggal</label><span class="text-danger"> *</span>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="tanggal" type="date" class="form-control" v-model="tanggal">
                                </div>
                            </div> -->
                            <div class="inpute- mb-3">
                                <label>Nomor Bukti</label>
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
                            <button type="submit" class="btn btn-primary mt-4 mb-4"> Cari</button>
                        </form>
                    </div>
            </div>
            <div class="card my-4" v-if="falseValue">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Result Browse Jurnal umum </h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2" id="hasilpencarian">
                    <div class="card-header p-0 position-relative mx-3 z-index-2" style="margin-top:10px">
                        <button class="btn btn-danger btn-sm" @click="back()"><i class="material-icons opacity-24">arrow_back</i>Back</button>
                    </div>
                    <div class="table-responsive p-0">
                        <table class="table table-responsive align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">no</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nomor Bukti</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Uraian</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Debet</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">kredit</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Saldo</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(post, index) in posts" :key="post.id">
                                    <td class="text-center">{{index+1}}.</td>
                                    <td class="text-center">{{post.tanggal}}</td>
                                    <td class="text-center">{{post.nomor_bukti}}</td>
                                    <td class="text-left">
                                        {{post.uraian}}
                                        <ul>
                                            <li v-for="(url, index) in JSON.parse(post.data)" :key="index"><label>{{ JSON.parse(JSON.stringify(url)).nama }}</label></li>
                                        </ul>
                                    </td>
                                    <td class="text-right">
                                        <ul style="list-style:none;margin-top: 27px;">
                                            <li v-for="(url, index) in JSON.parse(post.data)" :key="index">
                                                <label v-if="JSON.parse(JSON.stringify(url)).debet == null">0</label>
                                                <label v-if="JSON.parse(JSON.stringify(url)).debet != null">{{ JSON.parse(JSON.stringify(url)).debet }}</label>

                                            </li>
                                        </ul>
                                    </td>
                                    <td class="text-right">
                                        <ul style="list-style:none;margin-top: 27px;">
                                            <li v-for="(url, index) in JSON.parse(post.data)" :key="index">
                                                <label v-if="JSON.parse(JSON.stringify(url)).kredit == null">0</label>
                                                <label v-if="JSON.parse(JSON.stringify(url)).kredit != null">{{ JSON.parse(JSON.stringify(url)).kredit }}</label>

                                            </li>
                                        </ul>
                                    </td>
                                    <td class="text-right">
                                        <ul style="list-style:none;margin-top: 27px;">
                                            <li v-for="(url, index) in JSON.parse(post.data)" :key="index">
                                                <label v-if="JSON.parse(JSON.stringify(url)).kredit == null">0</label>
                                                <label v-if="JSON.parse(JSON.stringify(url)).kredit != null">{{ JSON.parse(JSON.stringify(url)).saldo }}</label>

                                            </li>
                                        </ul>
                                    </td>
                                    <td class="text-center">
                                        <!-- <router-link :to="{name:'lihatpost', params: {id:post.id}}" class="btn btn-primary btn-sm"><i class="material-icons opacity-24">visibility</i></router-link> &nbsp -->
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
                bulan : '',
                tahun : new Date().getFullYear(),
                nomor_bukti : '',
                selected: null,
                optionsbukti:[],
                optionstanggal:[],
                optionsbulan:[],
                optionstahun:[],
                strSuccess: '',
                strError: '',
                trueValue: true,
                falseValue: false

            }
        }
        ,
        created() {
            for (let i = 1; i <= 31; i++) {
                this.optionstanggal.push(i);
            }
            for (let i = 1; i <= 12; i++) {
                this.optionsbulan.push(i);
            }
            for (let i = 1900; i <= 3000; i++) {
                this.optionstahun.push(i);
            }
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
        },
        methods: {
            back(){
                this.trueValue = true;
                this.falseValue = false;
            },
            cariPost(e) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/posts/cari', {
                    tanggal : this.tanggal,
                    bulan : this.bulan,
                    tahun : this.tahun,
                    nomor_bukti : this.nomor_bukti,
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
                this.trueValue = false;
                this.falseValue = true;
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
