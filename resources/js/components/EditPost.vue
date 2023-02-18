<template>

    <!-- <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between pb-2 mb-2">
                <h5 class="card-title">Update Post Data</h5>
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


            <form @submit.prevent="updatePost" enctype="multipart/form-data">
                <div class="form-group mb-2">
                    <label>Name</label><span class="text-danger"> *</span>
                    <input type="text" class="form-control" v-model="name" placeholder="Enter post name">
                </div>

                <div class="form-group mb-2">
                    <label>Description</label><span class="text-danger"> *</span>
                   <textarea class="form-control" rows="3" v-model="description" placeholder="Enter post description"></textarea>
                </div>

                <div class="form-gorup mb-2">
                    <label>Image</label><span class="text-danger"> *</span>
                    <input type="file" class="form-control mb-2" v-on:change="onChange">

                    <div v-if="img">
                        <img v-bind:src="imgPreview" width="100" height="100"/>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4 mb-4"> Update Post</button>

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
                            <h6 class="text-white text-capitalize ps-3">Edit Data : {{ nomor_rekening }}</h6>
                        </div>
                    </div>
                    <div class="card-body ">
                        <form @submit.prevent="updatePost" enctype="multipart/form-data">
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
                            <!-- <button
                                type="button"
                                class="btn btn-success rounded-md border px-3 py-2 bg-pink-600 text-white"
                                @click="addMore()"
                            >
                                Tambah Rincian
                            </button> -->
                            <div v-for="(data, index) in datauraian" :key="index">
                                <div class="flex justify-start ml-2 mt-4">
                                    <VueMultiselect
                                    placeholder="Masukan Nama Uraian"
                                    v-model="data.nama"
                                    :options="optionsuraian"
                                    mode="tags">
                                        <template #noResult>
                                        tidak ada data Uraian
                                        </template>
                                    </VueMultiselect>
                                <!-- <input
                                    v-model="data.nama"
                                    placeholder="enter you course name"
                                    class="w-full py-2 px-3 border border-indigo-500 rounded"
                                /> -->
                                <input
                                    v-model="data.debet"
                                    placeholder="Masukkan Debet"
                                    class="w-full py-2 px-3 border border-indigo-500 rounded"
                                />
                                <input
                                    v-model="data.kredit"
                                    placeholder="Masukkan Kredit"
                                    class="w-full py-2 px-3 border border-indigo-500 rounded"
                                />
                                <!-- <button
                                    type="button"
                                    class="ml-2 rounded-md border px-3 py-2 bg-red-600 text-white"
                                    @click="remove(index)"
                                    v-show="index != 0"
                                >
                                    Remove
                                </button> -->
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
import VueMultiselect from 'vue-multiselect'

export default{
    data() {
        return {
            loggedIn: localStorage.getItem('loggedIn'),
            token: localStorage.getItem('token'),
            uraian : '',
            tanggal:'',
            nomor_bukti:'',
            nomor_rekening:'',
            debit:0,
            kredit:0,
            error: null,
            datauraian: [
                {
                nama: "",
                debet: "",
                kredit: "",
                },
            ],
            selected: null,
            optionsuraian : []
        }
    },

    components: {
            VueMultiselect
        },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/posts/edit/${this.$route.params.id}`)
            .then(response => {
                this.uraian = response.data['uraian'];
                this.tanggal = response.data['tanggal'];
                this.nomor_bukti = response.data['nomor_bukti'];
                this.nomor_rekening = response.data['nomor_rekening'];
                this.datauraian = JSON.parse(response.data['data']);

            })
            .catch(function(error) {
                console.log(error);
            });
        });
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.get('/api/uraian/selectnama/nama')
                .then(response => {
                    this.optionsuraian = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
            });
    },
    methods: {
        // onChange(e) {
        //     this.img = e.target.files[0];
        //     let reader = new FileReader();
        //     reader.addEventListener("load", function () {
        //         this.imgPreview = reader.result;
        //     }.bind(this), false);

        //     if (this.img) {
        //         if ( /\.(jpe?g|png|gif)$/i.test( this.img.name ) ) {
        //             reader.readAsDataURL( this.img );
        //         }
        //     }
        // },
        updatePost(e) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                let existingObj = this;
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }

                const formData = new FormData();
                formData.append('tanggal', this.tanggal);
                formData.append('nomor_bukti', this.nomor_bukti);
                formData.append('nomor_rekening', this.nomor_rekening);
                formData.append('uraian', this.uraian);
                formData.append('data', JSON.stringify(this.datauraian));

                this.$axios.post(`/api/posts/update/${this.$route.params.id}`, formData, config)
                .then(response => {
                    if (response.data.success) {
                        // console.log(response.data);
                        this.$router.push({name : 'home'})
                        // window.location.href = "/posts"
                    } else {
                        this.error = response.data.message
                        // document.querySelector('.alert').style.display = 'block'
                    }
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
