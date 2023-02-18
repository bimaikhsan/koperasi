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
                            <h6 class="text-white text-capitalize ps-3">Edit Data uraian</h6>
                        </div>
                    </div>
                    <div class="card-body ">
                        <form @submit.prevent="updatePost" enctype="multipart/form-data">

                            <div class="inpute- mb-3">
                                <label>Nama</label><span class="text-danger"> *</span>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="nama" type="text" class="form-control" v-model="nama" placeholder="Masukkan Nama">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 mb-4"> Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default{
    data() {
        return {
            loggedIn: localStorage.getItem('loggedIn'),
            token: localStorage.getItem('token'),
            nama : '',
            error: null
        }
    },

    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/uraian/edit/${this.$route.params.id}`)
            .then(response => {
                this.nama = response.data['nama'];
            })
            .catch(function(error) {
                console.log(error);
            });
        })
    },
    methods: {
        updatePost(e) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                let existingObj = this;
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }

                const formData = new FormData();
                formData.append('nama', this.nama);

                this.$axios.post(`/api/uraian/update/${this.$route.params.id}`, formData, config)
                .then(response => {
                    if (response.data.success) {
                        this.$router.push({name : 'uraian'})
                    } else {
                        this.error = response.data.message
                    }
                })
                .catch(function(error) {
                    this.error = response.data.message
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
