<template>
    <v-app>
        <Nav/>
        <v-container class="fill-height">
            <v-row>
                <v-col cols="12">
                    <v-card>
                        <v-card-title>
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="Search"
                                single-line
                                hide-details
                            ></v-text-field>
                        </v-card-title>
                        <v-data-table
                            :headers="headers"
                            :items="inventory"
                            :search="search"
                            class="elevation-1"
                        >
                        <template v-slot:item.harga="data">
                                <p v-text="formatRupiah(data.item.harga)"></p>
                            </template>
                            <template v-slot:item.actions="data">
                                <v-icon small class="mr-2" @click="editItem(data.index)">
                                    mdi-pencil
                                </v-icon>
                                <v-icon small @click="deleteItem(data.item.id)">
                                    mdi-delete
                                </v-icon>
                            </template>
                            <template v-slot:no-data>
                                <v-btn color="primary" @click="initialize">
                                    Reset
                                </v-btn>
                            </template>
                            <template v-slot:top>
                                <v-toolbar flat>
                                    <v-toolbar-title>Inventory</v-toolbar-title>
                                    <v-divider
                                        class="mx-4"
                                        inset
                                        vertical
                                    ></v-divider>
                                    <v-spacer></v-spacer>
                                    <v-dialog v-model="dialog" max-width="500px">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on" @click="formTitle = 'New Inventory'">
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
                                                        <v-col cols="12" sm="6" md="4">
                                                            <v-text-field v-model="editedItem.name" label="Name"></v-text-field>
                                                        </v-col>
                                                        <v-col cols="12" sm="6" md="4">
                                                            <v-text-field v-model.number="editedItem.stok" @keypress="isNumber($event)" label="Stok"></v-text-field>
                                                        </v-col>
                                                        <v-col cols="12" sm="6" md="4">
                                                            <v-text-field v-model.number="editedItem.harga" @keypress="isNumber($event)" label="Harga"></v-text-field>
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
            search: '',
            formTitle: '',
            dialog: false,
            headers: [
                {
                    text: 'Name',
                    align: 'start',
                    sortable: false,
                    value: 'name',
                },
                { text: 'Stok', value: 'stok' },
                { text: 'Harga', value: 'harga' },
                { text: 'Actions', value: 'actions', sortable: false },
            ],
            editedItem: {
                id: '',
                name: '',
                stok: '',
                harga: ''
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
            } catch (error) {
                console.log(error);
            }
        },
        editItem(item) {
            this.formTitle = 'Edit Inventory'
            this.editedItem = this.inventory[item]
            this.dialog = true
        },
        async deleteItem(id) {
            try {
                await axios.delete('/api/delete-inventory/' + id).then(response => {
                    this.initialize();
                })
            } catch (error) {
                console.log(error);
            }
        },
        async save(){
            try {
                await axios.post('/api/add-inventory', this.editedItem).then(response => {
                    this.initialize();
                    this.dialog = false;
                })
            } catch (error) {
                console.log(error);
            }
        },
    },
}
</script>