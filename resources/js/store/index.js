import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        loadingApp:false,
        currentUser:{},
        snackbar:false,
        snackbarText:'',
        drawer:false,
        itemsFranchises:false,
        activeItemsFranchises:false,
        dialogItemTable:false,
        navBar:[],
        service_headers:[],
        estimate_headers:[],
    },
    mutations: {
        setCurrentUser(state,data){
            state.currentUser = data
        },
        setSnackbar(state,data){
            state.snackbar = data
        },
        setSnackbarText(state,data){
            state.snackbarText = data
        },
        setDrawer(state,data){
            state.drawer = data
        },
        setItemsFranchises(state,data){
            state.itemsFranchises = data
        },
        setActiveItemsFranchises(state,data){
            state.activeItemsFranchises = data
        },
        setDialogItemTable(state,data){
            state.dialogItemTable = data
        },
        setNavBar(state,data){
            state.navBar = data
        },
        setLoadingApp(state,data){
            state.loadingApp = data
        },
        setServiceHeaders(state, data){
            state.service_headers = data
        },
        setEstimateHeaders(state, data){
            state.estimate_headers = data
        },

    },
    getters:{
        getServiceHeaders(state){
            return state.service_headers
        },
        getEstimateHeaders(state){
            return state.estimate_headers
        },
    }
})

export default store
