<template>
    <div align="center" class="all-page">
        <v-img class="logo" max-width="350" src="http://localhost:8000/img/logo_oficial.png" contain></v-img>
        <div class="mx-auto w-4/12 mt-10 bg-blue-200 p-4 rounded-lg">
            <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 flex flex-col">
                <div>
                    <div class="row">
                        <div align="left" class="col-md-4">
                            <button @click="backArrow">
                                <img src="http://localhost:8000/img/back_arrow.png" alt="Back button" style="height:2rem">
                            </button>
                        </div>
                        <div class="col-md-4 text-center">
                            <h1 class="text-h4 font-weight-black">Depósito</h1>
                            <h1 class="text-h5 font-black" style="margin-top: 20px; margin-bottom: 5px">
                                Escolha o valor do seu depósito:
                            </h1>
                            <form method="post" @submit.prevent="addValue">
                                <input type="number" step="0.01" min="0.01"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                                    id="deposit_value" v-model="form.deposit_value" required />
                                <button style="margin-top: 20px"
                                    class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                                    type="submit">
                                    Depositar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { reactive, ref, onMounted } from 'vue'
import { useRouter } from "vue-router";
import { request } from '../helper';

axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('APP_DEMO_USER_TOKEN')}`;

export default {
    setup() {
        const errors = ref();
        const user = ref()
        const isLoading = ref()
        const form = reactive({
            deposit_value: ''
        })

        let router = useRouter();
        onMounted(() => {
            authentication()
        });

        const addValue = async () => {
            try {
                const result = await axios.post('/api/account/deposit', form);
                router.push('main')
            } catch (e) {
                if (e && e.response.data && e.response.data.errors) {
                    errors.value = Object.values(e.response.data.errors)
                } else {
                    errors.value = e.response.data.message || ""
                }
            }
        }

        const authentication = async () => {
            isLoading.value = true
            try {
                const req = await request('get', '/api/user')
                user.value = req.data
            } catch (e) {
                await router.push('/login')
                alert("Sessão expirada, necessário novo login!");
            }
        }

        const backArrow = () => {
            router.push('main')
        }

        return {
            user,
            form,
            errors,
            backArrow,
            isLoading,
            addValue
        }
    },
}
</script>

<style scoped>
/* Estilos CSS específicos para este componente */
.all-page {
    background-color: #010022;
    min-height: 100vh;
    font-family: 'kanit', sans-serif;
    /* Configurações aplicadas em toda a página */
}

.logo {
    margin-bottom: 20px;
    /* Margem inferior para a logo */
}
</style>