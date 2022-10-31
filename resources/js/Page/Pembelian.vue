<template>
    <v-app>
        <Nav/>
        <v-container class="fill-height">
            <v-row>
                <v-col cols="12">
                            <v-card>
            <v-card-title>Pembelian</v-card-title>
            <v-card-text>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-select :items="inventoryItems" @change="inventorySelect($event)" label="Inventory"></v-select>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field v-model.number="formPembelian.jumlah" @keypress="isNumber($event)" label="Jumlah Item"></v-text-field>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="save">Save</v-btn>
            </v-card-actions>
        </v-card>
                </v-col>
            </v-row>
            <v-row v-if="hasilPembelian != null">
                <v-col cols="12">
                    <v-card>
                        <v-card-title>Hasil Pembelian</v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12">
                                        <p>{{hasilPembelian}}</p>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>
<script>
import Nav from '../components/Navigation';
import axios from 'axios';
export default {
    components: {
        Nav
    },
    data() {
        return {
    dialog: false,
                inventory: [],
    formPembelian: {
        inventory_id: null,
        jumlah: null,
    },
    hasilPembelian: null,
        }
    },
    created() {
        this.initialize();
    },
    methods: {
        async initialize() {
            try {
              await axios.get('/api/inventory')
                .then(response => {
                    this.inventory = response.data.data;
                })  
            } catch (error) {
                console.log(error);
            }
        },
        inventorySelect(event) {
            this.formPembelian.inventory_id = event;
        },
        isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        save() {
            axios.post('/api/add-pembelian', this.formPembelian)
                .then(response => {
                    this.hasilPembelian = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
        }
    },
    computed: {
        inventoryItems() {
            if (this.inventory.length > 0) {
                return this.inventory.map(item => {
                    return {
                        value: item.id,
                        text: item.name
                    }
                })
            }
        },
    },
}
</script>