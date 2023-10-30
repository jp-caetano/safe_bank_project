<template>
    <div align="center" class="all-page">
        <v-img class="logo" max-width="350" src="http://localhost:8000/img/logo_oficial.png" contain></v-img>
        <div class="mx-auto w-4/12 mt-10 bg-blue-200 p-4 rounded-lg">
            <div class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 flex flex-col">
                <div align="left" class="col-md-4">
                    <button @click="backArrow">
                        <img src="http://localhost:8000/img/back_arrow.png" alt="Back button" style="height:2rem">
                    </button>
                </div>
                <div class="col-md-4 text-center">
                    <h1 class="text-h4 font-weight-black"> Login </h1>
                    <h1 class="text-h5 font-black" style="margin-top: 10px; margin-bottom: 15px">
                        Faça o seu acesso usando o seu número de CPF e a sua senha
                    </h1>
                </div>
                <ul class="list-disc text-red-400" v-for="(value, index) in errors" :key="index"
                    v-if="typeof errors === 'object'">
                    <li>{{ value[0] }}</li>
                </ul>
                <p class="list-disc text-red-400" v-if="typeof errors === 'string'">{{ errors }}</p>
                <form method="post" @submit.prevent="handleLogin">
                    <div class="mb-4">
                        <label align="left" class="block text-grey-darker text-sm font-bold mb-2" for="username">
                            CPF:
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="username"
                            type="text" v-model="form.cpf" required />
                    </div>
                    <div class="mb-4">
                        <label align="left" class="block text-grey-darker text-sm font-bold mb-2" for="password">
                            Senha:
                        </label>
                        <input
                            class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3"
                            id="password" type="password" v-model="form.password" required />
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded" type="submit">
                            Entrar
                        </button>
                        <router-link class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker"
                            to="register">
                            Criar nova Conta
                        </router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, ref } from 'vue';
import axios from 'axios';
import { useRouter } from "vue-router";
export default {
    setup() {
        const errors = ref()
        const router = useRouter();
        const form = reactive({
            cpf: '',
            password: '',
        })

        const handleLogin = async () => {
            try {
                const result = await axios.post('/api/auth/login', form)
                if (result.status === 200 && result.data && result.data.token) {
                    localStorage.setItem('APP_DEMO_USER_TOKEN', result.data.token)
                    await router.push('main')
                }
            } catch (e) {
                if (e && e.response.data && e.response.data.errors) {
                    errors.value = Object.values(e.response.data.errors)
                } else {
                    errors.value = e.response.data.message || ""
                }
            }
        }

        const backArrow = () => {
            router.push('/')
        }

        return {
            form,
            errors,
            handleLogin,
            backArrow
        }
    }
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
