<template>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">

                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Lihat Data : {{ nomor_rekening }}</h6>
                        </div>
                    </div>
                    <div class="card-body ">
                        <!-- <form> -->
                            <div class="inpute- mb-3">
                                <label>Nama</label>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="nama" type="text" disabled class="form-control" v-model="nama" placeholder="Masukkan Nama">
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Tanggal</label>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="tanggal" type="text" disabled class="form-control" v-model="tanggal">
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Nomor Bukti</label>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="nomor_bukti" type="text" disabled class="form-control" v-model="nomor_bukti" placeholder="Masukkan Nomor Bukti">
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Nomor Rekening</label>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="nomor_rekening" type="text" disabled class="form-control" v-model="nomor_rekening" placeholder="Masukkan Nomor Rekening">
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Debit</label>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="debit" min="0" type="number" disabled class="form-control" v-model="debit" placeholder="Masukkan Debit">
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Kredit</label>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="kredit" min="0" type="number" disabled class="form-control" v-model="kredit" placeholder="Masukkan Kredit">
                                </div>
                            </div>
                            <div class="inpute- mb-3">
                                <label>Saldo</label>
                                <div class="input-group input-group-outline mb-3">
                                    <input id="saldo" min="0" type="number" disabled class="form-control" v-model="saldo" placeholder="Masukkan Saldo">
                                </div>
                            </div>
                            <button class="btn btn-primary mt-4 mb-4" @click="back()"> Kembali</button>

                        <!-- </form> -->
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
            tanggal:'',
            nomor_bukti:'',
            nomor_rekening:'',
            debit:'',
            kredit:'',
            saldo:'',
            error: null
        }
    },
    methods: {
        back() {
            this.$router.go(-1)
        }
    },

    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/posts/edit/${this.$route.params.id}`)
            .then(response => {
                this.nama = response.data['nama'];
                this.tanggal = response.data['tanggal'];
                this.nomor_bukti = response.data['nomor_bukti'];
                this.nomor_rekening = response.data['nomor_rekening'];
                this.debit = response.data['debit'];
                this.kredit = response.data['kredit'];
                this.saldo = response.data['saldo'];
            })
            .catch(function(error) {
                console.log(error);
            });
        })
    },
        mounted() {
            if(!this.loggedIn) {
                window.location.href = "/";

            }
        }
}

</script>
