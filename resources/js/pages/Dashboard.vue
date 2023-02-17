<template>
    <div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Data Buku Besar </h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">no</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor Bukti</th>
                                    <th class="text-secondary opacity-7">Nomor Rekening</th>
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
                                        <router-link :to="{name:'editpost', params: {id:post.id}}" class="btn btn-warning">Edit</router-link>
                                        <button class="btn btn-danger" @click="deletePost(post.id)">Delete</button>
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
export default {
    name: "Dashboard",
    data() {
        return {
            loggedIn: localStorage.getItem('loggedIn'),
            token: localStorage.getItem('token'),
            posts: [],
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
                this.posts = response.data;
            })
            .catch(function(error) {
               console.log(error);
            });
        });
    },
    methods: {
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
