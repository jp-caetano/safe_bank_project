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
                    <h1 class="text-h4 font-weight-black"> Abertura de conta </h1>
                    <h1 class="text-h5 font-black" style="margin-top: 10px; margin-bottom: 15px">
                        (Todos os campos são obrigatórios)
                    </h1>
                </div>
                <ul class="list-disc text-red-400" v-for="(value, index) in errors" :key="index">
                    <li>{{ value[0] }}</li>
                </ul>
                <form method="post" @submit="handleSubmit">
                    <div align="center" style="display: flex; justify-content: space-around;">
                        <div class="col-md-4">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="name">
                                Nome:
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="name"
                                type="text" required v-model="form.name" />

                            <label style="margin-top: 11px;" class="block text-grey-darker text-sm font-bold mb-2"
                                for="cpf">
                                CPF:
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="cpf"
                                type="text" required v-model="form.cpf" />

                            <label style="margin-top: 11px;" class="block text-grey-darker text-sm font-bold mb-2" for="rg">
                                RG:
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="rg"
                                type="text" required v-model="form.rg" />

                            <label style="margin-top: 11px;" class="block text-grey-darker text-sm font-bold mb-2"
                                for="nationality">
                                Nacionalidade:
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                                id="nationality" type="text" required v-model="form.nationality" />
                        </div>

                        <div class="col-md-4">
                            <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
                                Email:
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                                type="email" id="email" required v-model="form.email" />

                            <label style="margin-top: 10px;" class="block text-grey-darker text-sm font-bold mb-2"
                                for="phone">
                                Telefone:
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                                type="text" id="phone" required v-model="form.phone" />

                            <label style="margin-top: 10px;" class="block text-grey-darker text-sm font-bold mb-2"
                                for="password">
                                Senha:
                            </label>
                            <input
                                class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3"
                                id="password" type="password" required v-model="form.password" />

                            <label class="block text-grey-darker text-sm font-bold mb-2" for="password_confirmation">
                                Confirme sua senha:
                            </label>
                            <input
                                class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3"
                                id="password_confirmation" type="password" required v-model="form.password_confirmation" />
                        </div>
                    </div>

                    <div style="margin-top: 15px;" class="flex items-center justify-between">
                        <button class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded" type="submit">
                            Abrir conta
                        </button>
                        <router-link class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker"
                            to="/login">
                            Fazer Login
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
        const errors = ref();
        let router = useRouter();
        const form = reactive({
            name: '',
            cpf: '',
            rg: '',
            nationality: '',
            email: '',
            phone: '',
            password: '',
        })

        const handleSubmit = async (evt) => {
            evt.preventDefault()
            try {
                const result = await axios.post('/api/auth/register', form);
                if (result.status === 200 && result.data && result.data.token) {
                    localStorage.setItem('APP_DEMO_USER_TOKEN', result.data.token)
                    await router.push('main')
                }
            } catch (e) {
                if (e.response.data && e.response.data.errors) {
                    errors.value = Object.values(e.response.data.errors)
                }
            }
        }

        const backArrow = () => {
            router.push('/')
        }

        return {
            form,
            errors,
            handleSubmit,
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