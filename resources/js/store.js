export default {
    state: {
        user: null
    },
    mutations: {
        setDataUser(state, data) {
            state.user = data;
        }
    },
    actions:{
        setDataUser(context, data) {
            context.commit('setDataUser', data);
            localStorage.setItem('user', JSON.stringify(data));
        },
        logout(context) {
            context.commit('setDataUser', null);
            localStorage.removeItem('user');
        },
        loadStoredState(context){
            let user = localStorage.getItem('user');
            if(user){
                context.commit('setDataUser', JSON.parse(user));
            }
        }
    }
}