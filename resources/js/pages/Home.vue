<template>
    <div align="center" class="all-page">
        <v-img class="logo" max-width="350" src="http://localhost:8000/img/logo_oficial.png" contain></v-img>
        <div class="mx-auto w-4/12 mt-10 bg-blue-200 p-4 rounded-lg">
            <!-- component -->
            <div align="center" class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 flex flex-col">
                <h1 class="text-h4 font-weight-black">Seja bem vindo(a)! </h1>
                <h1 class="text-h5 font-black" style="margin-top: 20px">
                    Entre em sua conta ou crie uma nova para começar a aproveitar nossos serviços
                </h1>
                <button class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                    style="margin-top: 30px" @click="getLogin">
                    Acessar conta
                </button>
                <button class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                    style="margin-top: 10px" @click="getRegister">
                    Criar nova conta
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { useRouter } from "vue-router";

export default {
    setup() {

        let router = useRouter();

        const getLogin = () => {
            router.push('/login')
        }

        const getRegister = () => {
            router.push('/register')
        }

        return {
            getLogin,
            getRegister
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
