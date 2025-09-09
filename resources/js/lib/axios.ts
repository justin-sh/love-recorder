import axios from 'axios';

const instance = axios.create({})

instance.interceptors.response.use(undefined, async (error)=>{
    if(error.response?.status === 401){
        window.location.href = '/login'
        return
    }

    throw error
})

export default instance
