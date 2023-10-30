<template>
    <div align="center" class="all-page">
        <v-img class="logo" max-width="350" src="http://localhost:8000/img/logo_oficial.png" contain></v-img>
        <div class="mx-auto w-5/12 mt-10 bg-blue-200 p-4 rounded-lg">
            <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 flex flex-col">
                <div class="w-11/12 p-1 mx-auto">
                    <div class="flex justify-between">
                        <button @click="getProfile">
                            <img src="http://localhost:8000/img/profile.png" alt="Profile Button" style="height:3rem">
                        </button>
                        <h1 class="text-h4 font-weight-black">Olá {{ user && user.name }}! </h1>
                        <button class="text-orange-500 underline hover:no-underline rounded-md" @click="handleLogout">
                            <img src="http://localhost:8000/img/logout.png" alt="Logout Button" style="height:2.5rem">
                        </button>
                    </div>
                    <div align="center" class="card" style="margin-top: 20px; margin-bottom: 30px;background-color:#E9F6FF">
                        <h2 class="text-h5 font-weight-black">Saldo Disponível:</h2>
                        <h2 class="text-h5">R${{ user && user.balance }}</h2>
                    </div>
                    <div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
                        <button class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                            @click="getStatement">
                            Extrato
                        </button>
                        <button class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                            @click="getTransfer">
                            Transferência
                        </button>
                        <button class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                            @click="getWithdraw">
                            Saque
                        </button>
                        <button class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                            @click="getDeposit">
                            Depósito
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import { ref, onMounted } from 'vue'
import { useRouter } from "vue-router";
import { request } from '../helper';

axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('APP_DEMO_USER_TOKEN')}`;

export default {
    setup() {
        const user = ref()
        const isLoading = ref()

        let router = useRouter();
        onMounted(() => {
            authentication()
        });

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

        const handleLogout = () => {
            localStorage.removeItem('APP_DEMO_USER_TOKEN')
            router.push('/')
        }

        const getProfile = () => {
            router.push('/profile')
        }

        const getDeposit = () => {
            router.push('/deposit')
        }

        const getWithdraw = () => {
            router.push('/withdraw')
        }

        const getTransfer = () => {
            router.push('/transfer')
        }

        const getStatement = () => {
            router.push('/statement')
        }

        const checked = async (val, index) => {
            try {
                const data = { has_completed: !val.has_completed }
                const req = await request('put', `/api/todos/${val.id}`, data)
                if (req.data.message) {
                    isLoading.value = false
                    return alert(req.data.message)
                }
                todos.value[index].has_completed = !val.has_completed
            } catch (e) {
                await router.push('/')
            }
            isLoading.value = false
        }

        return {
            user,
            checked,
            isLoading,
            handleLogout,
            getProfile,
            getDeposit,
            getWithdraw,
            getTransfer,
            getStatement
        }
    },
}
</script>

<style scoped>
/* Estilos CSS específicos para este componente */
.all-page {
    background-color: #010022;
    font-weight: bold;
    min-height: 100vh;
    font-family: 'kanit', sans-serif;
    /* Configurações aplicadas em toda a página */
}

.logo {
    margin-bottom: 20px;
    /* Margem inferior para a logo */
}
</style>
