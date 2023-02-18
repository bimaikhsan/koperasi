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
                                    <label>Nomor Akun</label><span class="text-danger"> *</span>
                                    <div class="input-group input-group-outline mb-3">
                                        <input id="nomor_akun" type="text" class="form-control" v-model="nomor_akun" placeholder="Masukkan Nomor Akun">
                                    </div>
                                </div>
                                <div class="inpute- mb-3">
                                    <label>Nama Akun</label><span class="text-danger"> *</span>
                                    <div class="input-group input-group-outline mb-3">
                                        <input id="nama_akun" type="text" class="form-control" v-model="nama_akun" placeholder="Masukkan Nama Akun">
                                    </div>
                                </div>
                                <div class="inpute- mb-3">
                                    <label>Debit</label>
                                    <div class="input-group input-group-outline mb-3">
                                        <input id="debit" type="number" class="form-control" v-model="debit" placeholder="Masukkan Debit">
                                    </div>
                                </div>
                                <div class="inpute- mb-3">
                                    <label>Kredit</label>
                                    <div class="input-group input-group-outline mb-3">
                                        <input id="kredit" type="number" class="form-control" v-model="kredit" placeholder="Masukkan Kredit">
                                    </div>
                                </div>
                                <div class="inpute- mb-3">
                                    <label>Saldo</label>
                                    <div class="input-group input-group-outline mb-3">
                                        <input id="saldo" type="number" class="form-control" v-model="saldo" placeholder="Masukkan Saldo">
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
            nomor_akun : '',
            nama_akun : '',
            debit : 0,
            kredit : 0,
            saldo : 0,
            error: null
        }
    },

    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/uraian/edit/${this.$route.params.id}`)
            .then(response => {
                this.nomor_akun = response.data['nomor_akun'];
                this.nama_akun = response.data['nama_akun'];
                this.debit = response.data['debit'];
                this.kredit = response.data['kredit'];
                this.saldo = response.data['saldo'];
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
                formData.append('nomor_akun', this.nomor_akun);
                formData.append('nama_akun', this.nama_akun);
                formData.append('debit', this.debit);
                formData.append('kredit', this.kredit);
                formData.append('saldo', this.saldo);

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
