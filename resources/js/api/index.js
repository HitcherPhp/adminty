import axios from 'axios';

const instance = axios.create({
    baseURL: process.env.BASE_URL,
    withCredentials: true,
})
export const login = (email, password) => instance.post('login', {email, password})
export const logOut = (token) => instance.post('logout', {_token: token})

export const getNavBarList = () => instance.post('get_links', {})
export const getFranchises = () => instance.post('get_franchises', {})
export const getDataTable = (tamp) => instance.post(`${tamp}`, {})
export const updateFranchises = (id) => instance.post('update_franchise_in_db', {id})
export const editItemDataTable = (tamp, id, need_service_headers, need_estimate_headers) => instance.post(`${tamp}/edit`, {id, need_service_headers, need_estimate_headers})
export const getCurrentUser = () => instance.post('get_current_user', {})
export const getDatAutocomplete = (tamp, data) => instance.post(`${tamp}/search_autocomplete`,{...data})
export const createItemTable = (tamp) => instance.post(`${tamp}`,{})
export const getAddedProductData = (tamp, id, count) => instance.post(`${tamp}/get_added_product_data`,{id, count})
export const getBasketEstimatePrice = (id, products) => instance.post('get_basket_estimate_price', {id, products})
