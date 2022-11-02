<template>
    <v-app>
        <Nav />
        <v-container class="fill-height">
            <v-row>
                <v-col cols="12">
                    <v-card>
                        <v-card-title>
                            <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line
                                hide-details></v-text-field>
                        </v-card-title>
                        <v-data-table :headers="headers" :items="transaksi" :search="search" class="elevation-1">
                            <template v-slot:no-data>
                                <v-btn color="primary" @click="initialize">
                                    Reset
                                </v-btn>
                            </template>
                            <template v-slot:top>
                                <v-toolbar flat>
                                    <v-toolbar-title>Transaksi</v-toolbar-title>
                                    <v-divider class="mx-4" inset vertical></v-divider>
                                    <v-spacer></v-spacer>
                                    <v-dialog v-model="dialog" max-width="500px">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on"
                                                @click="formTitle = 'New Transaksi'">
                                                New Item
                                            </v-btn>
                                        </template>
                                        <v-card>
                                            <v-card-title>
                                                <span class="headline">{{ formTitle }}</span>
                                            </v-card-title>
                                            <v-card-text>
                                                <v-container>
                                                    <v-row>
                                                        <v-col cols="12">
                                                            <v-menu ref="menu" v-model="menu"
                                                                :close-on-content-click="false"
                                                                :return-value.sync="editedItem.tanggal" transition="scale-transition"
                                                                offset-y min-width="auto">
                                                                <template v-slot:activator="{ on, attrs }">
                                                                    <v-text-field v-model="editedItem.tanggal" label="Picker in menu"
                                                                        prepend-icon="mdi-calendar" readonly
                                                                        v-bind="attrs" v-on="on"></v-text-field>
                                                                </template>
                                                                <v-date-picker v-model="editedItem.tanggal" no-title scrollable>
                                                                    <v-spacer></v-spacer>
                                                                    <v-btn text color="primary" @click="menu = false">
                                                                        Cancel
                                                                    </v-btn>
                                                                    <v-btn text color="primary"
                                                                        @click="$refs.menu.save(editedItem.tanggal)">
                                                                        OK
                                                                    </v-btn>
                                                                </v-date-picker>
                                                            </v-menu>
                                                        </v-col>
                                                        <v-col cols="12">
                                                            <v-select :items="inventorySelect" @change="" placeholder="Pilih Barang"></v-select>
                                                        </v-col>
                                                        <v-col cols="12">
                                                            <v-text-field v-model="editedItem.jumlah" @keypress="isNumber($event)" label="Jumlah"></v-text-field>
                                                        </v-col>
                                                        <v-col cols="12">
                                                            <v-radio-group v-model="editedItem.tipe" label="Tipe Transaksi">
                                                                <v-radio
                                                                    v-for="n in tipe_select"
                                                                    :key="n"
                                                                    :label="n"
                                                                    :value="n"
                                                                ></v-radio>
                                                            </v-radio-group>
                                                        </v-col>
                                                    </v-row>
                                                </v-container>
                                            </v-card-text>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn color="blue darken-1" text @click="dialog = false">Cancel</v-btn>
                                                <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </v-toolbar>
                            </template>
                        </v-data-table>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>
<script>
    import Nav from '../components/Navigation';
    import axios from 'axios';
    import mix from '../mixins/mix';
    export default {
        components: {
            Nav
        },
        mixins: [mix],
        data() {
            return {
                inventory: [],
                transaksi: [],
                tipe_select: ['penambahan', 'pengurangan'],
                search: '',
                menu: false,
                formTitle: '',
                dialog: false,
                headers: [{
                        text: 'Name',
                        align: 'start',
                        sortable: false,
                        value: 'name',
                    },
                    {
                        text: 'Stok',
                        value: 'stok'
                    },
                    {
                        text: 'Harga',
                        value: 'harga'
                    },
                    {
                        text: 'Actions',
                        value: 'actions',
                        sortable: false
                    },
                ],
                editedItem: {
                    id: '',
                    tanggal: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
                    nomor_transaksi: '',
                    name: '',
                    tipe: '',
                }
            }
        },
        mounted() {
            this.initialize();
        },
        methods: {
            async initialize() {
                try {
                    await axios.get('/api/inventory')
                        .then(response => {
                            this.inventory = response.data.data;
                        })
                    await axios.get('/api/transaksi')
                        .then(response => {
                            this.transaksi = response.data.data;
                        })
                } catch (error) {
                    console.log(error);
                }
            },
            async save() {
                this.generateNomorTransaksi();
                await axios.post('/api/addTransaksi', this.editedItem)
                    .then(response => {
                        this.initialize();
                        this.dialog = false;
                    })
            },
            generateNomorTransaksi() {
                if(this.transaksi.length > 0) {
                    this.editedItem.nomor_transaksi = `12000-${this.transaksi.length + 1}`;
                }else {
                    this.editedItem.nomor_transaksi = `120001`;
                }
            },
        },
        computed: {
            inventorySelect() {
                return this.inventory.map(item => {
                    return {
                        text: item.name,
                        value: item.id
                    }
                })
            },
        },
    }

</script>
