<template>
    <loading v-model:active="isLoading"
                 :can-cancel="true"
                 :opacity="100"
                 :is-full-page="fullPage"/>
    <div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Data Uraian </h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table table-responsive align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">no</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nama Akun</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Debet</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Kredit</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Saldo</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(post, index) in posts" :key="post.id">
                                    <td class="text-center">{{index+1}}.</td>
                                    <td class="text-center">{{post.nomor_akun}} - {{post.nama_akun}}</td>
                                    <td class="text-center">{{post.debit}}</td>
                                    <td class="text-center">{{post.kredit}}</td>
                                    <td class="text-center">{{post.saldo}}</td>
                                    <td class="text-center">
                                        <router-link :to="{name:'edituraian', params: {id:post.id}}" class="btn btn-warning btn-sm"><i class="material-icons opacity-24">edit</i></router-link> &nbsp
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
            this.$axios.get('/api/uraian')
            .then(response => {
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
                    this.$axios.delete(`/api/uraian/delete/${id}`)
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
