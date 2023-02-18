<template>
    <loading v-model:active="isLoading"
                 :can-cancel="true"
                 :opacity="100"
                 :is-full-page="fullPage"/>
    <div class="container-fluid py-4" id="data">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Data Jurnal Besar </h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table table-responsive align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">no</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nomor Bukti</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nomor Rekening</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Uraian</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Debet</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">kredit</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(post, index) in posts" :key="post.id">
                                    <td class="text-center">{{index+1}}.</td>
                                    <td class="text-center">{{post.tanggal}}</td>
                                    <td class="text-center">{{post.nomor_bukti}}</td>
                                    <td class="text-center">{{post.nomor_rekening}}</td>
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
import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/css/index.css';

export default {
    name: "Dashboard",
    components: {
        Loading
    },
    mounted() {
        if(!this.loggedIn) {
            this.isLoading = true
            setTimeout(() => {
                this.isLoading = false
            }, 1000)
            window.location.href = "/login";
        }
    },
    data() {
        return {
            loggedIn: localStorage.getItem('loggedIn'),
            token: localStorage.getItem('token'),
            posts: [],
            isLoading: false,
                fullPage: true,
            strSuccess: '',
            strError: ''
        }
    },
    created() {
        // this.$axios.get('api/user', {headers: {'Authorization': 'Bearer '+this.token}})
        // .then(response => {
        //     console.log(response)
        //     this.user = response.data.name // assign response to state user
        // })
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('/api/posts')
            .then(response => {
                const element = document.getElementById("data");
                element.scrollIntoView();
                this.posts = response.data;
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
                        console.log(response.data.data);
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
    }
    // beforeRouteEnter(to, from, next) {
    //     if (!this.loggedIn) {
    //         window.location.href = "/";
    //     }
    //     next();
    // }
}
</script>
