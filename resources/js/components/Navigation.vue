<template>
    <div>
        <v-app-bar absolute elevate-on-scroll scroll-target="#scroll-techniques-7">
            <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>
            <v-toolbar-title>My App</v-toolbar-title>
        </v-app-bar>

        <v-navigation-drawer
            v-model="drawer"
            app
            clipped
        >
        <v-list nav dense 
            v-for="item in items" :key="item.title"
        >
            <v-list-item-group>
                <v-list-item active-class="blue--text text--accent-4" @click="menuklik(item.to)">
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
        </v-list>
        </v-navigation-drawer>
    </div>
</template>
<script>
export default {
    data() {
        return {
            drawer: false,
            items: [
                { title: 'Inventory', icon: 'mdi-view-dashboard', to: '/inventory' },
                { title: 'Transaksi', icon: 'mdi-history', to: '/transaksi' },
            ],
        }
    },
    methods: {
        menuklik(href) {
            this.$router.push(href);
        }
    }
}
</script>